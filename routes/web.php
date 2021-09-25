<?php

use App\Controllers\Controller;
use App\Foundation\Route;

return [
    Route::get('/', 'App\Controllers\Controller', 'add'),
    Route::get('/category/([0-9])+', 'App\Controllers\Controller', 'add'),
];