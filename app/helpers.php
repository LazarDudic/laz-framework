<?php

if (!function_exists('view')) {
    function view($path, $data = [])
    {
        $file = __DIR__ . '/../views/' . $path . '.twig';
        if (!file_exists($file)) {
            throw new Exception('File /views/' . $path . ' does not exist.');
        }

        if (!is_array($data)) {
            throw new Exception('Second parameter of view() function must be an array.');
        }

        return [
            'path' => $path . '.twig',
            'data' => $data
        ];
    }
}

if (!function_exists('pd')) {
    function pd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }
}

if (!function_exists('dd')) {
    function dd($data)
    {
        die(var_dump($data));
    }
}
