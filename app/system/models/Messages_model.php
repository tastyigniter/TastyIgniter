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
 * Messages Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Messages_model.php
 * @link           http://docs.tastyigniter.com
 */
class Messages_model extends TI_Model {

    public function getCount($filter = array()) {
        if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
            $this->queryCustomerInboxMessages($filter);
        } else if (APPDIR === ADMINDIR) {

            if ($filter['filter_folder'] === 'inbox') {
                $this->queryInboxMessages($filter);
            } else if ($filter['filter_folder'] === 'draft') {
                $this->queryDraftMessages($filter);
            } else if ($filter['filter_folder'] === 'sent') {
                $this->querySentMessages($filter);
            } else if ($filter['filter_folder'] === 'archive') {
                $this->queryArchiveMessages($filter);
            } else if ($filter['filter_folder'] === 'all') {
                $this->queryAllMessages($filter);
            }

            if (!empty($filter['filter_search']) OR !empty($filter['filter_recipient'])
                OR !empty($filter['filter_type']) OR !empty($filter['filter_date'])
            ) {

                $this->db->group_start();
                if (!empty($filter['filter_search'])) {
                    $this->db->like('staff_name', $filter['filter_search']);
                    $this->db->or_like('subject', $filter['filter_search']);
                }

                if (!empty($filter['filter_recipient'])) {
                    $this->db->where('recipient', $filter['filter_recipient']);
                }

                if (!empty($filter['filter_type'])) {
                    $this->db->where('send_type', $filter['filter_type']);
                }

                if (!empty($filter['filter_date'])) {
                    $date = mdate('%Y-%m', strtotime($filter['filter_date']));
                    $this->db->like('messages.date_added', $date, 'after');
                }
                $this->db->group_end();
            }
        }

        $this->db->from('messages');

