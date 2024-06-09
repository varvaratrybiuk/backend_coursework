<?php

namespace models\products;

use core\Repository;

class ArtistRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getArtistId(?string $artistName)
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
    public function getAllArtists() : array
    {
        return $this->db->select("artist")->execute()->returnAssocArray();
    }

    /**
     * @throws \Exception
     */
    public function isArtistExist(?string $artistName)
    {
        return $this->getArtistId($artistName);
    }
}