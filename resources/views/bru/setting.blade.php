@extends('bru.template')

@section('contenu')

<div class="row bg-white mb-5 p-3 " id="param">
    <div class="col-1">
        <img src="{{asset('bru/img/icon/notif.png')}}" alt="" width="29px" height="29px" style="margin-left: 15px; margin-right: 25px;">
    </div>
    <div class="col-11">
        <p>
            Recevoir les messages de noification de publication d’offres par e-mail
            <input checked type="radio" class="ml-3" name="" id="" height="24px" width="24px"
                style="background-color: #0140BA ; color:white ; ">
        </p>
    </div>

    <div class="col-1">
        <img src="{{asset('bru/img/icon/notif.png')}}" alt="" width="29px" height="29px" style="margin-left: 15px; margin-right: 25px;">
    </div>
    <div class="col-11">
        <p>
            Recevoir les messages de noification de publication d’offres par e-mail
            <input type="radio" class="ml-3" name="" id="" height="24px" width="24px"
                style="background-color: #0140BA ; color:white ; ">
        </p>
    </div>

    <div class="col-1">
        <img src="{{asset('bru/img/icon/notif.png')}}" alt="" width="29px" height="29px" style="margin-left: 15px; margin-right: 25px;">
    </div>
    <div class="col-11">
        <p>
            Recevoir les messages de noification de publication d’offres par e-mail
            <input checked type="radio" class="ml-3" name="" id="" height="24px" width="24px"
                style="background-color: #0140BA ; color:white ; ">
        </p>
    </div>

</div>


@endsection
