<?php

namespace Admin\Classes;

use Admin\Facades\AdminAuth;
use Admin\Facades\AdminLocation;
use Illuminate\Support\Facades\Event;

/**
 * Admin User Panel
 */
class UserPanel
{
    protected $user;

    protected $location;

    protected static $menuLinksCache = [];

    public static function forUser($user = null, $location = null)
    {
        $instance = new static;
        $instance->user = $user ?: AdminAuth::getUser();
        $instance->location = $location ?: AdminLocation::current();

        return $instance;
    }

    public static function listMenuLinks($menu, $item, $user)
    {
        if (self::$menuLinksCache)
            return self::$menuLinksCache;

        $items = collect([
            'account' => [
                'label' => 'admin::lang.text_edit_details',
                'iconCssClass' => 'fa fa-user fa-fw',
                'url' => admin_url('staffs/account'),
                'priority' => 20,
            ],
            'logout' => [
                'label' => 'admin::lang.text_logout',
                'cssClass' => 'text-danger',
                'iconCssClass' => 'fa fa-power-off fa-fw',
                'url' => admin_url('logout'),
            ],
        ]);

        Event::fire('admin.menu.extendUserMenuLinks', [$items]);

        $instance = self::forUser();

        return self::$menuLinksCache = $items
            ->mapWithKeys(function ($item, $code) {
                $item = array_merge([
                    'priority' => 999,
                    'label' => null,
                    'cssClass' => null,
                    'iconCssClass' => null,
                    'attributes' => [],
                    'permission' => null,
                ], $item);

                if (array_key_exists('url', $item)) {
                    $item['attributes']['href'] = $item['url'];
                }

                return [
                    $code => (object)$item,
                ];
            })
            ->filter(function ($item) use ($instance) {
                if (!$permission = array_get($item, 'permission'))
                    return TRUE;

                return $instance->user->hasPermission($permission);
            })
            ->sortBy('priority');
    }

    public function getUserName()
    {
        return $this->user->staff->staff_name;
    }

    public function getLocationName()
    {
        return optional($this->location)->location_name;
    }

    public function getAvatarUrl()
    {
        return $this->user->staff->avatar_url;
    }

    public function hasActiveLocation()
    {
        return AdminLocation::check();
    }

    public function listGroupNames()
    {
        return $this->user->staff->groups->pluck('staff_group_name')->all();
    }

    public function getRoleName()
    {
        return optional($this->user->staff->role)->name;
    }

    public function listLocations()
    {
        return AdminLocation::listLocations()->map(function ($value, $key) {
            return (object)[
                'id' => $key,
                'name' => $value,
                'active' => $key === optional($this->location)->location_id,
            ];
        });
    }
}
