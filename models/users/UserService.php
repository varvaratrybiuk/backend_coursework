<?php

namespace models\users;

use Exception;

class UserService
{
    private UserRepository $repository;

    public function __construct()
    {
        $this->repository = new UserRepository();
    }
    /**
     * @throws Exception
     */
    public function register(UserDTO $userDTO): void
    {
        $user = $this->createUserFromDTO($userDTO);
        $this->saveUser($user);
    }
    /**
     * @throws Exception
     */
    public function login($email, $password): int
    {
        $email = new Email($email);
        $user = $this->repository->findByEmail(new User($email));
        if(empty($user) || !password_verify($password, $user[0]["password"]))
            throw new \Exception("Неправильний пароль або емейл не існує");
        return $user[0]["id"];
    }
    /**
     * @throws Exception
     */
    private function saveUser(User $user): void
    {
        if($this->repository->findByEmail($user) != [])
            throw new \Exception("Користувач існує");
        $this->repository->save($user);
    }

    public function findById(int $id): array
    {
        $userData = $this->repository->findUserById($id);
        unset($userData[0]['id'], $userData[0]['role_id'], $userData[0]['password']);
        return $userData[0];
    }
    /**
     * @throws Exception
     */
    public function updateUser(int $id, UserDTO $userDTO): void
    {
        $user = $this->createUserFromDTO($userDTO);
        $user->setId($id);
        $this->repository->updateUser($user);
    }
    /**
     * @throws Exception
     */
    private function createUserFromDTO(UserDTO $userDTO): User
    {
        $validEmail = new Email($userDTO->email);
        $validPassword = $userDTO->password != null ? new Password($userDTO->password) : null;
        return new User($validEmail, $validPassword, $userDTO->name, $userDTO->lastname, $userDTO->birthday);
    }

}