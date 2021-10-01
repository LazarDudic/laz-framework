<?php
namespace App\Controllers;

use App\Core\Database\DatabaseConnection;

abstract class Controller
{
    protected $db;

    public function __construct(DatabaseConnection $db)
    {
        $this->db = $db;
    }

}