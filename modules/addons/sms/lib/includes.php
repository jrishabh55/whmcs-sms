<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}
require_once __DIR__.'/loader.php';

use JNEX\SMS\DB;
$sysurl = DB::table('tblconfiguration')->where('setting','=','SystemURL')->first()->value;
$username = DB::table('tbladmins')->first()->username || '';

define('JNEX_SMS_MODULE_NAME', 'sms');
define('JNEX_SMS_PREFIX', 'jnex');
define('JNEX_SMS_TABLE_PROVIDER', JNEX_SMS_PREFIX.'sms_provider');
define('JNEX_SMS_TABLE_TEMPLATES', JNEX_SMS_PREFIX.'sms_templates');
define('JNEX_SMS_URL', $sysurl);
define('JNEX_SMS_ADMIN_USERNAME', $username);
