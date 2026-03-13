<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleType::cases() as $role) {
            Role::query()->updateOrCreate(
                ['name' => $role->value],
                ['display_name' => $role->description()],
            );
        }
    }
}

