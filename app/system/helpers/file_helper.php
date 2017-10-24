<?php

/**
 * File helper functions
 */

if (!function_exists('unzip_file')) {
    /**
     * Unzip File
     *
     * @param      $file
     * @param null $extractTo
     *
     * @return string
     */
    function unzip_file($file, $extractTo = null)
    {
        if (!class_exists('ZipArchive', FALSE)) return FALSE;

        $zip = new ZipArchive;

        (!empty($extractTo)) OR $extractTo = dirname($file);

        if (!file_exists($file)) return FALSE;

        chmod($file, 0777);

        if ($zip->open($file) === TRUE) {
            $dirname = trim($zip->getNameIndex(0), DIRECTORY_SEPARATOR);

            $zip->extractTo($extractTo);
            $zip->close();

            return $dirname;
        } else {
            return FALSE;
        }
    }
}
