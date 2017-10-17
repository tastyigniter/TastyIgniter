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
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Updates Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Updates_model.php
 * @link           http://docs.tastyigniter.com
 */
class Updates_model extends TI_Model {

	protected $updated_files = array('modified' => array(), 'added' => array());

	protected $endpoint = 'https://api.tastyigniter.com/v1';

	public function lastVersionCheck() {
		$version = $this->config->item('last_version_check');

		if (isset($version['last_version_check'])) {
			return (strtotime('-7 day') < strtotime($version['last_version_check']));
		}

		return TRUE;
	}

	public function getUpdates($refresh) {
		$result = array();

		$extensions = array(); //@TO-DO: use $this->Extensions_model->getList(); instead
		$versions = $this->getVersions($extensions, $refresh);

		foreach ($versions as $key => $version) {
			if ($key == 'core' AND !empty($version->stable_tag)) {
				if (version_compare(TI_VERSION, $version->stable_tag) !== 0) {
					$result['core']['version_name'] = $version->version;
					$result['core']['stable_tag'] = $version->stable_tag;
				}
			} else if (is_array($version)) {
				foreach ($version as $name => $stable_tag) {
					if ( ! isset($extensions[$name])) continue;

					$extension = $extensions[$name];
					if (version_compare($extension['version'], $stable_tag) !== 0) {
						$result[$extension['type']][$extension['name']] = array(
							'name'       => $extension['name'],
							'stable_tag' => $stable_tag,
						);
					}
				}
			}
		}

		$result['last_version_check'] = $versions['last_version_check'];

		return $result;
	}

	public function getVersions($extensions = array(), $refresh = FALSE) {
		$version = $this->config->item('last_version_check');

		if (!$refresh AND isset($version['last_version_check']) AND strtotime('-7 day') < strtotime($version['last_version_check'])) {
			return $version;
		}

		$result = array();

		$result['last_version_check'] = mdate('%d-%m-%Y %H:%i:%s', time());

		$info = $this->installer->getSysInfo();

		// Check core stable version first
		$url = $this->endpoint . '/core/version/'. $info['version'] .'/'. $info['php_version'] .'/'. $info['mysql_version'];

		$result['core'] = $this->getRemoteVersion($url);

		// Then extensions, themes and translations
		if ( ! empty($extensions)) {
			foreach ($extensions as $extension) {
				if (in_array($extension['type'], array('module', 'payment'))) {
					$url = $this->endpoint . '/extension/version/' . $extension['name'] . '/' .$extension['version'] .'/'. $info['version'];
				} else {
					$url = $this->endpoint . '/theme/version/'. $extension['name'] .'/'. $extension['version'] .'/'. $info['version'];
				}

				$result[$extension['type']][$extension['name']] = $this->getRemoteVersion($url);
			}
		}

		$this->load->model('Settings_model');
		$this->Settings_model->addSetting('prefs', 'last_version_check', $result, '1');

		return $result;
	}

	public function getRemoteVersion($url) {
		$remote_data = $this->getRemoteData($url);

		if (is_string($remote_data)) {
			return json_decode($remote_data);
		}

		return NULL;
	}

	public function getRemoteData($url, $options = array(), $params = array()) {
		$options['USERAGENT'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:43.0) Gecko/20100101 Firefox/43.0';
		$options['AUTOREFERER'] = TRUE;
		$options['FAILONERROR'] = TRUE;
		$options['FOLLOWLOCATION'] = 1;

		if (empty($options['TIMEOUT'])) {
			$options['TIMEOUT'] = 30;
		}

		if (!empty($params)) {
			$options['POSTFIELDS'] = $params;
		}

		return get_remote_data($url, $options);
	}

