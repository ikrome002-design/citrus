<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_admin_login_page_returns_a_successful_response()
    {
        $response = $this->get('http://admin.lvh.me/');

        $response->assertStatus(200)
            ->assertSee('Admin Login');
    }

    public function test_the_merchant_login_page_returns_a_successful_response()
    {
        $response = $this->get('http://business.lvh.me/');

        $response->assertStatus(200)
            ->assertSee('Merchant Login');
    }
}
