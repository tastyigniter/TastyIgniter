<?php

return [
    'search_prompt' => 'Search api name',
    'search_tokens_prompt' => 'Search tokens',

    'text_tab_general' => 'General',
    'text_tokens_title' => 'Access Tokens',
    'text_token_type_staff' => 'User',
    'text_token_type_customer' => 'Customer',
    'text_guest' => 'Guests',
    'text_admin' => 'User',
    'text_customer' => 'Customers',
    'text_admin_customer' => 'User or Customers',
    'text_all' => 'All',
    'text_allow_only' => 'Allow Only',

    'button_tokens' => '<i class="fa fa-key"></i>&nbsp;&nbsp;Access tokens',

    'column_api_name' => 'API Name',
    'column_base_endpoint' => 'Base Endpoint',
    'column_description' => 'Description',

    'column_issued_to' => 'Issued to',
    'column_abilities' => 'Abilities',
    'column_token_type' => 'Type',
    'column_device_name' => 'Device name',
    'column_created' => 'Created on',
    'column_lastused' => 'Last used',

    'label_api_name' => 'API Name',
    'label_base_endpoint' => 'Base Endpoint',
    'label_description' => 'Description',
    'label_api_name_comment' => 'Name of your API resource',
    'label_description_comment' => 'Describe your API resource',
    'label_base_endpoint_comment' => 'https://example.com/api/<b>endpoint</b>',

    'label_controller' => 'Controller',
    'label_actions' => 'Actions',
    'help_actions' => 'Leave blank to deactivate the endpoint.',
    'label_require_authorization' => 'Require authorization',
    'label_setup' => 'Reference Docs',

    'actions' => [
        'text_index' => 'List all resources (GET)',
        'text_show' => 'Show a single resource (GET)',
        'text_store' => 'Create a resource (POST)',
        'text_update' => 'Update a resource (PUT/PATCH)',
        'text_destroy' => 'Delete a resource (DELETE)',
    ],

    'alert_auth_failed' => 'No valid API token provided.',
    'alert_auth_restricted' => 'The API token doesn\'t have permissions to perform the request.',
    'alert_token_restricted' => 'The API token doesn\'t have the right abilities to perform this action',
    'alert_validation_failed' => 'Failed to validate request parameters',

    'orders' => [
        'label_customer_id' => 'Customer ID',
    ],

    'addresses' => [
        'label_customer_id' => 'Customer ID',
    ],
];
