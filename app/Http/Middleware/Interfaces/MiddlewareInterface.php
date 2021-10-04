<?php
namespace App\Http\Middleware\Interfaces;

interface MiddlewareInterface
{
    public function handle($request);
}