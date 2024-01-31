<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use  RefreshDatabase;

    /**
     * Login Ok.
     */
    public function test_login_ok(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson(route("api.user.login"),['email' => $user->email, 'password' => "password"])->assertSuccessful();
    }

    /**
     * Login Fail.
     */
    public function test_login_invalid_email(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->postJson(route("api.user.login"),['email' => fake()->word(),'password' => fake()->password()])->assertInvalid(['email']);
    }
}
