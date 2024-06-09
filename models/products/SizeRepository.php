<?php

namespace models\products;

use core\Repository;

class SizeRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllSizes(): array
    {
        return $this->db->select("sizes")->execute()->returnAssocArray();
    }
}