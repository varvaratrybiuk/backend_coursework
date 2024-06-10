<?php

namespace models\products;

use core\Repository;
use http\Exception;

class ProductRepository extends Repository
{
    private ArtistRepository $artistRepository;
    private PhotosRepository $photosRepository;
    public function __construct()
    {
        parent::__construct();
        $this->artistRepository =  new ArtistRepository();
        $this->photosRepository = new PhotosRepository();
    }
    public function save(Product $product): false|string
    {
        $this->db->insert("products", [
            "artist_id" => $product->getArtistId(),
            "product_name"=> $product->getProductName(),
            "description" => $product->getDescription()
        ])->execute();
        return $this->db->lastInsertId();
    }
    /**
     * @throws \Exception
     */
    public function sortByDefinition(?string $artistName, ?string $sortByPrice, ?string $sortByRating): array
    {
        $artist_id = $this->artistRepository->isArtistExist($artistName);
        $products = $this->getProducts($artist_id);
        $dtos = $this->createProductObjs($products);
        $sortOptions = ['ASC', 'DESC'];
        if (in_array($sortByPrice, $sortOptions) || in_array($sortByRating, $sortOptions)) {
            usort($dtos, function($a, $b) use ($sortByPrice, $sortByRating, $sortOptions) {
                if (in_array($sortByPrice, $sortOptions)) {
                    $minPriceA = $a->getMinPrice();
                    $minPriceB = $b->getMinPrice();
                    if ($minPriceA !== $minPriceB) {
                        return ($sortByPrice == 'ASC') ? $minPriceA <=> $minPriceB : $minPriceB <=> $minPriceA;
                    }
                }
                if (in_array($sortByRating, $sortOptions)) {
                    $avgRatingA = $a->getAvgRating();
                    $avgRatingB = $b->getAvgRating();
                    return ($sortByRating == 'ASC') ? $avgRatingA <=> $avgRatingB : $avgRatingB <=> $avgRatingA;
                }
                return 0;
            });
        }
        return $dtos;
    }


    /**
     * @throws \Exception
     */
    public function findAllProducts(?string $artistName): array
    {
        $artist_id = $this->artistRepository->isArtistExist($artistName);
        $products = $this->getProducts($artist_id);
        return $this->createProductObjs($products);
    }

    public function findProductById(int $id): ProductObj
    {
        $product = $this->getProduct($id)[0];
        return $this->createProductObj($product);
    }
    public function addComment(CommentAndRating $comment): void
    {
        $this->db->insert("comments_and_rating", [
            "product_id" => $comment->getProductId(),
            "user_id" => $comment->getUserId(),
            "comment" => $comment->getComment(),
            "stars" => $comment->getStars()
        ])->execute();
    }
    public function updateProduct(int $product_id, int $productQuantity, string $productSize): void
    {
        $size = $this->db->select("sizes", "sizes.id, product_variants.product_quantity")
            ->join(["product_variants" => "size_id"], ["sizes" => "id"])
            ->where(["product_id" => $product_id, "size" => $productSize])
            ->execute()
            ->returnAssocArray();
        $quantity = $size[0]["product_quantity"] - $productQuantity;
        $this->db->update("product_variants")
            ->set(["product_quantity" => $quantity])
            ->where(["product_id" => $product_id, "size_id" => $size[0]["id"]])
            ->execute();
    }
    /**
     * @throws \Exception
     */

    private function getMinPriceFromPricesAndSizes(array $pricesAndSizes): float {
        $prices = array_column($pricesAndSizes, 'price');
        if (!empty($prices)) {
            return min($prices);
        }
        return 0;
    }
    private function getProducts(?int $artist_id): array
    {
        $query = $this->db->select("products", "id, product_name, description");
        if ($artist_id != null) {
            $query->where(["artist_id" => $artist_id]);
        }
        return $query->execute()->returnAssocArray();
    }

    private function createProductObjs(array $products): array
    {
        $allProducts = [];
        foreach ($products as $product) {
            $allProducts[] = $this->createProductObj($product);
        }

        return $allProducts;
    }
    private function average($numbers) {
        if (!is_array($numbers) || count($numbers) == 0) {
            return 0;
        }
        return round(array_sum($numbers) / count($numbers), 2);
    }
    private function createProductObj(array $product): ProductObj
    {
        $id = $product['id'];
        $sizeAndPriceArray = $this->getSizeAndPriceArray($id);
        $photosArray = $this->photosRepository->getPhotosArray($id);
        $commentsAndRating = $this->getRatingAndComments($id);
        $finaleProduct = new ProductObj(
            $product['product_name'],
            $sizeAndPriceArray,
            $product['description'],
            $photosArray,
            $commentsAndRating
        );
        $finaleProduct->setAvgRating($this->average(array_column($commentsAndRating, "stars")));
        $finaleProduct->setMinPrice($this->getMinPriceFromPricesAndSizes($sizeAndPriceArray));
        $finaleProduct->setId($id);
        return $finaleProduct;
    }
    private function getRatingAndComments(int $productId): array
    {
        return $this->db->select("comments_and_rating", "CONCAT(users.name, ' ', users.lastname) as author, comments_and_rating.comment, comments_and_rating.stars")
            ->join(["users" => "id"], ["comments_and_rating" => "user_id"])
            ->where(["comments_and_rating.product_id" => $productId])
            ->execute()
            ->returnAssocArray();
    }
    private function getSizeAndPriceArray(int $id): array
    {
        return $this->db->select("sizes", "sizes.size, product_variants.price, product_variants.product_quantity as quantity")
            ->join(["product_variants" => "size_id"], ["sizes" => "id"])
            ->join(["products" => "id"], ["product_variants" => "product_id"])
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();
    }

    private function getProduct(int $id): array
    {
        return $this->db->select("products", "id, product_name, description")
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();
    }

}