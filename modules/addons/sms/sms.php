<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

require_once(__DIR__."/lib/includes.php");
use JNEX\SMS\Admin\AdminDispatcher;
use JNEX\SMS\Client\ClientDispatcher;
use JNEX\SMS\DB;

function sms_config()
{
    return array(
        'name' => 'SMS',
        'description' => 'Module SMS based on multiple providers to send text SMS.',
        'author' => 'Rishabh Jain',
        'language' => 'english', // Default language
        'version' => '1.0', // Version number
        'fields' => array(
            'Text Field Name' => array(
                'FriendlyName' => 'Text Field Name',
                'Type' => 'text',
                'Size' => '25',
                'Default' => 'Default value',
                'Description' => 'Description goes here',
            ),
            // a password field type allows for masked text input
            'Password Field Name' => array(
                'FriendlyName' => 'Password Field Name',
                'Type' => 'password',
                'Size' => '25',
                'Default' => '',
                'Description' => 'Enter secret value here',
            ),
            // the yesno field type displays a single checkbox option
            'Checkbox Field Name' => array(
                'FriendlyName' => 'Checkbox Field Name',
                'Type' => 'yesno',
                'Description' => 'Tick to enable',
            ),
            // the dropdown field type renders a select menu of options
            'Dropdown Field Name' => array(
                'FriendlyName' => 'Dropdown Field Name',
                'Type' => 'dropdown',
                'Options' => array(
                    'option1' => 'Display Value 1',
                    'option2' => 'Second Option',
                    'option3' => 'Another Option',
                ),
                'Description' => 'Choose one',
            ),
            // the radio field type displays a series of radio button options
            'Radio Field Name' => array(
                'FriendlyName' => 'Radio Field Name',
                'Type' => 'radio',
                'Options' => 'First Option,Second Option,Third Option',
                'Description' => 'Choose your option!',
            ),
            // the textarea field type allows for multi-line text input
            'Textarea Field Name' => array(
                'FriendlyName' => 'Textarea Field Name',
                'Type' => 'textarea',
                'Rows' => '3',
                'Cols' => '60',
                'Description' => 'Freeform multi-line text input field',
            ),
        )
    );
}

/**
 * Activate.
 *
 * Called upon activation of the module for the first time.
 * Use this function to perform any database and schema modifications
 * required by your module.
 *
 * This function is optional.
 *
 * @return array Optional success/failure message
 */
function sms_activate()
{
    DB::table('tbladdonmodules')->insert([ 'module' => JNEX_MODULE_NAME, 'setting' => 'access', 'value' => 1 ]);


    return array(
        'status' => 'success', // Supported values here include: success, error or info
        'description' => 'This is a demo module only. In a real module you might report an error/failure or instruct a user how to get started with it here.',
    );
}

/**
 * Deactivate.
 *
 * Called upon deactivation of the module.
 * Use this function to undo any database and schema modifications
 * performed by your module.
 *
 * This function is optional.
 *
 * @return array Optional success/failure message
 */
function sms_deactivate()
{
    // Undo any database and schema modifications made by your module here
    $query = "DROP TABLE `mod_addonexample`";
    full_query($query);

    return array(
        'status' => 'success', // Supported values here include: success, error or info
        'description' => 'This is a demo module only. In a real module you might report an error/failure here.',
    );
}

/**
 * Upgrade.
 *
 * Called the first time the module is accessed following an update.
 * Use this function to perform any required database and schema modifications.
 *
 * This function is optional.
 *
 * @return void
 */
function sms_upgrade($vars)
{
    $currentlyInstalledVersion = $vars['version'];

    /// Perform SQL schema changes required by the upgrade to version 1.1 of your module
    if ($currentlyInstalledVersion < 1.1) {
        $query = "ALTER `mod_addonexample` ADD `demo2` TEXT NOT NULL ";
        full_query($query);
    }

    /// Perform SQL schema changes required by the upgrade to version 1.2 of your module
    if ($currentlyInstalledVersion < 1.2) {
        $query = "ALTER `mod_addonexample` ADD `demo3` TEXT NOT NULL ";
        full_query($query);
    }
}

/**
 * Admin Area Output.
 *
 * Called when the addon module is accessed via the admin area.
 * Should return HTML output for display to the admin user.
 *
 * This function is optional.
 *
 * @see sms\Admin\Controller@index
 *
 * @return string
 */
function sms_output($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. smss.php?module=sms
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    // Get module configuration parameters
    $configTextField = $vars['Text Field Name'];
    $configPasswordField = $vars['Password Field Name'];
    $configCheckboxField = $vars['Checkbox Field Name'];
    $configDropdownField = $vars['Dropdown Field Name'];
    $configRadioField = $vars['Radio Field Name'];
    $configTextareaField = $vars['Textarea Field Name'];

    // Dispatch and handle request here. What follows is a demonstration of one
    // possible way of handling this using a very basic dispatcher implementation.

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new AdminDispatcher();
    $response = $dispatcher->dispatch($action, $vars);
    echo $response;
}

/**
 * Admin Area Sidebar Output.
 *
 * Used to render output in the admin area sidebar.
 * This function is optional.
 *
 * @param array $vars
 *
 * @return string
 */
function sms_sidebar($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $_lang = $vars['_lang'];

    // Get module configuration parameters
    $configTextField = $vars['Text Field Name'];
    $configPasswordField = $vars['Password Field Name'];
    $configCheckboxField = $vars['Checkbox Field Name'];
    $configDropdownField = $vars['Dropdown Field Name'];
    $configRadioField = $vars['Radio Field Name'];
    $configTextareaField = $vars['Textarea Field Name'];

    $sidebar = '<p>Sidebar output HTML goes here</p>';
    return $sidebar;
}

/**
 * Client Area Output.
 *
 * Called when the addon module is accessed via the client area.
 * Should return an array of output parameters.
 *
 * This function is optional.
 *
 * @see sms\Client\Controller@index
 *
 * @return array
 */
function sms_clientarea($vars)
{
    // Get common module parameters
    $modulelink = $vars['modulelink']; // eg. index.php?m=sms
    $version = $vars['version']; // eg. 1.0
    $_lang = $vars['_lang']; // an array of the currently loaded language variables

    // Get module configuration parameters
    $configTextField = $vars['Text Field Name'];
    $configPasswordField = $vars['Password Field Name'];
    $configCheckboxField = $vars['Checkbox Field Name'];
    $configDropdownField = $vars['Dropdown Field Name'];
    $configRadioField = $vars['Radio Field Name'];
    $configTextareaField = $vars['Textarea Field Name'];

    // Dispatch and handle request here. What follows is a demonstration of one
    // possible way of handling this using a very basic dispatcher implementation.

    $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

    $dispatcher = new ClientDispatcher();
    return $dispatcher->dispatch($action, $vars);
}
