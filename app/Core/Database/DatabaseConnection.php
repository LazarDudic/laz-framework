<?php

namespace App\Core\Database;

class DatabaseConnection
{
    private static $instance = null;
    private static $connection = null;

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __wake_up()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance =  new self();;
            self::connect();
        }

        return self::$instance;
    }

    private static function connect()
    {
        try {
            self::$connection = new \PDO("mysql:host=" . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USERNAME'],  $_ENV['DB_PASSWORD']);
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    public static function getConnection()
    {
        return self::$connection;
    }
}
