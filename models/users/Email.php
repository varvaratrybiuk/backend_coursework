<?php

namespace models\users;

use Exception;

class Email
{
    private string $email;
    /**
     * @throws Exception
     */
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

    public function __toString(): string
    {
        return $this->email;
    }
}