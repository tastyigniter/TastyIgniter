<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Banners_model extends TI_Model {

    public function getBanners() {
        $this->db->from('banners');

        $query = $this->db->get();

        $result = array();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function getBanner($banner_id) {
        $this->db->from('banners');

        $this->db->where('banner_id', $banner_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function saveBanner($banner_id, $save = array()) {
        if (empty($save)) return FALSE;

        if (!empty($save['name'])) {
            $this->db->set('name', $save['name']);
        }

        if (!empty($save['type'])) {
            $this->db->set('type', $save['type']);
        }

        if (!empty($save['click_url'])) {
            $this->db->set('click_url', $save['click_url']);
        }

        if (!empty($save['language_id'])) {
            $this->db->set('language_id', $save['language_id']);
        }

        if (!empty($save['alt_text'])) {
            $this->db->set('alt_text', $save['alt_text']);
        }

        if (!empty($save['custom_code'])) {
            $this->db->set('custom_code', $save['custom_code']);
        }

        if (!empty($save['image_code'])) {
            $this->db->set('image_code', serialize($save['image_code']));
        }

        if (!empty($save['status'])) {
            $this->db->set('status', $save['status']);
        } else {
            $this->db->set('status', '0');
        }

        if (is_numeric($banner_id)) {
            $this->db->where('banner_id', $banner_id);
            $query = $this->db->update('banners');
        } else {
            $query = $this->db->insert('banners');
            $banner_id = $this->db->insert_id();
        }

        return ($query === TRUE AND is_numeric($banner_id)) ? $banner_id : FALSE;
    }

    public function deleteBanner($banner_id) {
        $this->db->where('banner_id', $banner_id);
        $this->db->delete('banners');

        if ($this->db->affected_rows() > 0) {
            return TRUE;
        }
    }
}

/* End of file banners_model.php */
/* Location: ./system/tastyigniter/models/banners_model.php */