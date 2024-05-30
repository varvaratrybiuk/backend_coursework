<?php

namespace controllers;

use core\BaseController;
use core\View;

class ErrorController extends BaseController
{
    private  array  $statusDescriptions = [
        "404" => "Сторінка не знайдена",
        "500" => "Внутрішня помилка сервера"
    ];
    public function errorPage(int $code): void
    {
        http_response_code($code);
        $errorView = new View();
        try {
            $message = $this->statusDescriptions[$code] ?? $this->statusDescriptions["500"];
            $errorView->renderTemplate("views/error/$code.php", $message);
        } catch (\Throwable) {
            $this->errorPage(500);
        }
        die();
    }
}