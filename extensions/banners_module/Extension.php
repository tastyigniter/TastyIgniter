<?php namespace Banners_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'banners_module',
			'name'       => 'Banners',
			'author'      => 'SamPoyigi',
			'description' => 'Easy way to display the different size of banner advertisements on any page.',
			'icon'        => 'fa-plug',
			'version'     => '1.1',
		);
	}

	public function registerComponents() {
		return array(
			'banners_module/components/Banners_module' => array(
				'code'        => 'banners_module',
				'name'       => 'lang:banners_module.text_component_title',
				'description' => 'lang:banners_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.BannersModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage banners module',
		);
	}

//	public function registerSettings() {
//		return admin_extension_url('banners_module/settings');
//	}
}

/* End of file Extension.php */
/* Location: ./extensions/banners_module/Extension.php */