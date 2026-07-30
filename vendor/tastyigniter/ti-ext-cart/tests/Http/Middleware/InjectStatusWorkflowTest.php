<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Middleware;

use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Cart\Http\Middleware\InjectStatusWorkflow;
use Illuminate\Support\Facades\Route;

it('injects status workflow modal into response when conditions are met', function(): void {
    Route::middleware(['web', InjectStatusWorkflow::class])
        ->get('/admin/test', [Menus::class, 'index']);

    $response = actingAsSuperUser()->get('/admin/test');

    $response->assertOk();

    expect($response->getContent())->toContain('data-control="status-workflow"');
});

it('does not inject status workflow modal when conditions are not met', function(): void {
    Route::middleware(['web', InjectStatusWorkflow::class])
        ->post('/admin/test', [Menus::class, 'index']);

    $response = actingAsSuperUser()->post('/admin/test', [], [
        'X-Requested-With' => 'XMLHttpRequest',
        'X-IGNITER-REQUEST-HANDLER' => 'onSave',
    ]);

    $response->assertOk();

    expect($response->getContent())->not->toContain('data-control="order-workflow"');
});
