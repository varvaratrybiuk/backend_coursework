<?php

namespace core;

class DataMapper
{
    protected DataBase $db;

    public function __construct()
    {
        $this->db = Core::getInstance()->getDataBaseObj();
    }
}