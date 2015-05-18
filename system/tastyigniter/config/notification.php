<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['notification']['action_messages']	= array(
    'notify_self'           => 'You',
    'notify_changed'		=> array('<b>{actor}</b> changed {object} status to <b>{subject}</b>.', 'fa fa-tasks'),
    'notify_assigned'		=> array('<b>{actor}</b> assigned {object} to <b>{subject}</b>.', 'fa fa-tasks'),
    'notify_added'			=> array('<b>{actor}</b> added a new {object}.', 'fa fa-tasks'),
    'notify_deleted'		=> array('<b>{actor}</b> deleted {object}.', 'fa fa-tasks'),
    'notify_updated'		=> array('<b>{actor}</b> updated {object} details.', 'fa fa-tasks'),
    'notify_approved'		=> array('<b>{actor}</b> approved a {object} by {subject}.', 'fa fa-tasks'),
    'notify_rejected'		=> array('<b>{actor}</b> rejected a {object} by {subject}.', 'fa fa-tasks'),
    'notify_removed'		=> array('<b>{actor}</b> completely removed {object}.', 'fa fa-tasks'),
    'notify_installed'		=> array('<b>{actor}</b> installed {object}.', 'fa fa-tasks'),
    'notify_uninstalled'	=> array('<b>{actor}</b> uninstalled {object}.', 'fa fa-tasks'),
    'notify_customized'		=> array('<b>{actor}</b> customized {object} {subject}.', 'fa fa-tasks'),
    'notify_set'			=> array('<b>{actor}</b> set {object} {subject}.', 'fa fa-tasks'),
    'notify_backedup'		=> array('<b>{object}</b> backup by {actor}.', 'fa fa-tasks'),
    'notify_expire'			=> array('<b>{object}</b> will expire {subject}.', 'fa fa-tasks'),
    'notify_expired'		=> array('<b>{object}</b> has expired.', 'fa fa-tasks'),
);


/* End of file notification.php */
/* Location: ./system/tastyigniter/config/notification.php */