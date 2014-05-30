<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language {
	private $folder = '';
	
	public function __construct() {
		$this->CI =& get_instance();
		
		$this->accept_lang = $this->getAcceptLang();
		$this->default_lang_id = $this->CI->config->item('language_id');

		if ($this->accept_lang) {
			$this->folder = $this->getFolderFromDB($this->accept_lang);
		} else if ($this->default_lang_id) {
			$this->folder = $this->getFolderFromDB($this->default_lang_id);
		}
	}
	
	public function folder() {
		return ($this->folder == '') ? 'english' : $this->folder;
	}
	
	public function getFolderFromDB($language) {
		$this->CI->load->model('Languages_model');
		
		$folder = '';
		if ($language) {
			$folder = $this->CI->Languages_model->getLanguageFolder($language);
		}

		return $folder;
	}
	
	public function getAcceptLang() {
		if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) AND $_SERVER["HTTP_ACCEPT_LANGUAGE"]) {
			return $this->parseAcceptLang($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
		}
	}

	public function parseAcceptLang($http_accept) {
		$language = '';
		
		if (isset($http_accept) AND strlen($http_accept) > 1)  {
		    $languages = array();
		    preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $http_accept, $lang_parse);

			if (count($lang_parse[1]) AND count($lang_parse[4])) {
				foreach (array_combine($lang_parse[1], $lang_parse[4]) as $lang => $val) {
					if ($val !== '') {
						$languages[$lang] = (float) $val;
					} else {
						$languages[$lang] = (float) 1;
					}
				}

				arsort($languages, SORT_NUMERIC);
			}
			
			$start = 1;
			foreach ($languages as $key => $value) {
				if ($start === 1) {
					$language = strtolower(substr($key, 0, 2));
				}
				$start++;
			}
		}

		return $language;
	}
}

// END Language Class

/* End of file Language.php */
/* Location: ./application/libraries/Language.php */