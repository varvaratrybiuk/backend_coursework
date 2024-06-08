<?php

use core\Router;

$catalogRouter = new Router();

$catalogRouter->get("/catalog/", "CatalogController_showCatalogPage");
$catalogRouter->get("/catalog/{artist_name}/", "CatalogController_showArtistCatalogPage");
$catalogRouter->get("/catalog/product/{product_id}", "CatalogController_showProductPage");

$catalogRouter->post("/catalog/", "CatalogController_showSortedProducts");
$catalogRouter->post("/catalog/product/{product_id}", "CatalogController_actionAddCommentAndRating");
$catalogRouter->post("/catalog/{artist_name}?/", "CatalogController_showSortedProducts");
return $catalogRouter;