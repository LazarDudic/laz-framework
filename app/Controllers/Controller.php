<?php
namespace App\Controllers;


class Controller
{
    private $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }
    public function add()
    {
        return view('404', compact('marko'));
    }
}