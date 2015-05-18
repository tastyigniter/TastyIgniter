<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Permalink_model extends TI_Model {

    public function isPermalinkEnabled() {
        return ($this->config->item('permalink') == '1') ? TRUE : FALSE;
    }

    public function getPermalinks() {
        if (!$this->isPermalinkEnabled()) return array();

        $this->db->from('permalinks');

        $query = $this->db->get();
        $result = array();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function getPermalink($query) {
        if (!$this->isPermalinkEnabled()) return array();

        $this->db->from('permalinks');
        $this->db->where('query', $query);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function updatePermalink($controller, $permalink = array(), $query = '') {
        $return = FALSE;

        if (!$this->isPermalinkEnabled()) return $return;

        if (empty($controller)) return $return;

        if (empty($permalink['permalink_id'])) {
            return $this->addPermalink($controller, $permalink, $query);
        }

        if (!empty($permalink['permalink_id']) AND !empty($permalink['slug']) AND !empty($query)) {

            if ($slug = $this->_checkDuplicate($controller, $permalink)) {
                $this->db->set('slug', $slug);
                $this->db->set('controller', $controller);

                $this->db->where('permalink_id', $permalink['permalink_id']);
                $this->db->where('query', $query);
                $return = $this->db->update('permalinks');
            }
        }

        return $return;
    }

    public function addPermalink($controller, $permalink = array(), $query = '') {
        $return = FALSE;

        if (!$this->isPermalinkEnabled()) return $return;

        if (empty($controller)) return $return;

        if (!empty($permalink['permalink_id'])) {
            return $this->updatePermalink($controller, $permalink, $query);
        }

        if (!empty($permalink) AND !empty($permalink['slug']) AND !empty($query)) {
            if ($slug = $this->_checkDuplicate($controller, $permalink)) {
                $this->db->where('query', $query);
                $this->db->where('controller', $controller);
                $this->db->delete('permalinks');

                $this->db->set('controller', $controller);
                $this->db->set('slug', $slug);
                $this->db->set('query', $query);

                if ($this->db->insert('permalinks')) {
                    $return = $this->db->insert_id();
                }
            }
        }

        return $return;
    }

    private function _checkDuplicate($controller, $permalink = array(), $duplicate = '0') {
        if (!empty($controller) AND !empty($permalink['slug'])) {

            $slug = ($duplicate > 0) ? $permalink['slug'].'-'.$duplicate : $permalink['slug'];
            $slug = url_title($slug, '-', TRUE);

            $this->db->where('controller', $controller);
            $this->db->where('slug', $slug);

            $this->db->from('permalinks');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                if (!empty($permalink['permalink_id']) AND $permalink['permalink_id'] !== $row['permalink_id']) {
                    $duplicate++;
                    $this->checkDuplicate($controller, $permalink, $duplicate);

                }
            }

            return $slug;
        }
    }

    public function deletePermalink($permalink_id) {
        if (is_numeric($permalink_id)) {
            $this->db->where('permalink_id', $permalink_id);
            $this->db->delete('permalinks');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
    }
}

/* End of file permalink_model.php */
/* Location: ./system/tastyigniter/models/permalink_model.php */