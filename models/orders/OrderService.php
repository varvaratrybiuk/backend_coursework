<?php

namespace models\orders;

use models\address\AddressObj;
use models\address\AddressService;
use models\Date;
use models\users\UserObj;
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
    public function addUserOrder(int $address_id, int $user_id, OrderObj $orderDTO): void
    {
        $orderDTO->setUserId($user_id);
        $orderDTO->setAddressId($address_id);
        $this->saveOrder($orderDTO);
    }
    private function saveOrder(OrderObj $orderDTO): void
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
    public function addGuestOrder(UserObj $userDTO, OrderObj $orderDTO, AddressObj $addressDTO): void
    {
        $user_id = $this->service->findUserIdByEmail($userDTO->email);
        if($user_id == null)
            $user_id = $this->service->register($userDTO);
        $orderDTO->setUserId($user_id);
        $orderDTO->setAddressId($this->addressService->addAddress($addressDTO, $user_id));
        $this->saveOrder($orderDTO);
    }
    public function getAllUsersOrders(): array
    {
       return $this->repository->getAllUsersOrders();
    }
    public function getAllOrdersProducts(): array
    {
       return $this->repository->getAllOrdersProducts();
    }
    public function getOrdersStatuses(): array
    {
        return $this->repository->getOrdersStatuses();
    }
    public function updateStatus(int $orderId, int $statusId)
    {
        $this->repository->updateStatus($orderId, $statusId);
    }
}