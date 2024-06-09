<?php
use core\Router;

$adminRouter = new Router();

$adminRouter->get("/admin/add", "AdminController_showAddProduct");
$adminRouter->get("/admin/update", "AdminController_showUpdateProductPage");
$adminRouter->get("/admin/update_status", "AdminController_showChangeOrderStatusPage");

$adminRouter->post("/admin/add/{form_name}", "AdminController_actionAddProduct");
$adminRouter->post("/admin/update", "AdminController_actionUpdateProduct");
$adminRouter->post("/admin/update_status", "AdminController_actionChangeOrderStatus");


return $adminRouter;