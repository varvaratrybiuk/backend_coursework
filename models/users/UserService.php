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
    public function register(UserObj $userObj): int
    {
        $user = $this->createUserFromObj($userObj);
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
    public function updateUser(int $id, UserObj $userObj): void
    {
        $user = $this->createUserFromObj($userObj);
        $user->setId($id);
        $this->repository->updateUser($user);
    }
    /**
     * @throws Exception
     */
    private function createUserFromObj(UserObj $userObj): User
    {
        $validEmail = new Email($userObj->email);
        $validPassword = $userObj->password != null ? new Password($userObj->password) : null;
        $validBirthday = $userObj->birthday != null ? new Birthday($userObj->birthday) : null;
        return new User($validEmail, $validPassword, $userObj->name, $userObj->lastname, $validBirthday, $userObj->role_id);
    }
    public function findUserIdByEmail(string $email)
    {
        $email = new Email($email);
        $user = $this->repository->findByEmail(new User($email));
        return $user ? $user[0]["id"] : null;
    }
}