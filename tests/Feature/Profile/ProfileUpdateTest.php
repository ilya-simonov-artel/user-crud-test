<?php

namespace Tests\Feature\Profile;

use App\Enums\RoleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use Tests\TestCase;

class ProfileUpdateTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function test_profile_update_returns_json_payload(): void
    {
        $user = $this->createUserWithRole(RoleType::User);

        $payload = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '+1 555 000-9999',
        ];

        $response = $this->actingAs($user)->putJson(route('profile.update', $user), $payload);

        $response->assertOk();
        $response->assertJsonPath('message', 'Profile updated successfully.');
        $response->assertJsonPath('data.id', $user->id);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }
}

