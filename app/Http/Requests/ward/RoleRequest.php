<?php

namespace App\Http\Requests\ward;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            // 'permissions' => 'required', // Não é obrigatorio
            'permissions.*' => 'required|integer', // Quando existir precisa ser no formato [1=>1]
        ];
    }
}
