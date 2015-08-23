<?php
// Ensure that we don't run into any php date-related issues
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('UTC');
}

// The path to the tastyigniter application index.php folder
//define ('ROOTPATH', '../test');

//--------------------------------------------------------------------
// Override Functions
//--------------------------------------------------------------------
// Override some functions from core/Common.php so they throw errors
// instead of strings.

function show_error($message, $status_code = 500, $heading = 'An Error Was Encountered')
{
    throw new PHPUnit_Framework_Exception($message, $status_code);
}

function show_404($page = '', $log_error = TRUE)
{
//	throw new PHPUnit_Framework_Exception($page, 404);
}

//--------------------------------------------------------------------
// Load up CodeIgniter so that we can use it!
//--------------------------------------------------------------------


ob_start();
include( 'index.php' );
ob_end_clean();

/**
 * Class CodeIgniterTestCase
 *
 * Use this for testing anything that needs $ci access.
 *
 */
class CodeIgniterTestCase extends \Codeception\TestCase\Test {

    use \MythTester;

    protected $ci;

    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        $this->ci =& get_instance();
    }

    //--------------------------------------------------------------------

    public function __get($var)
    {
        return $this->ci->$var;
    }

    //--------------------------------------------------------------------

}