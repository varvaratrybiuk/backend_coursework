<?php

namespace models\products;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }
    public function addComment(int $productId, string $comment, int $userId, int $rating) : array
    {
        $commentObj = new CommentAndRating($userId, $productId, $comment, $rating);
        $this->productRepository->addComment($commentObj);
        $comments = $this->getProductById($productId)->getRatingAndComments();
        return $comments;
    }
    public function getAllProducts(string $artistName = null): array
    {
        return $this->productRepository->findAllProducts($artistName);
    }
    public function sortProducts($sortByPrice, $sortByRating, ?string $artistName = null): array
    {
        return $this->productRepository->sortByDefinition($artistName, $sortByPrice, $sortByRating);
    }
    public function getProductById(int $id): ProductDTO
    {
        return $this->productRepository->findProductById($id);
    }
    public function getProductsByIdAndSize(int $id, string $size): array
    {
       $products = $this->getAllProducts();
        foreach ($products as $product) {
            if ($product->getId() == $id) {
                $sizes = array_column($product->getPricesAndSizes(), "size");
                $prices = array_column($product->getPricesAndSizes(), 'price', 'size');
                if (in_array($size, $sizes) && isset($prices[$size])) {
                    return [$product, $prices[$size]];
                }
            }
        }
        return [];
    }
    public function updateProduct(int $productId, int $productQuantity, string $productSize): void
    {
        $this->productRepository->updateProduct($productId, $productQuantity, $productSize);
    }
}