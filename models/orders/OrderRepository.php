<?php

namespace models\orders;

use core\Repository;
use models\address\Address;
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
            $size = $productInform->getSize();
            $this->db->insert("storages", [
                "order_id" => $orderId,
                "product_id" => $productId,
                "quantity" => $quantity,
                "size" => $size
            ])->execute();
            $this->productService->updateProduct($productId, $quantity, $size);
        }
    }
    public function getAllUsersOrders(): array
    {
        $results = $this->db->select("orders", "CONCAT(users.name, ' ', users.lastname) AS full_name, 
        address_information.country,
        address_information.city,
        address_information.street,
        address_information.zip_code, orders.id, orders.status")
            ->join(["users" => "id"], ["orders" => "user_id"])
            ->join(["address_information" => "id"], ["orders" => "address_id"])
            ->execute()
            ->returnAssocArray();
        $userOrders = [];
        foreach ($results as $result) {
            $userOrder = new UserOrder(
                $result['full_name'],
                (int)$result['id'],
                (string)new Address($result['country'], $result['city'],  $result['street'], $result['zip_code']),
                (int)$result['status']
            );
            $userOrders[] = $userOrder;
        }
        return $userOrders;
    }
    public function getAllOrdersProducts(): array
    {
        $result = $this->db->select("storages", "order_id, products.product_name, storages.quantity, storages.size")
            ->join(["products" => "id"], ["storages"=> "product_id"])->execute()->returnAssocArray();
        $orderProducts = [];
        foreach ($result as $row) {
            $orderProduct = new OrderProduct(
                $row['order_id'],
                $row['product_name'],
                $row['quantity'],
                $row['size']
            );
            $orderProducts[] = $orderProduct;
        }

        return $orderProducts;
    }
    public function getOrdersStatuses() : array
    {
        return $this->db->select("status")->execute()->returnAssocArray();
    }
    public function updateStatus(int $orderId, int $statusId): void
    {
        $this->db->update("orders")->set(["status"=>$statusId])
            ->where(["id"=>$orderId])
            ->execute();
    }
}

