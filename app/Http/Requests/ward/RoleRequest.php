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
            // 'route_asignment' => 'required', // Não é obrigatorio
            // 'role_assignment' => 'required', // Não é obrigatorio
            'route_asignment.*' => 'required|integer', // Quando existir precisa ser no formato [1=>1]
            'role_assignment.*' => 'required|integer', // Quando existir precisa ser no formato [1=>1]
        ];
    }
}
