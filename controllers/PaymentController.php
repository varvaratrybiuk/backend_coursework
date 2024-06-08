<?php

namespace controllers;

use core\BaseController;
use core\Core;
use core\Request;
use models\address\AddressDTO;
use models\address\AddressService;
use models\orders\OrderDTO;
use models\orders\OrderService;
use models\orders\ProductInformDTO;
use models\users\UserDTO;
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
        $addressId = $this->getAddressId($userId);
        $orderDate = date('Y-m-d');
        $orderDTO = new OrderDTO($orderDate, $productInformList);

        try {
            if (!Core::getInstance()->getCurrentSession()->userIsLoggedIn()) {
                $this->processGuestOrder($orderDTO, $addressId);
            } else {
                $this->orderService->addUserOrder($addressId, $userId, $orderDTO);
            }
        } catch (\Exception $e) {
            $this->view->renderJson(["error" => $e->getMessage()]);
        }
        $this->view->renderJson(["done" => true]);
    }

    private function createProductInformList($userData): array
    {
        $productInformList = [];
        foreach ($userData as $item) {
            $decodedItem = json_decode($item['value'], true);
            foreach ($decodedItem as $item){
                $productInformList[] = new ProductInformDTO($item["id"], $item["quantity"], $item["size"]);
            }
        }
        return $productInformList;
    }

    private function getAddressId($userId): ?int
    {
        $addressId = Request::getPost('addressId');
        if (empty($addressId)) {
            $country = Request::getPost('country');
            $city = Request::getPost('city');
            $street = Request::getPost('street');
            $zipCode = Request::getPost('zip_code');
            $addressDTO = new AddressDTO($country, $city, $street, $zipCode);
            if(Core::getInstance()->getCurrentSession()->userIsLoggedIn())
                $addressId = $this->addressService->addAddress($addressDTO, $userId);
        }
        return $addressId;
    }

    /**
     * @throws \Exception
     */
    private function processGuestOrder($orderDTO, $addressId): void
    {
        $firstName = Request::getPost('first_name');
        $lastName = Request::getPost('last_name');
        $email = Request::getPost('email');
        $newUser = new UserDTO(
            $email,
            null,
            $firstName,
            $lastName,
            null,
            3
        );
        $this->orderService->addGuestOrder($newUser, $orderDTO,  $addressId);
    }
}