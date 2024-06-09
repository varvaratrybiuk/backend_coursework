<?php

namespace controllers;

use core\BaseController;
use core\Core;
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

    private function tryCatchWrapper(callable $action, int $code = 404): void
    {
        try {
            $action();
        } catch (\Exception $e) {
            $error = new ErrorController();
            $error->errorPage($code);
        }
    }

    private function setCssAndRender(string $cssPath, string $templatePath, string $pageTitle, array $params = []): void
    {
        $this->view->setFilePathToCss($cssPath);
        $this->view->renderTemplate($templatePath, $pageTitle, $params);
    }

    private function renderTemplateWithoutCss(string $templatePath,  array $params = []): void
    {
        $this->view->renderTemplateWithout($templatePath,  $params);
    }

    public function showCatalogPage(): void
    {
        $this->tryCatchWrapper(function() {
            $result = $this->productService->getAllProducts();
            $this->setCssAndRender("../../public/css/default_catalog.css", "views/catalog/productscatalog.php", "Каталог", ["productObjects" => $result]);
        });
    }

    public function showArtistCatalogPage(string $artistName): void
    {
        $this->tryCatchWrapper(function() use ($artistName) {
            $cssPath = "../../public/css/{$artistName}_theme.css";
            $artistNameFormatted = str_replace("_", " ", $artistName);
            $result = $this->productService->getAllProducts($artistNameFormatted);
            $this->setCssAndRender($cssPath, "views/catalog/productscatalog.php", "Каталог", ["productObjects" => $result]);
        });
    }

    public function showSortedProducts(?string $artistName = null): void
    {
        $this->tryCatchWrapper(function() use ($artistName) {
            $price = Request::getPost("sortPrice");
            $rating = Request::getPost("sortRating");
            $artistNameFormatted = $artistName ? str_replace("_", " ", $artistName) : null;
            $result = $this->productService->sortProducts($price, $rating, $artistNameFormatted);
            $this->renderTemplateWithoutCss("views/catalog/productscatalog.php",  ["productObjects" => $result]);
        });
    }

    public function showProductPage(int $product_id): void
    {
        $this->tryCatchWrapper(function() use ($product_id) {
            $result = $this->productService->getProductById($product_id);
            $this->setCssAndRender("../../public/css/product_page.css", "views/catalog/productpage.php", "Продукт", ["productObject" => $result]);
        });
    }
    public function actionAddCommentAndRating(int $product_id): void
    {
        $this->tryCatchWrapper(function () use ($product_id) {
            $user_id = Core::getInstance()->getCurrentSession()->get("id");
            $comment = Request::getPost("comment");
            $star = Request::getPost("rating");
            $this->productService->addComment($product_id, $comment,  $user_id,  $star );
            $this->tryCatchWrapper(function() use ($product_id) {
                $result = $this->productService->getProductById($product_id);
                $this->view->renderTemplateWithout("views/catalog/productpage.php", ["productObject" => $result]);
            });
        }, 500);
    }
}