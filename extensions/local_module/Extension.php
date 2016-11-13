<?php namespace Local_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'local_module',
			'name'       => 'Local',
			'description' => 'This extension allows your customers to find the nearest location',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-map-marker',
			'version'     => '1.2',
		);
	}

	public function registerComponents() {
		return array(
			'local_module/components/Local_module' => array(
				'code'        => 'local_module',
				'name'       => 'lang:local_module.text_component_title',
				'description' => 'lang:local_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.LocalModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage local module',
		);
	}

	public function registerSettings() {
		return admin_extension_url('local_module/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/local_module/Extension.php */