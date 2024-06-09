<?php

namespace models\orders;

class ProductInformDTO
{
    private int $productId;
    private int $quantity;
    private string $size;

    public function __construct(int $productId, int $quantity, string $size)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->size = $size;
    }

    public function getProductId(): int
    {
        return $this->productId;
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