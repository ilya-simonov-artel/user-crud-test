<?php

namespace Tests\Feature\Profile;

use App\Enums\RoleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use Tests\TestCase;

class ProfileAuthorizationTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function test_user_can_view_own_profile(): void
    {
        $user = $this->createUserWithRole(RoleType::User);

        $response = $this->actingAs($user)->get(route('profile.show', $user));

        $response->assertOk();
        $response->assertSee($user->email);
    }

    public function test_user_cannot_view_other_profile(): void
    {
        $user = $this->createUserWithRole(RoleType::User);
        $other = $this->createUserWithRole(RoleType::User);

        $response = $this->actingAs($user)->get(route('profile.show', $other));

        $response->assertForbidden();
    }
}

