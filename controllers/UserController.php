<?php

namespace controllers;

use core\BaseController;
use core\Core;
use core\Request;
use models\address\AddressDTO;
use models\address\AddressService;
use models\users\UserDTO;
use models\users\UserService;

class UserController extends BaseController
{
    private UserService $service;
    private AddressService $addressService;
    public function __construct()
    {
        parent::__construct();
        $this->service = new UserService();
        $this->addressService = new AddressService();
        $this->view->setFilePathToCss("../../public/css/form_style.css");
        $this->view->setFilePathToScript("../../public/js/form_fetch.js");
    }
    private function auth(): void
    {
        if(!Core::getInstance()->getCurrentSession()->userIsLoggedIn())
            header("Location: /login");
    }
    private function redirectIfLoggedIn(): void
    {
        if (Core::getInstance()->getCurrentSession()->userIsLoggedIn()) {
            header("Location: /");
            exit();
        }
    }

    public function actionShowLogin(): void
    {
        $this->redirectIfLoggedIn();
        $this->view->renderTemplate("views/user/login.php", "Вхід");
    }

    public function actionShowRegister(): void
    {
        $this->redirectIfLoggedIn();
        $this->view->renderTemplate("views/user/registration.php", "Реєстрація");
    }

    private function tryCatchWrapper(callable $action): void
    {
        try {
            $action();
        } catch (\Exception $e) {
            $this->view->renderJson(["error" => $e->getMessage()]);
        }
    }

    public function actionLogin(): void
    {
        $this->tryCatchWrapper(function () {
            $email = Request::getPost('logemail');
            $password = Request::getPost('logpassword');
            $user_id = $this->service->login($email, $password);
            Core::getInstance()->getCurrentSession()->add("id", $user_id);
            $this->view->renderJson(["redirect" => "/"]);
        });
    }

    public function actionRegister(): void
    {
        $this->tryCatchWrapper(function () {
            $registrationData = Request::getPost();
            $newUser = new UserDTO(
                $registrationData['regemail'],
                $registrationData['regpassword'],
                $registrationData['regname'],
                $registrationData['reglastname'],
                $registrationData['regbirthday'] ?? null
            );
            $this->service->register($newUser);
            $this->view->renderJson(["redirect" => "/login"]);
        });
    }
    public function actionLogout()
    {
        $this->auth();
        Core::getInstance()->getCurrentSession()->unset();
        header("Location: /login");
        exit;
    }
    private function showProfile(string $templateName, array $data = []): void
    {
        $this->view->setFilePathToCss("../../public/css/profile.css");
        $this->view->renderTemplate("views/user/usermenu.php", "Профіль",
            ["userMenuContent" => $this->view->getHTML("views/user/user_menu_items/$templateName.php", $data) ]);
    }
    public function actionShowInfo(): void
    {
        $this->auth();
        $user_id = Core::getInstance()->getCurrentSession()->get("id");
        $userInfo = $this->service->findById($user_id);
        $this->showProfile("contact", $userInfo);
    }

    public function actionShowAddress(): void
    {
        $this->auth();
        $user_id = Core::getInstance()->getCurrentSession()->get("id");
        $addressesArray = $this->addressService->findByUserId($user_id);
        $this->showProfile("address", $addressesArray);
    }

    public function actionShowOrders(): void
    {
        $this->auth();
        $this->showProfile("history");
    }
    public function actionUpdateInfo(): void
    {
        $this->auth();
        $this->tryCatchWrapper(function () {
            $user_id = Core::getInstance()->getCurrentSession()->get("id");
            $updateData = new UserDTO(
                Request::getPost('edit_email') ?? '',
                '',
                Request::getPost('edit_name') ?? '',
                Request::getPost('edit_lastname') ?? '',
                Request::getPost('edit_birthday') ?? null
            );
            $this->service->updateUser($user_id, $updateData);
            $this->view->renderJson(["redirect" => "/profile/contact"]);
        });
    }

    public function actionAddAddress(): void
    {
        $this->auth();
        $this->tryCatchWrapper(function () {
            $user_id = Core::getInstance()->getCurrentSession()->get("id");
            $address = new AddressDTO(
                Request::getPost('country'),
                Request::getPost('city'),
                Request::getPost('edit_street'),
                Request::getPost('zip_code')
            );
            $this->addressService->addAddress($address, $user_id);
            $this->view->renderJson(["redirect" => "/profile/address"]);
        });
    }

}