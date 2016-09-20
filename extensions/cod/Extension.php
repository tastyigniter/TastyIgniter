<?php namespace Cod;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'cod',
			'name'       => 'Cash On Delivery',
			'description' => 'This extension will allow you to accept Cash On Delivery payment method during checkout.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-money',
			'version'     => '1.1',
		);
	}

	public function registerPaymentGateway() {
		return array(
			'cod/components/Cod' => array(
				'code'        => 'cod',
				'name'       => 'lang:cod.text_component_title',
				'description' => 'lang:cod.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Payment.Cod',
			'action'      => array('manage'),
			'description' => 'Ability to manage cash on delivery payment',
		);
	}

	public function registerSettings() {
		return admin_extension_url('cod/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/cod/Extension.php */