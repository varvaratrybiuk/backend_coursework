<?php

namespace models\products;

use core\Repository;
use http\Exception;

class ProductRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function isArtistExist(?string $artistName)
    {
        return $this->getArtistId($artistName);
    }

    /**
     * @throws \Exception
     */
    public function sortByDefinition(?string $artistName, ?string $sortByPrice, ?string $sortByRating): array
    {
        $artist_id = $this->isArtistExist($artistName);
        $products = $this->getProducts($artist_id);
        $dtos = $this->createProductDTOs($products);
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
    private function getMinPriceFromPricesAndSizes(array $pricesAndSizes): float {
        return min(array_column($pricesAndSizes, 'price'));
    }

    /**
     * @throws \Exception
     */
    public function findAllProducts(?string $artistName): array
    {
        $artist_id = $this->isArtistExist($artistName);
        $products = $this->getProducts($artist_id);
        return $this->createProductDTOs($products);
    }

    public function findProductById(int $id): ProductDTO
    {
        $product = $this->getProduct($id)[0];
        return $this->createProductDTO($product);
    }

    /**
     * @throws \Exception
     */
    private function getArtistId(?string $artistName)
    {
        $id  = null;
        if ($artistName != null) {
            $artists = $this->db->select("artist")->execute()->returnAssocArray();
            $artistIds = array_column($artists, 'artist_id', 'artist_name');
            $id = $artistIds[$artistName] ?? null;
            if($id == null){
                throw new \Exception("Артист не присутній в магазині");
            }
        }
        return $id;
    }

    private function getProducts(?int $artist_id): array
    {
        $query = $this->db->select("products", "id, product_name, description");
        if ($artist_id != null) {
            $query->where(["artist_id" => $artist_id]);
        }
        return $query->execute()->returnAssocArray();
    }

    private function createProductDTOs(array $products): array
    {
        $allProducts = [];
        foreach ($products as $product) {
            $allProducts[] = $this->createProductDTO($product);
        }

        return $allProducts;
    }
    private function average($numbers) {
        if (!is_array($numbers) || count($numbers) == 0) {
            return 0;
        }
        return array_sum($numbers) / count($numbers);
    }
    private function createProductDTO(array $product): ProductDTO
    {
        $id = $product['id'];
        $sizeAndPriceArray = $this->getSizeAndPriceArray($id);
        $photosArray = $this->getPhotosArray($id);
        $commentsAndRating = $this->getRatingAndComments($id);
        $finaleProduct = new ProductDTO(
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
            ->join(["users" => "id"], ["comments_and_rating" => "id"])
            ->where(["comments_and_rating.product_id" => $productId])
            ->execute()
            ->returnAssocArray();
    }
    private function getSizeAndPriceArray(int $id): array
    {
        return $this->db->select("sizes", "sizes.size, product_variants.price")
            ->join(["product_variants" => "size_id"], ["sizes" => "id"])
            ->join(["products" => "id"], ["product_variants" => "product_id"])
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();
    }

    private function getPhotosArray(int $id): array
    {
        return $this->db->select("photo_storage", "photo_filepath")
            ->join(["products" => "id"], ["photo_storage" => "product_id"])
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