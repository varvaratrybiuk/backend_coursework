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
    public function findByEmail(User $user): array
    {
       return $this->db->select("users")->where(["email"=>$user->getEmail()])->execute()->returnAssocArray();
    }
    public function findUserById(int $id): array
    {
        return $this->db->select("users")->where(["id"=>$id])->execute()->returnAssocArray();
    }
    public function updateUser(User $user): void
    {
        $this->db->update("users",[   "email"=> (string)$user->getEmail(),
                "password" => (string)$user->getPassword(),
                "name" => $user->getName(),
                "lastname" => $user->getLastname(),
                "birthday" => $user->getBirthday()
            ]
        )->where(["id" => $user->getId()])->execute();
    }
}