<?php namespace Reservation_module;

if (!defined('BASEPATH')) exit('No direct access allowed');

class Extension extends \Base_Extension
{

	public function extensionMeta() {
		return array(
			'code'        => 'reservation_module',
			'name'       => 'Reservation',
			'description' => 'Accept restaurant reservations and table bookings online. Confirm or reject your reservations.',
			'author'      => 'SamPoyigi',
			'icon'        => 'fa-calendar',
			'version'     => '1.2',
		);
	}

	public function registerComponents() {
		return array(
			'reservation_module/components/Reservation_module' => array(
				'code'        => 'reservation_module',
				'name'       => 'lang:reservation_module.text_component_title',
				'description' => 'lang:reservation_module.text_component_desc',
			),
		);
	}

	public function registerPermissions() {
		return array(
			'name'        => 'Module.ReservationModule',
			'action'      => array('manage'),
			'description' => 'Ability to manage reservation module',
		);
	}
}

/* End of file Extension.php */
/* Location: ./extensions/reservation_module/Extension.php */