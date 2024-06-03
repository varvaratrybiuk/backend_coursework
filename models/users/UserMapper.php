<?php

namespace models\users;

use core\DataMapper;

class UserMapper extends DataMapper
{
    public function __construct()
    {
        parent::__construct();
    }
    public function save(User $user): void
    {
        $this->db->insert("users",
            [   "email"=> (string)$user->getEmail(),
                "password" => (string)$user->getPassword(),
                "name" => $user->getName(),
                "lastname" => $user->getLastname(),
                "birthday" => $user->getBirthday()
            ]
        )->execute();
    }
    public function findByEmail(User $user)
    {
       return $this->db->select("users")->where(["email"=>$user->getEmail()])->execute()->returnAssocArray();
    }
}