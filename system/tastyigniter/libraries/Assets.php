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
 * Alert Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Alert.php
 * @link           http://docs.tastyigniter.com
 */
class Assets
{
	protected $_title_separator = ' | ';
	protected $_head_tags = array();
	protected $_breadcrumbs = array();
	public $active_styles = '';

	protected $CI;

	/**
	 * Constructor - Sets Preferences
	 *
	 * The constructor can be passed an array of config values
	 * @param array $config
	 */
	public function __construct($config = array()) {
		$this->CI =& get_instance();
		$this->CI->load->helper('html');
		$this->CI->load->helper('string');

		log_message('info', 'Assets Class Initialized');
	}

	public function setHeadTags($head_tags = array()) {
		$head_tags['meta'][] = array('name' => 'description', 'content' => config_item('meta_description'));
		$head_tags['meta'][] = array('name' => 'keywords', 'content' => config_item('meta_keywords'));

		if (!empty($head_tags)) {
			foreach ($head_tags as $type => $value) {
				if ($type) {
					$this->setHeadTag($type, $value);
				}
			}
		}
	}

	public function getDocType() {
		return isset($this->_head_tags['doctype']) ? $this->_head_tags['doctype'] : '';
	}

	public function getFavIcon() {
		return isset($this->_head_tags['favicon']) ? $this->_head_tags['favicon'] : '';
	}

	public function getMetas() {
		return is_array($this->_head_tags['meta']) ? implode("\t\t", $this->_head_tags['meta']) : '';
	}

	public function getButtonList() {
		return is_array($this->_head_tags['buttons']) ? implode("\n\t\t", $this->_head_tags['buttons']) : '';
	}

	public function getIconList() {
		return is_array($this->_head_tags['icons']) ? implode("\n\t\t", $this->_head_tags['icons']) : '';
	}

	public function getStyleTags() {
		return is_array($this->_head_tags['style']) ? implode("\t\t", $this->_head_tags['style']) : '';
	}

	public function getScriptTags() {
		return is_array($this->_head_tags['script']) ? implode("\n\t\t", $this->_head_tags['script']) : '';
	}

	public function getBreadcrumb($tag_open = '<li class="{class}">', $link_open = '<a href="{link}">', $link_close = ' </a>', $tag_close = '</li>') {
		$crumbs = '';

		foreach ($this->_breadcrumbs as $crumb) {
			if (!empty($crumb['uri'])) {
				$crumbs .= str_replace('{class}', '', $tag_open) . str_replace('{link}', site_url(trim($crumb['uri'], '/')), $link_open) . $crumb['name'] . $link_close;
			} else {
				$crumbs .= str_replace('{class}', 'active', $tag_open) . '<span>'.$crumb['name'].' </span>';
			}

			$crumbs .= $tag_close;
		}

		return (!empty($crumbs)) ? '<ol class="breadcrumb">' .  $crumbs . '</ol>' : $crumbs;
	}

	public function setHeadTag($type = '', $tag = '') {
		if ($type) switch ($type) {
			case 'doctype':
				$this->setDocType($tag);
				break;
			case 'favicon':
				$this->setFavIcon($tag);
				break;
			case 'meta':
				$this->setMeta($tag);
				break;
			case 'style':
				$this->setStyleTag($tag);
				break;
			case 'script':
				$this->setScriptTag($tag);
				break;
			default :
				$this->_head_tags[$type] = $tag;
		}
	}

	public function setDocType($doctype = '') {
		$this->_head_tags['doctype'] = doctype($doctype). PHP_EOL;
	}

	public function setFavIcon($href = '') {
		if ($href != '' AND is_string($href)) {
			$this->_head_tags['favicon'] = link_tag($this->prepUrl($href), 'shortcut icon', 'image/ico');
		}
	}

	public function setMeta($metas = array()) {
		$metas = meta($metas);

		isset($this->_head_tags['meta']) OR $this->_head_tags['meta'] = array();

		array_unshift($this->_head_tags['meta'], $metas);
	}

