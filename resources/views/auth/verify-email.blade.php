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
                        <div class="text-center">
                           <img width="75%" src="{{ asset('assets\img\african-american-businesswoman-working-on-laptop-in-cafe 1.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="lg:order-2 order-1">
                    <h2 class="lg:text-4xl text-2xl font-bold text-center text-white mb-12">
                        Verification de mail
                    </h2>
                    <div class="flex flex-col justify-between lg:px-24 px-0">
                        <p class="text-white text-2xl text-justify mb-2">
                            Avant de continuer, veuillez confimer votre e-mail pour un lien de vérification.
                            Fouillez dans votre spam au cas où ça prendra du temps. <br>
                            Si vous n'avez pas reçu l'e-mail,
                        </p>

                        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit"
                            class=" px-24 mt-10 py-3 text-white bg-consultant-rouge rounded-md font-semibold inline-block">
                            cliquez ici pour en demander un autre
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
