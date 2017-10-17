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
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Config helper functions
 *
 * @category       Helpers
 * @package        TastyIgniter\Helpers\config_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('array_string_output')) {
	/**
	 * Output the array string which is then used in the config file.
	 *
	 * @param array   $array    Values to store in the config.
	 * @param integer $num_tabs Optional number of tabs to use in front of the array
	 *                          elements (for formatting/presentation). Ignored for numeric keys.
	 *
	 * @return string/boolean A string containing the array values in the config
	 * file, or false.
	 */
	function array_string_output($array, $num_tabs = 1) {
		if ( ! is_array($array)) {
			return FALSE;
		}

		$tval = 'array(';

		// Allow for two-dimensional arrays.
		$array_keys = array_keys($array);

		// Check whether they are basic numeric keys.
		if (is_numeric($array_keys[0]) AND $array_keys[0] == 0) {
			$tval .= "'" . implode("','", $array) . "'";
		} else {
			// Non-numeric keys.
			$tabs = "";
			for ($num = 0; $num < $num_tabs; $num ++) {
				$tabs .= "\t";
			}

			foreach ($array as $key => $value) {
				$tval .= "\n{$tabs}'{$key}' => ";
				if (is_array($value)) {
					$num_tabs ++;
					$tval .= array_string_output($value, $num_tabs);
				} else {
					$tval .= "'{$value}'";
				}
				$tval .= ',';
			}
			$tval .= "\n{$tabs}";
		}

		$tval .= ')';

		return $tval;
	}
}

if ( ! function_exists('write_config')) {
	/**
	 * Save the passed array settings into a single config file located in the
	 * config directory.
	 *
	 * @param string $file     The config file to write to.
	 * @param array  $settings An array of config setting name/value pairs to be
	 *                         written to the file.
	 * @param string $module   Name of the module where the config file exists.
	 * @param string $config_path
	 *
	 * @return bool False on error, else true.
	 */
	function write_config($file = '', $settings = NULL, $module = '', $config_path = APPPATH) {
		if (empty($file) || ! is_array($settings)) {
			return FALSE;
		}

		$config_file = "config/{$file}";

		// Look in module first.
		$found = FALSE;
		if ($module) {
			$file_details = Modules::find($config_file, $module, '');
			if ( ! empty($file_details) AND ! empty($file_details[0])) {
				$config_file = implode('', $file_details);
				$found = TRUE;
			}
		}

		// Fall back to application directory.
		if ( ! $found) {
			$config_file = "{$config_path}{$config_file}";
			$found = is_file($config_file . '.php');
		}

		// Load the file and loop through the lines.
		if ($found) {
			$contents = file_get_contents($config_file . '.php');
			$empty = FALSE;
		} else {
			// If the file was not found, create a new file.
			$contents = '';
			$empty = TRUE;
		}

		foreach ($settings as $name => $val) {
			// Is the config setting in the file?
			$start = strpos($contents, '$config[\'' . $name . '\']');
			$end = strpos($contents, ';', $start);
			$search = substr($contents, $start, $end - $start + 1);

			// Format the value to be written to the file.
			if (is_array($val)) {
				// Get the array output.
				$val = config_array_output($val);
			} elseif ( ! is_numeric($val)) {
				$val = "\"$val\"";
			}

			// For a new file, just append the content. For an existing file, search
			// the file's contents and replace the config setting.
			if ($empty) {
				$contents .= '$config[\'' . $name . '\'] = ' . $val . ";\n";
			} else {
				$contents = str_replace(
					$search,
					'$config[\'' . $name . '\'] = ' . $val . ';',
					$contents
				);
			}
		}

		// Make sure the file still has the php opening header in it...
		if (strpos($contents, '<?php') === FALSE) {
			$contents = "<?php defined('BASEPATH') OR exit('No direct script access allowed');\n\n{$contents}";
		}

		// Write the changes out...
		if ( ! function_exists('write_file')) {
			get_instance()->load->helper('file');
		}

		$result = write_file("{$config_file}.php", $contents);

		return $result !== FALSE;
	}
}

/* End of file config_helper.php */
/* Location: ./system/tastyigniter/helpers/config_helper.php */