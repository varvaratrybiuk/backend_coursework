<?php

namespace models\users;

use core\Repository;

class UserRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function save(User $user): string|false
    {
        $this->db->insert("users",
            [   "email"=> (string)$user->getEmail(),
                "role_id" => $user->getRoleId(),
                "password" => (string)$user->getPassword(),
                "name" => $user->getName(),
                "lastname" => $user->getLastname(),
                "birthday" => (string)$user->getBirthday()
            ]
        )->execute();
        return $this->db->lastInsertId();
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
                "name" => $user->getName(),
                "lastname" => $user->getLastname(),
                "birthday" => $user->getBirthday()
            ]
        )->where(["id" => $user->getId()])->execute();
    }
}