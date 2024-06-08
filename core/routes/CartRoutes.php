<?php
use core\Router;

$cartRouter = new Router();


$cartRouter->get('/cart', 'CartController_showCartPage');
$cartRouter->post('/cart', 'CartController_actionGetFinaleProducts');

return $cartRouter;