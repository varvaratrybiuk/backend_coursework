<?php

namespace models\orders;

use models\address\AddressDTO;
use models\address\AddressService;
use models\Date;
use models\users\UserDTO;
use models\users\UserService;

class OrderService
{
    private OrderRepository $repository;
    private UserService $service;
    private AddressService $addressService;


    public function __construct()
    {
        $this->repository = new OrderRepository();
        $this->service = new UserService();
        $this->addressService = new AddressService();

    }
    public function addUserOrder(int $address_id, int $user_id, OrderDTO $orderDTO): void
    {
        $orderDTO->setUserId($user_id);
        $orderDTO->setAddressId($address_id);
        $this->saveOrder($orderDTO);
    }
    private function saveOrder(OrderDTO $orderDTO): void
    {
        $date = new Date($orderDTO->getOrderDate());
        $order = new Order($orderDTO->getUserId(), $date, $orderDTO->getAddressId());
        $orderId = $this->repository->saveOrder($order);
        $orderDTO->setOrderId((int)$orderId);
        $this->repository->saveProductAndQuantity($orderDTO);
    }

    /**
     * @throws \Exception
     */
    public function addGuestOrder(UserDTO $userDTO, OrderDTO $orderDTO, AddressDTO $addressDTO): void
    {
        $user_id =  $this->service->register($userDTO);
        $orderDTO->setUserId($user_id);
        $orderDTO->setAddressId($this->addressService->addAddress($addressDTO, $user_id));
        $this->saveOrder($orderDTO);
    }
}