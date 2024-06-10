<?php

namespace models\products;

class ProductObj
{
    private ?int $id;
    private string $name;
    private string $description;
    private array $productPhotos;
    private array $pricesAndSizesAndQuantity;
    private string $minPrice;
    private array $ratingAndComments;
    private float $avgRating;

    public function __construct(string $name, array $pricesAndSizesAndQuantity, string $description,
                                array $productPhotos, array $ratingAndComments)
    {
        $this->name = $name;
        $this->pricesAndSizesAndQuantity = $pricesAndSizesAndQuantity;
        $this->description = $description;
        $this->productPhotos = $productPhotos;
        $this->ratingAndComments = $ratingAndComments;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getProductPhotos(): array
    {
        return $this->productPhotos;
    }

    public function setProductPhotos(array $productPhotos): void
    {
        $this->productPhotos = $productPhotos;
    }

    public function getPricesAndSizes(): array
    {
        return $this->pricesAndSizesAndQuantity;
    }


    public function getMinPrice(): string
    {
        return $this->minPrice;
    }

    public function setMinPrice(string $minPrice): void
    {
        $this->minPrice = $minPrice;
    }

    public function getRatingAndComments(): array
    {
        return $this->ratingAndComments;
    }

    public function getAvgRating(): float
    {
        return $this->avgRating;
    }

    public function setAvgRating(float $avgRating): void
    {
        $this->avgRating = $avgRating;
    }
}