<?php

namespace models\products;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function getAllProducts(string $artistName = null): array
    {
        return $this->productRepository->findAllProducts($artistName);
    }

    public function getProductById(int $id): ProductDTO
    {
        return $this->productRepository->findProductById($id);
    }
}