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
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Customizer Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Customizer.php
 * @link           http://docs.tastyigniter.com
 */
class Customizer {

    private $data = array();
    private $config = array();
    private $sections = array();
    private $fields = array();
    private $tables = array();
    private $rules = array();

    public function __construct($config = array()) {
        $this->CI =& get_instance();
        foreach ($config as $key => $val) {
            $this->{'_'.$key} = $val;
        }

        unset($config);

        log_message('info', 'Customizer Class Initialized');
    }

    public function initialize($theme = array()) {
        if (!empty($theme['data'])) $this->data = $theme['data'];

        if (!empty($theme['config']['customize']) AND is_array($theme['config']['customize'])) {
            $this->config = $theme['config'];
            $this->sections = $theme['config']['customize']['sections'];
        }

        unset($theme);
    }

    public function getNavView() {
        if (isset($this->sections) AND is_array($this->sections)) {
            $nav_row = 1;
            $nav_items = $this->_styles['nav'][0];

            foreach ($this->sections as $key => $section) {
                if (isset($section['title'])) {
                    $nav_items .= ($nav_row === 1) ? $this->_styles['nav_active_item'][0] : $this->_styles['nav_item'][0];
                    $nav_items .= str_replace('{id}', $key, $this->_styles['nav_link'][0]);

                    if (isset($section['icon'])) {
                        $nav_items .= str_replace('{class}', $section['icon'], $this->_styles['nav_icon'][0]).$this->_styles['nav_icon'][1];
                    }

                    $nav_items .= $section['title'] . $this->_styles['nav_link'][1] . $this->_styles['nav_active_item'][1];
                    $nav_row++;
                }
            }

            $nav_items .= $this->_styles['nav'][1];

            return $nav_items;
        }
    }

    public function getSectionsView() {
        $view = '';

        $this->buildSections();
        if (isset($this->sections) AND is_array($this->sections)) {
            $section_row = 1;
            foreach ($this->sections as $key => $section) {
                if (!isset($section['title'])) continue;

                $section_open = ($section_row === 1) ? str_replace('{active}', 'active', $this->_styles['section'][0]) : str_replace('{active}', '', $this->_styles['section'][0]);
                $view .= str_replace('{id}', $key, $section_open);
                $view .= $this->_styles['section_heading'][0] . $section['title'] . $this->_styles['section_heading'][1];
                $view .= (empty($section['desc'])) ? '' : $this->_styles['section_desc'][0] . $section['desc'] . $this->_styles['section_desc'][1];

                if (isset($this->fields[$key]) AND is_array($this->fields[$key])) {
                    foreach ($this->fields[$key] as $fields) {
                        foreach ($fields as $legend => $field) {
                            if (!empty($field['temp_field'])) {
                                $view .= $this->getFieldMarkup($field['temp_field']);
                            } else {
                                $view .= $this->_styles['fieldset'][0];
                                $view .= $this->_styles['fieldset_legend'][0] . $legend . $this->_styles['fieldset_legend'][1];

                                foreach ($field as $fld) {
                                    $view .= $this->getFieldMarkup($fld['temp_field']);
                                }

                                $view .= $this->_styles['fieldset'][1];
                            }
                        }
                    }
                }

                if (isset($this->tables[$key]) AND !empty($this->tables[$key])) {
                    $view .= $this->tables[$key];
                }

                $view .= $this->_styles['section'][1];
                $section_row++;
            }

            return $view;
        }
    }

    public function getRules() {
        if (!empty($this->rules)) return $this->rules;

        $this->setRules();

        return $this->rules;
    }

    public function getPostData() {
        $post_data = array();

        if ($this->CI->input->post() AND !empty($this->config['customize']['post_items'])) {
            foreach ($this->CI->input->post() as $key => $value) {
                if (in_array($key, $this->config['customize']['post_items'])) {
                    $post_data[$key] = $value;
                }
            }
        }

        return $post_data;
    }

