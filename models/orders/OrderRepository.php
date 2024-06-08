<?php

namespace models\orders;

use core\Repository;
use models\products\ProductService;

class OrderRepository extends Repository
{
    private ProductService $productService;
    public function __construct()
    {
        parent::__construct();
        $this -> productService = new ProductService();
    }
    public function saveOrder(Order $order): string|false
    {
        $this->db->insert("orders",
            [   "user_id" => $order->getUserId(),
                "address_id" => $order->getAddressId(),
                "order_date" =>  (string)$order->getOrderDate(),
                "status" => $order->getStatus()
            ]
        )->execute();
        return $this->db->lastInsertId();
    }
    public function saveProductAndQuantity(OrderDTO $orderInform): void
    {
        $orderId = $orderInform->getOrderId();
        $productInformList = $orderInform->getProductInform();

        foreach ($productInformList as $productInform) {
            $productId = $productInform->getProductId();
            $quantity = $productInform->getQuantity();
            $size = $productInform->getSizeId();
            $this->db->insert("storages", [
                "order_id" => $orderId,
                "product_id" => $productId,
                "quantity" => $quantity,
                "size" => $size
            ])->execute();
            $this->productService->updateProduct($productId, $quantity, $size);
        }
    }
}

