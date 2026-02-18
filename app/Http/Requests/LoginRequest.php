<?php

namespace App\Http\Requests;

use App\Rules\CloudflareTurnstileWardValidate;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'LoginForm.cf_turnstile_response' => ['required', new CloudflareTurnstileWardValidate],
            'LoginForm.username' => 'required',
            'LoginForm.password' => 'required',
        ];
    }

    public function messages(): array {
        return [
            // 'LoginForm.cf_turnstile_response.required' => 'Captcha verification empty. Please try again',
        ];
    }
}
