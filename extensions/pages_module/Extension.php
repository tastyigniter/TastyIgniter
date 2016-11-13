<?php namespace Pages_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'pages_module',
			'name'       => 'Pages Links',
			'description' => 'Allows you to place pages links on any page.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-files-o',
			'version'     => '1.2',
		);
	}

	public function autoload() {
	}

	public function registerComponents() {
		return array(
			'pages_module/components/Pages_module' => array(
				'code'        => 'pages_module',
				'name'       => 'lang:pages_module.text_component_title',
				'description' => 'lang:pages_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.PagesModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage pages module',
		);
	}
}

/* End of file Extension.php */
/* Location: ./extensions/pages_module/Extension.php */