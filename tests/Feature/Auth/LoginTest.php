<?php

namespace Tests\Feature\Auth;

use App\Enums\RoleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\CreatesUsers;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function test_login_redirects_to_profile_show(): void
    {
        $user = $this->createUserWithRole(RoleType::User, [
            'password' => Hash::make('secret-password'),
        ]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('profile.show', $user));
        $this->assertAuthenticatedAs($user);
    }
}