	public function update($update_type, $update_name = '', $update_version = '') {

		if ($update_type === 'core') {
			$update_version = $this->input->get('version');
			$filename = 'TastyIgniter-' . $update_version;

			flush_output(sprintf($this->lang->line('progress_update'), 'TastyIgniter'));
			flush_output($this->lang->line('progress_download_update'));
		} else {
			$extension = $this->Extensions_model->getExtension($update_name);

			$filename = 'TastyIgniter-' . $update_type . '-' . $update_name;

			flush_output($this->lang->line('progress_update'), $extension['title']);
			flush_output($this->lang->line('progress_download_update'));
		}

		$update_path = 'assets/downloads/temp-' . time();
		$update_file = ROOTPATH . $update_path . '/' . $filename . '.zip';

		// Download Update
		$remote_data = $this->downloadUpdate($update_type, $update_name);

		if ($remote_data) {
			if ( ! is_dir(ROOTPATH . $update_path)) {
				$oldumask = umask(0);
				mkdir(ROOTPATH . $update_path, DIR_WRITE_MODE, TRUE);
				umask($oldumask);
			}

			// Move downloaded zip to downloads folder
			if (is_int(file_put_contents($update_file, $remote_data))) {

				// Extracting Downloaded Zip
				flush_output($this->lang->line('progress_extract_update'));

				$this->load->helper('file');
				if ( ! ($filename = unzip_file($update_file))) {
					flush_output($this->lang->line('progress_extract_failed'));
				} else {
					flush_output($this->lang->line('progress_install_update'));

					// Install Update
					if ($update_type === 'core') {
						$message = $this->installCoreUpdate($update_version, $update_path .'/'. $filename);

						if ($message !== TRUE) {
							flush_output($message);
							flush_output($this->lang->line('progress_install_failed'));
						} else {
							$this->flushUpdatedFiles();
						}
					}
				}
			}

			if (file_exists($update_file)) unlink($update_file);

			// Delete the temp update path
			delete_files(ROOTPATH . $update_path, TRUE);
			rmdir(ROOTPATH . $update_path);

		} else {
			flush_output($this->lang->line('progress_download_failed'));
		}
	}

	public function downloadUpdate($update_type, $update = '') {
		$info = $this->installer->getSysInfo();

		// Check core version first
		if ($update_type == 'core') {
			$url = $this->endpoint . '/core/update/'.$info['version'].'/'. $info['php_version'] .'/'. $info['mysql_version'];
		} else {
			// Then extensions, themes and languages
			$update = explode('|', $update);
			if (count($update) === 2 AND $extension = $this->Extensions_model->getExtension($update[0])) {
				$url = $this->endpoint . '/' . $update_type . '/update/' . $update[0] . '/' . $update[1];
			} else {
				$url = $this->endpoint . '/' . $update_type . '/update/';
			}
		}

		$options['TIMEOUT'] = 60;
		return $this->getRemoteData($url, $options);
	}

	public function installCoreUpdate($update_version, $update_file) {
		$temp_path = ROOTPATH . $update_file;

		if ( ! is_dir($temp_path)) {
			return $this->lang->line('progress_archive_not_found');
		} else {
			$remove_files = array(
				'/tests',
				'/system/tastyigniter/logs',
				'/system/tastyigniter/session',
				'/system/tastyigniter/config/database.php',
			);

			// Remove the themes, languages, extensions, logs and sessions folder
			if ($this->removeTempFiles($remove_files, $temp_path)) {
				// Copy all files/folders from temp path
			    $updated_files = $this->copyTempFiles($temp_path, ROOTPATH);

				if ( ! empty($updated_files)) {
					$msg = 'Installed On: ' . date('r') . PHP_EOL;
					$msg .= 'Installed Version: ' . $update_version . PHP_EOL;
					$msg .= 'Uninstalled Version: ' . TI_VERSION . PHP_EOL;
					if ( ! write_file(IGNITEPATH .'config/updated.txt', $msg)) {
						return FALSE;
					}
				}
			}
		}

		return TRUE;
	}

	protected function removeTempFiles($files = array(), $from_folder = '') {

		if (empty($files)) return FALSE;

		if ( ! is_dir($from_folder)) return FALSE;

		foreach ($files as $file) {
			if (is_dir($from_folder . $file)) {
				delete_files($from_folder . $file, TRUE);
				rmdir($from_folder . $file);
			} else if (file_exists($from_folder . $file)) {
				unlink($from_folder . $file);
			}
		}

		return TRUE;
	}

