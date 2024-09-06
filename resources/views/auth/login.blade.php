@extends('layout.userLayout.template-auth')

@section('titre')
<title>Le consultant | Se connecter</title>
@endsection

@section('contenu')

<section class="">
    <div class="container mx-auto px-4">
        <div class="bg-consultant-blue lg:py-24 py-12 lg:px-16 px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 grid grid-cols-1">
                <!-- Section pour la création de compte -->
                <div class="lg:order-1 order-2 flex flex-col justify-center lg:pr-8 lg:border-r-4 lg:border-white">
                    <h2 class="text-2xl lg:text-4xl font-bold text-center text-white mb-8 lg:mb-24">
                        Création d'un compte
                    </h2>
                    <div class="text-center">
                        <a href="{{ route('register.morale') }}">
                            <button class="px-6 py-3 lg:px-8 lg:py-4 text-white bg-consultant-rouge rounded-md font-semibold">
                                Créer mon compte
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Section pour la connexion -->
                <div class="lg:order-2 order-1">
                    <h2 class="text-2xl lg:text-4xl font-bold text-center text-white mb-8 lg:mb-12">
                        Se connecter
                    </h2>

                    <form method="POST" action="{{ route('login') }}" class="flex flex-col space-y-4 lg:space-y-6 px-4 lg:px-0">
                        @csrf

                        @error('email')
                        <span class="w-full bg-consultant-rouge py-3 text-center text-white text-lg mb-3 block">Veillez vérifier vos identifiants</span>
                        @enderror

                        <input id="email" type="email" class="inp-log w-full px-4 py-3 rounded-md border border-gray-300" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="Email">

                        <input id="password" type="password" class="inp-log w-full px-4 py-3 rounded-md border border-gray-300" name="password" autocomplete="current-password" placeholder="Mot de passe">

                        <a href="{{ route('password.request') }}" class="text-white text-lg lg:text-2xl font-medium text-right underline decoration-dotted mb-4 block">Mot de passe oublié</a>

                        <div class="text-center">
                            <button type="submit" class="lg:text-2xl text-lg px-6 lg:px-24 py-3 lg:py-4 text-white bg-consultant-rouge rounded-md font-semibold inline-block">
                                Connexion
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
