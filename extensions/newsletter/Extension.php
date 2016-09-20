<?php namespace Newsletter;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'newsletter',
			'name'       => 'Newsletter',
			'description' => 'This extension will allow you to place a newsletter subscribe module around your website.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-newspaper-o',
			'version'     => '1.2',
		);
	}

	public function registerComponents() {
		return array(
			'newsletter/components/Newsletter' => array(
				'code'        => 'newsletter',
				'name'       => 'lang:newsletter.text_component_title',
				'description' => 'lang:newsletter.text_component_desc',
			),
		);
	}
}

/* End of file Extension.php */
/* Location: ./extensions/newsletter/Extension.php */