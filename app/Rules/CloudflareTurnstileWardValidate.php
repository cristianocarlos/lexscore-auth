<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Translation\PotentiallyTranslatedString;

class CloudflareTurnstileWardValidate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (app()->environment('testing') || app()->runningUnitTests()) {
            return;
        }

        try {
            $response = Http::timeout(5)
                ->asForm()
                ->post(config('services.cloudflare_turnstile_ward.verify_url'), [
                    'secret' => config('services.cloudflare_turnstile_ward.secret_key'),
                    // 'response' => $value,
                    'response' => request()->input('cf-turnstile-response'), // xunxo pq é usado o campo cf_turnstile_response pra aparecer o erro do validate na tela
                    'remoteip' => request()->ip(),
                ]);

            $data = $response->json();

            if (!$response->successful() || !($data['success'] ?? false)) {
                Log::warning('Turnstile validation failed', [
                    'errors' => $data['error-codes'] ?? [],
                    'ip' => request()->ip(),
                ]);
                $fail(__('validation.turnstile_failed'));
            }
        } catch (\Exception $e) {
            Log::error('Turnstile verification error', [
                'error' => $e->getMessage(),
                'ip' => request()->ip(),
            ]);
            $fail(__('validation.turnstile_error'));
        }
    }
}
