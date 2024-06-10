<?php

namespace controllers;

use core\BaseController;
use core\Core;
use core\Request;
use models\address\AddressObj;
use models\address\AddressService;
use models\orders\OrderObj;
use models\orders\OrderService;
use models\orders\ProductInformObj;
use models\users\UserObj;
use models\users\UserService;

class PaymentController extends BaseController
{
    private UserService $service;
    private OrderService $orderService;
    private AddressService $addressService;
    public function __construct()
    {
        parent::__construct();
        $this->service = new UserService();
        $this->orderService = new OrderService();
        $this->addressService = new AddressService();
        $this->view->setFilePathToCss("../../public/css/form_style.css");
    }
    public function showPaymentPage():void
    {
        if(Core::getInstance()->getCurrentSession()->userIsLoggedIn()){
            $user_id = Core::getInstance()->getCurrentSession()->get("id");
            $userInfo = $this->service->findById($user_id);
            $addresses = $this->addressService->findByUserId($user_id);
            $this->view->renderTemplate("views/payment/payment.php", "Оплата", [
                "userInfo" => $userInfo, "addresses" => $addresses]);
            return;
        }
        $this->view->renderTemplate("views/payment/payment.php", "Оплата");
    }

    public function actionPayment(): void
    {
        $userId = Core::getInstance()->getCurrentSession()->get("id");
        $userData = json_decode(Request::getPost("json"), true);
        $productInformList = $this->createProductInformList($userData);
        $orderDate = date('Y-m-d');
        $orderObj = new OrderObj($orderDate, $productInformList);

        try {
            if (!Core::getInstance()->getCurrentSession()->userIsLoggedIn()) {
                $this->processGuestOrder($orderObj);
            } else {
                $addressId = $this->getAddressId($userId);
                $this->orderService->addUserOrder($addressId, $userId, $orderObj);
            }
        } catch (\Exception $e) {
            $this->view->renderJson(["error" => $e->getMessage()]);
            die();
        }
        $this->view->renderJson(["done" => true]);
    }

    private function createProductInformList($userData): array
    {
        $productInformList = [];
        foreach ($userData as $item) {
            $decodedItem = json_decode($item['value'], true);
            foreach ($decodedItem as $item){
                $productInformList[] = new ProductInformObj($item["id"], $item["quantity"], $item["size"]);
            }
        }
        return $productInformList;
    }

    private function getAddressId($userId): ?int
    {
        $addressId = Request::getPost('addressId');
        if (empty($addressId)) {
            $addressDTO = $this->getAddressObj();
            if(Core::getInstance()->getCurrentSession()->userIsLoggedIn())
                $addressId = $this->addressService->addAddress($addressDTO, $userId);
        }
        return $addressId;
    }
    private function getAddressObj(): AddressObj
    {
        $country = Request::getPost('country');
        $city = Request::getPost('city');
        $street = Request::getPost('street');
        $zipCode = Request::getPost('zip_code');
        return new AddressObj($country, $city, $street, $zipCode);
    }
    /**
     * @throws \Exception
     */
    private function processGuestOrder($orderObj): void
    {
        $firstName = Request::getPost('first_name');
        $lastName = Request::getPost('last_name');
        $email = Request::getPost('email');
        $newUser = new UserObj(
            $email,
            null,
            $firstName,
            $lastName,
            null,
            3
        );
        $addressObj = $this->getAddressObj();
        $this->orderService->addGuestOrder($newUser, $orderObj,  $addressObj);
    }
}