<?php

namespace controllers;

use core\BaseController;
use core\View;

class ErrorController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->view->setFilePathToCss("../../public/css/main_page_style.css");
    }

    private  array  $statusDescriptions = [
        "404" => "Сторінка не знайдена",
        "500" => "Внутрішня помилка сервера"
    ];
    public function errorPage(int $code): void
    {
        http_response_code($code);
        try {
            $message = $this->statusDescriptions[$code] ?? $this->statusDescriptions["500"];
            $this->view->renderTemplate("views/error/$code.php", $message);
        } catch (\Throwable) {
            $this->errorPage(500);
        }
        die();
    }
}