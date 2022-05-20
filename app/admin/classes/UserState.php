<?php

namespace Admin\Classes;

use Admin\Facades\AdminAuth;
use Admin\Models\User_preferences_model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Admin User State
 */
class UserState
{
    protected const USER_PREFERENCE_KEY = 'admin_users_state';

    protected const ONLINE_STATUS = 1;

    protected const BACK_SOON_STATUS = 2;

    protected const AWAY_STATUS = 3;

    protected const CUSTOM_STATUS = 4;

    protected $user;

    protected $defaultStateConfig = [
        'status' => 1,
        'isAway' => false,
        'awayMessage' => null,
        'updatedAt' => null,
        'clearAfterMinutes' => 0,
    ];

    protected $stateConfigCache;

    public static function forUser($user = null)
    {
        $instance = new static;
        $instance->user = $user ?: AdminAuth::getUser();

        return $instance;
    }

    public function isAway()
    {
        return (bool)$this->getConfig('isAway');
    }

    public function getStatus()
    {
        return (int)$this->getConfig('status');
    }

    public function getMessage()
    {
        return $this->getConfig('awayMessage');
    }

    public function getClearAfterMinutes()
    {
        return (int)$this->getConfig('clearAfterMinutes', 0);
    }

    public function getUpdatedAt()
    {
        return $this->getConfig('updatedAt');
    }

    public function getClearAfterAt()
    {
        if ($this->getStatus() !== static::CUSTOM_STATUS)
            return null;

        return make_carbon($this->getConfig('updatedAt'))
            ->addMinutes($this->getClearAfterMinutes());
    }

    public function getStatusColorName()
    {
        return $this->isAway() ? 'danger' : 'success';
    }

    public static function getStatusDropdownOptions()
    {
        return [
            static::ONLINE_STATUS => 'admin::lang.staff_status.text_online',
            static::BACK_SOON_STATUS => 'admin::lang.staff_status.text_back_soon',
            static::AWAY_STATUS => 'admin::lang.staff_status.text_away',
            static::CUSTOM_STATUS => 'admin::lang.staff_status.text_custom_status',
        ];
    }

    public static function getClearAfterMinutesDropdownOptions()
    {
        return [
            1440 => 'admin::lang.staff_status.text_clear_tomorrow',
            240 => 'admin::lang.staff_status.text_clear_hours',
            30 => 'admin::lang.staff_status.text_clear_minutes',
            0 => 'admin::lang.staff_status.text_dont_clear',
        ];
    }

    public static function clearExpiredStatus()
    {
        DB::table(User_preferences_model::make()->getTable())
            ->where('item', static::USER_PREFERENCE_KEY)
            ->where('value->status', static::CUSTOM_STATUS)
            ->where('value->clearAfterMinutes', '!=', 0)
            ->get()
            ->each(function ($preference) {
                $state = json_decode($preference->value);
                if (!$state->clearAfterMinutes)
                    return true;

                $clearAfterAt = make_carbon($state->updatedAt)
                    ->addMinutes($state->clearAfterMinutes);

                if (Carbon::now()->lessThan($clearAfterAt))
                    return true;

                DB::table(User_preferences_model::make()->getTable())
                    ->where('id', $preference->id)
                    ->update(['value' => json_encode((new static)->defaultStateConfig)]);
            });
    }

    //
    //
    //

    public function updateState(array $state = [])
    {
        $state = array_merge($this->defaultStateConfig, $state);

        User_preferences_model::onUser()->set(self::USER_PREFERENCE_KEY, $state);

        $this->stateConfigCache = null;
    }

    protected function getConfig($key = null, $default = null)
    {
        if (is_null($this->stateConfigCache))
            $this->stateConfigCache = $this->loadConfigFromPreference();

        $result = array_merge($this->defaultStateConfig, $this->stateConfigCache);
        if (is_null($key))
            return $result;

        return array_get($result, $key, $default);
    }

    protected function loadConfigFromPreference()
    {
        if (!$this->user)
            return [];

        return User_preferences_model::onUser($this->user)->get(self::USER_PREFERENCE_KEY, []);
    }
}
