<?php namespace System\Models;

use Igniter\Flame\NestedSet\NestedTree;
use Illuminate\Database\Eloquent\SoftDeletes;
use Model;

/**
 * Messages Model Class
 * @package System
 */
class Messages_model extends Model
{
    use SoftDeletes;
    use NestedTree;

    const DELETED_AT = 'date_deleted';

    const CREATED_AT = 'date_added';

    /**
     * @var string The database table name
     */
    protected $table = 'messages';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'message_id';

    public $timestamps = TRUE;

    protected $fillable = ['date_added', 'send_type', 'parent_id', 'subject', 'body', 'status'];

    public $relation = [
        'belongsTo' => [
            'layout' => ['System\Models\Mail_templates_model'],
        ],
        'hasMany'   => [
            'recipients'      => ['System\Models\Message_meta_model'],
            'customers'       => ['Admin\Models\Customers_model'],
            'customer_groups' => ['Admin\Models\Customer_groups_model'],
            'staffs'          => ['Admin\Models\Staffs_model'],
            'staff_groups'    => ['Admin\Models\Staff_groups_model'],
        ],
        'morphTo'   => [
            'sender' => [],
        ],
    ];

    public $purgeable = [
        'customers',
        'customer_groups',
        'staffs',
        'staff_groups',
    ];

    public static function countUnread($messagable)
    {
        if (!$messagable instanceof Model)
            return null;

        return Message_meta_model::where('messageable_id', $messagable->getKey())
                                 ->where('messageable_type', get_class($messagable))->isUnread()->count();
    }

    public function getRecipientOptions()
    {
        $receivers = collect($this->listReceivers());

        return $receivers->transform(function ($receiver) {
            return $receiver['label'];
        });
    }

    //
    // Accessors & Mutators
    //

    public function getSummaryAttribute($value)
    {
        return str_limit(strip_tags($this->body), 120);
    }

    public function getRecipientAttribute($value)
    {
        if (!isset($this->attributes['recipient']))
            return $value;

        $replace = ['all_customers' => 'customers', 'all_staffs' => 'staffs'];
        if (array_key_exists($this->attributes['recipient'], $replace))
            return $replace[$this->attributes['recipient']];

        return $this->attributes['recipient'];
    }

