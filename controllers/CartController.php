<?php

namespace controllers;

use core\BaseController;
use core\Request;
use models\products\ProductService;

class CartController extends BaseController
{
    private ProductService $productService;
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
        $this->view->setFilePathToCss("../../public/css/cart_and_payment.css");
    }
    public function showCartPage(): void
    {
        $this->view->renderTemplate("views/cart/cart.php", "Корзина");
    }
    public function actionGetFinaleProducts(){
        $userData = json_decode(Request::getPost("json"), true);
        $result = [];
        foreach ($userData as $item) {
            $decodedItem = json_decode($item['value'], true);
            $result = $decodedItem;
        }
        $data = [];
        foreach ($result as $item){
            $data[] = $this->productService->getProductsByIdAndSize($item['id'], $item['size']);
        }
         $this->view->renderTemplateWithout("views/cart/cartTemplate.php", ["data" =>  $data]);
    }
}