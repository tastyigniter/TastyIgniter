<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;

it('has homepage', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
            ->assertSee('Getting Started');
    });
});
