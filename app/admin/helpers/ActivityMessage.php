<?php

namespace Admin\Helpers;

use Admin\Facades\AdminAuth;
use Admin\Models\Users_model;
use Igniter\Flame\ActivityLog\Models\Activity;

class ActivityMessage
{
    public static function attachCauserPlaceholders($line, Activity $activity)
    {
        $prefix = '<b>:causer.staff_name</b> ';
        $self = lang('system::lang.activities.activity_self');

        if (!$activity->causer instanceof Users_model)
            $prefix = '<b>'.lang('system::lang.activities.activity_system').'</b> ';

        if ($activity->causer AND $activity->causer->user_id == AdminAuth::getId())
            $prefix = '<b>'.ucfirst($self).'</b> ';

        return $prefix.lang($line);
    }

    public static function attachAssignedPlaceholders($line, Activity $activity)
    {
        $self = lang('system::lang.activities.activity_self');

        $prefix = '<b>:causer.staff_name</b> ';
        if (!$activity->causer instanceof Users_model)
            $prefix = '<b>'.lang('system::lang.activities.activity_system').'</b> ';

        if ($activity->causer AND $activity->causer->user_id == AdminAuth::getId())
            $prefix = '<b>'.ucfirst($self).'</b> ';

        $assigneeId = $activity->properties->get('assignee_id');
        if (!$assigneeId AND strlen($activity->properties->get('assignee_group_id'))) {
            $suffix = ' <b>:properties.assignee_group_name</b>';
        }
        elseif ($assigneeId == optional(AdminAuth::staff())->getKey()) {
            $suffix = ' <b>'.$self.'</b>';
        }
        else {
            $suffix = ' <b>:properties.assignee_name</b>';
        }

        return $prefix.lang($line).$suffix;
    }
}