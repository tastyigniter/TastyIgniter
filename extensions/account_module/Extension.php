<?php namespace Account_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'account_module',
			'name'        => 'Account',
			'description' => 'This extension will allows you to place account links on any page.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-plug',
			'version'     => '1.1',
		);
	}

	public function registerComponents() {
		return array(
			'account_module/components/Account_module' => array(
				'code'        => 'account_module',
				'name'       => 'lang:account_module.text_component_title',
				'description' => 'lang:account_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.AccountModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage account module',
		);
	}
}

/* End of file Extension.php */
/* Location: ./extensions/account_module/Extension.php */