        return $this->db->count_all_results();
    }

    public function getList($filter = array()) {
        if (!empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if ($this->db->limit($filter['limit'], $filter['page'])) {
            $this->db->select('*, messages.date_added, messages.status AS message_status');
            $this->db->from('messages');

            if (!empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
                $this->queryCustomerInboxMessages($filter);
            } else if (APPDIR === ADMINDIR) {

                if ($filter['filter_folder'] === 'inbox') {
                    $this->queryInboxMessages($filter);
                } else if ($filter['filter_folder'] === 'draft') {
                    $this->queryDraftMessages($filter);
                } else if ($filter['filter_folder'] === 'sent') {
                    $this->querySentMessages($filter);
                } else if ($filter['filter_folder'] === 'archive') {
                    $this->queryArchiveMessages($filter);
                } else if ($filter['filter_folder'] === 'all') {
                    $this->queryAllMessages($filter);
                }

                if (!empty($filter['filter_search']) OR !empty($filter['filter_recipient'])
                    OR !empty($filter['filter_type']) OR !empty($filter['filter_date'])
                ) {

                    $this->db->group_start();
                    if (!empty($filter['filter_search'])) {
                        $this->db->like('staff_name', $filter['filter_search']);
                        $this->db->or_like('subject', $filter['filter_search']);
                    }

                    if (!empty($filter['filter_recipient'])) {
                        $this->db->where('recipient', $filter['filter_recipient']);
                    }

                    if (!empty($filter['filter_type'])) {
                        $this->db->where('send_type', $filter['filter_type']);
                    }

                    if (!empty($filter['filter_date'])) {
                        $date = mdate('%Y-%m', strtotime($filter['filter_date']));
                        $this->db->like('messages.date_added', $date, 'after');
                    }
                    $this->db->group_end();
                }
            }

            if (!empty($filter['sort_by']) AND !empty($filter['order_by'])) {
                $this->db->order_by($filter['sort_by'], $filter['order_by']);
            }

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
        }
    }

    protected function queryCustomerInboxMessages($filter = array()) {
        if (isset($filter['customer_id'])) {
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');
            $this->db->join('customers', 'customers.customer_id = message_meta.value AND message_meta.item = ' . $this->db->escape('customer_id'), 'left');

            $this->db->where('message_meta.status', '1');
            $this->db->where('message_meta.deleted', '0');
            $this->db->where('messages.send_type', 'account');
            $this->db->where('message_meta.item', 'customer_id');
            $this->db->where('message_meta.value', $filter['customer_id']);
        }
    }

    protected function queryInboxMessages($filter = array()) {
        if (isset($filter['filter_staff'])) {
            $this->db->select('message_meta.status AS recipient_status');

            $this->db->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

            $this->db->where('messages.status >=', '1');
            $this->db->where('message_meta.status', '1');
            $this->db->where('message_meta.deleted', '0');
            $this->db->where('messages.send_type', 'account');
            $this->db->where('message_meta.item', 'staff_id');
            $this->db->where('message_meta.value', $filter['filter_staff']);
        }
    }

    protected function queryDraftMessages($filter = array()) {
        if (isset($filter['filter_staff'])) {
            $this->db->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');

            $this->db->where('messages.status', '0');
            $this->db->where('messages.sender_id', $filter['filter_staff']);
        }
    }

    protected function querySentMessages($filter = array()) {
        if (isset($filter['filter_staff'])) {
            $this->db->select('message_meta.status AS recipient_status');
            $this->db->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id AND message_meta.item = ' . $this->db->escape('sender_id'), 'left');

            $this->db->where('messages.status', '1');
            $this->db->where('message_meta.status', '1');
            $this->db->where('message_meta.deleted', '0');
            $this->db->where('message_meta.item', 'sender_id');
            $this->db->where('message_meta.value', $filter['filter_staff']);
        }
    }

    protected function queryArchiveMessages($filter = array()) {
        if (isset($filter['filter_staff'])) {
            $this->db->select('message_meta.status AS recipient_status');
            $this->db->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

            $this->db->where('messages.status', '1');
            $this->db->where('message_meta.deleted', '1');
            $this->db->where('message_meta.value', $filter['filter_staff']);

            $this->db->group_start();
            $this->db->where('message_meta.item', 'staff_id');
            $this->db->or_where('message_meta.item', 'sender_id');
            $this->db->group_end();
        }
    }

    protected function queryAllMessages($filter = array()) {
        if (isset($filter['filter_staff'])) {
            $this->db->select('message_meta.status AS recipient_status');
            $this->db->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

            $this->db->where('messages.status', '1');
            $this->db->where('message_meta.value', $filter['filter_staff']);
            $this->db->where('message_meta.deleted !=', '2');

            $this->db->group_start();
            $this->db->where('message_meta.item', 'staff_id');
            $this->db->or_where('message_meta.item', 'sender_id');
            $this->db->group_end();
        }
    }

    public function getMessage($message_id) {
        if ($message_id) {
            $this->db->from('messages');
            $this->db->where('message_id', $message_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }
    }

    public function getDraftMessage($message_id) {
        if ($message_id) {
            $this->db->from('messages');
            $this->db->where('sender_id', $this->user->getStaffId());
            $this->db->where('message_id', $message_id);
            $this->db->where('status', '0');

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }
    }

    public function getRecipients($message_id) {
        if ($message_id) {
            $this->db->select('message_meta.*, staffs.staff_id, staffs.staff_name, staffs.staff_email, customers.customer_id, customers.first_name, customers.last_name, customers.email');
            $this->db->from('message_meta');
            $this->db->join('staffs', "staffs.staff_id = message_meta.value OR staffs.staff_email = message_meta.value", 'left');
            $this->db->join('customers', "customers.customer_id = message_meta.value OR customers.email = message_meta.value", 'left');
            $this->db->where('item !=', 'sender_id');
            $this->db->where('message_id', $message_id);

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
        }
    }

    public function getMessageDates() {
        $this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
        $this->db->from('messages');
        $this->db->group_by('MONTH(date_added)');
        $this->db->group_by('YEAR(date_added)');
        $query = $this->db->get();
        $result = array();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function viewMessage($message_id, $user_id = '') {
        if (is_numeric($message_id) AND is_numeric($user_id)) {
            $this->db->select('*, message_meta.status, messages.date_added, message_meta.status AS recipient_status, messages.status AS message_status');
            $this->db->from('messages');
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

            $this->db->group_by('messages.message_id');

            $this->db->where('messages.message_id', $message_id);

            if (APPDIR === ADMINDIR) {
                $this->db->join('staffs', 'staffs.staff_id = messages.sender_id', 'left');

                $this->db->group_start();
                $this->db->where('message_meta.item', 'sender_id');
                $this->db->or_where('message_meta.item', 'staff_id');
                $this->db->group_end();

                $this->db->where('message_meta.value', $user_id);
            } else {
                $this->db->join('customers', 'customers.customer_id = message_meta.value', 'left');

                $this->db->where('messages.status', '1');
                $this->db->where('message_meta.status', '1');
                $this->db->where('message_meta.deleted', '0');
                $this->db->where('messages.send_type', 'account');
                $this->db->where('message_meta.item', 'customer_id');
                $this->db->where('message_meta.value', $user_id);
            }

            $query = $this->db->get();

            return $query->row_array();
        }
    }

    public function getUnreadCount($user_id = '') {
        if (is_numeric($user_id) AND $this->db->table_exists('message_meta')) {
            $this->db->where('messages.status', '1');
            $this->db->where('message_meta.status', '1');
            $this->db->where('message_meta.deleted', '0');
            $this->db->where('message_meta.state', '0');
            $this->db->where('messages.send_type', 'account');
            $this->db->where('message_meta.value', $user_id);

            if (APPDIR === ADMINDIR) {
                $this->db->where('message_meta.item', 'staff_id');
            } else {
                $this->db->where('message_meta.item', 'customer_id');
            }

            $this->db->from('messages');
            $this->db->join('message_meta', 'message_meta.message_id = messages.message_id', 'left');

            $total = $this->db->count_all_results();

            if ($total < 1) {
                $total = '';
            }

            return $total;
        }
    }

    public function updateState($message_meta_id, $user_id, $state, $folder = '') {
        $query = FALSE;

        if (!is_array($message_meta_id)) $message_meta_id = array($message_meta_id);

        if (is_numeric($user_id)) {
            if ($state === 'unread') {
                $this->db->set('state', '0');
            } else if ($state === 'read') {
                $this->db->set('state', '1');
            } else if ($state === 'restore') {
                $this->db->set('status', '1');
                $this->db->set('deleted', '0');
            } else if ($state === 'archive') {
                $this->db->set('deleted', '1');
            } else if ($state === 'trash') {
                $this->db->set('deleted', '2');
            }

            $this->db->where('value', $user_id);
            $this->db->where_in('message_meta_id', $message_meta_id);

            if (APPDIR === ADMINDIR) {
                if ($folder === 'inbox') {
                    $this->db->where('item', 'staff_id');
                } else if ($folder === 'sent') {
                    $this->db->where('item', 'sender_id');
                } else {
                    $this->db->group_start();
                    $this->db->where('item', 'sender_id');
                    $this->db->or_where('item', 'staff_id');
                    $this->db->group_end();
                }
            } else {
                $this->db->where('item', 'customer_id');
            }

            $query = $this->db->update('message_meta');
        }

        return $query;
    }

    public function saveMessage($message_id, $save = array()) {
        if (empty($save)) return FALSE;

        if (isset($save['send_type'])) {
            $this->db->set('send_type', $save['send_type']);
        }

        if (isset($save['recipient'])) {
            $this->db->set('recipient', $save['recipient']);
        }

        if (isset($save['subject'])) {
            $this->db->set('subject', $save['subject']);
        }

        if (isset($save['body'])) {
            $this->db->set('body', $save['body']);
        }

        if (isset($save['save_as_draft']) AND $save['save_as_draft'] === '1') {
            $this->db->set('status', '0');
        } else {
            $this->db->set('status', '1');
        }

        $this->db->set('sender_id', $this->user->getStaffId());
        $this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', time()));

        if (is_numeric($message_id)) {
            $this->db->where('message_id', $message_id);
            $query = $this->db->update('messages');
        } else {
            $query = $this->db->insert('messages');
            $message_id = $this->db->insert_id();
        }

        if ($query === TRUE AND is_numeric($message_id) AND empty($save['save_as_draft'])
            AND !empty($save['recipient']) AND !empty($save['send_type'])
        ) {
            $this->sendMessage($message_id, $save);
        }

        return $message_id;
    }

    private function sendMessage($message_id, $send = array()) {
        $results = array();

        $column = ($send['send_type'] === 'email') ? 'email' : 'id';

        if (empty($send['save_as_draft']) OR $send['save_as_draft'] !== '1') {
            $this->load->model('Customers_model');

            switch ($send['recipient']) {
                case 'all_newsletters':
                    $results = $this->Customers_model->getCustomersByNewsletterForMessages($column);
                    break;
                case 'all_customers':
                    $results = $this->Customers_model->getCustomersForMessages($column);
                    break;
                case 'customer_group':
                    $results = $this->Customers_model->getCustomersByGroupIdForMessages($column,
                        $send['customer_group_id']);
                    break;
                case 'customers':
                    if (isset($send['customers'])) {
                        $results = $this->Customers_model->getCustomerForMessages($column, $send['customers']);
                    }

                    break;
                case 'all_staffs':
                    $results = $this->Staffs_model->getStaffsForMessages($column);
                    break;
                case 'staff_group':
                    $results = $this->Staffs_model->getStaffsByGroupIdForMessages($column, $send['staff_group_id']);
                    break;
                case 'staffs':
                    if (isset($send['staffs'])) {
                        $results = $this->Staffs_model->getStaffForMessages($column, $send['staffs']);
                    }

                    break;
            }

            $results['sender_id'] = $this->user->getStaffId();

            if (!empty($results) AND $this->addRecipients($message_id, $send, $results)) {
                return TRUE;
            }
        }
    }

    public function addRecipients($message_id, $send, $recipients) {
        $this->db->where('message_id', $message_id);
        $this->db->delete('message_meta');

        $suffix = ($send['send_type'] === 'email') ? 'email' : 'id';

        if ($recipients) {
            foreach ($recipients as $key => $recipient) {
                if (!empty($recipient)) {
                    $status = (is_numeric($recipient)) ? '1' : $this->_sendMail($message_id, $recipient);

                    $this->db->set('value', $recipient);
                    $this->db->set('message_id', $message_id);
                    $this->db->set('status', $status);

                    if ($key === 'sender_id') {
                        $this->db->set('item', 'sender_id');
                    } else if (in_array($send['recipient'], array('all_staffs', 'staff_group', 'staffs'))) {
                        $this->db->set('item', 'staff_' . $suffix);
                    } else {
                        $this->db->set('item', 'customer_' . $suffix);
                    }

                    if (!($query = $this->db->insert('message_meta'))) {
                        return FALSE;
                    }
                }
            }

            return $query;
        }
    }

    public function deleteMessage($message_id, $user_id = '') {
        if (is_numeric($message_id)) $message_id = array($message_id);

        if (!empty($message_id) AND ctype_digit(implode('', $message_id))) {
            // Delete draft messages
            $this->db->where_in('message_id', $message_id);
            $this->db->where('sender_id', $user_id);
            $this->db->where('status', '0');
            $this->db->delete('messages');
            $affected_rows = $this->db->affected_rows();

            return $affected_rows;
        }
    }

    public function _sendMail($message_id, $email) {
        if (!empty($message_id) AND !empty($email)) {
            $this->load->library('email');

            $mail_data = $this->getMessage($message_id);
            if (isset($mail_data['subject'], $mail_data['body'])) {
                $this->email->initialize();

                $this->email->from($this->config->item('site_email'), $this->config->item('site_name'));

                $this->email->to(strtolower($email));
                $this->email->subject($mail_data['subject']);
                $this->email->message($mail_data['body']);

                if (!$this->email->send()) {
                    log_message('debug', $this->email->print_debugger(array('headers')));
                    $notify = '0';
                } else {
                    $notify = '1';
                }

                return $notify;
            }
        }
    }
}

/* End of file messages_model.php */
/* Location: ./system/tastyigniter/models/messages_model.php */