	public function setStyleTag($href = '', $name = '', $priority = NULL, $suffix = '') {
		if ( ! is_array($href)) {
			$href = array($priority => array('href' => $href, 'name' => $name, 'rel' => 'stylesheet', 'type' => 'text/css'));
		} else if (isset($href[0]) AND is_string($href[0])) {
			$name = (isset($href[1])) ? $href[1] : '';
			$priority = (isset($href[2])) ? $href[2] : '';

			$href = array($priority => array('href' => $href[0], 'name' => $name, 'rel' => 'stylesheet', 'type' => 'text/css'));
		} else if (isset($href['href'])) {
			$priority = (isset($href['priority'])) ? $href['priority'] : '';
			unset($href['priority']);
			$href = array($priority => $href);
		}

		foreach ($href as $priority => $tag) {
			if (isset($tag['href'])) {
				!empty($suffix) OR $suffix = 'ver='.TI_VERSION;

				$tag['href'] = $this->prepUrl($tag['href'], $suffix);
				if (!empty($tag['name'])) {
					$tag['id'] = $tag['name'];
				}

				unset($tag['name']);
				$priority = (empty($priority)) ? random_string('numeric', 4) : $priority;
				$this->_head_tags['style'][$priority] = link_tag($tag);
				ksort($this->_head_tags['style']);
			} else {
				$this->setStyleTag($tag);
			}
		}
	}

	public function setScriptTag($href = '', $name = '', $priority = NULL, $suffix = '') {
		$charset = strtolower($this->CI->config->item('charset'));

		if ( ! is_array($href)) {
			$href = array($priority => array('src' => $href, 'name' => $name, 'charset' => $charset, 'type' => 'text/javascript'));
		} else if (isset($href[0]) AND is_string($href[0])) {
			$href[1] = (isset($href[1])) ? $href[1] : '';
			$priority = (isset($href[2])) ? $href[2] : '';

			$href = array($priority => array('src' => $href[0], 'name' => $href[1], 'charset' => $charset, 'type' => 'text/javascript'));
		} else if (isset($href['src'])) {
			$priority = (isset($href['priority'])) ? $href['priority'] : '';
			unset($href['priority']);
			$href = array($priority => $href);
		}

		foreach ($href as $priority => $tag) {
			if (isset($tag['src'])) {
				!empty($suffix) OR $suffix = 'ver='.TI_VERSION;

				$tag['src'] = $this->prepUrl($tag['src'], $suffix);

				if (!empty($tag['name'])) {
					$tag['id'] = $tag['name'];
				}
				unset($tag['name']);

				$script_tag = '';
				foreach ($tag as $k => $v) {
					$script_tag .= $k.'="'.$v.'" ';
				}

				$priority = (empty($priority)) ? random_string('numeric', 4) : $priority;
				$this->_head_tags['script'][$priority] = '<script ' . $script_tag . '></script>';
				ksort($this->_head_tags['script']);
			} else {
				$this->setScriptTag($tag);
			}
		}
	}

	public function setBreadcrumb($name, $uri = '') {
		$this->_breadcrumbs[] = array('name' => $name, 'uri' => $uri );
		return $this;
	}

	protected function prepUrl($href, $suffix = '') {
		if (!preg_match('#^(\w+:)?//#i', $href)) {
			list($href, $location) = $this->CI->template->find_path($href);
			$href = theme_url($href);
		}

		if (!empty($suffix)) {
			$suffix = (strpos($href, '?') === FALSE) ? '?'. $suffix : '&'. $suffix;
		}

		return $href . $suffix;
	}

	public function getActiveStyle() {
		// Compile the customizer styles
		$this->active_styles = $this->compileActiveStyle();

		return $this->active_styles . "\n\t\t";
	}

	public function getActiveThemeOptions($item = NULL) {
		if ($this->CI->config->item(strtolower(APPDIR), 'active_theme_options')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'active_theme_options');
		} else if ($this->CI->config->item(strtolower(APPDIR), 'customizer_active_style')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'customizer_active_style');
		}

		if (empty($active_theme_options) OR !isset($active_theme_options[0]) OR !isset($active_theme_options[1])) {
			return NULL;
		}

		if ($active_theme_options[0] !== $this->CI->template->getTheme()) {
			return NULL;
		}

		$theme_options = NULL;
		if (is_array($active_theme_options[1])) {
			$theme_options = $active_theme_options[1];
		}

		if ($item === NULL) {
			return $theme_options;
		} else if (isset($theme_options[$item])) {
			return $theme_options[$item];
		} else {
			return NULL;
		}
	}

	protected function compileActiveStyle($content = '') {
		if ($this->CI->config->item(strtolower(APPDIR), 'active_theme_options')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'active_theme_options');
		} else if ($this->CI->config->item(strtolower(APPDIR), 'customizer_active_style')) {
			$active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'customizer_active_style');
		}

		if (!empty($active_theme_options) AND isset($active_theme_options[0]) AND $active_theme_options[0] === $this->CI->template->getTheme()) {
			$data = (isset($active_theme_options[1]) AND is_array($active_theme_options[1])) ? $active_theme_options[1] : array();
			$content = $this->CI->template->load_view('stylesheet', $data);
		}

		return $content;
	}

}