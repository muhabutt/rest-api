<?php


namespace App\Core;


use App\Config\Config;
use PDO;
use PDOException;

/**
 * Class Database
 * @package App\Core
 */
class Database
{
    /**
     * @var mixed|string
     */
    private $host;
    /**
     * @var mixed|string
     */
    private $db;
    /**
     * @var mixed|string
     */
    private $username;
    /**
     * @var mixed|string
     */
    private $password;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $this->host = Config::getValue('HOST');
        $this->db = Config::getValue('DBNAME');
        $this->username = Config::getValue('USERNAME');
        $this->password = Config::getValue('PASSWORD');
    }

    /**
     * Connects with databases and return PDO
     * @return PDO
     */
    public function connectDB()
    {
        $pdo = null;
        try {
            $pdo = new PDO(
                "mysql:host=".$this->host.";dbname=".$this->db.";"."charset=utf8",
                $this->username,
                $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        } catch (PDOException $e) {
            Helpers::errorResponse500('Could not connect to database!');
        }

        return $pdo;
    }
}
