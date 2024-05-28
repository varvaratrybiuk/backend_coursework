<?php

use core\Router;

$testRouter = new Router();

$testRouter->get('/store/{userID}/{page}', 'TestController_actionStore');
$testRouter->get('/', 'TestController_actionIndex');
$testRouter->get('/me/{id}?', 'TestController_actionProfile');
return $testRouter;