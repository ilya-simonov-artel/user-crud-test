<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    protected function routeUser(string $key = 'user'): ?User
    {
        $routeUser = $this->route($key);

        return $routeUser instanceof User ? $routeUser : null;
    }
}


