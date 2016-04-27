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
defined('BASEPATH') OR exit('No direct access allowed');

/**
 * TastyIgniter Exceptions Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Exceptions.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Exceptions extends CI_Exceptions {

	/**
	 * General Error Page
	 *
	 * Takes an error message as input (either as a string or an array)
	 * and displays it using the specified template.
	 *
	 * @param	string		$heading	Page heading
	 * @param	string|string[]	$message	Error message
	 * @param	string		$template	Template name
	 * @param 	int		$status_code	(default: 500)
	 *
	 * @return	string	Error page output
	 */
	public function show_error($heading, $message, $template = 'error_general', $status_code = 500)
	{
		$templates_path = $this->getErrorViewsPath();

		if (is_cli())
		{
			$message = "\t".(is_array($message) ? implode("\n\t", $message) : $message);
		}
		else
		{
			set_status_header($status_code);
			$message = '<p>'.(is_array($message) ? implode('</p><p>', $message) : $message).'</p>';
		}

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}

		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

	// --------------------------------------------------------------------

	public function show_exception($exception)
	{
		$templates_path = $this->getErrorViewsPath();

		$message = $exception->getMessage();
		if (empty($message))
		{
			$message = '(null)';
		}

		if ( ! is_cli())
		{
			set_status_header(500);
		}

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}

		ob_start();
		include($templates_path.'error_exception.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}

	// --------------------------------------------------------------------

	/**
	 * Native PHP error handler
	 *
	 * @param	int	$severity	Error level
	 * @param	string	$message	Error message
	 * @param	string	$filepath	File path
	 * @param	int	$line		Line number
	 * @return	string	Error page output
	 */
	public function show_php_error($severity, $message, $filepath, $line)
	{
		$templates_path = $this->getErrorViewsPath();

		$severity = isset($this->levels[$severity]) ? $this->levels[$severity] : $severity;

		// For safety reasons we don't show the full file path in non-CLI requests
		if ( ! is_cli())
		{
			$filepath = str_replace('\\', '/', $filepath);
			if (FALSE !== strpos($filepath, '/'))
			{
				$x = explode('/', $filepath);
				$filepath = $x[count($x)-2].'/'.end($x);
			}
		}

		$template = 'error_php';

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include($templates_path.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		echo $buffer;
	}

	/**
	 * @return mixed|string
	 */
	protected function getErrorViewsPath() {
		$default_themes = config_item('default_themes');

		if (empty($default_themes)) {
			$CI =& get_instance();

			if ( ! isset($CI->db)) {
				$CI->load->database();

				$query = $CI->db->get_where('settings', array('item' => 'default_themes'));
				if (is_string($query->row()->value)) {
					$default_themes = unserialize($query->row()->value);
				}
			}
		}

		$default_theme = isset($default_themes[APPDIR]) ? $default_themes[APPDIR] : '';
		$templates_path = config_item('error_views_path');

		// set the error views path for the theme if it exists
		if (!empty($default_theme) AND is_dir(THEMEPATH  . $default_theme . 'errors/')) {
			$templates_path = THEMEPATH  . $default_theme . 'errors/';
		} else if (empty($templates_path)) {
			$templates_path = VIEWPATH.'errors'.DIRECTORY_SEPARATOR;
		}

		return $templates_path;
	}
}