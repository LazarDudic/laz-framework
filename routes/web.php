<?php

use App\Foundation\Route\Route;

return [
    Route::get('/', 'App\Controllers\HomeController', 'show'),
    // Route::get('/category/([0-9])+', 'App\Controllers\Controller', 'add'),
];