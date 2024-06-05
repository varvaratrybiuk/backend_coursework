<?php

namespace core;

class Repository
{
    protected DataBase $db;

    public function __construct()
    {
        $this->db = Core::getInstance()->getDataBaseObj();
    }
}