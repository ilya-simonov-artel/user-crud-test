<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;

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

        return array_merge($this->baseUserRules($routeUser), [
            'phone' => ['nullable', 'string', 'max:32', 'regex:/^\+?[0-9\-\s\(\)]+$/'],
            'avatar' => $this->avatarRules(),
            'avatar_remove' => $this->avatarRemoveRules(),
        ]);
    }

    public function messages(): array
    {
        return [
            'phone.regex' => 'Phone may contain digits, spaces, and +()- symbols only.',
        ];
    }
}
