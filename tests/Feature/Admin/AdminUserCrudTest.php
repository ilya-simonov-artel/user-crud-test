<?php

namespace Tests\Feature\Admin;

use App\Enums\RoleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use Tests\TestCase;

class AdminUserCrudTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function test_admin_can_create_user(): void
    {
        $admin = $this->createUserWithRole(RoleType::Admin);
        $role = $this->ensureRole(RoleType::User);

        $payload = [
            'name' => 'Created User',
            'email' => 'created-user@example.com',
            'phone' => '+1 555 010-0100',
            'role_id' => $role->id,
            'password' => 'secret123',
        ];

        $response = $this->actingAs($admin)->post(route('admin.users.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'created-user@example.com',
            'role_id' => $role->id,
        ]);
    }

    public function test_admin_search_filters_users(): void
    {
        $admin = $this->createUserWithRole(RoleType::Admin);

        $matching = $this->createUserWithRole(RoleType::User, ['name' => 'Search Target']);
        $this->createUserWithRole(RoleType::User, ['name' => 'Other User']);

        $response = $this->actingAs($admin)->get(route('admin.users.index', ['search' => 'Target']));

        $response->assertOk();
        $response->assertSee($matching->name);
        $response->assertDontSee('Other User');
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = $this->createUserWithRole(RoleType::Admin);

        $response = $this->actingAs($admin)
            ->deleteJson(route('admin.users.destroy', $admin));

        $response->assertStatus(422);
        $response->assertJsonPath('message', 'You cannot delete your own account from the admin panel.');
    }

    public function test_admin_can_delete_other_user(): void
    {
        $admin = $this->createUserWithRole(RoleType::Admin);
        $user = $this->createUserWithRole(RoleType::User);

        $response = $this->actingAs($admin)
            ->deleteJson(route('admin.users.destroy', $user));

        $response->assertOk();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}

