<?php

namespace core;

class BaseController
{
    protected View $view;
    public function __construct()
    {
        $this->view = new View();
    }
}