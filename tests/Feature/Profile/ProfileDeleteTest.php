<?php

namespace Tests\Feature\Profile;

use App\Enums\RoleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use Tests\TestCase;

class ProfileDeleteTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function test_profile_delete_removes_user(): void
    {
        $user = $this->createUserWithRole(RoleType::User);

        $response = $this->actingAs($user)->deleteJson(route('profile.destroy', $user));

        $response->assertOk();
        $response->assertJsonPath('message', 'Account deleted successfully.');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

