<?php

namespace models\users;

class UserService
{
    public UserMapper $mapper;

    public function __construct()
    {
        $this->mapper = new UserMapper();
    }
    public function register($email, $password, $name, $lastname, $birthday = null): void
    {
        $validEmail = new Email($email);
        $validPassword = new Password($password);
        $user =  new User($validEmail, $validPassword, $name, $lastname, $birthday);
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
}