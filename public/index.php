<?php

use App\Foundation\DatabaseConnection;

require_once __DIR__.'/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

DatabaseConnection::getConnection();