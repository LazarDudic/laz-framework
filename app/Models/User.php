<?php
namespace App\Models;

class User extends Model
{
    protected $table = 'users';
    protected $columns = [
        'name',
        'email',
        'password'
    ];

}