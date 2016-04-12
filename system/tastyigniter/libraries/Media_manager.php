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
 * Media_manager Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Media_manager.php
 * @link           http://docs.tastyigniter.com
 */
class Media_manager {

    private $_image_path = IMAGEPATH;
    private $_root_folder = 'data/';
    private $_thumbs_folder = 'thumbs/';
    private $_sub_folder;
    private $_max_size = '300';
    private $_thumb_width = '320';
    private $_thumb_height = '220';
    private $_uploads = '1';
    private $_new_folder = '1';
    private $_copy = '1';
    private $_move = '1';
    private $_rename = '1';
    private $_delete = '1';
    private $_allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico');
    private $_hidden_files = array('index.html');
    private $_hidden_folders = array();
    private $_transliteration = FALSE;

    private $_remember_days = '7';
    private $_options = array();

    public function __construct($config = array()) {
        $this->CI =& get_instance();

        foreach ($config as $key => $value) {
            if (property_exists($this, '_'.$key)) {
                $this->{'_'.$key} = $value;
            }
        }

        $this->_options = $config;
    }

    public function getOptions() {
        return $this->_options;
    }

    public function getImagePath() {
        return $this->_image_path;
    }

    public function getRootFolder() {
        return $this->_root_folder;
    }

    public function getAllowedExt() {
        return $this->_allowed_ext;
    }

    public function getUploadMaxSize() {
        return $this->_max_size;
    }

    public function recursiveFolders($path = '') {
        return $this->_recursiveFolders($this->_image_path . $this->_root_folder . $path);
    }

    public function folderTree($path = '', $return_link = '') {
        $this->_sub_folder = ($path !== '') ? explode('/', $path) : array();
        return $this->_folderTree('', $return_link, '');
    }

    public function fetchGalleries() {
        $galleries = $this->_recursiveFolders($this->_image_path . $this->_root_folder . 'gallery/', FALSE);

        $_galleries = array();
        foreach ($galleries as $key => $value) {
            $_galleries[] = array('name' => basename($value), 'path' => $value);
        }

        return $_galleries;
    }

    public function fetchFiles($path, $sort = array()) {
        if (!is_dir($this->_image_path . $this->_root_folder . $path)) return array();

        if ( ! is_dir($this->_image_path . $this->_thumbs_folder . $path)) {
            $this->createFolder(FALSE, $this->_image_path . $this->_thumbs_folder . $path);
        }

        $u_files = array();

        foreach (glob($this->_image_path . $this->_root_folder . $path . '*') as $key => $file_path) {
            $file_name = basename($file_path);

            if (!empty($sort['filter']) AND strpos(strtolower($file_name), strtolower($sort['filter'])) === FALSE) continue;

            $date = mdate('%d %M %y', filemtime($file_path));

            $perms = substr(substr(sprintf('%o', fileperms($file_path)), -4), 0, 2);

            if (is_file($file_path) AND !in_array($file_name, $this->_hidden_files)) {
                $size = filesize($file_path);
                $file_ext = substr(strrchr($file_name, '.'), 1);
                $ext_name = $this->fixFileName($file_ext);
                $ext_lower = strtolower($ext_name);
                $file_type = (in_array($ext_lower, $this->_allowed_ext)) ? 'img' : 'file';
                $u_files[] = array('name' => $file_name, 'type' => $file_type, 'date' => $date, 'size' => $size, 'ext' => $file_ext, 'perms' => $perms);
            }
        }

        $u_files = $this->sortFiles($sort, $u_files);

        return $u_files;
    }

    public function getThumbnail($file_name, $sub_folder = '') {

        list($img_width, $img_height, $img_type, $attr) = getimagesize($this->_image_path . $this->_root_folder . $sub_folder . $file_name);

        $img_dimension = $img_width .' x '. $img_height;

        if ($img_width < $this->_thumb_width AND $img_height < $this->_thumb_height) {
            $thumb_url = image_url($this->_root_folder . $sub_folder . $file_name);
        } else {
            $this->CI->load->model('Image_tool_model');
            $thumb_url = $this->CI->Image_tool_model->resize($sub_folder . $file_name, $this->_thumb_width, $this->_thumb_height);
        }

        return array('dimension' => $img_dimension, 'url' => $thumb_url);
    }

