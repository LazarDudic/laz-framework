<?php

use App\Controllers\HomeController;
use App\Foundation\Route\Route;

return [
    Route::get('/', HomeController::class, 'show'),
    // Route::get('/category/([0-9])+', 'App\Controllers\Controller', 'add'),
];