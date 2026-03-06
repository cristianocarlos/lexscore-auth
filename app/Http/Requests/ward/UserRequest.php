<?php

namespace App\Http\Requests\ward;

use App\Rules\FullNameValidate;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ($this->method() == 'PUT') {
            return [
                'name' => ['required', new FullNameValidate],
                'email' => 'required|email',
            ];
        }
        return [
            'name' => ['required', new FullNameValidate],
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
