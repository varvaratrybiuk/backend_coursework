<?php

namespace core;

class Session
{

    public function startSession(): void
    {
        if(session_id() == "")
            session_start();
    }
    public function  add($key, $value): void
    {
        $_SESSION[$key][] = $value;
    }
    public function get($key)
    {
        if (array_key_exists($key, $_SESSION))
            return $_SESSION[$key];
    }
    public function unset(): void
    {
        unset($_SESSION['id']);
    }
    public function userIsLoggedIn(): bool
    {
        return (bool)$this->get('id');
    }
}