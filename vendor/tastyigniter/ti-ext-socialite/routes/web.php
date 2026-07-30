<?php

declare(strict_types=1);

use Igniter\Socialite\Classes\ProviderManager;

Route::group([
    'prefix' => 'igniter/socialite',
    'middleware' => ['web'],
], function(): void {
    Route::any('{provider}/{action}', fn($provider, $action) => (new ProviderManager)->runEntryPoint($provider, $action))->name('igniter_socialite_provider')->where('provider', '[a-zA-Z-]+')->where('action', '[a-zA-Z]+');
});
