<?php

namespace controllers;

use core\BaseController;
use core\Core;
use core\Request;
use models\orders\OrderService;
use models\products\ArtistRepository;
use models\products\ProductService;
use models\products\SizeRepository;

class AdminController extends BaseController
{
    private ProductService $productService;
    private ArtistRepository $artistRepository;
    private  SizeRepository $sizeRepository;
    private OrderService $orderService;
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
        $this->artistRepository = new ArtistRepository();
        $this->sizeRepository = new SizeRepository();
        $this->orderService = new OrderService();
        $this->view->setFilePathToCss("../../public/css/admin_styles.css");
    }
    private function isAdmin(): void
    {
        if(Core::getInstance()->getCurrentSession())
            header("Location: /");
    }
    //Зміна замовлення
    public function showChangeOrderStatusPage(): void
    {
        $usersOrders = $this->orderService->getAllUsersOrders();
        $ordersProducts = $this->orderService->getAllOrdersProducts();
        $statuses = $this->orderService->getOrdersStatuses();
        $this->view->renderTemplate("views/admin/changeStatus.php", "Змінити статус замовлення", [
            "usersOrders" => $usersOrders,
            "ordersProducts" => $ordersProducts,
            "statuses"=> $statuses
        ]);
    }

    public function actionChangeOrderStatus(): void
    {
        $orderId = Request::getPost("orderId");
        $newStatus = Request::getPost("newStatusId");
        $this->orderService->updateStatus($orderId, $newStatus);
    }
    //Оновлення кількості та цін
    public function showUpdateProductPage(): void
    {
        $products = $this->productService->getAllProducts();
        $this->view->renderTemplate("views/admin/changePrice.php", "Оновити продукт", ["products"=>$products]);
    }
    public function actionUpdateProduct(): void
    {
        $productData = json_decode(Request::getPost("json"), true);
        $this->productService->updateVariants($productData);
    }
    //Додати продукт
    public function showAddProduct(): void
    {
        $products = $this->productService->getAllProducts();
        $artist = $this->artistRepository->getAllArtists();
        $sizes = $this->sizeRepository->getAllSizes();
        $this->view->renderTemplate("views/admin/addProduct.php", "Додати продукт",
            ["products" => $products, "artists" => $artist, "sizes" => $sizes]);
    }

    public function actionAddProduct($formName) : void
    {
        if ($formName == "productForm") {
            $this->processingProductForm(Request::getPost());
        } elseif ($formName == "variantForm") {
            $this->processingVariantForm(Request::getPost());
        } else {
        }
    }
    private function processingVariantForm(array $data){
        $productId = $data["product"];
        $sizeId = $data["size"];
        $quantity = $data["quantity"];
        $price = $data["price"];
        $this->productService->addVariants($productId, $sizeId, $quantity, $price);
    }

    private function processingProductForm(array $data): void
    {
        $name = $data["name"];
        $description = $data["description"];
        $photos = $this->processingPhotos($name);
        $artist = $data["artist"];
        $this->productService->saveProductAndPhotos($artist, $name, $description, $photos);
    }
    private function processingPhotos(string $name): array
    {
        $uploadedFiles = [];
        foreach ($_FILES['photos']['name'] as $key => $photoName) {
            $file = $_FILES['photos']['tmp_name'][$key];
            if (file_exists("public/images/save_images")) {
                $path = "public/images/save_images/" . $name . uniqid() . ".png";
                if (move_uploaded_file($file, $path)) {
                    $uploadedFiles[] = "../../" . $path;
                }
            }
        }
        return $uploadedFiles;
    }
}