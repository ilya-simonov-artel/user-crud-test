<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SearchUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Gate::allows('admin');
    }

    protected function prepareForValidation(): void
    {
        $search = $this->input('search');

        $this->merge([
            'search' => is_string($search) ? trim($search) : $search,
        ]);
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
        ];
    }
}

