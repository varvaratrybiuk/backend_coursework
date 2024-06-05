<?php

namespace models\products;

use core\Repository;

class ProductRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }

    public function findAllProducts(?string $artistName): array
    {
        $allProducts = [];
        $id  = null;
        if ($artistName != null) {

            $artists = $this->db->select("artist")->execute()->returnAssocArray();
            $artistIds = array_column($artists, 'artist_id', 'artist_name');
            $id = $artistIds[$artistName] ?? null;
        }
        $query = $this->db->select("products", "id, product_name, description");
        if ($id !== null) {
            $query->where(["artist_id" => $id]);
        }
        $products = $query->execute()->returnAssocArray();
        foreach ($products as $product) {
            $id = $product['id'];
            $sizeAndPriceArray = $this->db->select("sizes", "sizes.size, product_variants.price")
                ->join(["product_variants" => "size_id"], ["sizes" => "id"])
                ->join(["products" => "id"], ["product_variants" => "product_id"])
                ->where(["products.id" => $id])
                ->execute()->returnAssocArray();

            $photosArray = $this->db->select("photo_storage", "photo_filepath")
                ->join(["products" => "id"], ["photo_storage" => "product_id"])
                ->where(["products.id" => $id])
                ->execute()->returnAssocArray();

            $finaleProduct = new ProductDTO(
                $product['product_name'],
                $sizeAndPriceArray,
                $product['description'],
                $photosArray,
            );
            $finaleProduct->setId($id);
            $allProducts[] = $finaleProduct;
        }
        return $allProducts;
    }
    public function findProductById(int $id): ProductDTO
    {
        $sizeAndPriceArray = $this->db->select("sizes", "sizes.size, product_variants.price")
            ->join(["product_variants" => "size_id"], ["sizes" => "id"])
            ->join(["products" => "id"], ["product_variants" => "product_id"])
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();

        $product = $this->db->select("products", "name, description, price")
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();

        $photos = $this->db->select("photo_storage", "photo_filepath")
            ->join(["products" => "id"], ["photo_storage" => "product_id"])
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();

        return new ProductDTO(
            $product['product_name'],
            $sizeAndPriceArray,
            $product['description'],
            $photos,
        );
    }
}