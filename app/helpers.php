<?php

if (! function_exists('view')) {
    function view($path, $data = [])
    {
        $file = __DIR__.'/../views/'.$path.'.twig';
        if (!file_exists($file)) {
            throw new Exception('File /views/'.$path.' does not exist.');
        }

        if (!is_array($data)) {
            throw new Exception('Second parameter of view() function must be an array.');
        }

        return [
            'path' => $path.'.twig',
            'data' => $data
        ];
    }
}