    public function getReceiverAttribute($value)
    {
        $receivers = $this->listReceivers();

        $replace = ['all_customers' => 'customers', 'all_staffs' => 'staffs'];
        $recipient = array_key_exists($this->recipient, $replace) ? $replace[$this->recipient] : $this->recipient;

        return isset($receivers[$recipient]) ? (object)$receivers[$recipient] : null;
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, $options = [])
    {
        extract(array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => null,
        ], $options));

        $query->isAccountSendType()->listMessages($options);

        return $query->paginate($pageLimit);
    }

    public function scopeSelectRecipientStatus($query)
    {
        return $query->selectRaw('*, '.DB::prefix('message_meta').'.status AS recipient_status');
    }

    public function scopeFilterState($query, $state)
    {
        return $query->whereHas('recipients', function ($q) use ($state) {
            $q->where('state', $state);
        });
    }

    public function scopeListMessages($query, $options = [])
    {
        extract(array_merge([
            'context'   => 'inbox',
            'recipient' => null,
        ], $options));

        if (!is_null($recipient)) {

            if ($context == 'inbox') {
                $query->whereNull('parent_id')->whereHas('recipients', function ($q) use ($recipient) {
                    $q->where('messageable_id', $recipient->getKey())
                      ->where('messageable_type', get_class($recipient));
                });
            }
            else if ($context == 'draft') {
                $query->where('status', 0)->orWhereNull('status')
                      ->where('sender_id', $recipient->getKey())
                      ->where('sender_type', get_class($recipient));
            }
            else if ($context == 'sent') {
                $query->whereNull('parent_id')->where('status', 1)
                      ->where('sender_id', $recipient->getKey())
                      ->where('sender_type', get_class($recipient));
            }
            else if ($context == 'archive') {
                $query->whereNull('parent_id')->where('sender_id', $recipient->getKey())
                      ->where('sender_type', get_class($recipient))->onlyTrashed();
            }
        }

        return $query;
    }

    public function scopeViewConversation($query, $options = [])
    {
        extract(array_merge([
            'recipient' => null,
        ], $options));

        $query->whereNull('parent_id')->where('status', 1);

        if (!is_null($recipient)) {

            $query->whereHas('recipients', function ($q) use ($recipient) {
                $q->where('messageable_id', $recipient->getKey())
                  ->where('messageable_type', get_class($recipient));
            });

            $query->orWhere(function ($q) use ($recipient) {
                $q->where('sender_id', $recipient->getKey())
                  ->where('sender_type', get_class($recipient));
            });
        }

        return $query;
    }

    public function scopeIsAccountSendType($query)
    {
        return $query->where('send_type', 'account');
    }

    //
    // Helpers
    //

    public function readState($messagable)
    {
        if (!$messagable instanceof Model OR !$this->recipients)
            return null;

        $meta = $this->recipients->where('messageable_id', $messagable->getKey())
                                 ->where('messageable_type', get_class($messagable))->first();
        if (!count($meta))
            return null;

        return $meta->state == 1 ? 'read' : 'unread';
    }

    public static function listFolders()
    {
        return [
            'inbox'   => [
                'title' => 'lang:system::messages.text_inbox',
                'icon'  => 'fa-inbox',
                'url'   => 'messages',
            ],
            'draft'   => [
                'title' => 'lang:system::messages.text_draft',
                'icon'  => 'fa-file-text-o',
                'url'   => 'messages/draft',
            ],
            'sent'    => [
                'title' => 'lang:system::messages.text_sent',
                'icon'  => 'fa-paper-plane-o',
                'url'   => 'messages/sent',
            ],
            'all'     => [
                'title' => 'lang:system::messages.text_all',
                'icon'  => 'fa-briefcase',
                'url'   => 'messages/all',
            ],
            'archive' => [
                'title' => 'lang:system::messages.text_archive',
                'icon'  => 'fa-archive',
                'url'   => 'messages/archive',
            ],
        ];
    }

    public function getSendTypeOptions()
    {
        return [
            'email'   => 'lang:system::messages.text_email',
            'account' => 'lang:system::messages.text_account',
        ];
    }

    public function listReceivers()
    {
        return [
            'all_newsletters' => [
                'label' => 'lang:system::messages.text_all_newsletters',
            ],
            'customers'       => [
                'label' => 'lang:system::messages.text_customers',
                'model' => 'Admin\Models\Customers_model',
            ],
            'customer_group'  => [
                'label' => 'lang:system::messages.text_customer_group',
                'model' => 'Admin\Models\Customer_groups_model',
            ],
            'staffs'          => [
                'label' => 'lang:system::messages.text_staff',
                'model' => 'Admin\Models\Staffs_model',
            ],
            'staff_group'     => [
                'label' => 'lang:system::messages.text_staff_group',
                'model' => 'Admin\Models\Staff_groups_model',
            ],
        ];
    }

    public function listParticipants()
    {
        $participants = $this->recipients;
        if (!count($participants))
            return null;

        $participants->transform(function ($participant) {
            if (!$participant->messageable) return FALSE;
            if (!$participant->messageable->staff) return FALSE;

            return $participant->messageable->staff;
        });

        return $participants;
    }

    /**
     * Return all recipients of a message
     *
     * @param int $message_id
     *
     * @return array
     */
    public function getRecipients($message_id)
    {
//        $staffTable = DB::getTablePrefix().'staffs';
//        $customersTable = DB::getTablePrefix().'customers';
//        $metaTable = DB::getTablePrefix().'message_meta';
//
//        $query = Message_meta_model::selectRaw("{$metaTable}.*, {$staffTable}.staff_id, {$staffTable}.staff_name, ".
//            "{$staffTable}.staff_email, {$customersTable}.customer_id, {$customersTable}.first_name, {$customersTable}.last_name, {$customersTable}.email");
//
//        $query->leftJoin('staffs', function ($join) {
//            $join->on('staffs.staff_id', '=', 'message_meta.value')
//                 ->orOn('staffs.staff_email', '=', 'message_meta.value');
//        });
//        $query->leftJoin('customers', function ($join) {
//            $join->on('customers.customer_id', '=', 'message_meta.value')
//                 ->orOn('customers.email', '=', 'message_meta.value');
//        });
//
//        $query->where('item', '!=', 'sender_id');
//        $query->where('message_id', $message_id);
//
//        return $query->get();
    }