    private function setRules() {
        if (empty($this->sections) AND !is_array($this->sections)) return FALSE;

        foreach ($this->sections as $key => $section) {
            if (!empty($section['fields'])) {
                foreach ($section['fields'] as $field) {
                    if (!isset($field['type'])) continue;

                    $field = $this->parseField($field);
                    if (!empty($field['group'])) {
                        foreach ($field['group'] as $group) {
                            if (!empty($group['rules'])) {
                                $this->rules[$group['name']] = array('field' => $group['name'], 'label' => empty($group['label']) ? $field['label'] : $group['label'], 'rules' => $group['rules']);
                            }
                        }
                    } else if (!empty($field['rules'])) {
                        $this->rules[$field['name']] = array('field' => $field['name'], 'label' => $field['label'], 'rules' => $field['rules']);
                    }
                }
            }
        }
    }

    private function buildSections() {
        if (empty($this->sections) OR !is_array($this->sections)) return FALSE;

        foreach ($this->sections as $section_key => $section) {
            foreach ($section as $key => $value) {
                if ($key === 'fields') {
                    $this->fields[$section_key][] = $this->buildFields($value);
                }

                if ($key === 'fieldset') {
                    $this->fields[$section_key][] = $this->buildFieldset($value);
                }

                if ($key === 'table') {
                    $this->tables[$section_key][] = $this->buildTable($value);
                }
            }
        }
    }

    private function buildFieldset($fieldsets = array()) {
        $temp_fields = array();

        if (isset($fieldsets['fields'])) {
            $legend = isset($fieldsets['legend']) ? $fieldsets['legend'] : '';
            $temp_fields[$legend] = $this->buildFields($fieldsets['fields']);
        } else {
            foreach ($fieldsets as $fieldset) {
                $legend = isset($fieldset['legend']) ? $fieldset['legend'] : '';
                $temp_fields[$legend] = $this->buildFields($fieldset['fields']);
            }
        }

        return $temp_fields;
    }

    private function buildFields($fields = array()) {
        $temp_fields = array();

        if (isset($fields['type'])) {
            $temp_fields = $this->buildField($fields);
        } else {
            foreach ($fields as $field) {
                $temp_fields[] = $this->buildField($field);
            }
        }

        return $temp_fields;
    }

    private function buildField($field = array()) {
        if (!empty($field) AND isset($field['id'], $field['type'])) {
            $temp_field = $this->buildFieldMarkup($field);

            if (!empty($field['label'])) {
                $temp_field['label'] = $this->createLabel($field);
            }

            if ($temp_field !== '') {
                $field['temp_field'] = $temp_field;
            }
        }

        return $field;
    }

    private function buildFieldMarkup($field = array()) {
        $markup = array();

        $field = $this->parseField($field);

        if (!empty($field['name'])) {
            $markup['name'] = $field['name'];
            $markup['error'] = $this->getFieldError($field['name']);
            $this->rules[$field['name']] = array('field' => $field['name'], 'label' => $field['label'], 'rules' => $field['rules']);

            if ((isset($field['type']) AND !in_array($field['type'], array('radio', 'checkbox')))) {
                $field['value'] = $this->getFieldValue($field['name'], $field['value']);
            }
        }

        if (isset($field['type'])) switch ($field['type']) {
            case 'hidden':
            case 'text':
            case 'password':
            case 'upload':
                $markup['html'] = $this->createInput($field);
                break;
            case 'textarea':
                $markup['html'] = $this->createTextarea($field);
                break;
            case 'dropdown':
                $markup['html'] = $this->createDropdown($field);
                break;
            case 'checkbox':
            case 'radio':
                $markup['html'] = $this->createCheckboxOrRadio($field);
                break;
            case 'color':
                $markup['html'] = $this->createColorInput($field);
                break;
            case 'media':
                $markup['html'] = $this->createMediaInput($field);
                break;
            case 'input-group':
                $markup = $this->createInputGroup($field);
                break;
            case 'button-group':
                $markup = $this->createButtonGroup($field);
                break;
        }

        return $markup;
    }

