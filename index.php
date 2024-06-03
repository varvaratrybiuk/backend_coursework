<?php
function autoload($class): void
{
    $path = str_replace("\\", "/",$class).".php";
    if(file_exists($path))
        require_once($path);

}
spl_autoload_register("autoload");

$homeRouter = require 'core/routes/HomeRoutes.php';

$core = \core\Core::getInstance();
$core->setRoutes($homeRouter);
$core->setRoutes(require 'core/routes/UserRoutes.php');
$core->run();