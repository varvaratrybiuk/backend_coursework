<?php

namespace controllers;

use core\BaseController;
use models\products\ProductService;

class CatalogController extends BaseController
{
    private ProductService $productService;
    public function __construct()
    {
        parent::__construct();
        $this->productService = new ProductService();
    }
    public function showCatalogPage(string $sortByPrice = "ASC"): void
    {
        $this->view->setFilePathToCss("../../public/css/home_style.css");
        $result = $this->productService->getAllProducts();
        $this->view->renderTemplate("views/catalog/productcatalog.php", "Реєстрація",
            ["productObjects" => $result]);
    }
    public function showArtistCatalogPage(string $artistName, string $sortByPrice = "ASC"): void
    {
        $this->view->setFilePathToCss("../../public/css/home_style.css");
        $artistName = str_replace("_", " ", $artistName);
        $result = $this->productService->getAllProducts($artistName);
        $this->view->renderTemplate("views/catalog/productcatalog.php", "Реєстрація",
            ["productObjects" => $result]);
    }
}