<?php namespace Paypal_express;

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'paypal_express',
			'name'       => 'PayPal Express',
			'description' => 'This extension will allow you to accept PayPal Express payment method during checkout.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-paypal',
			'version'     => '1.1',
		);
	}

	public function autoload() {
	}

	public function registerPaymentGateway() {
		return array(
			'paypal_express/components/Paypal_express' => array(
				'code'        => 'paypal_express',
				'name'       => 'lang:paypal_express.text_component_title',
				'description' => 'lang:paypal_express.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Payment.PaypalExpress',
			'action'      => array('manage'),
			'description' => 'Ability to manage paypal express payment',
		);
	}

	public function registerSettings() {
		return admin_extension_url('paypal_express/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/paypal_express/Extension.php */