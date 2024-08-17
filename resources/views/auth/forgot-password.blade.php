@extends('layout.userLayout.template-auth')

@section('titre')
<title>Le consultant | Se connecter</title>
@endsection


@section('contenu')

<section class="">
    <div class="container">
        <div class="bg-consultant-blue lg:py-24 py-12 lg:px-16 px-8">
            <div class="grid lg:grid-cols-2 grid-cols-1">
                <div class="lg:order-1 order-2">
                    <div class="py-4 lg:border-r-4 lg:border-white flex flex-col justify-between">
                        <h2 class="lg:text-4xl text-2xl font-bold text-center text-white lg:mb-24">
                            Création d'un compte
                        </h2>
                        <div class="text-center">
                            <a href="{{ route('register.morale') }}">
                                <button
                                class="px-8 py-3 text-white bg-consultant-rouge rounded-md font-semibold inline-block">
                                Créer mon compte
                                 </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="lg:order-2 order-1">
                    <h2 class="lg:text-4xl text-2xl font-bold text-center text-white mb-12">
                        Modifier son mot de passe
                    </h2>


                    <form method="POST" action="{{ route('password.request') }}" class="flex flex-col justify-between lg:px-24 px-0">
                        @csrf

                        @error('email')
                        <span class="w-full bg-consultant-rouge py-3 text-center text-white text-lg mb-3">Cet Email n'existe pas...</span>
                        @enderror

                        @if(session('status'))
                        <span class="w-full bg-consultant-rouge py-3 text-center text-white text-lg mb-3">
                            Nous avons envoyé votre lien de réinitialisation de mot de passe par e-mail !
                        </span>
                        @endif

                        <input id="email" type="email" class="inp-log"
                            name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Email">


                        <div class="text-center">
                            <button type="submit"
                                class="lg:text-xl text-lg px-24 py-3 text-white bg-consultant-rouge rounded-md font-semibold inline-block">
                                Modifier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
