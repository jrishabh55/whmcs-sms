<?php
require_once __DIR__."/lib/includes.php";
use JNEX\SMS\Hooks;
use JNEX\SMS\DB;

if (!DB::exists(JNEX_SMS_TABLE_TEMPLATES)) return;

$hooks = DB::table(JNEX_SMS_TABLE_TEMPLATES)->where(['active' => 1])->pluck('name');
// $hooks = [
//     'ClientLogin',
//     'AdminLogin'
//     // $hookActive
// ];

Hooks::init()->add($hooks)->exec();
