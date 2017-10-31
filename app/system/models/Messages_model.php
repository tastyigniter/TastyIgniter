<?php namespace System\Models;

use Igniter\Flame\Database\Traits\NestedTree;
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

    public static function listMenuMessages($menu, $item, $user)
    {
        $query = self::listMessages([
            'context'   => 'inbox',
            'recipient' => $user,
        ]);

        return [
            'total' => $query->toBase()->getCountForPagination(),
            'items' => $query->get(),
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

    public function getSendTypeOptions()
    {
        return [
            'email'   => 'lang:system::messages.text_email',
            'account' => 'lang:system::messages.text_account',
        ];
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
}