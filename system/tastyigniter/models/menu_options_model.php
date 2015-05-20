<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Menu_options_model extends TI_Model {

    public function getCount($filter = array()) {
        if (!empty($filter['filter_search'])) {
            $this->db->like('option_name', $filter['filter_search']);
            $this->db->or_like('option_price', $filter['filter_search']);
        }

        $this->db->from('options');
        return $this->db->count_all_results();
    }

    public function getList($filter = array()) {
        if (!empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if ($this->db->limit($filter['limit'], $filter['page'])) {
            $this->db->from('options');

            if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
                $this->db->order_by($filter['sort_by'], $filter['order_by']);
            }

            if (!empty($filter['filter_search'])) {
                $this->db->like('option_name', $filter['filter_search']);
                $this->db->or_like('option_price', $filter['filter_search']);
            }

            if (!empty($filter['filter_display_type'])) {
                $this->db->where('display_type', $filter['filter_display_type']);
            }

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
        }
    }

    public function getOptionValues($option_id = FALSE) {
        $result = array();

        $this->db->from('option_values');
        $this->db->order_by('priority', 'ASC');

        if ($option_id !== FALSE) {
            $this->db->where('option_id', $option_id);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function getOption($option_id) {
        $this->db->from('options');
        $this->db->where('option_id', $option_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function getMenuOptions($menu_id = FALSE) {
        $results = array();

        $this->db->select('*, menu_options.menu_id, menu_options.option_id');
        $this->db->from('menu_options');
        $this->db->join('options', 'options.option_id = menu_options.option_id', 'left');

        if ($menu_id !== FALSE) {
            $this->db->where('menu_options.menu_id', $menu_id);
        }

        $this->db->order_by('options.priority', 'ASC');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $results[] = array(
                    'menu_option_id'	=> $row['menu_option_id'],
                    'menu_id'           => $row['menu_id'],
                    'option_id'			=> $row['option_id'],
                    'option_name'		=> $row['option_name'],
                    'display_type'		=> $row['display_type'],
                    'required'			=> $row['required'],
                    'priority'			=> $row['priority'],
                    'option_values'		=> $this->getMenuOptionValues($row['menu_option_id'], $row['option_id'])
                );
            }
        }

        return $results;
    }

    public function getMenuOptionValues($menu_option_id = FALSE, $option_id = FALSE) {
        $result = array();

        if ($menu_option_id !== FALSE AND $option_id !== FALSE) {
            $this->db->select('*, menu_option_values.option_id, option_values.option_value_id');
            $this->db->from('menu_option_values');
            $this->db->join('option_values', 'option_values.option_value_id = menu_option_values.option_value_id', 'left');

            $this->db->order_by('option_values.priority', 'ASC');
            $this->db->where('menu_option_values.menu_option_id', $menu_option_id);
            $this->db->where('menu_option_values.option_id', $option_id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }
        }

        return $result;
    }

    public function getAutoComplete($filter_data = array()) {
        if (is_array($filter_data) AND !empty($filter_data)) {
            $this->db->from('options');

            if (!empty($filter_data['option_name'])) {
                $this->db->like('option_name', $filter_data['option_name']);
            }

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $result[] = array(
                        'option_id'			=> $row['option_id'],
                        'option_name'		=> $row['option_name'],
                        'display_type'		=> $row['display_type'],
                        'priority'			=> $row['priority'],
                        'option_values'		=> $this->getOptionValues($row['option_id'])
                    );
                }
            }

            return $result;
        }
    }

    public function saveOption($save = array()) {
        if (empty($save)) return FALSE;

        if (!empty($save['option_name'])) {
            $this->db->set('option_name', $save['option_name']);
        }

        if (!empty($save['display_type'])) {
            $this->db->set('display_type', $save['display_type']);
        }

        if (!empty($save['priority'])) {
            $this->db->set('priority', $save['priority']);
        }

        if (is_numeric($this->input->get('id')) AND $option_id = $this->input->get('id')) {
            $this->db->where('option_id', $option_id);
            $query = $this->db->update('options');
        } else {
            $query = $this->db->insert('options');
            $option_id = $this->db->insert_id();
        }

        if (!empty($query) AND !empty($option_id)) {
            $this->addOptionValues($save['option_id'], $save['option_values']);

            return $option_id;
        }
    }

    public function addOptionValues($option_id = FALSE, $option_values = array()) {
        $query = FALSE;

        if ($option_id !== FALSE AND !empty($option_values) AND is_array($option_values)) {
            $this->db->where('option_id', $option_id);
            $this->db->delete('option_values');

            $priority = 1;
            foreach ($option_values as $key => $value) {
                if (!empty($value['value'])) {
                    $this->db->set('value', $value['value']);
                }

                if (!empty($value['price'])) {
                    $this->db->set('price', $value['price']);
                }

                if (!empty($value['option_value_id'])) {
                    $this->db->set('option_value_id', $value['option_value_id']);
                }

                $this->db->set('priority', $priority);

                $this->db->set('option_id', $option_id);
                $query = $this->db->insert('option_values');

                $priority++;
            }
        }

        return $query;
    }

    public function addMenuOption($menu_id = FALSE, $menu_options = array()) {
        $query = FALSE;

        if ($menu_id !== FALSE) {
            $this->db->where('menu_id', $menu_id);
            $this->db->delete('menu_options');

            $this->db->where('menu_id', $menu_id);
            $this->db->delete('menu_option_values');

            if (!empty($menu_options)) {
                foreach ($menu_options as $option) {
                    $this->db->set('menu_id', $menu_id);
                    $this->db->set('option_id', $option['option_id']);
                    $this->db->set('required', $option['required']);
                    $this->db->set('option_values', serialize($option['option_values']));

                    if (!empty($option['menu_option_id'])) {
                        $this->db->set('menu_option_id', $option['menu_option_id']);
                    }

                    if ($query = $this->db->insert('menu_options')) {
                        $menu_option_id = $this->db->insert_id();
                        $this->addMenuOptionValues($menu_option_id, $menu_id, $option['option_id'], $option['option_values']);
                    }
                }
            }
        }

        return $query;
    }

    public function addMenuOptionValues($menu_option_id = FALSE, $menu_id = FALSE, $option_id = FALSE, $option_values = array()) {
        if ($menu_option_id !== FALSE AND $menu_id !== FALSE AND $option_id !== FALSE AND !empty($option_values)) {
            foreach ($option_values as $value) {
                $this->db->set('menu_option_id', $menu_option_id);
                $this->db->set('menu_id', $menu_id);
                $this->db->set('option_id', $option_id);
                $this->db->set('option_value_id', $value['option_value_id']);
                $this->db->set('new_price', $value['price']);

                if (!empty($value['menu_option_value_id'])) {
                    $this->db->set('menu_option_value_id', $value['menu_option_value_id']);
                }

                $query = $this->db->insert('menu_option_values');
            }
        }
    }

    public function deleteOption($option_id) {
        if (is_numeric($option_id)) {
            $this->db->where('option_id', $option_id);
            $this->db->delete('options');

            $this->db->where('option_id', $option_id);
            $this->db->delete('option_values');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
    }

    public function deleteMenuOption($menu_id) {
        if (is_numeric($menu_id)) {
            $this->db->where('menu_id', $menu_id);
            $this->db->delete('menu_options');

            $this->db->where('menu_id', $menu_id);
            $this->db->delete('menu_option_values');

            if ($this->db->affected_rows() > 0) {
                return TRUE;
            }
        }
    }
}

/* End of file menu_options_model.php */
/* Location: ./system/tastyigniter/models/menu_options_model.php */