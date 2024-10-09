<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Abonnement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\URL;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
{
    if ($input['typeActor'] == 1) {

        Validator::make($input, [
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'regex:/^(0|(\+?[1-9]\d{0,2})? ?[0-9]{1,4}(?: ?[0-9]{2,3}){3})$/', 'max:15'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'conditions' => 'required',
        ])->validate();

        // Créer l'utilisateur et renvoyer l'instance complète
        $user = User::create([
            'nom' => $input['nom'],
            'prenoms' => $input['prenoms'],
            'adresse' => $input['adresse'],
            'telephone' => $input['telephone'],
            'typeActor' => 1,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'situation' => "Mode Gratuit",
            'description' => null,
        ]);

        $url = Url::temporarySignedRoute(
            'email_verified',
            now()->addMinutes(30),
            ['email' => $user->email]  // Utilisez ->email pour accéder à l'email de l'objet utilisateur
        );

        Mail::send('emails.mail', [
            'url' => $url, 
            'nom' => $user->nom 
        ], function ($message) use ($user) {
            $config = config('mail');
            $message->subject('Registration verification !')
                ->from($config['from']['address'], $config['from']['name'])
                ->to($user->email, $user->nom );
        });

        return redirect()->route('register')->with('status', 'Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception.');

    } elseif ($input['typeActor'] == 2) {

        Validator::make($input, [
            'societeType' => ['required'],
            'nomSociete' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'regex:/^(0|(\+?[1-9]\d{0,2})? ?[0-9]{1,4}(?: ?[0-9]{2,3}){3})$/', 'max:15'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'conditions' => 'required',
        ])->validate();

        // Créer l'utilisateur et renvoyer l'instance complète
        $user = User::create([
            'nomSociete' => $input['nomSociete'],
            'typeSociete' => $input['societeType'],
            'adresseSociete' => $input['adresse'],
            'telephoneSociete' => $input['telephone'],
            'typeActor' => 2,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'situation' => "Mode Gratuit",
            'description' => null,
        ]);

        $url = Url::temporarySignedRoute(
            'email_verified',
            now()->addMinutes(30),
            ['email' => $user->email]  // Utilisez ->email pour accéder à l'email de l'objet utilisateur
        );

        Mail::send('emails.company_mail', [
            'url' => $url, 
            'nomSociete' => $user->nomSociete
        ], function ($message) use ($user) {
            $config = config('mail');
            $message->subject('Registration verification !')
                ->from($config['from']['address'], $config['from']['name'])
                ->to($user->email, $user->nomSociete);
        });

        return redirect()->route('register')->with('status', 'Un email de confirmation vous a été envoyé. Veuillez vérifier votre boîte de réception.');

    }
}


public function verify(Request $request, $email)
{
    $user = User::where('email', $email)->first();

    if (!$user || !$request->hasValidSignature()) {
        abort(404);
    }

    $user->update([
        'email_verified_at' => now(),
    ]);

    return redirect()->route('login')->with('success', 'Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.');
}


  
}
