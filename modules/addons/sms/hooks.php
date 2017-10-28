<?php
require_once __DIR__."/lib/includes.php";
use JNEX\SMS\Hooks;

$hooks = [
    'ClientLogin',
    'AdminLogin'
];

Hooks::init()->add($hooks)->exec();
