<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Template {

    private $_module = '';
    private $_controller = '';
    private $_method = '';
    private $_theme = NULL;
    private $_theme_path = NULL;
    private $_theme_shortpath = NULL;
    private $_theme_locations = array();
    private $_partials = array();
    private $_modules = array();
    private $_title_separator = ' | ';
    private $_data = array();
    private $_head_tags = array();
    private $_active_styles = '';
    private $_breadcrumbs = array();
    private $_breadcrumb_divider = '';
    private $_breadcrumb_tag_open = '';
    private $_breadcrumb_tag_close = '';
    private $_breadcrumb_link_open = '';
    private $_breadcrumb_link_close = '';

    private $CI;

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

		if ( ! empty($config)) {
			$this->initialize($config);
		}

		log_message('info', 'Template Class Initialized');
	}

	public function initialize($config = array()) {
		// initialize config
		foreach ($config as $key => $val) {
			$this->{'_'.$key} = $val;
		}

		unset($config);

		// No locations set in config?
		if ($this->_theme_locations === array()) {
			// Let's use this obvious default
			$this->_theme_locations = array(THEMEPATH);
		}

		// Modular Separation / Modular Extensions has been detected
		if (method_exists( $this->CI->router, 'fetch_module' )) {
			$this->_module 	= $this->CI->router->fetch_module();
		}

		// What controllers or methods are in use
		$this->_controller	= $this->CI->router->fetch_class();
		$this->_method 		= $this->CI->router->fetch_method();

		// Load user agent library if not loaded
		$this->CI->load->library('user_agent');
	}

    public function render($view, $data = array(), $return = FALSE) {
		// Set whatever values are given. These will be available to all view files
		is_array($data) OR $data = (array) $data;

		// Merge in what we already have with the specific data
		$this->_data = array_merge($this->_data, $data);

		// We don't need you any more buddy
		unset($data);

        $this->CI->load->model('Themes_model');
        $theme_config = $this->CI->Themes_model->getConfig($this->_theme_shortpath);

         if (!empty($theme_config['head_tags'])) {
            $this->setHeadTags($theme_config['head_tags']);
        }

        // Output template variables to the template
		$template['title'] 	        = $this->_head_tags['title'];
		$template['breadcrumbs'] 	= $this->_breadcrumbs; //*** future reference
        $template['partials']	    = array();

        // Set the modules for this layout using the current URI segments
        $this->_modules = $this->_getLayoutModules();

		foreach ($this->_partials as $name => $partial) {
			$template['partials'][$name] = $this->_loadPartial($partial);
		}

        // Assign by reference, as all loaded views will need access to partials
        $this->_data['template'] =& $template;

        if ($this->CI->config->item('cache_mode') == '1') {
			$this->CI->output->cache($this->CI->config->item('cache_time'));
		}

 		// Want it returned or output to browser?
		if ( ! $return) {
            $this->CI->load->view('themes/'.$this->_theme.'/'.$view, $this->_data, FALSE);
        } else {
            return self::_load_view('themes/'.$this->_theme.'/'.$view, $this->_data, NULL);
        }
    }

    public function setPartials($partials = array()) {
        foreach ($partials as $name => $data) {
            if (is_string($data)) {
                $name = $data;
                $data = array();
            }

            $this->_partials[$name] = array('view' => $name, 'data' => $data);
        }

        return $this;
    }

    public function getPartials($partial = '') {
        $partials = !empty($this->_data['template']['partials']) ? $this->_data['template']['partials'] : array();
        return ($partial !== '' AND !empty($partials[$partial])) ? $partials[$partial] : '';
    }

    public function setTheme($theme = '') {
		$this->_theme = trim($theme, '/');

        if ($theme_location = $this->getThemeLocation($this->_theme)) {
            $this->_theme_path = rtrim($theme_location . $this->_theme);
            $this->_theme_shortpath = APPDIR . '/views/themes/' . $this->_theme;
        }
	}

    private function setHeadTags($head_tags = array()) {
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

    public function getTitle() {
        return isset($this->_head_tags['title']) ? $this->_head_tags['title'] : '';
    }

    public function getHeading() {
        return isset($this->_head_tags['heading']) ? $this->_head_tags['heading'] : '';
    }

    public function getBackButton() {
        return isset($this->_head_tags['back_button']) ? $this->_head_tags['back_button'] : '';
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

    public function getBreadcrumb() {
		$out = $this->_breadcrumb_tag_open;

		foreach ($this->_breadcrumbs as $crumb) {
            $out .= str_replace('{link}', site_url(trim($crumb['uri'], '/')), $this->_breadcrumb_link_open);
			$out .= $crumb['name'];
			$out .= $this->_breadcrumb_link_close;
		}

		$out .= $this->_breadcrumb_tag_close;

		return $out;
	}

    public function getActiveStyle() {
        // Compile the customizer styles
        $this->_active_styles = $this->_compileActiveStyle();

        return $this->_active_styles . "\n\t\t";
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
        array_unshift($this->_head_tags['meta'], $metas);
	}

    public function setTitle() {
        if (func_num_args() >= 1) {
            $this->_head_tags['title'] = implode($this->_title_separator, func_get_args());
        }
    }

    public function setHeading($heading = '') {
        $this->_head_tags['heading'] = $heading;
    }

    public function setBackButton($class, $href) {
        $this->_head_tags['back_button'] = '<a class="'.$class.'" href="'. $this->prepUrl($href) .'"><b class="fa fa-caret-left"></b></a>';
    }

    public function setButton($name, $attributes = array()) {
        $attr = '';
        foreach ($attributes as $key => $value) {
            $attr .= ' '. $key .'="'. $value .'"';
        }

        $this->_head_tags['buttons'][] = '<a'.$attr.'>'.$name.'</a>';
    }

    public function setIcon($icon) {
        $this->_head_tags['icons'][] = $icon;
    }

    public function setStyleTag($href = '', $name = '', $priority = NULL) {
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
                $tag['href'] = $this->prepUrl($tag['href']);
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

    public function setScriptTag($href = '', $name = '', $priority = NULL) {
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
                $tag['src'] = $this->prepUrl($tag['src']);

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

    public function getThemeLocation($theme = NULL) {
        $theme OR $theme = $this->_theme;

        foreach ($this->_theme_locations as $location) {
            if (is_dir($location . $theme)) {
                return $location;
            }
        }

        return FALSE;
    }

    private function _loadPartial($partial = array()) {
		$partial_contents = array('content_top', 'content_bottom', 'content_right', 'content_left');
		if (isset($partial['view'])) {
            // We can only work with data arrays
            is_array($partial['data']) OR $partial['data'] = (array) $partial['data'];

            if (in_array($partial['view'], $partial_contents)) {
                $position = explode('_', $partial['view']);
                $partial['data']['module_position'] = $position = isset($position[1]) ? $position[1] : '';

                // We stop here if no module was found.
                if (empty($this->_modules[$position])) return NULL;

                foreach ($this->_modules[$position] as $module) {
                    $partial['data'][$position.'_modules'][] = Modules::run($module['name'] .'/'. $module['name'] .'/index', $this->_data + $module['data']);
                }
            }

            return $this->_find_view($partial['view'], $partial['data']);
		}
	}

    private function _getLayoutModules() {
        $this->CI->load->model('Layouts_model');
        $this->CI->load->model('Extensions_model');

        $layout_id = $this->_getLayout();

        $layout_modules = $this->CI->Layouts_model->getLayoutModules($layout_id);
        $modules = $this->CI->Extensions_model->getModules();

        $_modules = array();
        foreach ($layout_modules as $layout_module) {
            if (isset($layout_module['module_code']) AND !empty($modules[$layout_module['module_code']])) {
                $module = $modules[$layout_module['module_code']];

                // layouts key not needed anymore.
                unset($module['ext_data']['layouts']);

                if ($module['name'] === $layout_module['module_code'] AND $layout_module['status'] === '1') {
                    $_modules[$layout_module['position']][] = array(
                        'name'			=> $module['name'],
                        'title'			=> $module['title'],
                        'layout_id'		=> $layout_module['layout_id'],
                        'position'		=> $layout_module['position'],
                        'priority'		=> $layout_module['priority'],
                        'data'		    => $module['ext_data'],
                    );
                }

            }
        }

        return $_modules;
    }

    private function _find_view($view, array $data) {
        if ( ! empty($this->_theme)) {
            $view_path = NULL;
            foreach ($this->_theme_locations as $location) {
                $theme_views = array(
                    $this->_theme . '/layouts/' . $view,
                    $this->_theme . '/partials/' . $view,
                    $this->_theme . '/modules/' . $this->_module . '/' . $view,
                    $this->_theme . '/' . $view
                );
                foreach ($theme_views as $theme_view) {
                    if (file_exists($location . $theme_view . '.php')) {
                        return self::_load_view($theme_view, $this->_data + $data, $location);
                    }
                }

            }
        }

        if ( empty($this->_theme)) {
            show_error('Unable to load the requested theme file: '. $view);
        }

        // Not found it yet? Just load, its either in the module or root view
        return self::_load_view($view, $this->_data + $data);
    }

    private function _load_view($view, array $data, $override_view_path = NULL) {
        if ($override_view_path !== NULL) {
            $this->CI->load->vars($data);

            // Load it directly, bypassing $this->load->view() as ME resets _ci_view
            $content = $this->CI->load->file($override_view_path . $view . '.php', TRUE);

        } else {// Can just run as usual
            // Grab the content of the view
            $content = $this->CI->load->view($view, $data, TRUE);
        }

        return $content;
    }

    private function _compileActiveStyle($content = '') {
        $active_styles = (strtolower(APPDIR) === MAINDIR) ? $this->CI->config->item(MAINDIR, 'customizer_active_style') : $this->CI->config->item(ADMINDIR, 'customizer_active_style');
        if (!empty($active_styles) and is_array($active_styles)) {
            if (isset($active_styles[0]) AND $active_styles[0] === $this->_theme) {
                $data = (isset($active_styles[1]) AND is_array($active_styles[1])) ? $active_styles[1] : array();
                $content = $this->_find_view('stylesheet', $data);
            }
        }

        return $content;
	}

    private function prepUrl($href) {
        if (!preg_match('#^(\w+:)?//#i', $href)) {
            $href = root_url($this->_theme_shortpath . '/' . $href);
        }

        return $href;
    }

    public function __get($name) {
        return isset($this->_data[$name]) ? $this->_data[$name] : NULL;
    }

    private function _getLayout() {
        $segments = array_merge($this->CI->uri->segment_array(), array('end'), $this->CI->uri->rsegment_array());

        if (APPDIR === ADMINDIR OR empty($segments) OR !is_array($segments)) return;

        $uri_route = $layout_id = '';
        foreach ($segments as $segment) {
            if ($segment === 'end') $uri_route = '';

            if ($segment === 'index' OR $segment === 'end') continue;

            $uri_route = ($uri_route === '') ? $segment : $uri_route.'/'.$segment;

            if ($segment === 'pages') {
                $layout_id = $this->CI->Layouts_model->getPageLayoutId((int)$this->CI->input->get('page_id'));
            } else if ($uri_route !== '') {
                $layout_id = $this->CI->Layouts_model->getRouteLayoutId($uri_route);
            }

            // Lets break the look if a layout was found.
            if (!empty($layout_id)) return $layout_id;
        }

        // We return null if no layout was found.
        return NULL;
    }
}

// END Template Class

/* End of file Template.php */
/* Location: ./system/tastyigniter/libraries/Template.php */