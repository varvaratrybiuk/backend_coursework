<?php
function autoload($class): void
{
    $path = str_replace("\\", "/",$class).".php";
    if(file_exists($path))
        require_once($path);

}
spl_autoload_register("autoload");

$testRouter = require 'core/routes/TestRoutes.php';
$core = \core\Core::getInstance();
$core->setRoutes($testRouter);
$core->run();