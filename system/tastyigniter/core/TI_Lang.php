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
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * TastyIgniter Lang Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\TI_Lang.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Lang extends MX_Lang {

    protected $defaultLang;
    protected $languages = array();

    /**
     * Load a language file
     *
     * @param    mixed $langfile Language file name
     * @param    string $lang
     * @param    bool $return Whether to return the loaded array of translations
     * @param    bool $add_suffix Whether to add suffix to $langfile
     * @param    string $alt_path Alternative path to look for the language file
     *
     * @param string $_module
     * @return string[] Array containing translations, if $return is set to TRUE
     */
	public function load($langfile, $lang = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '') {
	    if (is_array($langfile))
	    {
		    foreach($langfile as $_lang) $this->load($_lang);
		    return $this->language;
	    }

	    if (in_array($langfile.'_lang'.EXT, $this->is_loaded, TRUE))
		    return $this->language;

	    $lang = $this->defaultLang($langfile, $lang);

	    return parent::load($langfile, $lang, $return, $add_suffix, $alt_path, $_module);
    }

    // --------------------------------------------------------------------

    /**
     * Language line
     *
     * Fetches a single line of text from the language array
     *
     * @param    string $line Language line key
     * @param    string|array $params String or array of strings to be inserted at placeholders like %s, %d, etc.
     * @param    bool $log_errors Whether to log an error message if the line is not found
     * @return string Translation
     */
    public function line($line, $params = NULL, $log_errors = TRUE) {
        $value = isset($this->language[$line]) ? $this->language[$line] : FALSE;

        if (is_bool($params)) {
            $log_errors = (bool) $params;
            $params = NULL;
        } else if (is_string($params)) {
            $params = array($params);
        }

        // Because killer robots like unicorns!
        if ($value === FALSE AND $log_errors === TRUE) {
            log_message('error', 'Could not find the language line "' . $line . '"');
        }

        if (!empty($params) AND is_array($params)) {
            $value = vsprintf($value, $params);
        }

        return $value;
    }

	// --------------------------------------------------------------------

	/**
	 * Default Language
	 *
	 * Detects the browser language or uses the admin settings language as default language
	 *
	 * @param       string $langfile
	 * @param       string $lang
	 *
	 * @return string
	 */
	public function defaultLang($langfile, $lang = '') {
		if (empty($langfile) OR !empty($lang)) return $lang;

        if (!isset($this->CI))
            $this->CI =& get_instance();

        $defaultLang = $this->findDefaultLang();

		$this->CI->load->helper('language');
		if (find_lang_file($langfile, $defaultLang)) {
			return $defaultLang;
		}

		return $lang;
	}

    // --------------------------------------------------------------------

    protected function findDefaultLang()
    {
        if (isset($this->defaultLang))
            return $this->defaultLang;

        // Use admin settings
        $language = $this->CI->config->item((APPDIR === ADMINDIR) ? 'admin_language_id' : 'language_id');

        // Detect the browser language and use it instead
        if ($this->CI->config->item('detect_language') === '1') {
            $this->CI->load->library('user_agent');
            $http_lang = $this->CI->agent->languages();
            if ($this->CI->agent->accept_lang($http_lang[0])) {
                $language = $http_lang[0];
            }
        }

        return $this->defaultLang = $this->getIdiom($language);
    }

    // --------------------------------------------------------------------

    /**
	 * Language Idiom
	 *
	 * Fetches the idiom of the browser's language from the database.
	 *
	 * @param   string $language
	 *
	 * @return  string
	 */
	protected function getIdiom($language) {
		if (empty($this->languages) AND isset($this->CI->db)) {
			$this->CI->db->from('languages');

			$this->CI->db->where('status', '1');
			$query = $this->CI->db->get();

			if ($query->num_rows() > 0) {
				$this->languages = $query->result_array();
			}
		}

        if ($language !== '' AND !empty($this->languages)) {
			foreach ($this->languages as $row) {
                if (is_numeric($language)) {
					return ($row['language_id'] === $language) ? $row['idiom'] : null;
				} else if ($row['code'] === $language OR $row['idiom'] === $language) {
					return $row['idiom'];
				}
			}
        }

        return null;
    }

    // --------------------------------------------------------------------
}

/* End of file TI_Loader.php */
/* Location: ./system/tastyigniter/core/TI_Loader.php */