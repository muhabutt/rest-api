<?php


namespace App\Core;


use App\Config\Config;
use App\Core\Response\Response;
use PDO;

class Database
{
    private $host;
    private $db;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = Config::getValue('HOST');
        $this->db = Config::getValue('DBNAME');
        $this->username = Config::getValue('USERNAME');
        $this->password = Config::getValue('PASSWORD');
    }

    public function connectDB()
    {
        try {
            $pdo = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->db.";"."charset=utf8",
                $this->username,
                $this->password);
            //$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            Response::sendJson500Response();
        }

        return $pdo;
    }
}
