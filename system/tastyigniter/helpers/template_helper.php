<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Template Helpers
 *
 * @category    Helpers
 */

// ------------------------------------------------------------------------

/**
 * Get Header
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_header')) {
    function get_header() {
        return get_instance()->template->getPartials('header');
    }
}

// ------------------------------------------------------------------------

/**
 * Get Footer
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_footer')) {
    function get_footer() {
        return get_instance()->template->getPartials('footer');
    }
}

// ------------------------------------------------------------------------

/**
 * Get Partial
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_partial')) {
    function get_partial($partial = '', $class = '') {
        $partial_data = get_instance()->template->getPartials($partial);

        return str_replace('{class}', $class, $partial_data);
    }
}

// ------------------------------------------------------------------------

/**
 * Load Partial
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('load_partial')) {
    function load_partial($partial = '', $data = array()) {
        echo get_instance()->template->loadView($partial, $data);
    }
}

// ------------------------------------------------------------------------

/**
 * Check if Partial Exist in layout
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('partial_exists')) {
    function partial_exists($partial = '') {
        return (get_instance()->template->getPartials($partial)) ? TRUE : FALSE;
    }
}

// ------------------------------------------------------------------------

/**
 * Get Doctype
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_doctype')) {
    function get_doctype() {
        return get_instance()->template->getDocType();
    }
}

// ------------------------------------------------------------------------

/**
 * Set Doctype
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_doctype')) {
    function set_doctype($doctype = '') {
        get_instance()->template->setHeadTag('doctype', $doctype);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template metas
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_metas')) {
    function get_metas() {
        return get_instance()->template->getMetas();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template metas
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_meta')) {
    function set_meta($meta = array()) {
        get_instance()->template->setHeadTag('meta', $meta);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template favicon
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_favicon')) {
    function get_favicon() {
        return get_instance()->template->getFavIcon();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template favicon
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_favicon')) {
    function set_favicon($href = '') {
        get_instance()->template->setHeadTag('favicon', $href);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template title
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_title')) {
    function get_title() {
        return get_instance()->template->getTitle();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template title
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_title')) {
    function set_title($title = '') {
        get_instance()->template->setHeadTag('title', $title);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template heading
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_heading')) {
    function get_heading() {
        return get_instance()->template->getHeading();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template heading
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_heading')) {
    function set_heading($heading = '') {
        get_instance()->template->setHeadTag('heading', $heading);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template styles tag
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_style_tags')) {
    function get_style_tags() {
        return get_instance()->template->getStyleTags();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template styles tag
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_style_tag')) {
    function set_style_tag($href = '', $name = '', $priority = NULL) {
        get_instance()->template->setStyleTag($href, $name, $priority);
    }
}

// ------------------------------------------------------------------------

/**
 * Set template styles tag
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_style_tags')) {
    function set_style_tags($tags = array()) {
        get_instance()->template->setStyleTag($tags);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template scripts tag
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_script_tags')) {
    function get_script_tags() {
        return get_instance()->template->getScriptTags();
    }
}

// ------------------------------------------------------------------------

/**
 * Set template scripts tag
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_script_tag')) {
    function set_script_tag($href = '', $name = '', $priority = NULL) {
        get_instance()->template->setScriptTag($href, $name, $priority);
    }
}

// ------------------------------------------------------------------------

/**
 * Set template scripts tag
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('set_script_tags')) {
    function set_script_tags($tags = array()) {
        get_instance()->template->setScriptTag($tags);
    }
}

// ------------------------------------------------------------------------

/**
 * Get template active styles
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_active_styles')) {
    function get_active_styles() {
        return get_instance()->template->getActiveStyle();
    }
}

// ------------------------------------------------------------------------

/**
 * Get template breadcrumbs
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_breadcrumbs')) {
    function get_breadcrumbs() {
        return get_instance()->template->getBreadcrumb();
    }
}

// ------------------------------------------------------------------------

/**
 * Get template menu buttons
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_button_list')) {
    function get_button_list() {
        return get_instance()->template->getButtonList();
    }
}

// ------------------------------------------------------------------------

/**
 * Get template menu icons
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_icon_list')) {
    function get_icon_list() {
        return get_instance()->template->getIconList();
    }
}

// ------------------------------------------------------------------------

/**
 * Get template back butotn
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_back_button')) {
    function get_back_button() {
        return get_instance()->template->getBackButton();
    }
}

// ------------------------------------------------------------------------

/**
 * Get theme partial areas
 *
 *
 * @access    public
 * @return    string
 */
