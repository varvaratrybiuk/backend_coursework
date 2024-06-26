<?php

namespace models\users;

use Exception;

class Password
{
    private string $hashedPassword;
    /**
     * @throws Exception
     */
    public function __construct(string $password)
    {
        $this->ensureIsValidPassword($password);
        $this->hashedPassword = $this->hashPassword($password);
    }

    /**
     * @throws Exception
     */
    private function ensureIsValidPassword(string $password): void
    {
        $this->checkLength($password);
        $this->checkUppercase($password);
        $this->checkLowercase($password);
        $this->checkDigit($password);
        $this->checkSpecialCharacter($password);
    }
    /**
     * @throws Exception
     */
    private function checkLength(string $password): void
    {
        if (strlen($password) < 8) {
            throw new Exception("Пароль має бути більше 8 символів");
        }
    }
    /**
     * @throws Exception
     */
    private function checkUppercase(string $password): void
    {
        if (!preg_match('/[A-Z]/', $password)) {
            throw new Exception("Пароль повинен містити хоча б одну велику літеру");
        }
    }
    /**
     * @throws Exception
     */
    private function checkLowercase(string $password): void
    {
        if (!preg_match('/[a-z]/', $password)) {
            throw new Exception("Пароль повинен містити хоча б одну малу літеру");
        }
    }

    private function checkDigit(string $password): void
    {
        if (!preg_match('/[0-9]/', $password)) {
            throw new Exception("Пароль повинен містити хоча б одну цифру");
        }
    }

    private function checkSpecialCharacter(string $password): void
    {
        if (!preg_match('/[\W]/', $password)) {
            throw new Exception("Пароль повинен містити хоча б один спеціальний символ");
        }
    }

    private function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function __toString(): string
    {
        return $this->hashedPassword;
    }
}