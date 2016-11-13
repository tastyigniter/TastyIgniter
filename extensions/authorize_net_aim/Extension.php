<?php namespace Authorize_net_aim;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'authorize_net_aim',
			'name'       => 'Authorize.Net (AIM)',
			'description' => 'This extension allows customers to choose Authorize.Net (AIM) payment method during checkout.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-credit-card',
			'version'     => '1.1',
		);
	}

	public function registerPaymentGateway() {
		return array(
			'authorize_net_aim/components/Authorize_net_aim' => array(
				'code'        => 'authorize_net_aim',
				'name'       => 'lang:authorize_net_aim.text_component_title',
				'description' => 'lang:authorize_net_aim.text_component_desc',

			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Payment.AuthorizeNetAIM',
			'action'      => array('manage'),
			'description' => 'Ability to manage Authorize.Net payment extension',
		);
	}

	public function registerSettings() {
		return admin_extension_url('authorize_net_aim/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/authorize_net_aim/Extension.php */