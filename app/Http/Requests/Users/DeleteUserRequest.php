<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DeleteUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('admin');
    }

    public function rules(): array
    {
        return [];
    }
}

