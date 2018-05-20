<?php

return [
    'text_title'         => 'Extensions',
    'text_add_title'     => 'Extension: Upload',
    'text_delete_title'  => 'Extension: Delete',
    'text_filter_search' => 'Search name.',
    'text_filter_status' => 'View all status',
    'text_empty'         => 'There are no extensions available.',
    'text_installed'     => 'Installed',
    'text_uninstalled'   => 'Uninstalled',
    'text_upload_title'  => 'Upload the extension .zip file and it will be installed automatically.',
    'text_browse_title'  => 'Freshly baked from the oven...coming soon  <i class="fa fa-smile-o"></i>',
    'text_files'         => 'files',
    'text_files_data'    => 'files and data',
    'text_settings'      => 'Settings',

    'button_new'            => '<i class="fa fa-upload"></i>  Upload',
    'button_upload'         => 'Upload & Install',
    'button_choose'         => 'Choose',
    'button_browse'         => '<i class="fa fa-globe"></i>  Browse more extensions',
    'button_check'          => '<i class="fa fa-refresh"></i>  Updates',
    'button_change'         => 'Change',
    'button_delete'         => 'Delete',
    'button_payments'       => 'Manage Payments',
    'button_settings'       => 'Manage Settings',
    'button_yes_delete'     => 'Yes, delete',
    'button_return_to_list' => 'No, return to list',

    'column_name'    => 'Name',
    'column_icon'    => 'Icon',
    'column_version' => 'Version',

    'label_delete_data' => 'Delete Data',

    'error_config_no_found'  => 'An error occurred, extension registration file could not be found',
    'error_upload_type'      => 'The filetype you are attempting to upload is not allowed.',
    'error_upload_name'      => 'The extension name must not contain whitespace or spacing, use hyphens(-) instead..',
    'error_extension_exists' => 'the extension already exists',
    'error_php_upload'       => 'PHP File Uploading Error No: %s',

    'alert_info_layouts'            => '<b>Layout & Page component(s) registered</b>',
    'alert_warning_layouts'         => 'To display the component for this extension on a page add it to a layout <a href="%s" class="alert-link">here!</a>',
    'alert_delete_warning'          => 'You are about to delete the %s of extension <b>%s</b>',
    'alert_delete_confirm'          => 'Are you sure you wish to delete these %s? This cannot be undone!',
    'alert_is_installed'            => '. You must uninstall an extension before deleting.',
    'alert_setting_missing_id'      => 'Extension setting code has not been specified.',
    'alert_setting_not_found'       => 'Extension settings was not found.',
    'alert_setting_model_missing'   => 'Missing settings model.',
    'alert_setting_model_not_found' => 'Extension settings model [%s] was not found.',

    'activity_event_log' => '{event} extension <b>:subject.title</b>',
];