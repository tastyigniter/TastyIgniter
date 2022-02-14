<?php

namespace Tests\Browser;

use Admin\Models\Staffs_model;
use Admin\Models\Users_model;
use Laravel\Dusk\Browser;

it('can create a category', function () {
    $this->browse(function (Browser $browser) {
        createSuperuserAndLogin($browser)
            ->visit('/admin/categories/create')
            ->type('Category[name]', 'Some name')
            ->press('Save')
            ->waitForReload()
            ->assertPathBeginsWith('/admin/categories/edit/');
    });
});

it('cant create a category with more than 128 characters in it name', function () {
    $this->browse(function (Browser $browser) {
        createSuperuserAndLogin($browser)
            ->visit('/admin/categories/create')
            ->type('Category[name]', 'lOiks2Hd7HN3Khx86q6Z0w5GGorIaEdn6275cxx99924569fYMjf19z6YgrkG63f lOiks2Hd7HN3Khx86q6Z0w5GGorIaEdn6275cxx99924569fYMjf19z6YgrkG63f')
            ->press('Save')
            ->waitForReload()
            ->assertSee('The Name must be between 2 and 128 characters');
    });
});

