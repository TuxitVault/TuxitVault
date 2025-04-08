<?php

namespace App\Actions\Fortify;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'professionnal' => ['boolean'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'company_siret' => ['nullable', 'string', 'max:14'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'firstname' => $input['firstname'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'professionnal' => $input['professionnal'],
            'company_name' => $input['companyName'],
            'company_siret' => $input['companySiret'],
            'password' => Hash::make($input['password']),
            'owner' => !empty($input['professionnal']) && $input['professionnal'] === true,
        ]);

        Auth::login($user);

        $file = new File();
        $file->name = $user->email;
        $file->is_folder = 1;
        $file->makeRoot()->save();

        return $user;
    }

}
