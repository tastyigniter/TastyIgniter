<?php namespace Slideshow;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'slideshow',
			'name'       => 'Slideshow',
			'description' => 'Add a responsive image slider to your homepage or any page',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-film',
			'version'     => '1.2',
		);
	}

	public function registerComponents() {
		return array(
			'slideshow/components/Slideshow' => array(
				'code'        => 'slideshow',
				'name'       => 'lang:slideshow.text_component_title',
				'description' => 'lang:slideshow.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.Slideshow',
			'action'      => array('manage'),
			'description' => 'Ability to manage homepage slide show module',
		);
	}

	public function registerSettings() {
		return admin_extension_url('slideshow/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/slideshow/Extension.php */