<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Image_manager extends Admin_Controller {

    private $_uploads = FALSE;
    private $_new_folder = FALSE;
    private $_move = FALSE;
    private $_copy = FALSE;
    private $_rename = FALSE;
    private $_delete = FALSE;
    private $_remember_days;
    private $_allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico');

    public function __construct() {
		parent::__construct(); //  calls the constructor

        $this->load->library('media_manager', $this->config->item('image_manager'));

        $this->lang->load('media_manager');

        $setting = $this->media_manager->getOptions();
        foreach ($setting as $key => $value) {
            $this->{'_' . $key} = ($value === '0') ? FALSE : $value;
        }
    }

	public function index() {
        $this->user->restrict('Admin.MediaManager.Access');

        $this->output->enable_profiler(FALSE);

        $data['uploads'] = $this->_uploads;
        $data['new_folder'] = $this->_new_folder;
        $data['move'] = $this->_move;
        $data['copy'] = $this->_copy;
        $data['rename'] = $this->_rename;
        $data['delete'] = $this->_delete;

        $popup = $data['popup'] = ($this->input->get('popup')) ? $this->_fixGetParams($this->input->get('popup')) : '';
		$field_id = $data['field_id'] = ($this->input->get('field_id')) ? $this->_fixGetParams($this->input->get('field_id')) : '';
		$filter = $data['filter'] = ($this->input->get('filter')) ? $this->_fixGetParams($this->input->get('filter')) : '';
		$sort_by = $data['sort_by'] = ($this->input->get('sort_by')) ? $this->_fixGetParams($this->input->get('sort_by')) : 'name';
		$sort_order = $data['sort_order'] = ($this->input->get('sort_order')) ? $this->_fixGetParams($this->input->get('sort_order')) : 'ascending';
		$data['sort_icon'] = ($sort_order === 'ascending') ? '<i class="fa fa-caret-up"></i>' : '<i class="fa fa-caret-down"></i>';

		$get_params = http_build_query(array(
			'popup'    		=> $popup,
			'field_id'  	=> $field_id,
			'sub_folder'	=> ''
		));

        $root_folder = $this->media_manager->getRootFolder();
        $open_file = '';

        if ($this->input->get('sub_folder') AND strpos($this->input->get('sub_folder'), '../') === FALSE AND strpos($this->input->get('sub_folder'), './') === FALSE) {
            $sub_folder = $this->input->get('sub_folder');

            if ($pathinfo = pathinfo($sub_folder) AND !empty($pathinfo['extension'])) {
                $sub_folder = isset($pathinfo['dirname']) ? $pathinfo['dirname'].'/' : '';
                $open_file = isset($pathinfo['basename']) ? $pathinfo['basename'] : '';

                if (strpos($sub_folder, $root_folder) !== FALSE) {
                    $sub_folder = str_replace($root_folder, '', $sub_folder);
                }
            } else {
                $sub_folder = urldecode(trim(strip_tags($sub_folder), '/') .'/');
            }

            $this->session->set_tempdata('last_sub_folder', $sub_folder, 86400 * (int)$this->_remember_days);
        } else if ($this->session->tempdata('last_sub_folder')) {
            $sub_folder = $this->security->sanitize_filename($this->session->tempdata('last_sub_folder'), TRUE);
        } else {
            $sub_folder = '';
        }

        $sub_folder = ($sub_folder === "/") ? '' : $sub_folder;

        $this->setTemplateTags($popup);

        $data['title']              = $this->lang->line('text_heading');
        $data['files_empty']        = $this->lang->line('text_empty');
        $data['back']               = $this->lang->line('text_disabled');

		$data['back_url'] = '';
		if (trim($sub_folder) != '') {
			$src = explode('/', $sub_folder);
			unset($src[count($src) - 2]);
			$src = implode('/', $src);
			if ($src == '') {
				$src = '/';
			}

			$data['back']       = '';
			$data['back_url']   = page_url() .'?'. $get_params . rawurlencode($src) .'&'. uniqid();;
		}

		$data['current_url']    = current_url();
		$data['refresh_url']    = page_url() .'?'. $get_params . $sub_folder .'&'. uniqid();
		$data['link']           = page_url() .'?'. $get_params;
        $data['delete_folder']  = FALSE;
        $data['rename_folder']  = FALSE;
        $data['current_folder'] = '';

        $data['breadcrumbs'] = array();
		if ($sub_folder_array = explode('/', $sub_folder)) {
            $tmp_path = '';
			$data['breadcrumbs'][] = array('name' => '<i class="fa fa-home"></i>', 'link' => $data['link'] .'/');
			foreach ($sub_folder_array as $key => $p_dir) {
				$tmp_path .= $p_dir .'/';
				if ($p_dir != '') {
                    $data['breadcrumbs'][] = array('name' => $p_dir, 'link' => $data['link'] . $tmp_path);

                    $data['current_folder']  = $p_dir;
                }
            }

            if ($data['current_folder'] === 'gallery') {
                $data['new_folder'] = TRUE;
            }

            $dirname = dirname($sub_folder);
            $data['parent_folder']  = ($dirname === '.') ? '' : $dirname . '/';
        }

        $data['total_files'] = $total_size = 0;

        $data['files'] = array();
        $files = $this->media_manager->fetchFiles($sub_folder, array('by' => $sort_by, 'order' => $sort_order, 'filter' => $filter));
        foreach($files as $k => $file) {

            $file_ext = (!empty($file['ext'])) ? $file['ext'] : '';

            $new_name = $this->media_manager->fixFileName($file['name']);
            $file_name = ($file['name'] != '..' AND $file['name'] != $new_name) ? $new_name : $file['name'];
            $human_name = ($file['type'] === 'img' OR $file['type'] === 'file') ? substr($file_name, 0, '-' . (strlen($file_ext) + 1)) : $file_name;
            $html_class = ($file['type'] === 'img') ? 'ff-item-type-2 file' : 'ff-item-type-1 file';

            if ($open_file === $file['name']) {
                $html_class .= ' selected-on-open';
            }

            $img_dimension = $img_url = $thumb_url = '';

            $img_url = image_url($root_folder . $sub_folder . $file_name);

            if ($file['type'] === 'img') {
                $thumb_type = 'thumb';
                $thumbnail = $this->media_manager->getThumbnail($file_name, $sub_folder);
                $img_dimension = $thumbnail['dimension'];
                $thumb_url = $thumbnail['url'];
            }

            if ($thumb_url == '') {
                $thumb_type = 'icon';
                $thumb_url = image_url('default-icon.svg');
            }

            $total_size += $file['size'];

			$data['files'][] = array(
				'name'					=> $file_name,
				'human_name'			=> $human_name,
				'type'					=> $file['type'],
				'date'					=> $file['date'],
				'size'					=> $this->_makeSize($file['size']),
				'ext'					=> $file_ext,
				'perms'					=> $file['perms'],
				'path'				    => $sub_folder . $file_name,
				'img_url'				=> $img_url,
				'thumb_type'			=> $thumb_type,
				'thumb_url'				=> $thumb_url,
				'img_dimension'			=> $img_dimension,
				'html_class'			=> $html_class
			);
		}

        $data['galleries']       = $this->media_manager->fetchGalleries();

        $tree_link = page_url() .'?'. $get_params .'{link}&'. uniqid();
        $data['folder_tree']        = $this->media_manager->folderTree($sub_folder, $tree_link);

        $data['total_files']        = count($files);
        $data['root_folder']        = $root_folder;
        $data['sub_folder']         = $sub_folder;
        $data['folders_list']       = $this->media_manager->recursiveFolders();
        $data['folder_size']        = $this->_makeSize($total_size);
        $data['max_size_upload']    = $this->media_manager->getUploadMaxSize();
		$data['allowed_ext']        = $this->media_manager->getAllowedExt();

		if ($popup === 'iframe') {
            $this->load->view($this->config->item(ADMINDIR, 'default_themes') . 'image_manager', $data);
        } else {
            $this->template->render('image_manager', $data);
        }
    }

	public function resize() {
		$this->load->model('Image_tool_model');

		if ($this->input->get('image')) {
			$width = ($this->input->get('width')) ? (int) $this->input->get('width'): '';
			$height = ($this->input->get('height')) ? (int) $this->input->get('height'): '';

			$image_url = $this->Image_tool_model->resize(html_entity_decode($this->input->get('image'), ENT_QUOTES, 'UTF-8'), $width, $height);
			$this->output->set_output(json_encode($image_url));
		}
	}

	public function new_folder() {
		$json = array();

    	if (!$this->user->hasPermission('Admin.MediaManager.Add')) {
			$json['alert'] = sprintf($this->lang->line('alert_permission'), '<b>add</b> folder');
        } else if (!$this->_new_folder) {
            $json['alert'] = $this->lang->line('alert_new_folder_disabled');
		} else if (!$this->input->post('name')) {
            $json['alert'] = $this->lang->line('alert_file_name_required');
        } else {

            $sub_folder = $this->security->sanitize_filename($this->input->post('sub_folder'), TRUE);
            $folder_name = $this->media_manager->fixFileName($this->input->post('name'));

            if (strpos($this->input->post('sub_folder'), '/') === 0 OR strpos($this->input->post('sub_folder'), './') !== FALSE OR strpos($folder_name, '/') !== FALSE) {
				$json['alert'] = $this->lang->line('alert_invalid_file_name');
			} else if ($this->media_manager->fileExists($sub_folder . $folder_name)) {
				$json['alert'] = $this->lang->line('alert_file_exists');
			} else {
                if (!isset($json['alert'])) {
                    $this->media_manager->newFolder($sub_folder . $folder_name);
                    $json['success'] = $this->lang->line('alert_success_new_folder');
                }
            }
		}

		$this->output->set_output(json_encode($json));
	}

    public function rename() {
        $json = array();

        if (!$this->user->hasPermission('Admin.MediaManager.Manage')) {
            $json['alert'] = sprintf($this->lang->line('alert_permission'), '<b>manage</b> files');
        } else if (!$this->_rename) {
            $json['alert'] = $this->lang->line('alert_rename_disabled');
        } else if (!$this->input->post('file_path') AND !$this->input->post('file_name') AND !$this->input->post('new_name')) {
            $json['alert'] = $this->lang->line('alert_file_name_required');
        } else {

            $file_path = $this->security->sanitize_filename($this->input->post('file_path'), TRUE);
            $file_name = $this->media_manager->fixFileName($this->input->post('file_name'));
            $new_name = $this->media_manager->fixFileName($this->input->post('new_name'));

            if (strpos($file_path . $file_name, '/') === 0 OR strpos($file_path . $file_name, './') !== FALSE OR strpos($file_name, '/') !== FALSE) {
                $json['alert'] = $this->lang->line('alert_invalid_file_name');
            } else if (strpos($new_name, '/') !== FALSE) {
                $json['alert'] = $this->lang->line('alert_invalid_new_file_name');
            } else {
                $info = pathinfo($new_name);
                if (isset($info['extension']) AND !in_array($info['extension'], $this->_allowed_ext)) {
                    $json['alert'] = $this->lang->line('alert_extension_not_allowed');
                } else if (!$this->media_manager->isWritable(dirname($file_path . $file_name)) OR !$this->media_manager->isWritable($file_path . $file_name)) {
                    $json['alert'] = $this->lang->line('alert_file_not_writable');
                } else {
                    if (!isset($json['alert'])) {
                        if ($this->media_manager->rename($file_path . $file_name, $new_name)) {
                            $json['success'] = $this->lang->line('alert_success_rename');
                        } else {
                            $json['alert'] = $this->lang->line('alert_file_exists');
                        }
                    }
                }
            }
        }

        $this->output->set_output(json_encode($json));
    }

    public function copy() {
		$json = array();

    	if (!$this->user->hasPermission('Admin.MediaManager.Manage')) {
            $json['alert'] = sprintf($this->lang->line('alert_permission'), '<b>manage</b> files');
        } else if (!$this->_copy) {
            $json['alert'] = $this->lang->line('alert_copy_disabled');
		} else if (!$this->input->post('to_folder') AND !$this->input->post('copy_files')) {
            $json['alert'] = $this->lang->line('alert_select_copy_folder');
        } else {

			$to_folder = $this->security->sanitize_filename($this->input->post('to_folder'), TRUE);
			$from_folder = $this->security->sanitize_filename($this->input->post('from_folder'), TRUE);
			$copy_files = json_decode($this->input->post('copy_files'));

			if (!is_array($copy_files) AND empty($copy_files)) {
				$json['alert'] = $this->lang->line('alert_select_copy_file');
			} else if (!$this->media_manager->isWritable($to_folder)) {
				$json['alert'] = $this->lang->line('alert_file_not_writable');
			} else {
                if (!isset($json['alert'])) {
                    foreach ($copy_files as $copy_file) {
                        $copy_file = $this->media_manager->fixFileName($copy_file);

                        if (!$this->media_manager->copy($from_folder . $copy_file, $to_folder . $copy_file)) {
                            $json['alert'] = $this->lang->line('alert_file_exists');
                        } else {
                            $json['success'] = $this->lang->line('alert_success_copy');
                        }
                    }
                }
            }
		}

		$this->output->set_output(json_encode($json));
	}

    public function move() {
		$json = array();

    	if (!$this->user->hasPermission('Admin.MediaManager.Manage')) {
            $json['alert'] = sprintf($this->lang->line('alert_permission'), '<b>manage</b> files');
        } else if (!$this->_move) {
            $json['alert'] = $this->lang->line('alert_move_disabled');
		} else if (!$this->input->post('to_folder') AND !$this->input->post('move_files')) {
            $json['alert'] = $this->lang->line('alert_select_move_folder');
        } else {

			$to_folder = $this->security->sanitize_filename($this->input->post('to_folder'), TRUE);
			$from_folder = $this->security->sanitize_filename($this->input->post('from_folder'), TRUE);
			$move_files = json_decode($this->input->post('move_files'));

            if (!is_array($move_files) AND empty($move_files)) {
				$json['alert'] = $this->lang->line('alert_select_move_file');
			} else if (!$this->media_manager->isWritable($to_folder)) {
				$json['alert'] = $this->lang->line('alert_file_not_writable');
			} else {
                if (!isset($json['alert'])) {
                    foreach ($move_files as $move_file) {
                        $move_file = $this->media_manager->fixFileName($move_file);

                        if (!$this->media_manager->move($from_folder . $move_file, $to_folder . $move_file)) {
                            $json['alert'] = $this->lang->line('alert_file_exists');
                        } else {
                            $json['success'] = $this->lang->line('alert_success_move');
                        }
                    }
                }
            }
		}

		$this->output->set_output(json_encode($json));
	}

	public function delete() {
		$json = array();

    	if (!$this->user->hasPermission('Admin.MediaManager.Delete')) {
            $json['alert'] = sprintf($this->lang->line('alert_permission'), '<b>delete</b> files');
        } else if (!$this->_delete) {
            $json['alert'] = $this->lang->line('alert_delete_disabled');
		} else if (!$this->input->post('file_path') AND !($this->input->post('file_name') OR $this->input->post('file_names'))) {
            $json['alert'] = $this->lang->line('alert_select_delete_file');
        } else {

			$file_path = $this->security->sanitize_filename($this->input->post('file_path'), TRUE);
            $file_names = json_decode($this->input->post('file_names'));
            $file_name = $this->input->post('file_name');

            if (strpos($file_path, '/') === 0 OR strpos($file_path, './') !== FALSE OR strpos($file_name, '/') !== FALSE) {
                $json['alert'] = $this->lang->line('alert_invalid_path');
            }

			if ($file_name AND empty($file_names)) {
                $file_names = array($file_name);
			}

            if (!isset($json['alert'])) {
                foreach ($file_names as $file_name) {
                    $file_name = $this->media_manager->fixFileName($file_name);

                    if (!$this->media_manager->isWritable($file_path . $file_name)) {
                        $json['alert'] = $this->lang->line('alert_file_not_writable');
                        break;
                    } else if ($this->media_manager->delete($file_path . $file_name)) {
                        $json['success'] = $this->lang->line('alert_success_delete');
                    }
                }
            }
        }

		$this->output->set_output(json_encode($json));
	}

	public function upload() {
		$json = array();

    	if (!$this->user->hasPermission('Admin.MediaManager.Manage')) {
            $json['alert'] = sprintf($this->lang->line('alert_permission'), '<b>add</b> file');
		} else if (!$this->_uploads) {
			$json['error'] = $this->lang->line('alert_upload_disabled');
		} else {
            $sub_folder = $this->security->sanitize_filename($this->input->post('sub_folder'), TRUE);
            if (strpos($this->input->post('sub_folder'), '/') === 0 OR strpos($this->input->post('sub_folder'), './') !== FALSE) {
                $sub_folder = '';
            }

            if (!$this->media_manager->isWritable($sub_folder)) {
                $this->lang->line('alert_file_not_writable');
            } else if (!$this->media_manager->fileExists($sub_folder)) {
                $json['error'] = $this->lang->line('alert_invalid_path');
            } else {
                if (!isset($json['error'])) {
                    if (!$this->media_manager->upload($sub_folder)) {
                        $json['error'] = $this->lang->line('alert_error_upload');
                    } else {
                        $json['success'] = $this->lang->line('alert_success_upload');
                    }
                }
            }
        }

        $response = '';
        if (isset($json['error'])) {
            $this->output->set_status_header('401');
            $response = $json['error'];
        }

        if (isset($json['success'])) {
            $response = $json['success'];
        }

        $this->output->set_output($response);
	}

    private function _makeSize($size) {
        if (empty($size)) return '0 B';

        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $u = 0;
        while ((round($size / 1024) > 0) AND ($u < 4)) {
            $size = $size / 1024;
            $u++;
        }

        return (number_format($size, 0) . " " . $units[$u]);
    }

    private function _fixGetParams($str) {
		return strip_tags(preg_replace( "/[^a-zA-Z0-9\.\[\]_| -]/", '', $str));
	}

	private function _fixDirName($str){
		return str_replace('~',' ',dirname(str_replace(' ','~',$str)));
	}

    /**
     * @param $popup
     */
    private function setTemplateTags($popup) {
        if ($popup == 'iframe') {
            $this->template->setDocType('html5');
            $this->template->setMeta(array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv'));
            $this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=edge,chrome=1', 'type' => 'equiv'));
            $this->template->setMeta(array('name' => 'X-UA-Compatible', 'content' => 'IE=9; IE=8; IE=7', 'type' => 'equiv'));
            $this->template->setMeta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1', 'type' => 'name'));
            $this->template->setMeta(array('name' => 'robots', 'content' => 'noindex,nofollow', 'type' => 'name'));

            $this->template->setFavIcon('images/favicon.ico', 'shortcut icon', 'image/ico');

            $this->template->setStyleTag('css/bootstrap.min.css', 'bootstrap-css', '10');
            $this->template->setStyleTag('css/font-awesome.min.css', 'font-awesome-css', '11');
            $this->template->setStyleTag('css/metisMenu.min.css', 'metis-menu-css', '12');
            $this->template->setStyleTag('css/select2.css', 'select2-css', '13');
            $this->template->setStyleTag('css/select2-bootstrap.css', 'select2-bootstrap-css', '14');
            $this->template->setStyleTag(assets_url('css/imagemanager/dropzone.min.css'), 'dropzone-css', '15');
	        $this->template->setStyleTag('css/fonts.css', 'fonts-css', '16');
            $this->template->setStyleTag(assets_url('css/imagemanager/image-manager.css'), 'image-manager-css', '100');

            $this->template->setScriptTag('js/jquery-1.11.2.min.js', 'jquery-js', '1');
            $this->template->setScriptTag('js/bootstrap.min.js', 'bootstrap-js', '99');
            $this->template->setScriptTag(assets_url('js/js.cookie.js'), 'js-cookie-js', '100');
            $this->template->setScriptTag('js/metisMenu.min.js', 'metis-menu-js', '101');
            $this->template->setScriptTag(assets_url('js/imagemanager/bootbox.min.js'), 'bootbox-js', '102');
            $this->template->setScriptTag('js/select2.js', 'select-2-js', '103');
            $this->template->setScriptTag(assets_url('js/imagemanager/dropzone.min.js'), 'dropzone-js', '104');
            $this->template->setScriptTag(assets_url('js/imagemanager/selectonic.min.js'), 'selectonic-js', '107');
            $this->template->setScriptTag('js/common.js', 'common-js');
        }

        $this->template->setTitle($this->lang->line('text_title'));
        $this->template->setHeading($this->lang->line('text_heading'));
    }
}

/* End of file image_manager.php */
/* Location: ./admin/controllers/image_manager.php */