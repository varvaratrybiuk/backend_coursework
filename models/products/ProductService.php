<?php

namespace models\products;

class ProductService
{
    private ProductRepository $productRepository;
    private PhotosRepository $photosRepository;
    private ProductVariantRepository $variantRepository;

    public function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->photosRepository = new PhotosRepository();
        $this->variantRepository = new ProductVariantRepository();
    }
    public function addComment(int $productId, string $comment, int $userId, int $rating) : array
    {
        $commentObj = new CommentAndRating($userId, $productId, $comment, $rating);
        $this->productRepository->addComment($commentObj);
        return $this->getProductById($productId)->getRatingAndComments();
    }
    public function getAllProducts(string $artistName = null): array
    {
        return $this->productRepository->findAllProducts($artistName);
    }
    public function sortProducts($sortByPrice, $sortByRating, ?string $artistName = null): array
    {
        return $this->productRepository->sortByDefinition($artistName, $sortByPrice, $sortByRating);
    }
    public function getProductById(int $id): ProductObj
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
    public function saveProductAndPhotos(int $artist_id, string $name, string $description, array $photos): void
    {
        if($artist_id == 0 || $photos == []){
            throw new \Exception("Перевірте чи все заповнили");
        }
        $product = new Product($artist_id,  $name,  $description);
        $id = $this->productRepository->save($product);
        $this->photosRepository->savePhotos($id, $photos);
    }

    /**
     * @throws \Exception
     */
    public function addVariants(int $productId, int $sizeId, int $productQuantity, float $price): void
    {
        $validPrice = new Price($price);
        if($productId == 0 || $sizeId == 0 ){
            throw new \Exception("Ви не все обрали");
        }
        $productVariant = new ProductVariant($productId, $sizeId, $productQuantity,  $validPrice);
        $this->variantRepository->saveVariant($productVariant);
    }

    /**
     * @throws \Exception
     */
    public  function updateVariants(array $data)
    {
        foreach ($data as $item){
            if (isset($item['price'])) {
                new Price($item["price"]);
            }
            if (isset($item['quantity'])) {
                if ($item["quantity"] < 0) {
                    throw new \Exception("К-сть не можу бути ві'дємною");
                }
            }
        }
        $this->variantRepository->updateProductsVariant($data);
    }
}