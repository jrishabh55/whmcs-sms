<?php

namespace JNEX\SMS\Admin;

use JNEX\SMS\DB;

/**
 * Sample Admin Area Controller
 */
class Controller {

    /**
     * Index action.
     *
     * @param array $vars Module configuration parameters
     *
     * @return string
     */
    public function index($vars)
    {
        // Get common module parameters
        $modulelink = $vars['modulelink']; // eg. addonmodules.php?module=addonmodule
        $version = $vars['version']; // eg. 1.0
        $LANG = $vars['_lang']; // an array of the currently loaded language variables

        $temp_sms = DB::table(JNEX_SMS_TABLE_PROVIDER)->get();
        $hooks_template = DB::table(JNEX_SMS_TABLE_TEMPLATES)->get();
        // DB::table(JNEX_SMS_TABLE_PROVIDER)->insert()
        // Get module configuration parameters
        $configTextField = $vars['Text Field Name'];
        $configPasswordField = $vars['Password Field Name'];
        $configCheckboxField = $vars['Checkbox Field Name'];
        $configDropdownField = $vars['Dropdown Field Name'];
        $configRadioField = $vars['Radio Field Name'];
        $configTextareaField = $vars['Textarea Field Name'];

        $return = <<<HTML

<h2>Index</h2>

<p>This is the <em>index</em> action output of the sample addon module.</p>

<p>The currently installed version is: <strong>{$version}</strong></p>

<p>Values of the configuration field are as follows:</p>

<form method="POST" id="providersForm">
<div>
  <p>SMS Providers</p>
HTML;

    foreach ($temp_sms as $i){
      $active = ($i->active === 1) ? ' checked' : '';
      if ($i->id % 3 === 0) {
        $return .= "<br />";
      }
      $return.= <<<HTML
      <div class="input-wrapper"><label>{$i->name} </label> <input{$active} name="{$i->name}" type="checkbox" value="1"></div>
HTML;
    }

    $return.= <<<HTML
    <br>
    <input name="submit" value="Save Providers" type="submit">
    </form>
  </div>

    <form method = "POST" id="hooksForm">
      <div>
        <p>Applicable On</p>
HTML;
    foreach ($hooks_template as $i){
      $active = ($i->active === 1) ? ' checked' : '';

      $return.= <<<HTML
      <span class="input-wrapper"><label>{$i->name} </label> <input{$active} name="{$i->name}" type="checkbox" value="1"></span>
HTML;
      if ($i->id % 3 === 0) {
        $return .= "<br />";
      }
    }

    $return.= <<<HTML
    <br>
    <input name="submit" type="submit" value="Save Hooks">
    </form>
  </div>
<p>
    <a href="{$modulelink}&action=show" class="btn btn-success">
        <i class="fa fa-check"></i>
        Visit valid action link
    </a>
    <a href="{$modulelink}&action=invalid" class="btn btn-default">
        <i class="fa fa-times"></i>
        Visit invalid action link
    </a>
</p>

HTML;
return $return;
    }
    public function handlePost($vars){
      // $params = \json_decode(\json_encode($_POST));
      $params = $_POST;

      $providers = DB::table(JNEX_SMS_TABLE_PROVIDER)->get();

      foreach ($providers as $provider) {
        $val = !empty($params[$provider->name]);
        if ($val != $provider->active) {
            DB::table(JNEX_SMS_TABLE_PROVIDER)->where('name', $provider->name)->update([active => $val]);
        }
      }
      return 'updated';
    }

    public function handleHooks($vars){
      // $params = \json_decode(\json_encode($_POST));
      $params = $_POST;

      $hooksList = DB::table(JNEX_SMS_TABLE_TEMPLATES)->get();

      foreach ($hooksList as $hookV) {
        $val = !empty($params[$hookV->name]);
        if ($val != $hookV->active) {
            DB::table(JNEX_SMS_TABLE_TEMPLATES)->where('name', $hookV->name)->update([active => $val]);
        }
      }
      return 'updated';
    }

}
