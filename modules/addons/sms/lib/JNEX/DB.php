<?php
namespace JNEX\SMS;

use Illuminate\Database\Capsule\Manager as Capsule;

class DB extends Capsule
{
    public function __constructor()
    {
        super();
    }

    public static function createModuleTables()
    {
        static::settingTables();
    }

    public static function settingTables()
    {
        self::schema()->create(JNEX_SMS_TABLE_PROVIDER,function ($table){
          $table->increments('id');
          $table->unsignedInteger('remaining')->default(0);
          $table->unsignedInteger('sent')->default(0);
          $table->string('name')->unique();
          $table->boolean('active')->default(FALSE);
          });

          self::schema()->create(JNEX_SMS_TABLE_TEMPLATES, function($table){
          $table->increments('id');
          $table->string('name')->unique();
          $table->string('value');
          $table->boolean('active')->default(TRUE);
        });
    }

    public static function addHook()
    {
        $hookList = [
                ['name' => 'ClientLogin', 'value' => 'ClientLogin hook'],
                ['name' => 'AdminLogin', 'value' => 'AdminLogin hook'],
                ['name' => 'ClientChangePassword', 'value' => 'ClientChangePassword hook'],
                ['name' => 'TicketAdminReply', 'value' => 'TicketAdminReply hook'],
                ['name' => 'ClientAdd', 'value' => 'ClientAdd hook'],
                ['name' => 'AfterRegistrarRegistration', 'value' => 'AfterRegistrarRegistration hook'],
                ['name' => 'AfterRegistrarRenewal', 'value' => 'AfterRegistrarRenewal hook'],
                ['name' => 'AfterModuleCreate_SharedAccount', 'value' => 'AfterModuleCreate_SharedAccount hook'],
                ['name' => 'AfterModuleCreate_ResellerAccount', 'value' => 'AfterModuleCreate_ResellerAccount hook'],
                ['name' => 'AcceptOrder', 'value' => 'AcceptOrder hook'],
                ['name' => 'DomainRenewalNotice', 'value' => 'DomainRenewalNotice hook'],
                ['name' => 'InvoicePaymentReminder', 'value' => 'InvoicePaymentReminder hook'],
                ['name' => 'InvoicePaymentReminder_FirstOverdue', 'value' => 'InvoicePaymentReminder_FirstOverdue hook'],
                ['name' => 'InvoicePaymentReminder_secondoverdue', 'value' => 'InvoicePaymentReminder_secondoverdue hook'],
                ['name' => 'InvoicePaymentReminder_thirdoverdue', 'value' => 'InvoicePaymentReminder_thirdoverdue hook'],
                ['name' => 'AfterModuleSuspend', 'value' => 'AfterModuleSuspend hook'],
                ['name' => 'AfterModuleUnsuspend', 'value' => 'AfterModuleUnsuspend hook'],
                ['name' => 'InvoiceCreated', 'value' => 'InvoiceCreated hook'],
                ['name' => 'AfterModuleChangePassword', 'value' => 'AfterModuleChangePassword hook'],
                ['name' => 'InvoicePaid', 'value' => 'InvoicePaid hook'],
              ];
        DB::table(JNEX_SMS_TABLE_TEMPLATES)->insert($hookList);
    }

    public static function addProvider(){
      $providerList = [
        ['name' => 'SendCloud'],
        ['name' => 'Luosimao'],
      ];

      DB::table(JNEX_SMS_TABLE_PROVIDER)->insert($providerList);
    }
}
