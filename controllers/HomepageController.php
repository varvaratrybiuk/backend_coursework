<?php

namespace controllers;

use core\BaseController;

class HomepageController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->view->setFilePathToCss("../../public/css/home_style.css");
    }

    public function actionShowIndex()
    {
        $this->view->renderTemplate("views/home/index.php", "Головна");
    }
}