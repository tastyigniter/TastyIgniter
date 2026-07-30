<?php

declare(strict_types=1);

namespace Igniter\Api\Http\Controllers;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Facades\AdminMenu;
use Igniter\Admin\Http\Actions\ListController;
use Igniter\Api\Models\Token;

/**
 * API Tokens Admin Controller
 */
class Tokens extends AdminController
{
    public array $implement = [
        ListController::class,
    ];

    public array $listConfig = [
        'list' => [
            'model' => Token::class,
            'title' => 'igniter.api::default.text_tokens_title',
            'emptyMessage' => 'lang:admin::lang.list.text_empty',
            'defaultSort' => ['id', 'DESC'],
            'configFile' => 'token',
            'back' => 'igniter/api/resources',
        ],
    ];

    protected null|string|array $requiredPermissions = ['index' => 'Igniter.Api.*'];

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('resources', 'tools');
    }
}
