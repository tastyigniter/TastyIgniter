<?php

declare(strict_types=1);

namespace Igniter\User\Models;

use Igniter\Api\Models\Token;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Relations\MorphToMany;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Local\Models\Concerns\Locationable;
use Igniter\Local\Models\Location;
use Igniter\System\Models\Concerns\SendsMailTemplate;
use Igniter\System\Models\Concerns\Switchable;
use Igniter\System\Models\Language;
use Igniter\User\Auth\Models\User as AuthUserModel;
use Igniter\User\Classes\PermissionManager;
use Igniter\User\Classes\UserState;
use Igniter\User\Models\Concerns\SendsInvite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Carbon;
use Override;

/**
 * Users Model Class
 *
 * @property int $user_id
 * @property string $name
 * @property string|null $email
 * @property int|null $user_role_id
 * @property int|null $language_id
 * @property bool $status
 * @property int $sale_permission
 * @property string $username
 * @property string|null $password
 * @property bool|null $super_user
 * @property string|null $reset_code
 * @property Carbon|null $reset_time
 * @property string|null $activation_code
 * @property string|null $remember_token
 * @property bool|null $is_activated
 * @property Carbon|null $activated_at
 * @property Carbon|null $last_login
 * @property string|null $last_seen
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $invited_at
 * @property null|bool $send_invite
 * @property-read mixed $avatar_url
 * @property-read mixed $full_name
 * @property-read mixed $staff_email
 * @property-read mixed $staff_name
 * @property-read Collection<int, Location> $locations
 * @property-read DatabaseNotificationCollection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Token> $tokens
 * @property-read null|Language $language
 * @property-read null|UserRole $role
 * @property-read int|null $tokens_count
 * @property string|null $assign_value
 * @property-read Collection<int, UserGroup> $groups
 * @method static BelongsToMany groups()
 * @method static Builder<static>|User query()
 * @method static array pluckDates(string $column, string $keyFormat = 'Y-m', string $valueFormat = 'F Y')
 * @method static Builder<static>|User whereIsEnabled()
 * @method static Builder<static>|User whereResetCode(string $code)
 * @method static Builder<static>|User whereEmail(string $email)
 * @method static MorphToMany<static>|User locations()
 * @mixin Model
 */
class User extends AuthUserModel
{
    use HasFactory;
    use Locationable;
    use Purgeable;
    use SendsInvite;
    use SendsMailTemplate;
    use Switchable;

    public const string LOCATIONABLE_RELATION = 'locations';

    /**
     * @var string The database table name
     */
    protected $table = 'admin_users';

    protected $primaryKey = 'user_id';

    public $timestamps = true;

    protected $guarded = ['reset_code', 'activation_code', 'remember_token'];

    protected $appends = ['full_name'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'password' => 'hashed',
        'user_role_id' => 'integer',
        'sale_permission' => 'integer',
        'language_id' => 'integer',
        'super_user' => 'boolean',
        'status' => 'boolean',
        'is_activated' => 'boolean',
        'reset_time' => 'datetime',
        'invited_at' => 'datetime',
        'activated_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    public $relation = [
        'hasMany' => [
            'assignable_logs' => [AssignableLog::class, 'foreignKey' => 'assignee_id'],
        ],
        'belongsTo' => [
            'role' => [UserRole::class, 'foreignKey' => 'user_role_id'],
            'language' => [Language::class],
        ],
        'belongsToMany' => [
            'groups' => [UserGroup::class, 'table' => 'admin_users_groups'],
        ],
        'morphToMany' => [
            'locations' => [Location::class, 'name' => 'locationable'],
        ],
    ];

    protected $purgeable = ['password_confirm'];

    public function getStaffNameAttribute()
    {
        return $this->name;
    }

    public function getStaffEmailAttribute()
    {
        return $this->email;
    }

    public function getFullNameAttribute($value)
    {
        return $this->name;
    }

    public function getAvatarUrlAttribute(): string
    {
        return '//www.gravatar.com/avatar/'.md5(strtolower(trim((string)$this->email))).'.png?d=mm';
    }

    public function getSalePermissionAttribute($value)
    {
        return $value ?: 1;
    }

    public static function getDropdownOptions()
    {
        return static::query()->whereIsEnabled()->dropdown('name');
    }

    //
    // Scopes
    //

    public function scopeWhereNotSuperUser($query): void
    {
        $query->where('super_user', '!=', 1)->orWhereNull('super_user');
    }

    public function scopeWhereIsSuperUser($query): void
    {
        $query->where('super_user', 1);
    }

