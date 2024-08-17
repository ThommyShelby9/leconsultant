@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')

@endsection


@section('contenu')
<div class="tab-pane show active fade p-8 bg-white shadow" id="tabs-formationsJustify" role="tabpanel"
    aria-labelledby="tabs-formations-tabJustify">

    <?php $nbre=0 ;?>

    <div class="grid lg:grid-cols-3 grid-cols-1 gap-8 mb-4">

        @foreach ($mesformations as $item)
        <div class="card-form">
            <div class="h-[220px]">
                <img src="{{asset($item->imageForm)}}" alt=""
                            class="object-cover object-center w-full h-full">
            </div>
            <div class="border-b border-l border-r shadow px-4 pt-4 pb-8">
                <h4 class="font-semibold text-justify mb-8 text-consultant-gris3">
                    {{$item->titre}}
                </h4>
                <div class="px-2">
                    <div class="flex items-center mb-4">
                        <i class="fi-xnluxl-calendar mr-4"></i>
                        <h5 class="text-sm">Payé le {{$item->dateTicket}}</h5>
                    </div>
                    <div class="flex items-center mb-10">
                        <i class="fi-xnsuxl-hourglass-half-solid mr-4"></i>
                        @if($item->firstDate < date('Y-m-d')) <h5 class="text-sm">Deja passé</h5>
                            @elseif($item->firstDate == date('Y-m-d'))
                            <h5 class="text-sm">Aujourd'hui</h5>
                            @elseif($item->firstDate > date('Y-m-d'))
                            <h5 class="text-sm">Dans 10 jours</h5>
                            @endif

                    </div>
                    <div class="flex justify-center">
                        <form action="{{ route('DownTicket') }}" method="post">
                            @csrf
                            <input type="hidden" name="trans" value="{{ $item->idTransaction}}">
                            <input type="hidden" name="id" value="{{ $item->id }}">

                            <button class="btn link-consultant px-3"
                                style="background-color:; color: #0140BA; border-bottom: 2px solid #0140BA">
                                Telechager Ticket
                            </button>

                        </form>
                        <!--a href="" class="">Redemander un ticket</a-->
                    </div>
                </div>
            </div>
        </div>

        <?php $nbre +=1 ;?>

        @endforeach

    </div>



    @if($nbre > 0)

    <div class="flex flex-wrap justify-end">
        <a href="{{ route('pageFormation') }}" class="link-consultant mr-2">
            Accéder aux formations
        </a><i class="fi-xwlrxl-arrow-simple-wide text-consultant-blue"></i>
    </div>

    @else
    <div class="lg:p-16 p-6">
        <div class="border border-consultant-blue lg:py-16 py-6">
            <div class="flex flex-wrap justify-center">
                <div class="">
                    <h4 class="text-consultant-gris text-center mb-12">
                        Vous n'êtes inscrits à aucune formation
                    </h4>
                    <div class="flex flex-wrap justify-center">
                        <a href="{{ route('pageFormation') }}" class="link-consultant mr-2">
                            Accéder aux formations
                        </a><i class="fi-xwlrxl-arrow-simple-wide text-consultant-blue"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
