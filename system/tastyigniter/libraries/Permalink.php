<?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permalink {
	var $permalinks = array();
    var $slugs = array();

    public function __construct() {
		$this->CI =& get_instance();
        $this->CI->load->model('Permalink_model');

        $this->getPermalinks();

        if ($this->CI->config->item('permalink') == '1') {
            $this->slugs = $this->getSlugs();
            $this->_setRequestQuery();
        }
	}

    public function getPermalinks() {
        if (empty($this->permalinks)) {
            $this->permalinks = $this->CI->Permalink_model->getPermalinks();
        }

        return $this->permalinks;
    }

    public function getPermalink($query) {
        $result = array('permalink_id' => 0, 'slug' => '', 'controller' => '', 'url' => '', 'query' => $query);

        if (!empty($query) AND !empty($this->permalinks)) {
            foreach ($this->permalinks as $permalink) {
                if ($query === $permalink['query']) {
                    $result = $permalink;
                }
            }
        }

        return $result;
    }

    public function getSlugs() {
        $result = array();

        if (!empty($this->permalinks)) {
            foreach ($this->permalinks as $permalink) {
                if (isset($permalink['slug']) AND isset($permalink['query'])) {
                    $result[$permalink['slug']] = $permalink['query'];
                }
            }
        }

        return $result;
    }


    public function getQuerySlug($query = '') {
        $slugs = array_flip($this->slugs);

        if (isset($slugs[$query])) {
            return $slugs[$query];
        }
    }

    public function savePermalink($controller, $permalink = array(), $query = '') {
        return $this->CI->Permalink_model->savePermalink($controller, $permalink, $query);
    }

    public function deletePermalink($controller, $query = '') {
        return $this->CI->Permalink_model->deletePermalink($controller, $query);
    }

    private function _setRequestQuery() {
        if ($this->CI->config->item('permalink') === '1') {

            if ($this->CI->uri->segment(2)) {
                $slug = $this->CI->uri->segment(2);
            } else if ($this->CI->uri->segment(1)) {
                $slug = $this->CI->uri->segment(1);
            } else {
                $slug = '';
            }

            if (isset($this->slugs[$slug])) {
				$query = $this->slugs[$slug];
				$query = explode('=', $query);

				if (isset($query[1])) {
					$_GET[$query[0]] = $query[1];
				}
			}
		}
	}
}

// END Permalink class

/* End of file Permalink.php */
/* Location: ./system/tastyigniter/libraries/Permalink.php */