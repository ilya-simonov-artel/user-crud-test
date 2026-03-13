<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::query()->where('name', RoleType::Admin->value)->value('id');
        $userRoleId = Role::query()->where('name', RoleType::User->value)->value('id');

        User::query()->updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('password'),
                'phone' => '+1 555 000-0000',
                'role_id' => $adminRoleId,
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'simple_user@example.com'],
            [
                'name' => 'Demo Simple User',
                'password' => Hash::make('password_for_simple_user'),
                'phone' => '+1 555 000-0001',
                'role_id' => $userRoleId,
            ]
        );

        User::factory()
            ->count(100)
            ->create([
                'role_id' => $userRoleId,
            ]);
    }
}

