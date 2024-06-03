<?php

namespace core;
class Core extends Singleton
{
    private Router $router;
    private DataBase $db;
    private Session $session;
    protected function __construct() {
        parent::__construct();
        $this->session = new Session();
        $this->session->startSession();
        $dataBaseConfiguration = Config::readAndGet('config/database.php');
        $this->db = new DataBase($dataBaseConfiguration["dbHost"], $dataBaseConfiguration["dbName"],
            $dataBaseConfiguration["dbLogin"], $dataBaseConfiguration["dbPassword"]);
        $this->router = new Router();

    }
    public function getCurrentSession(): Session
    {
        return $this->session;
    }
    public function getDataBaseObj(): DataBase
    {
        return $this->db;
    }
    public function setRoutes(Router $someRouter): void
    {
        $this->router->addRoutes($someRouter);
    }

    public function run(): void
    {
        $this->router->run();
    }

}