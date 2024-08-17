@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Formations</title>
@endsection


@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:py-14 py-6">
        <div class="container">
            <h1 class="text-center text-white lg:text-5xl text-3xl font-bold uppercase">
               Créer une alerte
            </h1>
        </div>
    </div>
</section>
@endsection


@section('contenu')
<div class="py-12">

    @foreach ($abon_actu as $item)
        @if($item->typePack == 1)
            @if($item->modeEssaie == 0)
            <?php $container = False ; $container_pack = True; $msg=1;  ?>
            @else
            <?php $container = True ;  $idAbonnement=$item->id; $container_pack = True;$msg=2; $type=1 ;$data_input='radio' ; $data_1='marche' ; $data_2='ac';  ?>
            @endif
        @else
           @if($item->typePack !=1)
                @if($item->dateFin > date('Y-m-d'))
                <!--Abonnement en cours-->
                <?php $container = True ; $idAbonnement=$item->id; $type=2; $container_pack = False; $data_input='checkbox' ; $data_1='marche[]' ; $data_2='ac[]';  ?>
                
                @else
                Abonnement expiré <?php $container = False ;$container_pack = True; ?>
               
                @endif
           @endif
        @endif
    @endforeach
    
    @if($container)
    <div class="container">
        <form class="" action="{{ route('alerte.save') }}" method="post">
            @csrf

            <div class="grid lg:grid-cols-2 grid-cols-1 gap-12">
                <div class="">
                    <div class="flex items-center justify-center bg-consultant-blue h-[105px] rounded mb-8">
                        <h2 class="lg:text-2xl text-lg font-medium text-white">
                            Type de marché qui vous intéresse
                        </h2>
                    </div>
                    @foreach ($les_types_marches as $item)
                    <div class="flex items-center mb-6">
                        <input type="{{$data_input}}" name="{{$data_1}}" class="w-8 h-8 mr-10" value="{{ $item->id }}" >
                        <label class="font-medium lg:text-2xl text-lg text-consultant-gris">{{$item->title}}</label>
                    </div>
                    @endforeach

                </div>
                <div class="">
                    <div class="flex items-center justify-center bg-consultant-blue h-[105px] rounded mb-8">
                        <h2 class="lg:text-2xl text-lg font-medium text-white">
                            Type de AC qui vous intéresse
                        </h2>
                    </div>
                    @foreach ($les_categories as $item)
                    <div class="flex items-center mb-6">
                        <input type="{{$data_input}}" name="{{$data_2}}" class="w-8 h-8 mr-10" value="{{$item->id}}" >
                        <label class="font-medium lg:text-2xl text-lg text-consultant-gris">{{$item->title}}</label>
                    </div>
                    @endforeach

                </div>
            </div>
            <input type="hidden" name="type" value="{{ $type}}">
            <input type="hidden" name="idAbonnement" value="{{ $idAbonnement }}">
            <div class="text-center">
                <button type="submit" class="inline-block lg:text-2xl text-lg text-consultant-rouge font-semibold border border-consultant-rouge bg-white rounded-lg px-12 py-4 hover:bg-consultant-rouge hover:text-white transition mb-5">
                    Enregistrer
                </button>
                <!--div class="flex items-center justify-center">
                    <a href="" class="lg:text-lg text-sm text-consultant-gris font-medium mr-4">
                        Passer cette étape
                    </a>
                    <i class="fi-xnlrxl-arrow-simple text-consultant-blue"></i>
                </div-->
            </div>
        </form>
    </div>
    @endif

    @if($container_pack)
    <div class="container">
        <div class="bg-consultant-rouge text-2xl mb-5 py-5 text-center  px-4 ">
            @if($msg ==1)
            Veillez faire un abonnement payants
            @elseif($msg ==2)
            Vous profitez des 14 jours d'essaie que nous vous avons offert. Pensez à souscrire à notre pack payant pour plus de fonctionnalités.
            @endif
        </div>
        @include('component.packs')
    </div>
    @endif
    

</div>
@endsection

@section('code')
    <script src="https://cdn.kkiapay.me/k.js"></script>
@endsection