	protected function copyTempFiles($source, $destination) {
		//Remove trailing slash
		$source = rtrim($source, '/');
		$destination = rtrim($destination, '/');
		$parent_path = str_replace(rtrim(ROOTPATH, '/'), '', $destination);

		// Creating the destination directory
		if ( ! is_dir($destination)) {
			$oldumask = umask(0);
			mkdir($destination, DIR_WRITE_MODE, TRUE);
			umask($oldumask);
		}

		//Mapping the directory
		$this->load->helper('directory');
		$source_dir_map = directory_map($source, 0, TRUE);

		foreach ($source_dir_map as $key => $value) {
			if (is_numeric($key) AND ! is_dir($source . '/' . $value)) {

				if (file_exists($destination . '/' . $value)) {
					if ($this->isFilesIdentical($source . '/' . $value, $destination . '/' . $value) === FALSE) {
						$this->updated_files['modified'][] = trim($parent_path .'/'. $value, '/');
					} else {
						$this->updated_files['unchanged'][] = trim($parent_path .'/'. $value, '/');
						continue;
					}
				} else {
					$this->updated_files['added'][] = trim($parent_path .'/'. $value, '/');
				}

				if ( ! @copy($source . '/' . $value, $destination . '/' . $value)) { //This is a file so copy
					$this->updated_files['failed'][] = $parent_path .'/'. $value;
				}
			} else {
				$this->copyTempFiles($source . '/' . $key, $destination . '/' . $key); //this is a directory
			}
		}

		return $this->updated_files;
	}

	protected function isFilesIdentical($file_one, $file_two) {
		// Check if filesize is different
		if (@filesize($file_one) !== @filesize($file_two)) {
			return FALSE;
		}

		// Check if content is different
		$open_file_one = @fopen($file_one, 'rb');
		$open_file_two = @fopen($file_two, 'rb');

		$result = TRUE;
		while( ! @feof($open_file_one)) {
			if (@fread($open_file_one, 8192) != @fread($open_file_two, 8192)) {
				$result = FALSE;
				break;
			}
		}

		@fclose($open_file_one);
		@fclose($open_file_two);

		return $result;
	}

	public function flushUpdatedFiles() {
		asort($this->updated_files);

		$html = "<p>{$this->lang->line('progress_modified_files')}</p><div id=\"updatedFiles\" style=\"width:70%;display: none;\">";

		if (!empty($this->updated_files['failed'])) {
			$html .= sprintf($this->lang->line('text_files_failed'), count($this->updated_files['failed'])) .'<br />';
			$html .= '<textarea class="form-control" readonly>' . implode(PHP_EOL, $this->updated_files['failed']) . '</textarea><br />';
		}

		if (!empty($this->updated_files['added'])) {
			$html .= sprintf($this->lang->line('text_files_added'), count($this->updated_files['added'])) .'<br />';
			$html .= '<textarea class="form-control" readonly>' . implode(PHP_EOL, $this->updated_files['added']) . '</textarea><br>';
		}
		if (!empty($this->updated_files['modified'])) {
			$html .= sprintf($this->lang->line('text_files_modified'), count($this->updated_files['modified'])) .'<br />';
			$html .= '<textarea class="form-control" readonly>' . implode(PHP_EOL, $this->updated_files['modified']) . '</textarea><br>';
		}
		if (!empty($this->updated_files['unchanged'])) {
			$html .= sprintf($this->lang->line('text_files_unchanged'), count($this->updated_files['unchanged'])) .'<br />';
			$html .= '<textarea class="form-control" readonly>' . implode(PHP_EOL, $this->updated_files['unchanged']) . '</textarea><br>';
		}
		$html .= '</div><script type="text/javascript">jQuery(\'#toggleUpdatedFiles\').on(\'click\', function () { jQuery(\'#updatedFiles\').slideToggle(); });</script>';
		$html .= '<p>'.sprintf($this->lang->line('progress_update_success'), 'TastyIgniter').'</p>';
		flush_output($html, FALSE);
	}
}

/* End of file Updates_model.php */
/* Location: ./system/tastyigniter/models/Updates_model.php */