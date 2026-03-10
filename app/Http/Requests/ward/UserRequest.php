<?php

namespace App\Http\Requests\ward;

use App\Rules\FullNameRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ($this->method() == 'PUT') {
            return [
                'name' => ['required', new FullNameRule],
                'email' => 'required|email',
            ];
        }
        return [
            'name' => ['required', new FullNameRule],
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
