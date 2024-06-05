<?php

namespace models\products;

class ProductDTO
{
    private ?int $id;
    private string $name;
    private string $description;
    private array $productPhotos;
    private array $pricesAndSizes;

    public function __construct(string $name, array $pricesAndSizes, string $description, array $productPhotos)
    {
        $this->name = $name;
        $this->pricesAndSizes = $pricesAndSizes;
        $this->description = $description;
        $this->productPhotos = $productPhotos;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPricesAndSizes(): array
    {
        return $this->pricesAndSizes;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getProductPhotos(): array
    {
        return $this->productPhotos;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}