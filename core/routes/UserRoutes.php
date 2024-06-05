<?php
use core\Router;

$userRouter = new Router();

$userRouter->post("/login", "UserController_actionLogin");
$userRouter->post("/register", "UserController_actionRegister");


$userRouter->get("/logout", "UserController_actionLogout");
$userRouter->get("/login", "UserController_actionShowLogin");
$userRouter->get("/register", "UserController_actionShowRegister");

$userRouter->get("/profile/contact", "UserController_actionShowInfo");
$userRouter->get("/profile/address", "UserController_actionShowAddress");
$userRouter->get("/profile/history", "UserController_actionShowOrders");

$userRouter->post("/profile/address", "UserController_actionAddAddress");
$userRouter->post("/profile/contact", "UserController_actionUpdateInfo");
return $userRouter ;