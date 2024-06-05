<?php

namespace models\users;

class UserService
{
    private UserMapper $mapper;

    public function __construct()
    {
        $this->mapper = new UserMapper();
    }

    public function register(UserDTO $userDTO): void
    {
        $user = $this->createUserFromDTO($userDTO);
        $this->saveUser($user);
    }

    public function login($email, $password): int
    {
        $email = new Email($email);
        $user = $this->mapper->findByEmail(new User($email));
        if(!password_verify($password, $user[0]["password"]))
            throw new \Exception("Неправильний пароль або емейл не існує");
        return $user[0]["id"];
    }

    private function saveUser(User $user): void
    {
        if($this->mapper->findByEmail($user) != [])
            throw new \Exception("Користувач існує");
        $this->mapper->save($user);
    }

    public function findById(int $id): array
    {
        $userData = $this->mapper->findUserById($id);
        unset($userData[0]['id'], $userData[0]['role_id'], $userData[0]['password']);
        return $userData[0];
    }

    public function updateUser(int $id, UserDTO $userDTO): void
    {
        $user = $this->createUserFromDTO($userDTO);
        $user->setId($id);
        $this->mapper->updateUser($user);
    }

    private function createUserFromDTO(UserDTO $userDTO): User
    {
        $validEmail = new Email($userDTO->email);
        $validPassword = $userDTO->password != null ? new Password($userDTO->password) : null;
        return new User($validEmail, $validPassword, $userDTO->name, $userDTO->lastname, $userDTO->birthday);
    }

}