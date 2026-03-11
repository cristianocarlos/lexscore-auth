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
            // TODO: retornar erros ao form
            return [
                'name' => ['required', new FullNameRule],
                'email' => 'required|email',
                'cpf' => ['nullable', new CpfRule],
                'personal_data' => 'array',
                'personal_data.birth_date' => ['nullable', new PtBrDateRule],
                'personal_data.gender' => 'nullable|integer',
                'personal_data.address' => ['nullable', 'array', new PtBrAddressRule],
                'personal_data.phone_rows' => ['array', new PhoneRowsRule],
            ];
        }
        return [
            'password' => 'required',
        ];
    }
}
