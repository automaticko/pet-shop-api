<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\FormRequest;
use App\Http\Requests\Keys;

class LoginRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\Rule>>
     */
    public function rules(): array
    {
        return [
            Keys::EMAIL    => ['required', 'string', 'email:strict'],
            Keys::PASSWORD => ['required', 'string'],
        ];
    }
}
