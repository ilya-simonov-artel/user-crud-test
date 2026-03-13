<?php

namespace App\Http\Requests\Users;

use App\Http\Requests\BaseRequest;

class GetProfileRequest extends BaseRequest
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
        return [];
    }
}


