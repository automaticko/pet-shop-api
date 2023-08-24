<?php

namespace App\Http\Requests\Payment;

use App\Http\Requests\FormRequest;
use App\Http\Requests\Keys;
use App\Models\Payment;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\RequiredIf;

class StoreRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string|\Illuminate\Contracts\Validation\Rule>>
     */
    public function rules(): array
    {
        return [
            Keys::TYPE    => ['required', 'string', Rule::in(Payment::TYPES)],
            Keys::DETAILS => ['required', 'array'],

            $this->detail(Keys::HOLDER) => [$this->requiredIf(Payment::TYPE_CREDIT_CARD), 'string'],
            $this->detail(Keys::NUMBER) => [$this->requiredIf(Payment::TYPE_CREDIT_CARD), 'string'],
            $this->detail(Keys::CCV)    => [$this->requiredIf(Payment::TYPE_CREDIT_CARD), 'string'],

            $this->detail(Keys::EXPIRATION) => [
                $this->requiredIf(Payment::TYPE_CREDIT_CARD),
                'string',
                'date_format:Ym',
            ],

            $this->detail(Keys::FIRST_NAME) => [$this->requiredIf(Payment::TYPE_CASH_ON_DELIVERY), 'string'],
            $this->detail(Keys::LAST_NAME)  => [$this->requiredIf(Payment::TYPE_CASH_ON_DELIVERY), 'string'],
            $this->detail(Keys::ADDRESS)    => [$this->requiredIf(Payment::TYPE_CASH_ON_DELIVERY), 'string'],
            $this->detail(Keys::SWIFT)      => [$this->requiredIf(Payment::TYPE_BANK_TRANSFER), 'string'],
            $this->detail(Keys::IBAN)       => [$this->requiredIf(Payment::TYPE_BANK_TRANSFER), 'string'],
            $this->detail(Keys::NAME)       => [$this->requiredIf(Payment::TYPE_BANK_TRANSFER), 'string'],
        ];
    }

    private function detail(string $key): string
    {
        return Keys::DETAILS . '.' . $key;
    }

    private function requiredIf(string $expected): RequiredIf
    {
        return Rule::requiredIf($this->get(keys::TYPE) === $expected);
    }
}
