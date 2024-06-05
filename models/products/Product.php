<?php

namespace models\products;

class Product
{
    private int $id;
    private int $artistId;
    private string $productName;
    private string $description;

    public function __construct(int $id, int $artistId, string $productName, string $description)
    {
        $this->id = $id;
        $this->artistId = $artistId;
        $this->productName = $productName;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getArtistId(): int
    {
        return $this->artistId;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}