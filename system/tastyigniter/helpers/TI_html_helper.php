<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter HTML Helpers
 *
 * @category    Helpers
 */


if ( ! function_exists('doctype'))
{
    /**
     * Doctype
     *
     * Generates a page document type declaration
     *
     * Examples of valid options: html5, xhtml-11, xhtml-strict, xhtml-trans,
     * xhtml-frame, html4-strict, html4-trans, and html4-frame.
     * All values are saved in the doctypes config file.
     *
     * @param	string	type	The doctype to be generated
     * @return	string
     */
    function doctype($type = 'xhtml1-strict')
    {
        static $doctypes;

        if ( ! is_array($doctypes))
        {
            if (file_exists(IGNITEPATH.'config/doctypes.php'))
            {
                include(IGNITEPATH.'config/doctypes.php');
            }

            if (file_exists(IGNITEPATH.'config/'.ENVIRONMENT.'/doctypes.php'))
            {
                include(IGNITEPATH.'config/'.ENVIRONMENT.'/doctypes.php');
            }

            if (empty($_doctypes) OR ! is_array($_doctypes))
            {
                $doctypes = array();
                return FALSE;
            }

            $doctypes = $_doctypes;
        }

        return isset($doctypes[$type]) ? $doctypes[$type] : FALSE;
    }
}

// ------------------------------------------------------------------------

/* End of file ti_html_helper.php */
/* Location: ./system/tastyigniter/helpers/ti_html_helper.php */