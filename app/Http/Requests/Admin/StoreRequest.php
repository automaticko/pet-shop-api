<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\FormRequest;
use App\Models\File;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\Rule>>
     */
    public function rules(): array
    {
        return [
            parent::FIRST_NAME   => ['required', 'string'],
            parent::LAST_NAME    => ['required', 'string'],
            parent::AVATAR       => ['required', 'string', 'uuid', Rule::exists((new File())->getTable(), 'uuid')],
            parent::ADDRESS      => ['required', 'string'],
            parent::PHONE_NUMBER => ['required', 'string'],
            parent::MARKETING    => ['string'],

            parent::EMAIL => [
                'required',
                'string',
                'email:strict',
                Rule::unique((new User())->getTable(), 'email'),
            ],

            parent::PASSWORD => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->numbers()->letters()->symbols(),
            ],
        ];
    }
}
