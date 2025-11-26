<?php
define('BASE_URL', 'http://localhost/basisdata_lanjut/public/');

spl_autoload_register(function($class){
    $paths = [__DIR__ . '/../models/', __DIR__ . '/../controllers/'];
    foreach($paths as $p){
        $file = $p . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});
