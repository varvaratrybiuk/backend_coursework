<?php

namespace models\orders;

class OrderProduct
{
    private int $orderId;
    private string $productName;
    private int $quantity;
    private string $size;
    public function __construct(int $orderId, string $productName, int $quantity, string $size)
    {
        $this->orderId = $orderId;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->size = $size;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getSize(): string
    {
        return $this->size;
    }
}