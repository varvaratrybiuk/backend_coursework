<?php

namespace models\users;

class UserDTO
{
    public string $email;
    public ?int $role_id;
    public ?string $password;
    public string $name;
    public string $lastname;
    public ?string $birthday;

    public function __construct(string $email, ?string $password, string $name, string $lastname, ?string $birthday = null, int $role_id = 2)
    {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->role_id = $role_id;
    }

}