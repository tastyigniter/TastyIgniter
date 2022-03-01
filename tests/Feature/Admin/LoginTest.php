<?php

namespace Tests\Feature\Admin;

it('can login as admin', function () {
    // create admin user

    $response = $this->get('admin/login');

    $response->assertStatus(200);
    // test created admin user can login
});
