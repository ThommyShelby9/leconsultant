@extends('bru.template')

@section('contenu')

<div class="row bg-white mb-5 p-3  " id="info">
    <?php $nbre=0 ;?>
    @foreach ($mesformations as $item)
    <div class="col-lg-4 py-3 shadow-lg">
        <div class="card">
            <img src="{{asset('bru/img/african-american-businesswoman-working-on-laptop-in-cafe 1.png')}}" class="card-img-top" alt="..."
                width="334.89px">

            <div class="card-body">
                <h5 class="card-title text-justify" style="color:  #575757 ; font-size: 17px;">
                    {{$item->titre}}
                </h5>

                <div class="my-1">
                    <img src="{{asset('bru/img/icon/calendar.png')}} " alt="">
                    <span>Payé le {{$item->dateTicket}}</span>
                </div>
                <div class="my-1">
                    <img src="{{asset('bru/img/icon/deadline.png')}} " alt="">

                    @if($item->firstDate < date('Y-m-d'))
                    <span>Deja passé</span>
                    @elseif($item->firstDate == date('Y-m-d'))
                                        Aujourd'hui
                     @elseif($item->firstDate > date('Y-m-d'))
                     <span>Dans 10 Jrs</span>
                     @endif
                </div>
                <div class="text-center" style="">
                    <form action="{{ route('DownTicket') }}" method="post" >
                        @csrf
                        <input type="hidden" name="trans" value="{{ $item->idTransaction}}" >
                        <input type="hidden" name="id" value="{{ $item->id }}" >

                        <button class="btn" style="background-color:; color: #0140BA; border-bottom: 2px solid #0140BA" >
                            Telechager Ticket
                        </button>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <?php $nbre +=1 ;?>


    @endforeach

    @if($nbre==0)
    <div class="col-12 shadow-lg text-center py-5" style="border:2px solid #0140BA;">
        <p style="color:  #575757 ; font-size: 17px;">
            Vous vous n’êtes inscrits à aucune formation
        </p>

        <a href="{{ route('pageFormation') }}" class="btn my-3" style="color: #0140BA; ">
            Acceder aux autres formations
            <img src="img/icon/direct.png" alt="">
        </a>

    </div>
    @else
    <div class="col-12 text-right ">
        <a href="{{ route('pageFormation') }}" class="btn my-3" style="color: #0140BA; ">
            Acceder aux autres formations
            <img src="img/icon/direct.png" alt="">
        </a>
    </div>
    @endif


</div>


@endsection
