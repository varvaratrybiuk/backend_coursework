<?php

namespace models\users;

class Guest
{
    public string $email;
    public ?int $role_id;
    public string $name;
    public string $lastname;
}