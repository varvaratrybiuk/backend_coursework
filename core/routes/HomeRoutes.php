<?php

use core\Router;

$homeRouter = new Router();


$homeRouter->get('/', 'HomepageController_actionShowIndex');

return $homeRouter;