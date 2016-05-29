<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Addresses Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Addresses_model.php
 * @link           http://docs.tastyigniter.com
 */
class Addresses_model extends TI_Model {

	public function getCount($filter = array()) {
		if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			$this->db->where('customer_id', $filter['customer_id']);

			$this->db->from('addresses');

			return $this->db->count_all_results();
		}
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
			if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
				$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
			}

			if ($this->db->limit($filter['limit'], $filter['page'])) {
				$this->db->from('addresses');
				$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

				$this->db->where('customer_id', $filter['customer_id']);

				$query = $this->db->get();

				$address_data = array();

				if ($query->num_rows() > 0) {
					foreach ($query->result_array() as $result) {

						$address_data[$result['address_id']] = array(
							'address_id' => $result['address_id'],
							'address_1'  => $result['address_1'],
							'address_2'  => $result['address_2'],
							'city'       => $result['city'],
							'state'      => $result['state'],
							'postcode'   => $result['postcode'],
							'country_id' => $result['country_id'],
							'country'    => $result['country_name'],
							'iso_code_2' => $result['iso_code_2'],
							'iso_code_3' => $result['iso_code_3'],
							'format'     => $result['format'],
						);
					}
				}

				return $address_data;
			}
		}
	}

	public function getAddresses($customer_id) {
		$address_data = array();

		if (!empty($customer_id) AND is_numeric($customer_id)) {
			$this->db->from('addresses');
			$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $result) {

					$address_data[$result['address_id']] = array(
						'address_id' => $result['address_id'],
						'address_1'  => $result['address_1'],
						'address_2'  => $result['address_2'],
						'city'       => $result['city'],
						'state'      => $result['state'],
						'postcode'   => $result['postcode'],
						'country_id' => $result['country_id'],
						'country'    => $result['country_name'],
						'iso_code_2' => $result['iso_code_2'],
						'iso_code_3' => $result['iso_code_3'],
						'format'     => $result['format'],
					);
				}
			}
		}

		return $address_data;
	}

	public function getAddress($customer_id, $address_id) {
		if (!empty($address_id) AND is_numeric($address_id)) {
			$this->db->from('addresses');
			$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

			$this->db->where('address_id', $address_id);

			if (!empty($customer_id) AND is_numeric($customer_id)) {
				$this->db->where('customer_id', $customer_id);
			}

			$query = $this->db->get();

			$address_data = array();

			if ($query->num_rows() > 0) {
				$row = $query->row_array();

				$address_data = array(
					'address_id' => $row['address_id'],
					'address_1'  => $row['address_1'],
					'address_2'  => $row['address_2'],
					'city'       => $row['city'],
					'state'      => $row['state'],
					'postcode'   => $row['postcode'],
					'country_id' => $row['country_id'],
					'country'    => $row['country_name'],
					'iso_code_2' => $row['iso_code_2'],
					'iso_code_3' => $row['iso_code_3'],
					'format'     => $row['format'],
				);
			}

			return $address_data;
		}
	}

	public function getGuestAddress($address_id) {
		$this->db->from('addresses');
		$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

		$this->db->where('address_id', $address_id);

		$query = $this->db->get();

		$address_data = array();

		if ($query->num_rows() > 0) {
			$row = $query->row_array();

			$address_data = array(
				'address_id' => $row['address_id'],
				'address_1'  => $row['address_1'],
				'address_2'  => $row['address_2'],
				'city'       => $row['city'],
				'state'      => $row['state'],
				'postcode'   => $row['postcode'],
				'country_id' => $row['country_id'],
				'country'    => $row['country_name'],
				'iso_code_2' => $row['iso_code_2'],
				'iso_code_3' => $row['iso_code_3'],
				'format'     => $row['format'],
			);
		}

		return $address_data;
	}

	public function getDefault($address_id, $customer_id) {
		if (($address_id !== '0') && ($customer_id !== '0')) {
			$this->db->from('addresses');
			$this->db->join('countries', 'countries.country_id = addresses.country_id', 'left');

			$this->db->where('address_id', $address_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				return $query->row_array();
			}
		}
	}

	public function updateDefault($customer_id = '', $address_id = '') {
		$query = FALSE;

		if ($address_id !== '' AND $customer_id !== '') {
			$this->db->set('address_id', $address_id);
			$this->db->where('customer_id', $customer_id);

			$query = $this->db->update('customers');
		}

		return $query;
	}

	public function saveAddress($customer_id = FALSE, $address_id = FALSE, $address = array()) {

		if (is_array($address_id)) $address = $address_id;

		if (empty($address)) return FALSE;

		if ($customer_id) {
			$this->db->set('customer_id', $customer_id);
		}

		if (empty($address_id) AND isset($address['address_id'])) {
			$this->db->set('address_id', $address['address_id']);
		}

		if (isset($address['address_1'])) {
			$this->db->set('address_1', $address['address_1']);
		}

		if (isset($address['address_2'])) {
			$this->db->set('address_2', $address['address_2']);
		}

		if (isset($address['city'])) {
			$this->db->set('city', $address['city']);
		}

		if (isset($address['state'])) {
			$this->db->set('state', $address['state']);
		}

		if (isset($address['postcode'])) {
			$this->db->set('postcode', $address['postcode']);
		}

		if (isset($address['country'])) {
			$this->db->set('country_id', $address['country']);
		} else if (isset($address['country_id'])) {
			$this->db->set('country_id', $address['country_id']);
		}

		if (is_numeric($address_id)) {
			$this->db->where('address_id', $address_id);
			$query = $this->db->update('addresses');
		} else {
			$query = $this->db->insert('addresses');
			$address_id = $this->db->insert_id();
		}

		return ($query === TRUE AND is_numeric($address_id)) ? $address_id : FALSE;
	}

	public function deleteAddress($customer_id, $address_id) {

		$this->db->where('customer_id', $customer_id);
		$this->db->where('address_id', $address_id);

		$this->db->delete('addresses');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
}

/* End of file addresses_model.php */
/* Location: ./system/tastyigniter/models/addresses_model.php */