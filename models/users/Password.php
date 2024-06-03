<?php

namespace models\users;

class Password
{
    private string $hashedPassword;

    public function __construct(string $password)
    {
        $this->ensureIsValidPassword($password);
        $this->hashedPassword = $this->hashPassword($password);
    }

    private function ensureIsValidPassword(string $password): void
    {
        if (strlen($password) < 8) {
            throw new \Exception("Пароль має бути більше 8 символів");
        }

        if (!preg_match('/[A-Z]/', $password)) {
            throw new \Exception("Пароль повинен містити хоча б одну велику літеру");
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new \Exception("Пароль повинен містити хоча б одну малу літеру");
        }

        if (!preg_match('/[0-9]/', $password)) {
            throw new \Exception("Пароль повинен містити хоча б одну цифру");
        }

        if (!preg_match('/[\W]/', $password)) {
            throw new \Exception("Пароль повинен містити хоча б один спеціальний символ!");
        }
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}