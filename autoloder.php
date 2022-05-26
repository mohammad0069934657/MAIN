<?php
#cache constants
define('CACHE_ENABLED',0);
define('CACHE_DIR',__DIR__.'/cache');
#Authorization Constants
define('JWT_KEY','reza7485548545151*62626262626');
define('JWT_ALG','HS256');
include_once 'vendor/autoload.php';
include_once 'app/iran.php';
spl_autoload_register(function ($class){
    $class_file = __DIR__ . "/" . $class . ".php";
    if(!(file_exists($class_file) and is_readable($class_file)))
        die("$class not found");
    include_once $class_file;
    // echo $class_file;
});



