<?php defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('createFields')) {
	function createFields($fields = array()) {
		if (empty($fields) OR !is_array($fields)) {
			return FALSE;
		}

		$parsed_fields = array();
		foreach ($fields as $field) {
			if (!isset($field['id'], $field['label'], $field['type'])) {
				continue;
			}

			$control = $group_inputs = '';
			if ($field['type'] === 'textarea') {
				$field_name = $field['name'];
				$control .= _createTextarea($field);
			}

			if ($field['type'] === 'text' OR $field['type'] === 'hidden') {
				$field_name = $field['name'];
				$control .= _createInput($field);
			}

			if ($field['type'] === 'control-group') {
				if (!isset($field['group'])) {
					continue;
				}

				$group_count = 0;
				$group_name = array();
				foreach ($field['group'] as $group) {
					if (isset($group['type'])) {
						$group_name[] = $group['name'];
						if ($group['type'] === 'text' OR $group['type'] === 'hidden') {
							$group_inputs .= _createInput($group);
						}

						if ($group['type'] === 'text') {
							$group_count++;
						}
					}
				}

				$control .= '<div class="control-group control-group-'.$group_count.'">'.$group_inputs.'</div>';
				$field_name = $group_name;
				//$control .=	'form_error($field['id'], '<span class="text-danger">', '</span>');
			}

			$parsed_fields[] = array (
				'id'		=> str_replace('_', '-', $field['id']),
				'name' 		=> $field_name,
				'label' 	=> $field['label'],
				'desc'		=> $field['desc'],
				'control'	=> $control
			);
		}

		return $parsed_fields;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('validateFields')) {
	function validateFields($fields = array()) {
		if (empty($fields) OR !is_array($fields)) {
			return FALSE;
		}

		$error_fields = array();
		$CI =& get_instance();
		$CI->form_validation->set_rules($fields);

		if ($CI->input->post() AND $CI->form_validation->run() === FALSE) {
			foreach ($fields as $field) {
				$error_fields[] = array(
					'field'		=> $field['field'],
					'error'		=> form_error($field['field'], '<span class="text-danger">', '</span>')
				);
			}

			return $error_fields;
		} else {
			return FALSE;
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('createTable')) {
	function createTable($table = array()) {
		if (empty($table) OR !is_array($table)) {
			return FALSE;
		}

		if (!isset($table['table_open'], $table['thead'], $table['rows'])) {
			return FALSE;
		}

		$CI =& get_instance();
		$CI->load->library('table');
		$CI->table->set_template(array('table_open' => $table['table_open']));
		$CI->table->set_heading($table['thead']);

		$parsed_table = '<div class="table-responsive">';
		foreach ($table['rows'] as $row) {
			$parsed_row = array();

			foreach ($row as $col) {
				if (empty($col)) {
					continue;
				}

				$col_data = array();
				if (isset($col['class'])) {
					$col_data['class'] = $col['class'];
				}

				if (isset($col['data'])) {
					if (is_string($col['data'])) {
						$col_data['data'] = $col['data'];
					}

					if (is_array($col['data'])) {
						if (isset($col['data'][0]) AND is_array($col['data'][0])) {
							$parsed_fields = '';

							foreach ($col['data'] as $temp_field) {
								if (isset($temp_field['type']) AND ($temp_field['type'] === 'text' OR $temp_field['type'] === 'hidden')) {
									$parsed_fields .= _createInput($temp_field);
								}
							}

							$col_data['data'] = $parsed_fields;
						} else if (isset($col['data']['type'])) {
							if ($col['data']['type'] === 'text' OR $col['data']['type'] === 'hidden') {
								$col_data['data'] = _createInput($col['data']);
							}
						}
					}
				}

				if (empty($col_data)) {
					$col_data = $col;
				}

				$parsed_row[] = $col_data;
			}

			$CI->table->add_row($parsed_row);
		}

		$parsed_table .= $CI->table->generate();
		$parsed_table .= '</div>';

		return $parsed_table;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_createInput')) {
	function _createInput($input = array()) {
		if (empty($input) OR !isset($input['type'])) {
			return FALSE;
		}

		$open = $close = $left_addon = $right_addon = $control = '';
		$input_id = isset($input['id']) ? str_replace('_', '-', $input['id']) : '';
		$input_name = isset($input['name']) ? str_replace('-', '_', $input['name']) : '';
		$input_value = getThemeOptionValue($input['name'], $input['value']);
		$input_value = isset($input['value']) ? $input['value'] : '';

		if (isset($input['color']) AND $input['color'] === TRUE) {
			$open = '<div class="input-group ti-color-picker">';
			$left_addon = '<span class="input-group-addon lg-addon"><i></i></span>';
		}

		if (isset($input['media']) AND $input['media'] === TRUE) {
			$open = '<div class="input-group">';
			$no_photo = image_url('no_photo.png');
			$remove_event = 'onclick="$(\'#'.$input_id.'-thumb\').attr(\'src\', \''.$no_photo.'\'); $(\'#'.$input_id.'\').attr(\'value\', \'\');"';
			$left_addon = '<span class="input-group-addon lg-addon"><i><img id="'.$input_id.'-thumb" class="thumb img-responsive" width="28px" src="'.$no_photo.'" /></i></span>';
			$right_addon = '<span class="input-group-btn"><button type="button" class="btn btn-primary" onclick="mediaManager(\''.$input_id.'\');"><i class="fa fa-picture-o"></i></button><button type="button" class="btn btn-danger" '.$remove_event.'><i class="fa fa-times-circle"></i></button></span>';
		}

		if (isset($input['group_addon'])) {
			$open = '<div class="input-group">';
			$right_addon = '<span class="input-group-addon">'.$input['group_addon'].'</span>';
		}

		if ($input['type'] === 'hidden') {
			$control = form_hidden($input_name, $input_value);
	    } else if ($input['type'] === 'text') {
	    	$control = form_input(array('id' => $input_id, 'name' => $input_name, 'class' => 'form-control', 'value' => $input_value));
	    }

		if ($open !== '') {
			$close = '</div>';
		}

		return $open . $left_addon . $control . $right_addon . $close;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_createTextarea')) {
	function _createTextarea($textarea = array()) {
		if (empty($textarea) OR !isset($textarea['type']) OR $textarea['type'] !== 'textarea') {
			return FALSE;
		}

		$control = '';

		$textarea_id = isset($textarea['id']) ? str_replace('_', '-', $textarea['id']) : '';
		$textarea_name = isset($textarea['name']) ? str_replace('-', '_', $textarea['name']) : '';
		$textarea_value = isset($textarea['value']) ? $textarea['value'] : '';
 		$textarea_rows = isset($textarea['rows']) ? $textarea['rows'] : '';
    	$control .= form_textarea(array('id' => $textarea_id, 'name' => $textarea_name, 'class' => 'form-control', 'value' => $textarea_value, 'rows' => $textarea_rows));

		return $control;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('getThemeOptionValue')) {
	function getThemeOptionValue($input_name = '', $default_value = '') {
//		$CI =& get_instance();
		//$CI->config->item();
//		$CI->load->model('Themes_model');
//		$theme_config = $CI->Themes_model->getConfig($CI->input->get('name'), $input_name);
//var_dump($theme_config['customization']);
		/*if (empty($default_value) OR !isset($textarea['type']) OR $textarea['type'] !== 'textarea') {
			return FALSE;
		}

		$control = '';

		$textarea_id = isset($textarea['id']) ? str_replace('_', '-', $textarea['id']) : '';
		$textarea_name = isset($textarea['name']) ? str_replace('-', '_', $textarea['name']) : '';
		$textarea_value = isset($textarea['value']) ? $textarea['value'] : '';
 		$textarea_rows = isset($textarea['rows']) ? $textarea['rows'] : '';
    	$control .= form_textarea(array('id' => $textarea_id, 'name' => $textarea_name, 'class' => 'form-control', 'value' => $textarea_value, 'rows' => $textarea_rows));

		return $control;*/
		return TRUE;
	}
}

// ------------------------------------------------------------------------

/* End of file admin_theme_helper.php */
/* Location: ./system/helpers/admin_theme_helper.php */