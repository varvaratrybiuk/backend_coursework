<?php

namespace controllers;

use core\BaseController;
use core\Core;
use core\Request;
use models\users\UserService;

class UserController extends BaseController
{
    private UserService $service;
    public function __construct()
    {
        parent::__construct();
        $this->service = new UserService();
        $this->view->setFilePathToCss("../../public/css/form_style.css");
        $this->view->setFilePathToScript("../../public/js/form_fetch.js");
    }
    public function actionShowLogin(): void
    {
        $this->view->renderTemplate("views/user/login.php", "Вхід");
    }
    public function actionShowRegister(): void
    {
        $this->view->renderTemplate("views/user/registration.php", "Реєстрація");
    }
    public function actionLogin(): void
    {
        try
        {
            $email = Request::getPost('logemail');
            $password = Request::getPost('logpassword');
            $user_id = $this->service->login($email , $password);
            Core::getInstance()->getCurrentSession()->add("id", $user_id);
            $this->view->renderJson(["redirect" => "/"]);
        }
       catch (\Exception $e){
           $this->view->renderJson(["error" => $e->getMessage()]);
       }

    }
    public function actionRegister(): void
    {
        try
        {
            $email = Request::getPost('regemail');
            $password = Request::getPost('regpassword');
            $name = Request::getPost('regname');
            $lastname = Request::getPost('reglastname');
            $birthday = Request::getPost('regbirthday');
            $this->service->register($email, $password, $name, $lastname, $birthday);
            $this->view->renderJson(["redirect" => "/login"]);
        }
        catch (\Exception $e){
            $this->view->renderJson(["error" => $e->getMessage()]);
        }
    }
    public function actionLogout()
    {
        Core::getInstance()->getCurrentSession()->unset();
        header("Location: /login");
        exit;
    }
    public function actionShowProfile(string $templateName = "contactInfo")
    {
        $this->view->setFilePathToCss("../../public/css/profile.css");
        $this->view->renderTemplate("views/user/usermenu.php", "Профіль",
            $data = ["userMenuContent" => $this->view->getHTML("views/user/user_menu_items/$templateName.php") ]);
    }
    public function actionUpdate(){

    }
}