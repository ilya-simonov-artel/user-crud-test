<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return Gate::allows('admin');
    }

    public function rules(): array
    {
        $user = $this->routeUser();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'phone' => ['nullable', 'string', 'max:32'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:25600'],
            'avatar_remove' => ['nullable', 'boolean'],
        ];
    }
}

