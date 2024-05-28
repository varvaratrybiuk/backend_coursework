<?php

namespace controllers;

use core\BaseController;

class TestController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function actionStore(int $userdId, int $page): void
    {
        $this->view->renderTemplate("views/test/store.php", "Магазин", ["userId"=>$userdId]);
    }
    public function actionIndex(): void
    {
        $this->view->renderTemplate("views/test/index.php", "Магазин");
    }
    public  function actionProfile(): void
    {
        $this->view->renderTemplate("views/test/me.php", "Магазин");
    }
}