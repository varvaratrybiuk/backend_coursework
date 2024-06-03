<?php

namespace models\users;


class User
{
    private int $id;
    private ?Email $email ;
    private ?Password $password;
    private ?string $name;
    private ?string $lastname;
    private ?string $birthday;
    public function __construct($email = null, $password = null, $name = null, $lastname = null, $birthday = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getBirthday()
    {
        return $this->birthday;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }
}