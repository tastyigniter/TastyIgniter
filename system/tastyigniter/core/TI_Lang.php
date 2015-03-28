<?php defined('BASEPATH') or exit('No direct script access allowed');

class TI_Lang extends MX_Lang {

	protected $directory = '';

	/**
	 * Load a language file
	 *
	 * @param	mixed	$langfile	Language file name
	 * @param	string	lang		Language name (english, etc.)
	 * @param	bool	$return		Whether to return the loaded array of translations
	 * @param 	bool	$add_suffix	Whether to add suffix to $langfile
	 * @param 	string	$alt_path	Alternative path to look for the language file
	 *
	 * @return	void|string[]	Array containing translations, if $return is set to TRUE
	 */

	public function load($langfile = array(), $lang = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '', $_module = '')	{
		$this->CI =& get_instance();

		$this->CI->load->library('user_agent');
		$http_lang = $this->CI->agent->languages();

		if (APPDIR === 'main' AND $lang === '') {
			if (!$this->CI->agent->accept_lang($http_lang[0]) AND !($lang = $this->getLangDirectory($http_lang[0]))) {
				$lang = $this->getLangDirectory($this->CI->config->item('language_id'));
			}
		}

		parent::load($langfile, $lang, $return, $add_suffix, $alt_path, $_module);
	}

	public function getLangDirectory($language) {
		if ($this->directory === '' AND $language !== '' AND isset($this->CI->db)) {
			$this->CI->db->from('languages');

			if (is_numeric($language)) {
				$this->CI->db->where('language_id', $language);
			} else {
				$this->CI->db->where('code', $language);
			}

			$this->CI->db->where('status', '1');
			$query = $this->CI->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();
				$this->directory = $row['directory'];
			}
		}

		return $this->directory;
	}

	// --------------------------------------------------------------------
}

/* End of file TI_Loader.php */
/* Location: ./system/tastyigniter/core/TI_Loader.php */