    private function buildTable($table = array()) {
        if (!empty($table) AND isset($table['type'], $table['thead'], $table['rows'])) {

            $this->CI->load->library('table');

            $table_tag = $this->getTableTag($table);

            $this->CI->table->set_template(array('table_open' => $table_tag[0], 'table_close' => $table_tag[1]));
            $this->CI->table->set_heading($table['thead']);

            $table_markup = $this->_styles['table_responsive'][0];
            foreach ($table['rows'] as $row) {
                $temp_row = $this->createTableRow($row);
                $this->CI->table->add_row($temp_row);
            }

            $table_markup .= $this->CI->table->generate();
            $table_markup .= $this->_styles['table_responsive'][1];

            return $table_markup;
        }
    }

    private function getTableTag($table) {
        if (isset($table['type'])) switch ($table['type']) {
            case 'table':
                $table_tag = $this->_styles['table_sortable'];
                break;
            case 'border':
                $table_tag = $this->_styles['table_border'];
                break;
            case 'striped':
                $table_tag = $this->_styles['table_striped'];
                break;
            case 'sortable':
                $table_tag = $this->_styles['table_sortable'];
                break;
        }

        return $table_tag;
    }

    private function getFieldMarkup($temp_field, $remove_style = FALSE) {
        $field_markup = '';

        if (!empty($temp_field)) {
            $field_label = (empty($temp_field['label'])) ? '' : $temp_field['label'];

            $field_html = empty($temp_field['html']) ? '' : $temp_field['html'];

            if (!empty($temp_field['error'])) {
                $field_html .= $this->getErrorMarkup($temp_field['error']);
            }

            if ($remove_style) {
                $field_markup .= $field_label . $field_html;
            } else {
                $field_markup .= $this->_styles['field'][0] . $field_label . $this->_styles['control'][0] . $field_html  . $this->_styles['control'][1] . $this->_styles['field'][1];
            }
         }

        return $field_markup;
    }

    private function getErrorMarkup($field_error, $error_markup = '') {
        if (!empty($field_error)) {
            if (is_array($field_error)) {
                $last_err = '';
                foreach ($field_error as $error) {
                    $error_markup .= ($last_err !== $error) ? $this->_styles['error'][0] . $error . $this->_styles['error'][1] : '';
                    $last_err = $error;
                }
            } else {
                $error_markup .= $this->_styles['error'][0] . $field_error . $this->_styles['error'][1];
            }
        }

        return $error_markup;
    }

    private function createLabel($field = array()) {
        if (isset($field['label'])) {
            $label = str_replace('{id}', $field['id'], $this->_styles['label'][0]) . $field['label'];

            if (isset($field['desc'])) {
                $label .= $this->_styles['label_desc'][0] . $field['desc'] . $this->_styles['label_desc'][1];
            }

            return $label . $this->_styles['label'][1];
        }
    }

    private function createTextarea($field = array()) {
        if (empty($field['type']) OR $field['type'] !== 'textarea') return FALSE;

        return form_textarea(array('id' => $field['id'], 'name' => $field['name'], 'class' => $this->_form_classes['textarea'], 'value' => $field['value'], 'rows' => $field['rows']));
    }

    private function createInput($field = array()) {
        if (empty($field['type'])) return FALSE;

        $input = '';
        if ($field['type'] === 'hidden') {
            $input = form_hidden($field['name'], $field['value']);
        } else if ($field['type'] === 'text') {
            $input = form_input(array('id' => $field['id'], 'name' => $field['name'], 'class' => $this->_form_classes['text'], 'value' => $field['value']));
        } else if ($field['type'] === 'password') {
            $input = form_password(array('id' => $field['id'], 'name' => $field['name'], 'class' => $this->_form_classes['text'], 'value' => $field['value']));
        } else if ($field['type'] === 'upload') {
            $input = form_upload(array('id' => $field['id'], 'name' => $field['name'], 'class' => $this->_form_classes['text'], 'value' => $field['value']));
        }

        if (!empty($field['l_addon']) OR !empty($field['r_addon'])) {
            $field['l_addon'] = (!empty($field['l_addon'])) ? $this->_styles['input_l_addon'][0] . $field['l_addon'] . $this->_styles['input_l_addon'][1] : '';
            $field['r_addon'] = (!empty($field['r_addon'])) ? $this->_styles['input_r_addon'][0] . $field['r_addon'] . $this->_styles['input_r_addon'][1] : '';

            return $this->_styles['input_addon'][0] . $field['l_addon'] . $input . $field['r_addon'] . $this->_styles['input_addon'][1];
        }

        return $input;
    }

