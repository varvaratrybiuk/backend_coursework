<?php

namespace models\orders;

class OrderObj
{
    private int $orderId;
    private int $userId;
    private int $addressId;
    private string $orderDate;
    private array $productInform;

    public function __construct(string $orderDate, array $productInform)
    {
        $this->orderDate = $orderDate;
        $this->productInform = $productInform;
    }
    public function setAddressId(int $addressId): void
    {
        $this->addressId = $addressId;
    }

    public function getAddressId(): int
    {
        return $this->addressId;
    }
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getOrderDate(): string
    {
        return $this->orderDate;
    }


    public function getProductInform(): array
    {
        return $this->productInform;
    }
}