if ( ! function_exists('get_theme_partials')) {
    function get_theme_partials($theme = NULL, $domain = 'main') {

        $theme_config = load_theme_config(trim($theme, '/'), $domain);

        return isset($theme_config['partial_area']) ? $theme_config['partial_area'] : array();
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('find_theme_files')) {
    /**
     * Search a theme folder for files.
     *
     * Searches an individual folder for any theme files and returns an array
     * appropriate for display in the theme tree view.
     *
     * @param string $filename The theme folder to search
     * @param string $domain The domain where the theme is located
     *
     * @return array $theme_files
     */
    function find_theme_files($filename = NULL, $domain = 'main') {
        if (empty($filename)) {
            return NULL;
        }

        $CI =& get_instance();
        $CI->config->load('template');

        $theme_files = array();
        foreach (glob(ROOTPATH . "{$domain}/views/themes/{$filename}/*") as $file) {
            $file_name = basename($file);
            $file_ext = strtolower(substr(strrchr($file, '.'), 1));

            $type = '';
            if (is_dir($file) AND ! in_array($file_name, config_item('theme_hidden_folders'))) {
                $type = 'dir';
            } else if ( ! in_array($file_name, config_item('theme_hidden_files'))) {
                if (in_array($file_ext, config_item('allowed_image_ext'))) {
                    $type = 'img';
                } else if (in_array($file_ext, config_item('allowed_file_ext'))) {
                    $type = 'file';
                }
            }

            if ($type !== '') {
                $theme_files[] = array('type' => $type, 'name' => $file_name, 'path' => $file, 'ext' => $file_ext);
            }
        }

        $type = array();
        foreach ($theme_files as $key => $value) {
            $type[$key] = $value['type'];
        }
        array_multisort($type, SORT_ASC, $theme_files);

        return $theme_files;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('list_themes')) {
    /**
     * List existing themes in the system
     *
     * Lists the existing themes in the system by examining the
     * theme folders in both admin and main domain, and also gets the theme
     * config.
     *
     * @return array The names,path,config of the theme directories.
     */
    function list_themes() {
        $themes = array();

        foreach (array(MAINDIR, ADMINDIR) as $domain) {
            foreach (glob(ROOTPATH . "{$domain}/views/themes/*", GLOB_ONLYDIR) as $filepath) {
                $filename = basename($filepath);

                $themes[] = array(
                    'location' => $domain,
                    'basename' => $filename,
                    'path'     => "{$domain}/views/themes/{$filename}",
                    'config'   => load_theme_config($filename, $domain)
                );
            }
        }

        return $themes;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('load_theme_config')) {
    /**
     * Load a single theme config file into an array.
     *
     * @param string $filename The name of the theme to locate. The config file
     * will be found and loaded by looking in the admin and main theme folders.
     * @param string $domain The domain where the theme is located.
     *
     * @return mixed The $theme array from the file or false if not found. Returns
     * null if $filename is empty.
     */
    function load_theme_config($filename = NULL, $domain = 'main') {
        if (empty($filename)) {
            return NULL;
        }

        if ( ! file_exists(ROOTPATH."{$domain}/views/themes/{$filename}/theme_config.php")) {
            log_message('debug', 'Theme ['.$filename.'] does not have a config file.');
            return NULL;
        }

        include(ROOTPATH."{$domain}/views/themes/{$filename}/theme_config.php");

        if ( ! isset($theme) OR ! is_array($theme)) {
            log_message('debug', 'Theme ['.$filename.'] config file does not appear to contain a valid array.');
            return NULL;
        }

        log_message('debug', 'Theme ['.$filename.'] config file loaded.');
        return $theme;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('load_theme_file')) {
    /**
     * Load a single theme generic file into an array.
     *
     * @param string $filename The name of the file to locate. The file will be
     * found by looking in the admin and main themes folders.
     * @param string $theme The theme to check.
     * @param string $domain The domain where the theme is located.
     *
     * @return mixed The $theme_file array from the file or false if not found. Returns
     * null if $filename is empty.
     */
    function load_theme_file($filename = NULL, $theme = NULL, $domain = 'main') {
        if (empty($filename) OR empty($theme)) {
            return NULL;
        }

        $theme_file_path = ROOTPATH."{$domain}/views/themes/{$theme}/{$filename}";

        if ( ! file_exists($theme_file_path)) {
            return NULL;
        }

        $CI =& get_instance();
        $CI->config->load('template');

        $file_name = basename($theme_file_path);
        $file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));

        if (in_array($file_ext, config_item('allowed_image_ext'))) {
            $file_type = 'img';
            $content = root_url("{$domain}/views/themes/{$theme}/{$filename}");
        } else if (in_array($file_ext, config_item('allowed_file_ext'))) {
            $file_type = 'file';
            $content = htmlspecialchars(file_get_contents($theme_file_path));
        } else {
            return NULL;
        }

        $theme_file = array(
            'name'		    => $file_name,
            'ext'		    => $file_ext,
            'type'		    => $file_type,
            'path'		    => $theme_file_path,
            'content'	    => $content,
            'is_writable'   => is_really_writable($theme_file_path)
        );

        return $theme_file;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('save_theme_file')) {
    /**
     * Save a theme file.
     *
     * @param string $filename The name of the file to locate. The file will be
     * found by looking in the admin and main themes folders.
     * @param string $theme The theme to check.
     * @param string $domain The domain where the theme is located.
     * @param array $new_data A string of the theme file content replace.
     * @param boolean $return True to return the contents or false to return TRUE.
     *
     * @return bool|string False if there was a problem loading the file. Otherwise,
     * returns true when $return is false or a string containing the file's contents
     * when $return is true.
     */
    function save_theme_file($filename = NULL, $theme = NULL, $domain = 'main', $new_data = NULL, $return = FALSE) {
        if (empty($filename) OR empty($theme) OR empty($new_data)) {
            return FALSE;
        }

        $theme_file_path = ROOTPATH."{$domain}/views/themes/{$theme}/{$filename}";

        if ( ! file_exists($theme_file_path)) {
            return FALSE;
        }

        $file_ext = strtolower(substr(strrchr($theme_file_path, '.'), 1));

        $CI =& get_instance();
        $CI->config->load('template');

        if (!in_array($file_ext, config_item('allowed_file_ext')) OR !is_really_writable($theme_file_path)) {
            return FALSE;
        }

        if ($fp = @fopen($theme_file_path, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {
            flock($fp, LOCK_EX);
            fwrite($fp, $new_data);
            flock($fp, LOCK_UN);
            fclose($fp);

            @chmod($theme_file_path, FILE_WRITE_MODE);

            return ($return === TRUE) ? $new_data : TRUE;
        }

        return FALSE;
    }
}

// ------------------------------------------------------------------------

/* End of file template_helper.php */
/* Location: ./system/tastyigniter/helpers/template_helper.php */