<?php


function chargerClass($class) {
    if (strstr(strtolower($class), 'interface')) {
        require_once 'interface/' . $class . '.php';
    } else if (strstr(strtolower($class), 'service')) {
        require_once 'service/' . $class . '.php';
    } else {
        require_once 'class/' . $class . '.php';
    }
}

spl_autoload_register('chargerClass');


$className = Employee::class;


$c = new $className();

print_r($c);
