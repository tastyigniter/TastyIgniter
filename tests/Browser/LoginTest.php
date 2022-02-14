<?php

namespace Tests\Browser;

use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use Laravel\Dusk\Browser;

it('can see login form', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/admin')
            ->assertSee('Login');
    });
});

it('can login', function () {
    $this->browse(function (Browser $browser) {
        $user = createSuperuser();
        $browser->visit('/admin')
            ->type('username', $user->username)
            ->type('password', 'password12')
            ->press('Login')
            ->waitForReload()
            ->assertPathIs('/admin/dashboard');
    });
});
