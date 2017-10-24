<?php

return [
    'text_title'         => 'Permissions',
    'text_new_title'     => 'Permission: New',
    'text_edit_title'    => 'Permission: Update',
    'text_preview_title' => 'Permission: Preview',
    'text_form_name'     => 'Permission',
    'text_empty'         => 'There are no permissions available.',
    'text_filter_search' => 'Search permission name.',
    'text_filter_status' => 'View all status',
    'text_access'        => 'Access',
    'text_manage'        => 'Manage',
    'text_add'           => 'Add',
    'text_delete'        => 'Delete',

    'column_name'        => 'Name',
    'column_actions'     => 'Available Actions',
    'column_description' => 'Description',
    'column_status'      => 'Status',
    'column_id'          => 'ID',

    'label_name'        => 'Name',
    'label_description' => 'Description',
    'label_status'      => 'Status',
    'label_action'      => 'Action',

    'help_name'   => 'Permissions name are made up of (Domain.Context):<br />Domain  - Typically the application domain name (e.g. Admin, Site, Extension, Module, Payment).<br />Context - The controller class name (e.g. Menus, Orders, Locations, or Settings).',
    'help_action' => 'The permitted action (Access, Manage, Add, Delete)',

    'error_invalid_name' => 'Invalid permission name, must match Domain.Context',

    'activity_event_log'           => '{event} permission <b>:subject.name</b>',
];