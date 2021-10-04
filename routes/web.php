<?php

use App\Core\Route\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\HomeController;

return [
    Route::get('/', HomeController::class, 'show', [AuthMiddleware::class]),
    // Route::get('/category/([0-9])+', 'App\Controllers\Controller', 'add'),
];