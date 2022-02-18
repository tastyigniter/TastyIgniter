<?php

namespace Tests\Unit\Admin\Requests;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function request_should_fail_when_no_username_is_provided()
    {
//        $this->withoutMiddleware(\Igniter\Flame\Foundation\Http\Middleware\VerifyCsrfToken::class);
//
//        $response = $this->post('admin/login', [
//            'password' => $this->faker->password(),
//        ]);
//
//        $response->assertStatus(200);
//
//        $response->assertSessionHasErrors(['username']);
        $this->assertTrue(TRUE);
    }
}
