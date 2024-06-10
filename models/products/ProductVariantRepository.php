<?php

namespace models\products;

use core\Repository;

class ProductVariantRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function saveVariant(ProductVariant $productVariant): void
    {
        $this->db->insert("product_variants",
            [   "product_id"=> $productVariant->getProductId(),
                "size_id"=> $productVariant->getSizeId(),
                "product_quantity"=> $productVariant->getProductQuantity(),
                "price"=> $productVariant->getPrice()])->execute();
    }

    public function updateProductsVariant(array $data): void
    {
        foreach ($data as $index =>$item){
            $index = intval($index);
            if (!array_key_exists('price', $item)) {
                $this->db->update("product_variants")
                    ->join(["sizes"=> "id"], ["product_variants" => "size_id"])
                    ->set(["product_quantity" => $item['quantity']])
                    ->where(["product_id" => $index, "size"=> $item["size"]])->execute();
                continue;
            }
            if (!array_key_exists('quantity', $item)) {
                $this->db->update("product_variants")
                    ->join(["sizes"=> "id"], ["product_variants" => "size_id"])
                    ->set(["price" => $item['price']])
                    ->where(["product_id" => $index, "size"=> $item["size"]])->execute();
                continue;
            }
            $this->db->update("product_variants")
                ->join(["sizes"=> "id"], ["product_variants" => "size_id"])
                ->set(["price" => $item['price'], "product_quantity"=>$item['quantity']])
                ->where(["product_id" => $index, "size"=> $item["size"]])->execute();
        }
    }
}