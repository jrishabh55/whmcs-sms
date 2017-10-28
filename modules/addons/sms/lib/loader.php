<?php

spl_autoload_register(function ($class) {
    $class = explode("\\", $class);
    unset($class[1]);
    $file = __DIR__.'/'.implode(DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require_once($file);
    }
});

 ?>
