<?php

namespace Tests\Feature\Admin;

use App\Enums\RoleType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesUsers;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;
    use CreatesUsers;

    public function test_admin_can_access_admin_users_page(): void
    {
        $admin = $this->createUserWithRole(RoleType::Admin);

        $response = $this->actingAs($admin)->get(route('admin.users.index'));

        $response->assertOk();
    }

    public function test_regular_user_cannot_access_admin_users_page(): void
    {
        $user = $this->createUserWithRole(RoleType::User);

        $response = $this->actingAs($user)->get(route('admin.users.index'));

        $response->assertForbidden();
    }
}

