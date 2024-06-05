<?php

use core\Router;

$catalogRouter = new Router();

$catalogRouter->get("/catalog/{sort_type}?", "CatalogController_showCatalogPage");
$catalogRouter->get("/catalog/{artist_name}/{sort_type}?", "CatalogController_showArtistCatalogPage");

return $catalogRouter;