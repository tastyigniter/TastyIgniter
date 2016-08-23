<?php namespace Stripe;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'stripe',
			'name'       => 'Stripe (Requires SSL)',
			'description' => 'This extension will allow you to accept credit card payments using Stripe payment gateway during checkout.',
			'author'      => 'SamPoyigi',
			'icon'		  => 'fa-cc-stripe',
			'version'     => '1.1',
		);
	}

	public function registerPaymentGateway() {
		return array(
			'stripe/components/Stripe' => array(
				'code'        => 'stripe',
				'name'        => 'lang:stripe.text_component_title',
				'description' => 'lang:stripe.text_component_desc',
			)
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Payment.Stripe',
			'action'      => array('manage'),
			'description' => 'Ability to manage Stripe payment extension',
		);
	}

	public function registerSettings() {
		return admin_extension_url('stripe/settings');
	}
}

/* End of file Extension.php */
/* Location: ./extensions/stripe/Extension.php */