//
//    /**
//     * Find a single message by message_id
//     *
//     * @param int $message_id
//     *
//     * @return array
//     */
//    public function getMessage($message_id)
//    {
//        return $this->find($message_id);
//    }
//
//    /**
//     * Find a single draft message by message_id
//     *
//     * @param int $message_id
//     *
//     * @return array
//     */
//    public function getDraftMessage($message_id)
//    {
//        return $this->where('sender_id', $this->user->getStaffId())
//                    ->where('message_id', $message_id)
//                    ->where('status', '0')->first();
//    }
//
//    /**
//     * Return the dates of all messages
//     * @return array
//     */
//    public function getMessageDates()
//    {
//        return $this->pluckDates('date_added');
//    }
////
////    /**
////     * Find a single message by message_id and user_id
////     *
////     * @param int $message_id
////     * @param string $user_id
////     *
////     * @return array
////     */
////    public function viewMessage($message_id, $user_id = '')
////    {
//////        if (is_numeric($message_id) AND is_numeric($user_id)) {
//////            $messageTable = DB::getTablePrefix().'messages';
//////            $metaTable = DB::getTablePrefix().'message_meta';
//////
//////            $query = $this->selectRaw("*, {$metaTable}.status, {$messageTable}.date_added, {$metaTable}.status AS recipient_status, ".
//////                "{$messageTable}.status AS message_status");
//////            $query->groupBy('messages.message_id');
//////            $query->where('messages.message_id', $message_id);
//////
//////            if (APPDIR == ADMINDIR) {
//////                $query->join('staffs', 'staffs.staff_id', '=', 'messages.sender_id', 'left');
//////
//////                $query->where(function ($query) {
//////                    $query->where('message_meta.item', 'sender_id');
//////                    $query->orWhere('message_meta.item', 'staff_id');
//////                });
//////
//////                $query->where('message_meta.value', $user_id);
//////            }
//////            else {
//////                $query->join('customers', 'customers.customer_id', '=', 'message_meta.value', 'left');
//////
//////                $query->where(function ($query) use ($user_id) {
//////                    $query->where('messages.status', '1');
//////                    $query->where('message_meta.status', '1');
//////                    $query->where('message_meta.deleted', '0');
//////                    $query->where('messages.send_type', 'account');
//////                    $query->where('message_meta.item', 'customer_id');
//////                    $query->where('message_meta.value', $user_id);
//////                });
//////            }
//////
//////            $query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');
//////
//////            return $query->first();
//////        }
////    }
////
////    /**
////     * Count the number of unread inbox messages
////     *
////     * @param string $user_id
////     *
////     * @return string
////     */
////    public function getUnreadCount($user_id = '')
////    {
//////        if (is_numeric($user_id)) {
//////            $query = $this->where('messages.status', '1')
//////                          ->where('message_meta.status', '1')
//////                          ->where('message_meta.deleted', '0')
//////                          ->where('message_meta.state', '0')
//////                          ->where('messages.send_type', 'account')
//////                          ->where('message_meta.value', $user_id);
//////
//////            if (APPDIR == ADMINDIR) {
//////                $query->where('message_meta.item', 'staff_id');
//////            }
//////            else {
//////                $query->where('message_meta.item', 'customer_id');
//////            }
//////
//////            $query->join('message_meta', 'message_meta.message_id', '=', 'messages.message_id', 'left');
//////
//////            return $query->count();
//////        }
////    }
////
////    /**
////     * Update a message state or status
////     *
////     * @param int $message_meta_id
////     * @param int $user_id
////     * @param string $state
////     * @param string $folder
////     *
////     * @return bool
////     */
////    public function updateState($user_id, $state, $folder = '')
////    {
//////        $query = FALSE;
//////
//////        if (!is_array($message_meta_id)) $message_meta_id = [$message_meta_id];
//////
//////        if (is_numeric($user_id)) {
//////            $update = [];
//////            if ($state == 'unread') {
//////                $update['state'] = '0';
//////            }
//////            else if ($state == 'read') {
//////                $update['state'] = '1';
//////            }
//////            else if ($state == 'restore') {
//////                $update['status'] = '1';
//////                $update['deleted'] = '0';
//////            }
//////            else if ($state == 'archive') {
//////                $update['deleted'] = '1';
//////            }
//////            else if ($state == 'trash') {
//////                $update['deleted'] = '2';
//////            }
//////
//////            $where['value'] = $user_id;
//////            $this->load->model('Message_meta_model');
//////            $queryBuilder = $this->Message_meta_model->whereIn('message_meta_id', $message_meta_id);
//////
//////            if (APPDIR == ADMINDIR) {
//////                if ($folder == 'inbox') {
//////                    $queryBuilder->where('item', 'staff_id');
//////                }
//////                else if ($folder == 'sent') {
//////                    $queryBuilder->where('item', 'sender_id');
//////                }
//////                else {
//////                    $queryBuilder->where(function ($query) {
//////                        $query->where('item', 'sender_id');
//////                        $query->orWhere('item', 'staff_id');
//////                    });
//////                }
//////            }
//////            else {
//////                $queryBuilder->where('item', 'customer_id');
//////            }
//////
//////            $query = $queryBuilder->update($update);
//////        }
//////
//////        return $query;
////    }
////
////    /**
////     * Create a new or update existing message
////     *
////     * @param int $message_id
////     * @param array $save
////     *
////     * @return bool|int The $message_id of the affected row, or FALSE on failure
////     */
////    public function saveMessage($message_id, $save = [])
////    {
////        $save['sender_id'] = $this->user->getStaffId();
////        $save['sender_typr'] = get_class($this->user->getUser());
////
////        $messageModel = $this->findOrNew($message_id);
////
////        $saved = $messageModel->fill($save)->save();
////
////        return $saved ? $messageModel->getKey() : $saved;
////
//////        if (is_numeric($message_id) AND empty($save['save_as_draft'])
//////            AND !empty($save['recipient']) AND !empty($save['send_type'])
//////        ) {
//////            $this->sendMessage($message_id, $save);
//////        }
//////
//////        return $message_id;
////    }
////
////    /**
////     * Send a new or existing message
////     *
////     * @param       $message_id
////     * @param array $send
////     *
////     * @return bool
////     */
////    protected function sendMessage($message_id, $send = [])
////    {
//////        $results = [];
//////
//////        $column = ($send['send_type'] == 'email') ? 'email' : 'id';
//////
//////        if (empty($send['save_as_draft']) OR $send['save_as_draft'] != '1') {
//////            $this->load->model('Customers_model');
//////
//////            switch ($send['recipient']) {
//////                case 'all_newsletters':
//////                    $results = $this->Customers_model->getCustomersByNewsletterForMessages($column);
//////                    break;
//////                case 'all_customers':
//////                    $results = $this->Customers_model->getCustomersForMessages($column);
//////                    break;
//////                case 'customer_group':
//////                    $results = $this->Customers_model->getCustomersByGroupIdForMessages($column,
//////                        $send['customer_group_id']);
//////                    break;
//////                case 'customers':
//////                    if (isset($send['customers'])) {
//////                        $results = $this->Customers_model->getCustomerForMessages($column, $send['customers']);
//////                    }
//////
//////                    break;
//////                case 'all_staffs':
//////                    $results = $this->Staffs_model->getStaffsForMessages($column);
//////                    break;
//////                case 'staff_group':
//////                    $results = $this->Staffs_model->getStaffsByGroupIdForMessages($column, $send['staff_group_id']);
//////                    break;
//////                case 'staffs':
//////                    if (isset($send['staffs'])) {
//////                        $results = $this->Staffs_model->getStaffForMessages($column, $send['staffs']);
//////                    }
//////
//////                    break;
//////            }
//////
//////            $results['sender_id'] = $this->user->getStaffId();
//////
//////            if (!empty($results) AND $this->addRecipients($message_id, $send, $results)) {
//////                return TRUE;
//////            }
//////        }
////    }
////
////    /**
////     * Add message recipients to database
////     *
////     * @param $message_id
////     * @param $send
////     * @param $recipients
////     *
////     * @return bool
////     */
////    public function addRecipients($message_id, $send, $recipients)
////    {
//////        $this->load->model('Message_meta_model');
//////        $this->Message_meta_model->where('message_id', $message_id)->delete();
//////
//////        $suffix = ($send['send_type'] == 'email') ? 'email' : 'id';
//////
//////        if ($recipients) {
//////            $insert = [];
//////            foreach ($recipients as $key => $recipient) {
//////                if (!empty($recipient)) {
//////                    $status = (is_numeric($recipient)) ? '1' : $this->_sendMail($message_id, $recipient);
//////
//////                    $meta['value'] = $recipient;
//////                    $meta['message_id'] = $message_id;
//////                    $meta['status'] = $status;
//////
//////                    if ($key === 'sender_id') {
//////                        $meta['item'] = 'sender_id';
//////                    }
//////                    else if (in_array($send['recipient'], ['all_staffs', 'staff_group', 'staffs'])) {
//////                        $meta['item'] = 'staff_'.$suffix;
//////                    }
//////                    else {
//////                        $meta['item'] = 'customer_'.$suffix;
//////                    }
//////
//////                    $insert[] = $meta;
//////                }
//////            }
//////
//////            if (!($query = $this->Message_meta_model->insertGetId($insert))) {
//////                return FALSE;
//////            }
//////
//////            return $query;
//////        }
////    }
////
////    /**
////     * Delete a single or multiple message by message_id
////     *
////     * @param int $message_id
////     * @param string $user_id
////     *
////     * @return mixed
////     */
////    public function deleteMessage($message_id, $user_id = '')
////    {
//////        if (is_numeric($message_id)) $message_id = [$message_id];
//////
//////        if (!empty($message_id) AND ctype_digit(implode('', $message_id))) {
//////            // Delete draft messages
//////            return $this->where('sender_id', $user_id)
//////                        ->where('status', '0')->whereIn('message_id', $message_id)->delete();
//////        }
////    }
////
////    /**
////     * Send a message to recipient email or account
////     *
////     * @param int $message_id
////     * @param string $email
////     *
////     * @return string
////     */
////    public function _sendMail($message_id, $email)
////    {
//////        if (!empty($message_id) AND !empty($email)) {
//////            $this->load->library('email');
//////
//////            $mail_data = $this->getMessage($message_id);
//////            if (isset($mail_data['subject'], $mail_data['body'])) {
//////                $this->email->initialize();
//////
//////                $this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
//////
//////                $this->email->to(strtolower($email));
//////                $this->email->subject($mail_data['subject']);
//////                $this->email->message($mail_data['body']);
//////
//////                if (!$this->email->send()) {
//////                    log_message('debug', $this->email->print_debugger(['headers']));
//////                    $notify = '0';
//////                }
//////                else {
//////                    $notify = '1';
//////                }
//////
//////                return $notify;
//////            }
//////        }
////    }
}