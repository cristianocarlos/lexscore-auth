<?php

namespace App\Http\Requests;

use App\Rules\FullNameValidate;
use Illuminate\Foundation\Http\FormRequest;

class WardUserRequest extends FormRequest
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
