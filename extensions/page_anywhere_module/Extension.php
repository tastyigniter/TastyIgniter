<?php namespace Page_anywhere_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'page_anywhere_module',
			'name'        => 'Page anywhere',
			'description' => 'Allows you to place a page in any partial',
			'author'      => 'GeneralCss',
			'icon'        => 'fa-file-text-o',
			'version'     => '0.1.0',
		);
	}

	public function autoload() {
	}

	public function registerComponents() {
		return array(
			'page_anywhere_module/components/Page_anywhere_module' => array(
				'code'        => 'page_anywhere_module',
				'name'       => 'lang:page_anywhere_module.text_component_title',
				'description' => 'lang:page_anywhere_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.PageAnywhereModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage page-anywhere module',
		);
	}

	public function registerSettings() {
		return admin_extension_url('page_anywhere_module/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/page_anywhere_module/Extension.php */