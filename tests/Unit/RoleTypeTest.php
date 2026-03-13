<?php

namespace Tests\Unit;

use App\Enums\RoleType;
use PHPUnit\Framework\TestCase;

class RoleTypeTest extends TestCase
{
    public function test_role_type_descriptions_are_defined(): void
    {
        $this->assertSame('Administrator', RoleType::Admin->description());
        $this->assertSame('User', RoleType::User->description());
    }

    public function test_role_type_values_are_stable(): void
    {
        $this->assertSame('admin', RoleType::Admin->value);
        $this->assertSame('user', RoleType::User->value);
    }
}

