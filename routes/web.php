<?php

use App\Controllers\HomeController;
use App\Core\Route\Route;

return [
    Route::get('/', HomeController::class, 'show'),
    // Route::get('/category/([0-9])+', 'App\Controllers\Controller', 'add'),
];