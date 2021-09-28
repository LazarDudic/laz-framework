<?php
namespace App\Controllers;

abstract class Controller
{
    protected $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }

}