<?php

namespace models\orders;

use models\Date;

class Order
{
    private int $orderId;
    private int $address_id;
    private int $userId;
    private Date $orderDate;
    private ?int $status;

    public function __construct(int $userId, Date $orderDate, int $address_id, ?int $status = 1)
    {
        $this->userId = $userId;
        $this->address_id = $address_id;
        $this->orderDate = $orderDate;
        $this->status = $status;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOrderDate(): Date
    {
        return $this->orderDate;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function getAddressId(): int
    {
        return $this->address_id;
    }
}