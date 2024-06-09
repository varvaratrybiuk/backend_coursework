<?php

namespace models\products;

class ProductVariant
{
    private int $id;
    private int $productId;
    private int $sizeId;
    private int $productQuantity;
    private Price $price;

    public function __construct( int $productId, int $sizeId, int $productQuantity, Price $price)
    {
        $this->productId = $productId;
        $this->sizeId = $sizeId;
        $this->productQuantity = $productQuantity;
        $this->price = $price;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getSizeId(): int
    {
        return $this->sizeId;
    }

    public function getProductQuantity(): int
    {
        return $this->productQuantity;
    }

    public function getPrice(): float
    {
        return $this->price->getAmount();
    }
}