    public function newFolder($name) {
        if ($this->_new_folder !== '1') return FALSE;

        $folder_path = $this->_image_path . $this->_root_folder . $name;
        $folder_thumb_path = $this->_image_path . $this->_thumbs_folder . $name;

        $this->createFolder($folder_path, $folder_thumb_path);
    }

    public function createFolder($file_path = FALSE, $thumb_path = FALSE) {
        $oldumask = umask(0);

        if ($file_path AND !file_exists($file_path)) {
            mkdir($file_path, DIR_WRITE_MODE, TRUE);
        }

        if ($thumb_path AND !file_exists($thumb_path)) {
            mkdir($thumb_path, DIR_WRITE_MODE, TRUE);
        }

        umask($oldumask);
    }

    public function copy($from_path, $to_path, $first_call = FALSE) {
        if ($this->_copy !== '1') return FALSE;

        if (!$first_call) {
            $from_path = $this->_image_path . $this->_root_folder . $from_path;
            $to_path = $this->_image_path . $this->_root_folder . $to_path;
        }

        if (file_exists($to_path)) {
            return FALSE;
        }

        if (is_file($from_path)) {
            return copy($from_path, $to_path);
        }

        if (is_dir($from_path)) {
            $this->createFolder($to_path, FALSE);

            foreach (scandir($from_path) as $item) {
                if ($item != '.' AND $item != '..') {
                    if ( ! is_dir($from_path .'/'. $item)) {
                        copy($from_path .'/'. $item, $to_path .'/'. $item);
                    } else {
                        $this->copy($from_path .'/'. $item, $to_path .'/'. $item, TRUE);
                    }
                }
            }
        }
    }

    public function move($file_path, $move_path) {
        if ($this->_move !== '1') return FALSE;

        $root_path = $this->_image_path . $this->_root_folder;

        if (file_exists($root_path . $file_path)) {
            $new_path = $root_path .'/'. $move_path;

            if (! file_exists($root_path. $new_path)) {
                return rename($root_path .$file_path, $new_path);
            }
        }

        return FALSE;
    }

    public function rename($file_path, $new_name) {
        if ($this->_rename !== '1') return FALSE;

        $root_path = $this->_image_path . $this->_root_folder;

        $new_name = $this->fixFileName($new_name);

        if (file_exists($root_path . $file_path)) {
            $info = pathinfo($root_path . $file_path);
            $new_path = $info['dirname'] .'/'. $new_name;

            if (isset($info['dirname']) AND ! file_exists($root_path. $new_path)) {
                return rename($root_path .$file_path, $new_path);
            }
        }

        return FALSE;
    }

    public function delete($path, $first_call = FALSE) {
        if ($this->_delete !== '1') return FALSE;

        if (!$first_call) {
            $path = $this->_image_path . $this->_root_folder . $path;
        }

        if (!file_exists($path)) {
            return FALSE;
        } else if (is_file($path)) {
            return unlink($path);
        }

        foreach (scandir($path) as $item) {
            if ($item != '.' AND $item != '..') {
                if ( ! is_dir($path .'/'. $item)) {
                    unlink($path .'/'. $item);
                } else {
                    $this->delete($path .'/'. $item, TRUE);
                }
            }
        }

        if (is_dir($path)) {
            return rmdir($path);
        }
    }

