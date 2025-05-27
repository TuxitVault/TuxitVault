<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            'confirmed',
            Password::min(10)      // minimum 10 caractères
                ->mixedCase()      // majuscules et minuscules
                ->numbers()        // au moins un chiffre
                ->symbols()        // au moins un symbole
                ->uncompromised(), // vérifie via Have I Been Pwned
        ];
    }
}
