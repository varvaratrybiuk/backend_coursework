<?php

namespace models\users;


class User
{
    private int $id;
    private ?int $role_id;
    private ?Email $email ;
    private ?Password $password;
    private ?string $name;
    private ?string $lastname;
    private ?Birthday $birthday;
    public function __construct(?Email $email = null, ?Password $password = null, ?string $name = null, ?string $lastname = null, ?Birthday $birthday = null, ?int $role_id = null)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->role_id = $role_id;
    }
    public function getRoleId(): ?int
    {
        return $this->role_id;
    }
    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password|null
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

    public function getBirthday(): Birthday|null
    {
        return $this->birthday;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

}