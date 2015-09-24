<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Featured_menus_model extends TI_Model {

    public function getByIds($filter = array()) {
        if (empty($filter['menu_ids'])) return array();

        $result = array();

        if (!empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if ($this->db->limit($filter['limit'], $filter['page'])) {
            $this->db->select('menu_id, menu_name, menu_description, menu_price, menu_photo');
            $this->db->from('menus');
            $this->db->where('menu_status', '1');
            $this->db->where_in('menu_id', $filter['menu_ids']);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $this->load->model('Image_tool_model');
                $dimension_w = (!empty($filter['dimension_w'])) ? $filter['dimension_w'] : NULL;
                $dimension_h = (!empty($filter['dimension_h'])) ? $filter['dimension_h'] : NULL;

                foreach ($query->result_array() as $row) {
                    if ( ! empty($dimension_w) AND !empty($dimension_h)) {
                        if ( ! empty($row['menu_photo'])) {
                            $row['menu_photo'] = $this->Image_tool_model->resize($row['menu_photo'], $dimension_w, $dimension_h);
                        } else {
                            $row['menu_photo'] = $this->Image_tool_model->resize('data/no_photo.png', $dimension_w, $dimension_h);
                        }
                    }

                    $result[$row['menu_id']] = $row;
                }
            }
        }

        return $result;
    }
}