<?php namespace System\Models;

use Admin\Models\Customers_model;
use Admin\Models\Staffs_model;
use DB;
use Igniter\Flame\Database\Traits\NestedTree;
use Igniter\Flame\Database\Traits\Purgeable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Mail\Message;
use Mail;
use Model;

/**
 * Messages Model Class
 * @package System
 */
class Messages_model extends Model
{
    use SoftDeletes;
    use NestedTree;
    use Purgeable;

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
            'layout' => ['System\Models\Mail_layouts_model'],
        ],
        'hasMany'   => [
            'recipients' => ['System\Models\Message_meta_model'],
//            'customers'      => ['Admin\Models\Customers_model'],
//            'customer_group' => ['Admin\Models\Customer_groups_model'],
//            'staff'          => ['Admin\Models\Staffs_model'],
//            'staff_group'    => ['Admin\Models\Staff_groups_model'],
        ],
        'morphTo'   => [
            'sender' => [],
        ],
    ];

    public $purgeable = [
        'customers',
        'customer_group',
        'staff',
        'staff_group',
    ];

    public static $allowedSortingColumns = [
        'date_added asc', 'date_added desc',
        'subject asc', 'subject desc',
    ];

    public static function findRecipients($type, array $ids = [])
    {
        $model = str_contains($type, 'customer')
            ? Customers_model::class : Staffs_model::class;

        if (ends_with($type, '_group')) {
            return $model::whereHas('group', function ($query) use ($ids) {
                $query->whereKey($ids);
            })->get();
        }

        if ($type == 'all_newsletters')
            return $model::where('newsletter', 1)->get();

        return $model::findMany($ids);
    }

    public static function getSendTypeOptions()
    {
        return [
            'email'   => lang('system::messages.text_email'),
            'account' => lang('system::messages.text_account'),
        ];
    }

    public static function countUnread($messagable)
    {
        if (!$messagable instanceof Model)
            return null;

        return Message_meta_model::whereMessagable($messagable)->isUnread()->count();
    }

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

    public static function listReceivers()
    {
        return [
            'all_newsletters' => 'lang:system::messages.text_all_newsletters',
            'customers'       => 'lang:system::messages.text_customers',
            'customer_group'  => 'lang:system::messages.text_customer_group',
            'staff'           => 'lang:system::messages.text_staff',
            'staff_group'     => 'lang:system::messages.text_staff_group',
        ];
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

    //
    // Events
    //

    public function afterSave()
    {
        $this->performAfterSave();
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
        // Backward compatibility
        $replace = ['all_customers' => 'customers', 'all_staffs' => 'staff'];
        if (array_key_exists($value, $replace))
            return $replace[$value];

        return $value;
    }

    public function getRecipientLabelAttribute($value)
    {
        return array_get(self::listReceivers(), $this->recipient);
    }

    //
    // Scopes
    //

    public function scopeListFrontEnd($query, array $options = [])
    {
        $options = array_merge([
            'page'      => 1,
            'pageLimit' => 20,
            'sort'      => null,
        ], $options);

        $options['context'] = 'inbox';

        $query->whereSentToInbox()->listMessages($options);

        return $query->paginate($options['pageLimit'], $options['page']);
    }

    public function scopeListMessages($query, array $options = [])
    {
        extract(array_merge([
            'sort'      => null,
            'context'   => 'inbox',
            'recipient' => null,
        ], $options));

        switch ($context) {
            case 'inbox':
                $query->whereNull('parent_id')->whereHas('recipients', function ($q) use ($recipient) {
                    $q->whereMessagable($recipient);
                });
                break;
            case 'draft':
                $query->where('status', 0)->orWhereNull('status')->whereSender($recipient);
                break;
            case 'sent':
                $query->whereNull('parent_id')->where('status', 1)->whereSender($recipient);
                break;
            case 'archive':
                $query->whereNull('parent_id')->whereSender($recipient)->onlyTrashed();
                break;
        }

        if (!is_array($sort)) {
            $sort = [$sort];
        }

        foreach ($sort as $_sort) {
            if (in_array($_sort, self::$allowedSortingColumns)) {
                $parts = explode(' ', $_sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query;
    }

    public function scopeViewConversation($query, array $options = [])
    {
        extract(array_merge([
            'recipient' => null,
        ], $options));

        $query->whereNull('parent_id')->where('status', 1);

        if (!is_null($recipient)) {

            $query->whereHas('recipients', function ($q) use ($recipient) {
                $q->whereMessagable($recipient);
            });

            $query->orWhere(function ($q) use ($recipient) {
                $q->whereSender($recipient);
            });
        }

        return $query;
    }

    public function scopeWhereSender($query, $sender)
    {
        return $query->where('sender_id', $sender->getKey())
                     ->where('sender_type', get_class($sender));
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

    public function scopeWhereSentToInbox($query)
    {
        return $query->where('send_type', 'account');
    }

    public function scopeWhereSentToEmail($query)
    {
        return $query->where('send_type', 'email');
    }

    //
    // Helpers
    //

    public function send($recipients)
    {
        if ($this->status !== -1)
            return;

        $subject = $this->subject;
        Mail::sendToMany(
            $recipients,
            [
                'html' => $this->body,
                'raw'  => TRUE,
            ],
            $this->toArray(),
            function (Message $message) use ($subject) {
                $message->subject($subject)
                        ->replyTo(config('mail.from.address'), config('mail.from.name'));
            },
            ['bcc' => TRUE]
        );
    }

    public function sent()
    {
        $this->status = 1;
        $this->save();

        $this->recipients()->update(['status' => 1]);
    }

    public function isSent()
    {
        return $this->status > 0;
    }

    public function sendToEmail()
    {
        return $this->send_type == 'email';
    }

    public function sendToInbox()
    {
        return $this->send_type == 'account';
    }

    /**
     * Return all recipients of a message
     *
     * @param int $message_id
     *
     * @return array
     */
    public function listRecipients()
    {
        $recipients = $this->recipients;
        if (!count($recipients))
            return null;

        $recipients->transform(function ($recipient) {
            if (!$recipient->messagable) return FALSE;
            if (!$recipient->messagable->staff) return FALSE;

            return $recipient->messagable->staff;
        });

        return $recipients;
    }

    public function readState($messagable)
    {
        if (!$messagable instanceof Model OR !$this->recipients)
            return null;

        $meta = $this->recipients()->whereMessagable($messagable)->first();
        if (!count($meta))
            return null;

        return $meta->state == 1 ? 'read' : 'unread';
    }

    public function addRecipients($recipients)
    {
        if ($recipients->isEmpty())
            return;

        $this->recipients()->delete();

        $recipients->each(function ($model) {
            $this->recipients()->create([
                'messagable_id'   => $model->getKey(),
                'messagable_type' => get_class($model),
            ]);

            return $model;
        });
    }

    protected function performAfterSave()
    {
        $this->restorePurgedValues();

        if (!empty($this->attributes[$this->recipient]) AND is_array($this->attributes[$this->recipient])) {

            $recipientList = self::findRecipients($this->recipient, $this->attributes[$this->recipient]);
            unset($this->attributes[$this->recipient]);

            if ($this->sendToEmail()) {
                $this->send($recipientList);
            }
            else {
                $this->addRecipients($recipientList);
            }
        }
    }
}