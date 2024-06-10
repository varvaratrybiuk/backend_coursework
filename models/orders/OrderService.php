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
    public function addUserOrder(int $address_id, int $user_id, OrderObj $orderObj): void
    {
        $orderObj->setUserId($user_id);
        $orderObj->setAddressId($address_id);
        $this->saveOrder($orderObj);
    }
    private function saveOrder(OrderObj $orderObj): void
    {
        $date = new Date($orderObj->getOrderDate());
        $order = new Order($orderObj->getUserId(), $date, $orderObj->getAddressId());
        $orderId = $this->repository->saveOrder($order);
        $orderObj->setOrderId((int)$orderId);
        $this->repository->saveProductAndQuantity($orderObj);
    }

    /**
     * @throws \Exception
     */
    public function addGuestOrder(UserObj $userObj, OrderObj $orderObj, AddressObj $addressObj): void
    {
        $user_id = $this->service->findUserIdByEmail($userObj->email);
        if($user_id == null)
            $user_id = $this->service->register($userObj);
        $orderObj->setUserId($user_id);
        $orderObj->setAddressId($this->addressService->addAddress($addressObj, $user_id));
        $this->saveOrder($orderObj);
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