<?php

/*
MyApp
index.php controller
MyApp\Controller\Index
-> lib/Controller/Index.php
*/

spl_autoload_register(function ($class) {
    $prefix = 'MyApp\\';
    if (strpos($class, $prefix) === 0) {
        # code...
        $className = substr($class, strlen($prefix));
        $classFilePath = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($classFilePath)) {
            # code...
            require $classFilePath;
        }
    }

});
