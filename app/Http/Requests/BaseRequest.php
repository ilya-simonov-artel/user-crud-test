<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BaseRequest extends FormRequest
{
    protected function routeUser(string $key = 'user'): ?User
    {
        $routeUser = $this->route($key);

        return $routeUser instanceof User ? $routeUser : null;
    }

    protected function baseUserRules(?User $ignoreUser = null): array
    {
        $emailRule = Rule::unique('users', 'email');

        if ($ignoreUser) {
            $emailRule = $emailRule->ignore($ignoreUser->id);
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', $emailRule],
        ];
    }

    protected function avatarRules(): array
    {
        return ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:25600'];
    }

    protected function avatarRemoveRules(): array
    {
        return ['nullable', 'boolean'];
    }
}
