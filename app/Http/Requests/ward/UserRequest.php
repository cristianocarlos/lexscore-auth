<?php

namespace App\Http\Requests\ward;

use App\Rules\CpfRule;
use App\Rules\FullNameRule;
use App\Rules\PhoneRowsRule;
use App\Rules\PtBrAddressRule;
use App\Rules\PtBrDateRule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        if ($this->method() == 'PUT') {
            // Sem o campo da tela
            // nullable // sometimes // [nada] -- comportamento igual
            // Com o campo na tela
            // nullable -- só roda o validator seguinte se tiver valor
            // sometimes // [nada] -- roda os validators seguintes
            return [
                'name' => ['required', new FullNameRule],
                'email' => 'nullable|email',
                'cpf' => ['nullable', new CpfRule],
                'personal_data' => 'array',
                'personal_data.address' => ['nullable', 'array', new PtBrAddressRule],
                'personal_data.birth_date' => ['nullable', new PtBrDateRule],
                'personal_data.gender' => 'nullable|integer',
                'personal_data.phone_rows' => ['nullable', 'array', new PhoneRowsRule],
                'photo' => 'nullable|string', // TODO: validar string precisa conter "data:"
                // 'role_assignment' => 'required', // Não é obrigatorio
                'role_assignment.*' => 'required|integer', // Quando existir precisa ser no formato [1=>1]
            ];
        }
        return [
            'name' => ['required', new FullNameRule],
            'email' => 'nullable|email',
            'cpf' => ['nullable', new CpfRule],
            'personal_data' => 'array',
            'personal_data.address' => ['nullable', 'array', new PtBrAddressRule],
            'personal_data.birth_date' => ['nullable', new PtBrDateRule],
            'personal_data.gender' => 'nullable|integer',
            'personal_data.phone_rows' => ['nullable', 'array', new PhoneRowsRule],
            'password' => 'required',
            'photo' => 'nullable|string', // TODO: validar string precisa conter "data:"
            // 'role_assignment' => 'required', // Não é obrigatorio
            'role_assignment.*' => 'required|integer', // Quando existir precisa ser no formato [1=>1]
        ];
    }
}
