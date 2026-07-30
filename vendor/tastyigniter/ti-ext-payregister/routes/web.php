<?php

declare(strict_types=1);

use Igniter\PayRegister\Classes\PaymentGateways;

Route::group([
    'prefix' => 'ti_payregister',
    'middleware' => ['web'],
], function(): void {
    Route::any('{code}/{slug}', fn($code, $slug) => PaymentGateways::runEntryPoint($code, $slug))->where('slug', '(.*)?');
});
