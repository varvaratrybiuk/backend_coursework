<?php

namespace models\products;

use core\Repository;

class PhotosRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getPhotosArray(int $id): array
    {
        return $this->db->select("photo_storage", "photo_filepath")
            ->join(["products" => "id"], ["photo_storage" => "product_id"])
            ->where(["products.id" => $id])
            ->execute()->returnAssocArray();
    }
    public function savePhotos(int $productId, array $photos): void
    {
        foreach ($photos as $photo){
            $this->db->insert("photo_storage", ["product_id"=>$productId, "photo_filepath"=> $photo])->execute();
        }
    }
}