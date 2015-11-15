<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Template {

    private $_module = '';
    private $_controller = '';
    private $_method = '';
    private $_theme = NULL;
    private $_theme_path = NULL;
    private $_theme_shortpath = NULL;
    private $_theme_locations = array();
    private $_partial_areas = array();
    private $_layouts = array();
    private $_modules = array();
    private $_title_separator = ' | ';
    private $_data = array();
    private $_head_tags = array();
    private $_active_styles = '';
    private $_breadcrumbs = array();
    private $_theme_config = array();

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

        // Set default theme
        if ($default_theme = $this->CI->config->item(APPDIR, 'default_themes')) {
            $this->setTheme($default_theme);
        }

        // Load the theme config and store array in $this->_theme_config
        $this->_theme_config = load_theme_config($this->_theme, APPDIR);

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

        if (!empty($this->_theme_config['head_tags'])) {
            $this->setHeadTags($this->_theme_config['head_tags']);
        }

        // Output template variables to the template
        $template['title'] 	        = $this->_head_tags['title'];
        $template['breadcrumbs'] 	= $this->_breadcrumbs;              //*** future reference
        $template['partials']	    = array();

        // Assign by reference, as all loaded views will need access to partials
        $this->_data['template'] =& $template;
        $this->_data['controller'] = $this->_controller;

        $this->setPartials();

        // Set the modules for this layout using the current URI segments
        if (!empty($this->_partial_areas)) {
            $this->_modules = $this->getLayoutModules();

            // Load the partials variables
            $template['partials'] = $this->fetchPartials();
        }

        // Load the layouts variables
        foreach ($this->_layouts as $name) {
            $template['partials'][$name] = $this->_find_view($name, array());
        }

        // Lets do the caching instead of the browser
        if ($this->CI->config->item('cache_mode') === '1') {
//			$this->CI->output->cache($this->CI->config->item('cache_time'));
		}

        // Want it returned or output to browser?
		if ( ! $return) {
            $this->CI->load->view('themes/'.$this->_theme.'/'.$view, $this->_data, FALSE);
        } else {
            return self::_load_view('themes/'.$this->_theme.'/'.$view, $this->_data, NULL);
        }
    }

    public function buildNavMenu($prefs = array()) {
        if ( ! is_array($this->_theme_config['nav_menu'])) {
            return NULL;
        }
        
        $nav_menu = $this->_theme_config['nav_menu'];
        
        $default = array(
            'container_open' => '<ul class="nav" id="side-menu">',
            'container_close' => '</ul>',
        );

        foreach ($default as $key => &$value) {
            if (isset($prefs[$key])) $value = $prefs[$key];
        }

        $out = '';
        foreach ($nav_menu as $menu) {
            if (isset($menu['permission'])) {
                $permission = (strpos($menu['permission'], '|') !== FALSE) ? explode('|', $menu['permission']) : array($menu['permission']);

	            $permitted = array();
	            foreach ($permission as $perm) {
		            $permitted[strtolower($perm)] = ( ! $this->CI->user->hasPermission($perm.'.Access')) ? FALSE : TRUE;
	            }

                if (!($permitted = array_filter($permitted))) continue;
            }

            $out .= '<li>'.$this->buildNavMenuLink($menu);

            if (isset($menu['child']) AND is_array($menu['child'])) {
                $out .= '<ul class="nav nav-second-level">';

                foreach ($menu['child'] as $child) {
                    if (isset($child['permission']) AND empty($permitted[strtolower($child['permission'])])) continue;
                    $out .= '<li>'.$this->buildNavMenuLink($child).'</li>';
                }

                $out .= '</ul>';
            }

            $out .= '</li>';
        }

        return $default['container_open'] . $out . $default['container_close'];
    }

    public function buildNavMenuLink($menu = array()) {
        $out = '<a';

        if (isset($menu['class'])) {
            $out .= ' class="'.$menu['class'].'"';
        }

        if (isset($menu['href'])) {
            $out .= ' href="'.$menu['href'].'"';
        }

        $out .= '>';
        if (isset($menu['icon'])) {
            $out .= '<i class="fa '.$menu['icon'].' fa-fw"></i>';
        } else {
            $out .= '<i class="fa fa-square-o fa-fw"></i>';
        }

        if (isset($menu['icon']) AND isset($menu['title'])) {
            $out .= '<span class="content">'.$menu['title'].'</span>';
        } else {
            $out .= $menu['title'];
        }

        if (isset($menu['child'])) {
            $out .= '<span class="fa arrow"></span>';
        }

        $out .= '</a>';

        return $out;
    }

    public function setTheme($theme = '') {
		$this->_theme = trim($theme, '/');

        if ($theme_location = $this->getThemeLocation($this->_theme)) {
            $this->_theme_path = rtrim($theme_location . $this->_theme);
            $this->_theme_shortpath = APPDIR . '/views/themes/' . $this->_theme;
        } else {
            show_error('Unable to locate the active theme: '.APPDIR . '/views/themes/' . $this->_theme);
        }
	}

    public function setPartials() {
        $partial_areas = isset($this->_theme_config['partial_area']) ? $this->_theme_config['partial_area'] : $this->_partial_areas;

        foreach ($partial_areas as $partial_area) {
            $id = isset($partial_area['id']) ? $partial_area['id'] : $partial_area;
            $this->_partial_areas[$id] = $partial_area;
        }

        $this->_layouts = array('header', 'footer');

        return $this;
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

    public function getPartials($partial = '') {
        $partials = !empty($this->_data['template']['partials']) ? $this->_data['template']['partials'] : array();
        return ($partial !== '' AND !empty($partials[$partial])) ? $partials[$partial] : '';
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
        $heading = '';
        if (isset($this->_head_tags['heading'])) {
            if (count($heading_array = explode(':', $this->_head_tags['heading'])) === 2) {
                $heading = $heading_array[0] . '&nbsp;&nbsp;<small>' . $heading_array[1] . '</small>';
            } else {
                $heading = $this->_head_tags['heading'];
            }
        }

        return $heading;
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

    public function getActiveStyle() {
        // Compile the customizer styles
        $this->_active_styles = $this->_compileActiveStyle();

        return $this->_active_styles . "\n\t\t";
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

		if ($active_theme_options[0] !== $this->_theme) {
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

    public function getLayoutModules() {
        $this->CI->load->model('Layouts_model');

        $layout_modules = $this->_getLayoutModules();

        $modules = $this->CI->extension->getModules();

        $_modules = array();
        foreach ($layout_modules[1] as $layout_module) {
            if (isset($layout_module['module_code']) AND !empty($modules[$layout_module['module_code']])) {

                $module = $modules[$layout_module['module_code']];

                // layouts array key not needed anymore @DEPRECATED.
                unset($module['ext_data']['layouts']);

                if ($module['name'] === $layout_module['module_code'] AND $layout_module['status'] === '1') {
                    // position key @DEPRECATED starting from v1.4.0
                    $partial = !empty($layout_module['position']) ? $layout_module['position'] : $layout_module['partial'];
                    $partial = in_array($partial, array('top', 'left', 'right', 'bottom')) ? 'content_'.$partial : $partial;

                    // in_array test to append content_ to @DEPRECATED position key
                    $_modules[$partial][] = array(
                        'name'			=> $module['name'],
                        'title'			=> $module['title'],
                        'layout_id'		=> $layout_module['layout_id'],
                        'partial'		=> $partial,
                        'priority'		=> $layout_module['priority'],
                        'data'		    => $module['ext_data'],
                    );
                }

            }
        }

        return $_modules;
    }

    public function loadView($view, $data = array()) {
        if (is_string($view)) {
            return $this->_find_view($view, (array) $data);
        }
    }

    private function fetchPartials() {
        if (empty($this->_partial_areas)) return NULL;

        $partials = array();
        foreach ($this->_partial_areas as $partial_name => $partial) {
            if (is_string($partial_name)) {
                $partial_class = isset($partial['class']) ? $partial['class'] : '';

                // We stop here if no module was found.
                if (empty($this->_modules[$partial_name])) continue;

                $partial_data = isset($partial['open_tag']) ? str_replace('{id}', str_replace('_', '-', $partial_name), str_replace('{class}', $partial_class, $partial['open_tag'])) : '';

                $this->sortModules($partial_name);
                foreach ($this->_modules[$partial_name] as $module) {
                    $partial_data .= Modules::run($module['name'] .'/index', $this->_data + $module['data']);
                }

                $partial_data .= isset($partial['close_tag']) ? $partial['close_tag'] : '';
                $partials[$partial_name] = $partial_data;
            }
        }

        return $partials;
    }

    private function _getLayoutModules() {
        $segments = array_merge(
            array($this->CI->uri->uri_string()),
            array('clear'),
            $this->CI->uri->segment_array(),
            array('clear'),
            $this->CI->uri->rsegment_array()
        );

        if (!$this->CI->uri->segment(2) AND in_array('index', $this->CI->uri->rsegment_array())) {
            array_push($segments, 'clear', $this->CI->uri->rsegment(1) .'/'. $this->CI->uri->rsegment(1));
        }

        if (APPDIR === ADMINDIR OR empty($segments)) return array(NULL, array());

        $this->CI->load->model('Layouts_model');

        $uri_route = '';
        foreach ($segments as $segment) {
            if ($segment === 'clear') $uri_route = '';

            if ($segment === 'index' OR $segment === 'clear') continue;

            $uri_route = ($uri_route === '') ? $segment : $uri_route.'/'.$segment;

            if ($segment === 'pages') {
                $uri_route = (int)$this->CI->input->get('page_id');
            }

            $layout_modules = $this->CI->Layouts_model->getRouteLayoutModules($uri_route);

            // Lets break the look if a layout was found.
            if (!empty($layout_modules)) return array($uri_route, $layout_modules);
        }
        // We return null if no layout was found.
        return array(NULL, array());
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
	    if ($this->CI->config->item(strtolower(APPDIR), 'active_theme_options')) {
		    $active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'active_theme_options');
	    } else if ($this->CI->config->item(strtolower(APPDIR), 'customizer_active_style')) {
		    $active_theme_options = $this->CI->config->item(strtolower(APPDIR), 'customizer_active_style');
	    }

	    if (!empty($active_theme_options) AND isset($active_theme_options[0]) AND $active_theme_options[0] === $this->_theme) {
		    $data = (isset($active_theme_options[1]) AND is_array($active_theme_options[1])) ? $active_theme_options[1] : array();
		    $content = $this->_find_view('stylesheet', $data);
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

    private function sortModules($partial_name) {
        if (!empty($partial_name)) {
            foreach ($this->_modules[$partial_name] as $key => $module) {
                $modules[$key] = $module['priority'];
            }

            array_multisort($modules, SORT_ASC, $this->_modules[$partial_name]);
        }
    }
}

// END Template Class

/* End of file Template.php */
/* Location: ./system/tastyigniter/libraries/Template.php */