<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Reviews_model extends CI_Model {

    public function getCount($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->db->like('author', $filter['filter_search']);
			$this->db->or_like('location_name', $filter['filter_search']);
			$this->db->or_like('order_id', $filter['filter_search']);
		}

		if (!empty($filter['filter_location'])) {
			$this->db->where('reviews.location_id', $filter['filter_location']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->db->where('review_status', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->db->where('YEAR(date_added)', $date[0]);
			$this->db->where('MONTH(date_added)', $date[1]);
		}

		$this->db->from('reviews');
		$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');
		return $this->db->count_all_results();
    }

	public function getList($filter = array()) {
		if (!empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

        if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('reviews');
			$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

			if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			if (!empty($filter['filter_location'])) {
				$this->db->where('reviews.location_id', $filter['filter_location']);
			}

			if (!empty($filter['filter_search'])) {
				$this->db->like('author', $filter['filter_search']);
				$this->db->or_like('location_name', $filter['filter_search']);
				$this->db->or_like('order_id', $filter['filter_search']);
			}

			if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
				$this->db->where('review_status', $filter['filter_status']);
			}

			if (!empty($filter['filter_date'])) {
				$date = explode('-', $filter['filter_date']);
				$this->db->where('YEAR(date_added)', $date[0]);
				$this->db->where('MONTH(date_added)', $date[1]);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getReview($review_id) {
		$this->db->from('reviews');
		$this->db->join('locations', 'locations.location_id = reviews.location_id', 'left');

		$this->db->where('review_id', $review_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getReviewDates() {
		$this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->db->from('reviews');
		$this->db->group_by('MONTH(date_added)');
		$this->db->group_by('YEAR(date_added)');
		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function updateReview($update = array()) {
		$query = FALSE;

		if (!empty($update['sale_type'])) {
			$this->db->set('sale_type', $update['sale_type']);
		}

		if (!empty($update['sale_id'])) {
			$this->db->set('sale_id', $update['sale_id']);
		}

		if (!empty($update['location_id'])) {
			$this->db->set('location_id', $update['location_id']);
		}

		if (!empty($update['customer_id'])) {
			$this->db->set('customer_id', $update['customer_id']);
		}

		if (!empty($update['author'])) {
			$this->db->set('author', $update['author']);
		}

		if (!empty($update['rating'])) {
			if (isset($update['rating']['quality'])) {
				$this->db->set('quality', $update['rating']['quality']);
			}

			if (isset($update['rating']['delivery'])) {
				$this->db->set('delivery', $update['rating']['delivery']);
			}

			if (isset($update['rating']['service'])) {
				$this->db->set('service', $update['rating']['service']);
			}
		}

		if (!empty($update['review_text'])) {
			$this->db->set('review_text', $update['review_text']);
		}

		if ($update['review_status'] === '1') {
			$this->db->set('review_status', '1');
		} else {
			$this->db->set('review_status', '0');
		}

		if (!empty($update['review_id'])) {
			$this->db->where('review_id', $update['review_id']);
			$query = $this->db->update('reviews');

			if ($update['review_status'] === '1') {
				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'approved', 'object' => 'review', 'object_id' => $update['review_id'], 'actor_id' => $this->user->getStaffId(), 'subject_id' => $update['customer_id']));
			} else {
				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'updated', 'object' => 'review', 'object_id' => $update['review_id'], 'actor_id' => $this->user->getStaffId()));
			}
		}

		return $query;
	}

	public function addReview($add = array()) {
		$query = FALSE;

		if (!empty($add['location_id'])) {
			$this->db->set('location_id', $add['location_id']);
		}

		if (!empty($add['sale_type'])) {
			$this->db->set('sale_type', $add['sale_type']);
		}

		if (!empty($add['sale_id'])) {
			$this->db->set('sale_id', $add['sale_id']);
		}

		if (!empty($add['customer_id'])) {
			$this->db->set('customer_id', $add['customer_id']);
		}

		if (!empty($add['author'])) {
			$this->db->set('author', $add['author']);
		}

		if (!empty($add['rating'])) {
			if (isset($add['rating']['quality'])) {
				$this->db->set('quality', $add['rating']['quality']);
			}

			if (isset($add['rating']['delivery'])) {
				$this->db->set('delivery', $add['rating']['delivery']);
			}

			if (isset($add['rating']['service'])) {
				$this->db->set('service', $add['rating']['service']);
			}
		}

		if (!empty($add['review_text'])) {
			$this->db->set('review_text', $add['review_text']);
		}

		if ($add['review_status'] === '1') {
			$this->db->set('review_status', '1');
		} else {
			$this->db->set('review_status', '0');
		}

		if (!empty($add)) {
			$this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));
			if ($this->db->insert('reviews')) {
				$query = $this->db->insert_id();

				$this->load->model('Notifications_model');
				$this->Notifications_model->addNotification(array('action' => 'added', 'object' => 'review', 'object_id' => $query, 'actor_id' => $this->user->getStaffId()));
			}
		}

		return $query;
	}

	public function deleteReview($review_id) {
		if (is_numeric($review_id)) {
			$this->db->where('review_id', $review_id);
			$this->db->delete('reviews');

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}
}

/* End of file reviews_model.php */
/* Location: ./admin/models/reviews_model.php */