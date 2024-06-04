<?php
use core\Router;

$userRouter = new Router();

$userRouter->post("/login", "UserController_actionLogin");
$userRouter->post("/register", "UserController_actionRegister");


$userRouter->get("/logout", "UserController_actionLogout");
$userRouter->get("/login", "UserController_actionShowLogin");
$userRouter->get("/register", "UserController_actionShowRegister");
$userRouter->get("/profile/{name}?", "UserController_actionShowProfile");


return $userRouter ;