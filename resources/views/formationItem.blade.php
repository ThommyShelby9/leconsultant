@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Formation</title>
@endsection


@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:py-14 py-6">
        <div class="container">
            <h1 class="text-center text-white lg:text-5xl text-3xl font-bold uppercase">
                {{$formation->titre}}
            </h1>
        </div>
    </div>
</section>
@endsection


@section('contenu')

<div class="py-12">
    <div class="container">
        <div class="flex items-center mb-6">
            <div class="mr-8">
                <i class="fi-cnluh2-clock"></i>
            </div>
            <div class="lg:text-lg text-sm">
                Niveau: <span class="font-medium"> {{$formation->niveau}} </span>
            </div>
        </div>
        <div class="flex items-center mb-6">
            <div class="mr-8">
                <i class="fi-cnluh2-clock"></i>
            </div>
            <div class="lg:text-lg text-sm">
                Durée: <span class="font-medium"> {{$formation->dureeNbre." ".$formation->dureeMode}} </span>
            </div>
        </div>
        <div class="flex items-center mb-6">
            <div class="mr-8">
                <i class="fi-cnluh2-clock"></i>
            </div>
            <div class="lg:text-lg text-sm">
                Date et lieu: <span class="font-medium"> {{$formation->firstDate." ( ".$formation->firstTime." ) à ".$formation->lieu}} </span>
            </div>
        </div>
        <div class="flex items-center mb-6">
            <div class="mr-8">
                <i class="fi-cnluh2-clock"></i>
            </div>
            <div class="lg:text-lg text-sm">
                Conférencier : <span class="font-medium">{{$formation->confName. " qui est ".$formation->confPost}}</span>
            </div>
        </div>
        <div class="flex items-center mb-10">
            <div class="mr-8">
                <i class="fi-xnlux2-map-marker"></i>
            </div>
            <div class="lg:text-lg text-sm">
                Lieu de la formation: <span class="font-medium">Cotonou</span>
            </div>
        </div>
        <div class="shadow lg:px-16 lg:pt-11 lg:pb-16 px-6 pt-4 pb-6 mb-18">

            @if($formation->competence !=null)
            <h2 class="lg:text-xl text-base text-consultant-rouge  font-medium mb-3">
                Compétences requises:
            </h2>
            <p class=" lg:text-lg text-md mb-6" >
                {{$formation->competence }}
            </p>
            @endif

            <h2 class="lg:text-xl text-base text-consultant-rouge  font-medium mb-12">
                Ce que vous apprendrez:
            </h2>
            <p class=" lg:text-lg text-md" >
                {{$formation->description }}
            </p>
        </div>
        <h2 class="text-consultant-rouge lg:text-5xl text-3xl font-bold mb-8 ">
            Contenu de la formation
        </h2>
        <div class="">
            <p class="lg:px-14 px-5 border-l-[10px] border-consultant-gris3 text-justify lg:text-lg text-sm lg:w-4/5 w-full">
                <?php echo html_entity_decode( $formation->contenu ) ; ?>
            </p>
            <hr class="lg:w-4/5 w-full my-6">
        </div>
        <div class="mt-12">
            @auth
            <div class="bg-white shadow-lg rounded-lg p-8 max-w-md">
                <h3 class="text-2xl font-bold text-consultant-blue mb-4">Inscription à la formation</h3>
                <div class="mb-4">
                    <p class="text-3xl font-bold text-consultant-rouge">{{ $formation->prix }} FCFA</p>
                </div>
                <form action="{{ route('formation.initiate', ['formationId' => $formation->id]) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de téléphone Mobile Money</label>
                        <input type="tel"
                               name="phone"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-consultant-rouge focus:border-transparent"
                               placeholder="Ex: 97000000"
                               pattern="[0-9]{8,15}"
                               required>
                        <small class="text-gray-500 text-xs">Format: 8 à 15 chiffres</small>
                    </div>
                    <button type="submit" class="w-full bg-consultant-rouge text-white py-3 px-6 rounded-lg hover:bg-opacity-90 transition-all duration-300 font-semibold text-lg">
                        Payer et obtenir mon ticket
                    </button>
                </form>
            </div>
            @else
            <a href="{{ route('login') }}">
                <button class="inline-block lg:text-2xl text-lg text-consultant-rouge font-semibold border border-consultant-rouge bg-white rounded px-12 py-4 hover:bg-consultant-rouge hover:text-white transition">
                    Prendre un ticket
                </button>
            </a>
            @endauth
        </div>
    </div>
</div>

@endsection

@section('code')
{{-- PayPlus - Pas de script nécessaire --}}
@endsection

