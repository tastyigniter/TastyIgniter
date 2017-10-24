<?php

return [
    'tastyigniter' => [
        'system_name'    => 'TastyIgniter',
        'system_powered' => '<a target="_blank" href="http://tastyigniter.com">Powered by TastyIgniter</a>',
        'copyright'      => 'Thank you for using <a target="_blank" href="http://tastyigniter.com">TastyIgniter</a>',
        'version'        => 'Version %s',
    ],
    'no_database'  => [
        'label' => 'Database Error Was Encountered',
        'help'  => "A database connection is required. Check the database is configured and migrated before trying again.",
    ],
    'required'     => [
        'config' => "Configuration used in %s must supply a value '%s'.",
    ],
    'not_found'    => [
        'model'  => "The model ':name' is not found.",
        'layout'  => "The layout ':name' is not found.",
        'partial' => "The partial ':name' is not found.",
        'config'  => 'Unable to find configuration file %s defined for %s.',
        'class'   => "Unable to find '%s' in %s",
    ],
    'missing'      => [
        'config_key' => "Missing required [%s] key in [%s]",
        'carte_key'  => 'No carte key found, click the carte button below to enter one.',
    ],
    'error'        => [
    ],
];