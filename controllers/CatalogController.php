<?php

namespace controllers;

use core\BaseController;
use core\Request;
use models\products\ProductService;

class CatalogController extends BaseController
{
    private ProductService $productService;
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();

    }
    private function tryCatchWrapper(callable $action): void
    {
        try {
            $action();
        } catch (\Exception $e) {
            $error = new ErrorController();
            $error->errorPage(404);
        }
    }
    public function showCatalogPage(): void
    {
        $this->tryCatchWrapper(function(){
            $this->view->setFilePathToCss("../../public/css/default_catalog.css");
            $result = $this->productService->getAllProducts();
            $this->view->renderTemplate("views/catalog/productscatalog.php", "Реєстрація",
                ["productObjects" => $result]);
        });
    }
    public function showArtistCatalogPage(string $artistName): void
    {
        $this->tryCatchWrapper(function() use ($artistName) {
            $this->view->setFilePathToCss("../../public/css/{$artistName}_theme.css");
            $artistName = str_replace("_", " ", $artistName);
            $result = $this->productService->getAllProducts($artistName);
            $this->view->renderTemplate("views/catalog/productscatalog.php", "Реєстрація",
                ["productObjects" => $result]);
        });

    }
    public function showSortedProducts(?string $artistName = null): void
    {
        $this->tryCatchWrapper(function () use ($artistName) {
            $price = Request::getPost("sortPrice");
            $rating = Request::getPost("sortRating");
            if($artistName)
                $artistName = str_replace("_", " ", $artistName);
            $result = $this->productService->sortProducts($price, $rating, $artistName);
            $this->view->renderTemplateWithout("views/catalog/productscatalog.php", "Реєстрація",
                ["productObjects" => $result]);
        });
    }
    public function showProductPage(int $product_id): void
    {
        $this->tryCatchWrapper(function () use ($product_id) {
            $result = $this->productService->getProductById($product_id);
            $this->view->setFilePathToCss("../../public/css/product_page.css");
            $this->view->renderTemplate("views/catalog/productpage.php", "Реєстрація",
                ["productObject" => $result]);
        });
    }
}