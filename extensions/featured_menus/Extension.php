<?php namespace Featured_menus;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'featured_menus',
			'name'       => 'Featured Menu Items',
			'description' => 'This extension will allow you to attach a featured menu component to any page or layout.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-cutlery',
			'version'     => '1.2',
		);
	}

	public function autoload() {
	}

	public function registerComponents() {
		return array(
			'featured_menus/components/Featured_menus' => array(
				'code'        => 'featured_menus',
				'name'       => 'lang:featured_menus.text_component_title',
				'description' => 'lang:featured_menus.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.FeaturedMenus',
			'action'      => array('manage'),
			'description' => 'Ability to manage featured menu module',
		);
	}

	public function registerSettings() {
		return admin_extension_url('featured_menus/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/featured_menus/Extension.php */