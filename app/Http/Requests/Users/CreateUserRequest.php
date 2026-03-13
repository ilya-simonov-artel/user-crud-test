<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Gate;

class CreateUserRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return Gate::allows('admin');
    }

    public function rules(): array
    {
        return array_merge($this->baseUserRules(), [
            'phone' => ['nullable', 'string', 'max:32'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:6', 'max:255'],
            'avatar' => $this->avatarRules(),
            'avatar_remove' => $this->avatarRemoveRules(),
        ]);
    }
}
