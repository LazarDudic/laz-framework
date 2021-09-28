<?php
namespace App\Foundation;

class DatabaseConnection {

    private static $instance = null;
    
    private function __construct(){}
    private function __clone(){}
    private function __wake_up(){}
   
    public static function getConnection()
    {
        if (self::$instance == null)
        {
            try {
                self::$instance = new \PDO("mysql:host=".$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], $_ENV['DB_USERNAME'],  $_ENV['DB_PASSWORD']);
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT); 
            } catch(\PDOException $error) {
                echo $error->getMessage();
            }
        }
   
        return self::$instance;
    }
  }