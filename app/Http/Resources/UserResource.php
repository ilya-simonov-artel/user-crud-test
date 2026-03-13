<?php

namespace App\Http\Resources;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin User
 * @property-read Role|null $role
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'role' => $this->role?->name,
            'role_description' => $this->role?->descriptionLabel(),
            'avatar_url' => $this->avatar_path ? Storage::disk('public')->url($this->avatar_path) : null,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}

