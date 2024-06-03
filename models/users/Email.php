<?php

namespace models\users;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!$this->isValidEmail($email)) {
            throw new \Exception("Неправильний формат емейлу");
        }
        $this->email = $email;
    }

    private function isValidEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}