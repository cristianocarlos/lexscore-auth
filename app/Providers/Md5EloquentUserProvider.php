<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Support\Arrayable;

class Md5EloquentUserProvider extends EloquentUserProvider
{
    public function __construct(Hasher $hasher, $model) {
        parent::__construct($hasher, $model);
    }

    /**
     * Override the validateCredentials method to use MD5
     */
    public function validateCredentials(Authenticatable $user, array $credentials) {
        $plain = $credentials['user_pass'];
        $hashed = $user->getAuthPassword();

        // Check if password is stored as MD5
        if (strlen($hashed) === 32 && ctype_xdigit($hashed)) {
            return md5($plain) === $hashed;
        }

        // Fallback to default bcrypt validation
        return $this->hasher->check($plain, $hashed);
    }

    /**
     * Override retrieveByCredentials to handle MD5
     */
    public function retrieveByCredentials(array $credentials) {
        if (empty($credentials) ||
           (count($credentials) === 1 &&
            array_key_exists('user_pass', $credentials))) {
            return null;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->newModelQuery();

        foreach ($credentials as $key => $value) {
            if (str_contains($key, 'user_pass')) {
                continue;
            }

            if (is_array($value) || $value instanceof Arrayable) {
                $query->whereIn($key, $value);
            } else {
                $query->where($key, $value);
            }
        }

        return $query->first();
    }
}
