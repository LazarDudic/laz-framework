<?php

namespace App\Core\Request;

class Request
{
    public function urlWithoutQuery(): string
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function method(): string
    {
        return strtoupper($_SERVER["REQUEST_METHOD"]);
    }

    public function all(): array
    {
        $body = [];

        if ($this->method() === 'GET') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        } else if ($this->method() === 'POST') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}
?>