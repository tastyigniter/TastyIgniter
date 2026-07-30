<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Time to live for parsed Template Pages.
    |--------------------------------------------------------------------------
    |
    | Specifies the number of minutes the Template object cache lives. After the interval
    | is expired item are re-cached. Note that items are re-cached automatically when
    | the corresponding template file is modified.
    |
    */

    'parsedTemplateCacheTTL' => null,

    'parsedTemplateCachePath' => storage_path('igniter/cache'),
];
