<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends BaseRequest
{
    public function authorize(): bool
    {
        $routeUser = $this->routeUser();

        return $this->user() !== null
            && $routeUser !== null
            && $this->user()->is($routeUser);
    }

    public function rules(): array
    {
        $routeUser = $this->routeUser();

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($routeUser?->id),
            ],
            'phone' => ['nullable', 'string', 'max:32', 'regex:/^\+?[0-9\-\s\(\)]+$/'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:25600'],
            'avatar_remove' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone may contain digits, spaces, and +()- symbols only.',
        ];
    }

}
