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
            self::$instance = new \PDO("mysql:host=".$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], 
                $_ENV['DB_USERNAME'],  $_ENV['DB_PASSWORD']);
        }
   
        return self::$instance;
    }
  }