<?php

namespace core;
class Core extends Singleton
{
    private Router $router;
    protected function __construct() {
        parent::__construct();
        $this->router = new Router();
    }
    public function setRoutes(Router $somerouter): void
    {
        $this->router->addRoutes($somerouter);
    }
    public function run(): void
    {
        $this->router->run();
    }

}