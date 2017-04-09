<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */

/*
 *---------------------------------------------------------------
 * APPLICATION ENVIRONMENT
 *---------------------------------------------------------------
 *
 * You can load different configurations depending on your
 * current environment. Setting the environment also influences
 * things like logging and error reporting.
 *
 * This can be set to anything, but default usage is:
 *
 *     development
 *     testing
 *     production
 *
 * NOTE: If you change these, also change the error_reporting() code below
 */
defined('ENVIRONMENT') OR define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * ERROR REPORTING
 *---------------------------------------------------------------
 *
 * Different environments will require different levels of error reporting.
 * By default development will show errors but testing and live will hide them.
 */
switch (ENVIRONMENT) {
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);
        ini_set('display_errors', 0);
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'The application environment is not set correctly.';
        exit(1); // EXIT_ERROR
}

/*
 *------------------------------------------------------------------------------
 * DEFAULT INI SETTINGS
 *------------------------------------------------------------------------------
 *
 * Necessary setting for PHP 5.3+ compatibility.
 *
 * Note: This now defaults to UTC instead of GMT if the date.timezone value is not
 * set (PHP 5.4+), but on PHP 5.3 it may use the TZ environment variable or attempt
 * to guess the timezone from the host operating system. Setting date.timezone is
 * recommended to avoid this, or you can replace @date_default_timezone_get() below
 * with 'UTC' or 'GMT', as desired.
 */
if (ini_get('date.timezone') == '' AND function_exists('date_default_timezone_set')) {
    date_default_timezone_set(function_exists('date_default_timezone_get') ?
        @date_default_timezone_get() : date_default_timezone_set('UTC')
    );
}

/*
 *---------------------------------------------------------------
 * SYSTEM FOLDER NAME
 *---------------------------------------------------------------
 *
 * This variable must contain the name of your "system" folder.
 * Include the path if the folder is not in the same directory
 * as this file.
 */
$system_path = 'system';

/*
 *---------------------------------------------------------------
 * APPLICATION FOLDER NAME
 *---------------------------------------------------------------
 *
 * If you want this front controller to use a different "app"
 * folder than the default one you can set its name here. The folder
 * can also be renamed or relocated anywhere on your server. If
 * you do, use a full server path.
 *
 * Both admin and main app MUST be under same root.
 *
 * For more info please see the user guide:
 * http://codeigniter.com/user_guide/general/managing_apps.html
 *
 * NO TRAILING SLASH!
 */
$application_folder = 'app';

/*
 *---------------------------------------------------------------
 * VIEW FOLDER NAME
 *---------------------------------------------------------------
 *
 * You can no longer relocate the view folder
 * The name of the view folder can ONLY be renamed
 *
 * NO TRAILING SLASH!
 */
$view_folder = 'views';

/*
 * ---------------------------------------------------------------
 *  Resolve the system path for increased reliability
 * ---------------------------------------------------------------
 */

$ci_folder = 'ci3/';

// Set the current directory correctly for CLI requests
if (defined('STDIN')) {
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE) {
    $system_path = $_temp.'/';
} else {
    // Ensure there's a trailing slash
    $system_path = rtrim($system_path, '/').'/';
}

// Is the system path correct?
if (!is_dir($system_path)) {
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Your system folder path does not appear to be set correctly. Please open the following file and correct this: '.pathinfo(__FILE__, PATHINFO_BASENAME);
    exit(3); // EXIT_CONFIG
}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
// The name of THIS file
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

// Path to the tastyigniter system folder
define('IGNITEPATH', $system_path);

// Path to the front controller (this file)
define('FCPATH', str_replace(SELF, '', __FILE__));

// Path to the system folder
define('BASEPATH', str_replace('\\', '/', $system_path.$ci_folder));

// Path to the root folder
define('ROOTPATH', rtrim(dirname($system_path), '/').'/');

// Name of the codeigniter folder
define('SYSDIR', trim(strrchr(trim(BASEPATH, '/'), '/'), '/'));

/*
 * --------------------------------------------------------------------
 * LOAD THE BOOTSTRAP FILE
 * --------------------------------------------------------------------
 *
 * And away we go...
 */
require_once IGNITEPATH.'core/TastyIgniter.php';

/* End of file index.php */
/* Location: ./index.php */