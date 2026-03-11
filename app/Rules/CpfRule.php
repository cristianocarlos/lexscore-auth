<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void {
        if (!preg_match('/^[0-9]{3}.[0-9]{3}.[0-9]{3}-[0-9]{2}$/', $value)) {
            $fail('The :attribute must be in the format XXX.XXX.XXX-XX.');
        } elseif (!$this->isValid($value)) {
            $fail('The :attribute is invalid.');
        }
    }

    private function isValid(?string $cpf): bool {
        if (empty($cpf)) return false;
        $length = 11;
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (!is_numeric($cpf)) return false;
        if (mb_strlen($cpf) > 11) return false;
        $cpf = str_pad((string) $cpf, $length, '0', STR_PAD_LEFT);
        // Números inválidos
        if (mb_strlen($cpf) != $length
          or $cpf === '00000000000'
          or $cpf === '11111111111'
          or $cpf === '22222222222'
          or $cpf === '33333333333'
          or $cpf === '44444444444'
          or $cpf === '55555555555'
          or $cpf === '66666666666'
          or $cpf === '77777777777'
          or $cpf === '88888888888'
          or $cpf === '99999999999'
        ) {
            return false;
        } else {
            // Calcula os digitos verificadores para verificar se o CPF é válido
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        }
    }
}
