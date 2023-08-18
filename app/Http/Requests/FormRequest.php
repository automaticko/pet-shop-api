<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http;

class FormRequest extends Http\FormRequest implements Keys
{
    public function authorize(): bool
    {
        return true;
    }
}
