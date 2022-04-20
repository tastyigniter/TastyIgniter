<?php

namespace System\Controllers;

use Admin\Facades\AdminMenu;

class Activities extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
    ];

    public $listConfig = [
        'list' => [
            'model' => 'System\Models\Activities_model',
            'title' => 'lang:system::lang.activities.text_title',
            'emptyMessage' => 'lang:system::lang.activities.text_empty',
            'defaultSort' => ['updated_at', 'DESC'],
            'configFile' => 'activities_model',
        ],
    ];

    protected $requiredPermissions = 'Admin.Activities';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('activities', 'system');
    }

    public function listExtendQuery($query)
    {
        $query->listRecent([
            'onlyUser' => $this->currentUser,
        ]);
    }
}