    private function createColorInput($field = array()) {
        if (empty($field['type']) AND $field['type'] !== 'color') return FALSE;

        $input = form_input(array('id' => $field['id'], 'name' => $field['name'], 'class' => $this->_form_classes['color'], 'value' => $field['value']));

        $field['l_addon'] = $this->_styles['color_l_addon'][0] . '<i></i>' . $this->_styles['color_l_addon'][1];
        return $this->_styles['color_addon'][0] . $field['l_addon'] . $input . $this->_styles['color_addon'][1];
    }

    private function createMediaInput($field = array()) {
        if (empty($field['type']) AND $field['type'] !== 'media') return FALSE;

        $this->CI->load->model('Image_tool_model');

        $no_photo_src = $this->CI->Image_tool_model->resize('data/no_photo.png');
        if (!empty($field['value'])) {
            $image_src = $this->CI->Image_tool_model->resize($field['value']);
        } else {
            $image_src = $no_photo_src;
        }

        $remove_event = 'onclick="$(\'#'.$field['id'].'-thumb\').attr(\'src\', \''.$no_photo_src.'\'); $(\'#'.$field['id'].'\').attr(\'value\', \'\');"';
        $field['l_addon'] = $this->_styles['media_l_addon'][0] . '<i><img id="'.$field['id'].'-thumb" class="thumb img-responsive" width="28px" src="'.$image_src.'" /></i>' . $this->_styles['media_l_addon'][1];
        $field['r_addon'] = $this->_styles['media_r_addon'][0] . '<button type="button" class="btn btn-primary" onclick="mediaManager(\''.$field['id'].'\');"><i class="fa fa-picture-o"></i></button><button type="button" class="btn btn-danger" '.$remove_event.'><i class="fa fa-times-circle"></i></button>' . $this->_styles['media_r_addon'][1];

        $input = form_input(array('id' => $field['id'], 'name' => $field['name'], 'class' => $this->_form_classes['media'], 'value' => $field['value']));

        return $this->_styles['media_addon'][0] . $field['l_addon'] . $input . $field['r_addon'] . $this->_styles['media_addon'][1];
    }

    private function createDropdown($field = array()) {
        if (empty($field['type'])) return FALSE;

        $extra = 'id="' . $field['id'] . '" class="' . $this->_form_classes['dropdown'] . '"';

        if ($field['type'] === 'dropdown') {
            return form_dropdown($field['name'], $field['options'], $field['value'], $extra);
        } else if ($field['type'] === 'multiselect') {
            return form_multiselect($field['name'], $field['options'], $field['value'], $extra);
        }
    }

    private function createCheckboxOrRadio($field = array()) {
        if (empty($field['type'])) return FALSE;

        if ($field['type'] === 'checkbox') {
            return form_checkbox(array('id' => $field['id'], 'name' => $field['name'], 'value' => $field['value'], 'checked' => $field['checked'])) . $field['label'];
        } else if ($field['type'] === 'radio') {
            return form_radio(array('id' => $field['id'], 'name' => $field['name'], 'value' => $field['value'], 'checked' => $field['checked'])) . $field['label'];
        }
    }

    private function createInputGroup($field = array()) {
        if (empty($field['type']) AND $field['type'] !== 'input-group' AND empty($field['group'])) return FALSE;

        $group_count = 0;
        $temp_names = $temp_errors =array();
        $temp_html = $control = '';
        foreach ($field['group'] as $field) {
            if ($field['type'] !== 'hidden') $group_count++;
            $temp_fields = $this->buildFieldMarkup($field);
            $temp_names[] = $temp_fields['name'];
            $temp_errors[] = $temp_fields['error'];
            $temp_html .= $temp_fields['html'];
        }

        $control .= str_replace('{group_count}', $group_count, $this->_styles['input_group'][0]);
        $control .=  $temp_html . $this->_styles['input_group'][1];
        return array('name' => $temp_names, 'html' => $control, 'error' => $temp_errors);
    }

