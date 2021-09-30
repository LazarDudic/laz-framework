<?php

use App\Foundation\Database\DatabaseConnection;
use App\Foundation\DIContainer\Container;
use App\Models\User;

$container = new Container();

$container->bind(DatabaseConnection::class, DatabaseConnection::getInstance());
// $container->bind(User::class, new User(DatabaseConnection::getInstance()));

return $container;