<?php
namespace App\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function show() 
    {
        return view('home');
    }
}