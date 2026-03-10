<?php

namespace App\Http\Requests\ward;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        return [
            'name' => 'required|string',
            'parent_id' => 'nullable|integer',
            'route_id' => 'nullable|integer',
            'shortcut_data.name' => 'nullable|string',
            'shortcut_data.icon_name' => 'nullable|string',
        ];
    }
}
