<?php namespace Cart_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'cart_module',
			'name'       => 'Cart',
			'description' => 'Easily add a shopping cart to your site. The most powerful way to sell your menu items.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-shopping-cart',
			'version'     => '2.0',
		);
	}

	public function registerComponents() {
		return array(
			'cart_module/components/Cart_module' => array(
				'code'        => 'cart_module',
				'name'       => 'lang:cart_module.text_component_title',
				'description' => 'lang:cart_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.CartModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage cart module',
		);
	}

	public function registerSettings() {
		return admin_extension_url('cart_module/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/cart_module/Extension.php */