    //
    // Events
    //

    #[Override]
    public function beforeLogin(): void {}

    #[Override]
    public function afterLogin(): void
    {
        $this->query()
            ->whereKey($this->getKey())
            ->update(['last_login' => now()]);
    }

    #[Override]
    public function extendUserQuery($query): void
    {
        $query
            ->with(['role', 'groups', 'locations'])
            ->whereIsEnabled();
    }

    public function isSuperUser(): bool
    {
        return $this->super_user == 1;
    }

    //
    // Permissions
    //

    public function hasAnyPermission($permissions)
    {
        return $this->hasPermission($permissions, false);
    }

    public function hasPermission($permissions, $checkAll = true)
    {
        // Bail out if the user is a superuser
        if ($this->isSuperUser()) {
            return true;
        }

        $staffPermissions = $this->getPermissions();

        if (is_string($permissions) && str_contains($permissions, ',')) {
            $permissions = explode(',', $permissions);
        }

        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        return (bool)resolve(PermissionManager::class)->checkPermission(
            $staffPermissions, $permissions, $checkAll);
    }

    public function getPermissions()
    {
        $role = $this->role;

        $permissions = [];
        if ($role && is_array($role->permissions)) {
            $permissions = $role->permissions;
        }

        return $permissions;
    }

    //
    // Location
    //

    public function mailGetRecipients($type): array
    {
        return match ($type) {
            'staff' => [
                [$this->email, $this->full_name],
            ],
            'admin' => [
                [setting('site_email'), setting('site_name')],
            ],
            default => [],
        };
    }

    public function mailGetData(): array
    {
        $model = $this->fresh();

        return array_merge($model->toArray(), [
            'staff' => $model,
            'staff_name' => $model->name,
            'staff_email' => $model->email,
            'username' => $model->username,
        ]);
    }

    //
    // Assignment
    //

    public function canAssignTo(): bool
    {
        return !UserState::forUser($this)->isAway();
    }

    public function hasGlobalAssignableScope(): bool
    {
        return $this->sale_permission === 1;
    }

    public function hasGroupAssignableScope(): bool
    {
        return $this->sale_permission === 2;
    }

    public function hasRestrictedAssignableScope(): bool
    {
        return $this->sale_permission === 3;
    }

    //
    // Helpers
    //

    protected function mailSendInvite(array $vars = [])
    {
        $this->mailSend('igniter.user::mail.invite', 'staff', $vars);
    }

    public function mailSendResetPasswordRequest(array $vars = []): void
    {
        $vars = array_merge([
            'reset_link' => null,
        ], $vars);

        $this->mailSend('igniter.user::mail.admin_password_reset_request', 'staff', $vars);
    }

    public function mailSendResetPassword(array $vars = []): void
    {
        $vars = array_merge([
            'login_link' => null,
        ], $vars);

        $this->mailSend('igniter.user::mail.admin_password_reset', 'staff', $vars);
    }

    /**
     * Return the dates of all staff
     * @return array
     */
    public function getUserDates()
    {
        return static::pluckDates('created_at');
    }

    public function getLocale()
    {
        return $this->language?->code;
    }

    /**
     * Create a new or update existing user locations
     *
     * @param array $locations
     *
     * @return array<string, array>
     */
    public function addLocations($locations = [])
    {
        return $this->locations()->sync($locations);
    }

    /**
     * Create a new or update existing user groups
     *
     * @param array $groups
     *
     * @return array<string, array>
     */
    public function addGroups($groups = [])
    {
        return static::groups()->sync($groups);
    }

    #[Override]
    public function register(array $attributes, $activate = false): self
    {
        $this->name = array_get($attributes, 'name');
        $this->email = array_get($attributes, 'email');
        $this->username = array_get($attributes, 'username');
        $this->password = array_get($attributes, 'password');
        $this->user_role_id = array_get($attributes, 'user_role_id');
        $this->super_user = array_get($attributes, 'super_user', false);
        $this->status = array_get($attributes, 'status', true);
        $this->is_activated = $activate ? false : null; // Set to false to prevent auto activation in observer
        $this->save();

        if ($activate) {
            $this->completeActivation($this->getActivationCode());
        }

        // Prevents subsequent saves to this model object
        $this->password = null;

        if (array_key_exists('groups', $attributes)) {
            static::groups()->attach($attributes['groups']);
        }

        if (array_key_exists('locations', $attributes)) {
            $this->locations()->attach($attributes['locations']);
        }

        $this->reload();

        return $this;
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'admin.users.'.$this->getKey();
    }
}
