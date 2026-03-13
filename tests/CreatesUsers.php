<?php

namespace Tests;

use App\Enums\RoleType;
use App\Models\Role;
use App\Models\User;

trait CreatesUsers
{
    protected function ensureRole(RoleType $type): Role
    {
        return Role::query()->firstOrCreate(
            ['name' => $type->value],
            ['display_name' => $type->description()]
        );
    }

    protected function createUserWithRole(RoleType $type, array $overrides = []): User
    {
        $role = $this->ensureRole($type);

        return User::factory()->create(array_merge([
            'role_id' => $role->id,
        ], $overrides));
    }
}