    public function upload($sub_folder) {
        if ($this->_uploads !== '1') return FALSE;

        $this->CI->load->library('upload');
        $this->CI->upload->set_upload_path($this->_image_path . $this->_root_folder . $sub_folder);
        $this->CI->upload->set_allowed_types($this->_allowed_ext);
        $this->CI->upload->set_max_filesize($this->_max_size);

        if ( ! $this->CI->upload->do_upload('file')) {
            log_message('debug', $this->CI->upload->display_errors('', ''));
            return FALSE;
        } else {
            $data = $this->CI->upload->data();
            if (!$data) {
                unlink($data['full_path']);
                return FALSE;
            } else {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function folderSize($path) {
        $total_size = 0;
        $files = scandir($path);
        $cleanPath = rtrim($path, '/'). '/';

        foreach($files as $file) {
            if ($file != "." AND $file != "..") {
                $currentFile = $cleanPath . $file;
                if (is_dir($currentFile)) {
                    $size = $this->folderSize($currentFile);
                    $total_size += $size;
                } else {
                    $size = filesize($currentFile);
                    $total_size += $size;
                }
            }
        }
        return $total_size;
    }

    public function fixFileName($str) {
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');

        if ($this->_transliteration) {
            $str = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str);
        }

        $str = str_replace(array('"', "'", "/", "\\"), "", $str);
        $str = strip_tags($str);

        if (strpos($str, '.') === 0) {
            $str = 'temp_name'. $str;
        }

        return $this->CI->security->sanitize_filename(trim($str));
    }

    public function fileExists($file_path) {
        return file_exists($this->_image_path . $this->_root_folder . $file_path);
    }

    public function isWritable($file_path) {
        return is_really_writable($this->_image_path . $this->_root_folder . $file_path);
    }

    public function _recursiveFolders($path, $first_call = TRUE) {
        $folder_paths = array();
        if ($first_call) {
            $folder_paths[] = '/';
        }

        foreach (glob($path .'*', GLOB_ONLYDIR) as $filepath) {
            if (is_dir($filepath) AND !in_array(basename($filepath), $this->_hidden_folders)) {
                $folder_paths[] = substr($filepath, strpos($filepath, $this->_root_folder) + strlen($this->_root_folder)) .'/';

                $child = glob($filepath . '/*', GLOB_ONLYDIR);
                if (!empty($child)) {
                    $children = $this->_recursiveFolders($filepath . '/', FALSE);
                    foreach ($children as $childname) {
                        $folder_paths[] = substr($childname, strrpos($childname, $this->_root_folder));
                    }
                }
            }
        }

        return $folder_paths;
    }

    public function _folderTree($directory, $return_link, $parent = '') {

        $folder_tree = '';
        $folder_tree .= ($parent === '') ? '<nav class="nav"><ul class="metisFolder" role="menu">' : '<ul>';

        $directory = ($parent === '') ? $this->_image_path . $this->_root_folder : $directory;

        if ($directory_map = glob($directory .'*', GLOB_ONLYDIR)) {
            foreach ($directory_map as $dirpath) {
                $dirname = basename($dirpath);
                $active = (in_array($dirname, $this->_sub_folder)) ? ' active' : '';

                if (is_dir($dirpath) AND ! in_array($dirname, $this->_hidden_folders)) {
                    $parent_dir = $parent . '/' . $dirname;

                    $link = str_replace('{link}', $parent . '/' . urlencode($dirname) . '/', $return_link);
                    $folder_tree .= '<li class="directory' . $active . '"><a href="' . $link . '"><i class="fa fa-folder-open"></i> ' . htmlspecialchars($dirname) . '</a>';
                    $folder_tree .= $this->_folderTree($directory . $dirname . '/', $return_link, $parent_dir);
                    $folder_tree .= '</li>';

                    if ( ! is_dir($this->_image_path . 'thumbs/' . $parent_dir)) {
                        $this->createFolder(FALSE, $this->_image_path . 'thumbs/' . $parent_dir);
                    }
                }
            }
        }

        $folder_tree .= '</ul>';
        if ($parent === '') {
            $folder_tree .= '</nav>';
        }

        return $folder_tree;
    }

    private function sortFiles($sort, $u_files) {
        if (isset($sort['by'])) {
            switch ($sort['by']) {
                case 'name':
                    usort($u_files, function ($x, $y) {
                        return $x['name'] > $y['name'];
                    });
                    break;
                case 'date':
                    usort($u_files, function ($x, $y) {
                        return $x['date'] > $y['date'];
                    });
                    break;
                case 'size':
                    usort($u_files, function ($x, $y) {
                        return $x['size'] - $y['size'];
                    });
                    break;
                case 'extension':
                    usort($u_files, function ($x, $y) {
                        return $x['ext'] > $y['ext'];
                    });
                    break;
            }

            if (isset($sort['order']) AND $sort['order'] === 'descending') {
                $u_files = array_reverse($u_files);

                return $u_files;
            }
        }


        return $u_files;
    }
}

// END Media_manager Class

/* End of file Media_manager.php */
/* Location: ./system/tastyigniter/libraries/Media_manager.php */