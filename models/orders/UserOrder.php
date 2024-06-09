<?php

namespace models\orders;

class UserOrder
{
    private string $fullName;
    private int $orderId;
    private string $address;
    private int $status;

    public function __construct(string $fullName, int $orderId, string $address, int $status)
    {
        $this->fullName = $fullName;
        $this->orderId = $orderId;
        $this->address = $address;
        $this->status = $status;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}