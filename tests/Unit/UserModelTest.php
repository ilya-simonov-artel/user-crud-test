<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    public function test_user_is_admin_when_role_is_admin(): void
    {
        $user = new User();
        $user->setRelation('role', new Role(['name' => 'admin']));

        $this->assertTrue($user->isAdmin());
    }

    public function test_user_is_not_admin_when_role_is_user(): void
    {
        $user = new User();
        $user->setRelation('role', new Role(['name' => 'user']));

        $this->assertFalse($user->isAdmin());
    }
}

