<?php namespace Categories_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'categories_module',
			'name'       => 'Categories',
			'description' => 'This extension will allow you to place a list of categories around your website.',
			'author'      => 'SamPoyigi',
			'icon'		  => 'fa-cubes',
			'version'     => '1.2',
		);
	}

	public function registerComponents() {
		return array(
			'categories_module/components/Categories_module' => array(
				'code'        => 'categories_module',
				'name'        => 'lang:categories_module.text_component_title',
				'description' => 'lang:categories_module.text_component_desc',
			)
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.CategoriesModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage categories module',
		);
	}
}

/* End of file Extension.php */
/* Location: ./extensions/categories_module/Extension.php */