<?php
namespace JNEX\SMS;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB extends Capsule {

    public function __constructor () {
        super();
    }

    public static function createModuleTables() {
        static::settingTables();
    }

    public static function settingTables() {
        DB::create(JNEX_SMS_TABLE, function ($table) {
            $table->increaments("id");
            $table->string("name");
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

}
