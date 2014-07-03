<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');
/**
 * TastyIgniter
 *
 * An open source restaurant management application for PHP 5.1.6 or newer
 *
 * @package		TastyIgniter
 * @author		SamPoyigi
 * @copyright	Copyright (c) 2013, TastyIgniter, Inc.
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * TastyIgniter reCAPTCHA Helper
 *
 * @package		TastyIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		SamPoyigi
 */

// ------------------------------------------------------------------------

/**
 * Create reCAPTCHA
 *
 * @access	public
 * @param	array	array of data for the reCAPTCHA
 * @param	string	path to create the image in
 * @param	string	URL to the reCAPTCHA image folder
 * @param	string	server path to font
 * @return	string
 */
if ( ! function_exists('create_captcha'))
{
	function create_captcha($public_key = '', $error = '')
	{
		require_once(FCPATH .'/application/libraries/recaptchalib.php');
		return recaptcha_get_html($public_key, $error);
  	}
}

// ------------------------------------------------------------------------


/**
 * Validate reCAPTCHA
 *
 * @access	public
 * @param	array	array of data for the reCAPTCHA
 * @param	string	path to create the image in
 * @param	string	URL to the reCAPTCHA image folder
 * @param	string	server path to font
 * @return	string
 */
if ( ! function_exists('validate_captcha'))
{
	function validate_captcha($private_key = '', $recaptcha = array())
	{
		require_once(FCPATH .'/application/libraries/recaptchalib.php');
		
		if (!empty($recaptcha) AND isset($recaptcha['ip_address']) AND  isset($recaptcha['challenge']) AND  isset($recaptcha['response'])) {
			$response = recaptcha_check_answer($private_key, $recaptcha['ip_address'], $recaptcha['challenge'], $recaptcha['response']);

			if (!$response->is_valid) {
				return $response->error;
			} else {
				return FALSE;
			}
		}
	}
}

// ------------------------------------------------------------------------


/* End of file captcha_helper.php */
/* Location: ./system/heleprs/captcha_helper.php */