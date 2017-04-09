<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Directory helper functions
 *
 * @category       Helpers
 * @package        Igniter\Helpers\TI_directory_helper.php
 * @link           http://docs.tastyigniter.com
 */

if ( ! function_exists('copy_directory')) {
	/**
	 * Copy all files in the source dir to destination
	 *
	 * Copy a single directory recursively ( all file and directories
	 * inside it ).
	 *
	 * @param    string $source_dir   Path to source
	 * @param    string $destination_dir Path to source
	 *
	 * @return bool
	 */
	function copy_directory($source_dir, $destination_dir)
	{
		if (!is_dir($source_dir) OR is_dir($destination_dir))
			return FALSE;

		// preparing the paths
		$source_dir = rtrim($source_dir, '/');
		$destination_dir = rtrim($destination_dir, '/');

		// creating the destination directory
		if ( ! is_dir($destination_dir))
			mkdir($destination_dir, DIR_WRITE_MODE, TRUE);

		if ( ! function_exists('directory_map'))
			get_instance()->load->helper('directory');

		// Mapping the directory
		$directory_map = directory_map($source_dir);

		foreach ($directory_map as $key => $value) {
			// Check if its a file or directory
			if (is_numeric($key)) {
				copy("{$source_dir}/{$value}", "{$destination_dir}/{$value}");
			} else {
				copy_directory("{$source_dir}/{$key}", "{$destination_dir}/{$key}");
			}
		}

		return TRUE;
	}
}

if ( ! function_exists('directory_map'))
{
    /**
     * Create a Directory Map
     *
     * Reads the specified directory and builds an array
     * representation of it. Sub-folders contained with the
     * directory will be mapped as well.
     *
     * @param    string $source_dir Path to source
     * @param    int $directory_depth Depth of directories to traverse
     *                        (0 = fully recursive, 1 = current dir, etc)
     * @param    bool $hidden Whether to show hidden files
     * @param   string $hide_file
     *
     * @return array
     */
    function directory_map($source_dir, $directory_depth = 0, $hidden = FALSE, $hide_file = '.')
    {
        if ($fp = @opendir($source_dir))
        {
            $filedata	= array();
            $new_depth	= $directory_depth - 1;
            $source_dir	= rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;

            while (FALSE !== ($file = readdir($fp)))
            {
                // Remove '.', '..', and hidden files [optional]
                if ($file === '.' OR $file === '..' OR ($hidden === FALSE && $file[0] === '.') OR $file === $hide_file)
                {
                    continue;
        }

                if (($directory_depth < 1 OR $new_depth > 0) && is_dir($source_dir.$file))
                {
                    $filedata[$file] = directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $new_depth, $hidden);
                }
                else
                {
                    $filedata[] = $file;
                }
            }

            closedir($fp);
            return $filedata;
        }

        return FALSE;
    }
}
