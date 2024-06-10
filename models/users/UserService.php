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
    public function isAdmin($userId):bool
    {
        return $this->repository->gerUserRoleId($userId)["role_id"] == 1;
    }
    /**
     * @throws Exception
     */
    public function register(UserObj $userDTO): int
    {
        $user = $this->createUserFromDTO($userDTO);
        return $this->saveUser($user);
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
    private function saveUser(User $user): false|string
    {
        if($this->repository->findByEmail($user) != [])
            throw new \Exception("Користувач існує");
        return $this->repository->save($user);
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
    public function updateUser(int $id, UserObj $userDTO): void
    {
        $user = $this->createUserFromDTO($userDTO);
        $user->setId($id);
        $this->repository->updateUser($user);
    }
    /**
     * @throws Exception
     */
    private function createUserFromDTO(UserObj $userDTO): User
    {
        $validEmail = new Email($userDTO->email);
        $validPassword = $userDTO->password != null ? new Password($userDTO->password) : null;
        $validBirthday = $userDTO->birthday != null ? new Birthday($userDTO->birthday) : null;
        return new User($validEmail, $validPassword, $userDTO->name, $userDTO->lastname, $validBirthday, $userDTO->role_id);
    }
    public function findUserIdByEmail(string $email)
    {
        $email = new Email($email);
        $user = $this->repository->findByEmail(new User($email));
        return $user ? $user[0]["id"] : null;
    }
}