    private function createButtonGroup($field = array()) {
        if (empty($field['type']) AND $field['type'] !== 'button-group' AND empty($field['group'])) return FALSE;

        $group_count = 0;
        $temp_names = $temp_errors =array();
        $temp_html = $control = '';
        foreach ($field['group'] as $button) {
            if ($button['type'] !== 'hidden') $group_count++;

            $value = $this->getFieldValue($button['name']);
            if ($value === $button['value']) {
                $button['checked'] = TRUE;
            } else if (!empty($value)) {
                unset($button['checked']);
            }

            $button['id'] = $field['id'].'-'.$group_count;

            $temp_fields = $this->buildFieldMarkup($button);
            $temp_names[] = $temp_fields['name'];
            $temp_errors[] = $temp_fields['error'];

            $button_label = (isset($button['checked'])) ? str_replace('{active}', 'active', $this->_styles['button_label'][0]) : str_replace('{active}', '', $this->_styles['button_label'][0]);
            $button_label = str_replace('{data_btn}', $button['data-btn'], $button_label);

            $temp_html .= $button_label . $temp_fields['html'] . $this->_styles['button_label'][1];
        }

        $control .= str_replace('{group_count}', $group_count, $this->_styles['button_group'][0]);
        $control .=  $temp_html . $this->_styles['button_group'][1];
        return array('name' => $temp_names, 'html' => $control, 'error' => $temp_errors);
    }

    private function createTableRow($row = array()) {
        $parsed_row = array();

        if (!empty($row)) {
            foreach ($row as $col) {
                if (empty($col)) continue;

                if (isset($col['fields']) AND !isset($col['data'])) {
                    $fields = $this->buildFields($col['fields']);

                    $temp_field = array();
                    foreach ($fields as $field) {
                        $temp_field[] = $this->getFieldMarkup($field['temp_field'], TRUE);
                    }

                    $col['data'] = !empty($temp_field) ? implode('', $temp_field) : '';
                    unset($col['fields']);
                }

                $parsed_row[] = $col;
            }
        }

        return $parsed_row;
    }

    private function parseField($field = array()) {
        if (empty($field['name'])) return $field;

        $temp_item = array('id' => '', 'name' => '', 'label' => '', 'value' => '', 'type' => '', 'l_addon' => '', 'r_addon' => '', 'rows' => '', 'group' => array(), 'rules' => '', 'temp_fields' => array(), 'error' => '', 'options' => array(), 'checked' => FALSE);

        foreach($temp_item as $key => $value) {
            if (!isset($field[$key])) {
                $field[$key] = $value;
            }
        }

        $field['id'] = str_replace('_', '-', $field['id']);
        $field['name'] = str_replace('-', '_', $field['name']);

        return $field;
    }

    private function getFieldError($name) {
        $error_array = $this->CI->form_validation->error_array();

        if (!empty($name) AND !empty($error_array)) {
            if (isset($error_array[$name])) {
                return $error_array[$name];
            }
        }
    }

    private function getFieldData($name) {
        $temp_data = NULL;

        if (preg_match_all('/\[(.*?)\]/', $name, $matches)) {
            $indexes = array();
            sscanf($name, '%[^[][', $indexes[0]);
            for ($i = 0, $c = count($matches[0]); $i < $c; $i++) {
                if ($matches[1][$i] !== '') {
                    $indexes[] = $matches[1][$i];
                }
            }

            $temp_data = $this->reduceArray($this->data, $indexes);
        } else {
            $temp_data = isset($this->data[$name]) ? $this->data[$name] : NULL;
        }

        return $temp_data;
    }

    private function getFieldValue($name, $default = '') {
        $temp_value = $this->getFieldData($name);
        $temp_value = ($temp_value !== NULL) ? $temp_value : $default;
        return $this->CI->form_validation->set_value($name, $temp_value);
    }

    private function reduceArray($array, $keys, $i = 0) {
        if (is_array($array) AND isset($keys[$i])) {
            return isset($array[$keys[$i]]) ? $this->reduceArray($array[$keys[$i]], $keys, ($i+1)) : NULL;
        }

        return ($array === '') ? NULL : $array;
    }
}


// END Customizer Class

/* End of file Customizer.php */
/* Location: ./system/tastyigniter/libraries/Customizer.php */