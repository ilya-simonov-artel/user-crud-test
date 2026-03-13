<?php

namespace Tests\Unit;

use App\Enums\RoleType;
use App\Models\Role;
use PHPUnit\Framework\TestCase;

class RoleModelTest extends TestCase
{
    public function test_role_description_label_prefers_display_name(): void
    {
        $role = new Role([
            'name' => RoleType::Admin->value,
            'display_name' => 'Custom Admin',
        ]);

        $this->assertSame('Custom Admin', $role->descriptionLabel());
    }

    public function test_role_description_label_falls_back_to_enum(): void
    {
        $role = new Role([
            'name' => RoleType::User->value,
        ]);

        $this->assertSame('User', $role->descriptionLabel());
    }
}

