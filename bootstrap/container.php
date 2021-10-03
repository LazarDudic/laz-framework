<?php

use App\Core\DIContainer\Container;
use App\Core\Database\DatabaseConnection;

$container = new Container();

$container->bind(DatabaseConnection::class, DatabaseConnection::getInstance());
// $container->bind(User::class, new User(DatabaseConnection::getInstance()));

return $container;