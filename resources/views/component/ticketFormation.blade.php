<style>
    .container {
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .row::after {
        content: "";
        clear: both;
        display: table;
    }

    [class*="col-"] {
        float: left;
        padding: 10px;
    }

    .col-1 {
        width: 8.33%;
    }

    .col-2 {
        width: 16.66%;
    }

    .col-3 {
        width: 25%;
    }

    .col-4 {
        width: 33.33%;
    }

    .col-5 {
        width: 41.66%;
    }

    .col-6 {
        width: 50%;
    }

    .col-7 {
        width: 58.33%;
    }

    .col-8 {
        width: 66.66%;
    }

    .col-9 {
        width: 75%;
    }

    .col-10 {
        width: 83.33%;
    }

    .col-11 {
        width: 91.66%;
    }

    .col-12 {
        width: 100%;
    }

    * {
        box-sizing: border-box;
    }

    h2 {
        color: #FF5959;
        text-align: center;
    }

</style>

@foreach ($infos as $item)

<div class="container">
    <div class="row">
        <div class="col-6">
            <img src="logo.png" alt="">
        </div>
        <div class="col-6">
            <p>
                Numéro de ticket : <b>{{$item->idTransaction }}</b>
            </p>
            <p>
                Date d'achat : <b>{{ date('d M Y', strtotime($item->dateTicket)) }}</b>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <h2>INFORMATION PARTICIPANT</h2>
            <b>
                {{ $item->nom." ".$item->prenoms }}
                {{ $item->nomSociete }}
            </b>
            <p>
                {{ $item->email }}
            </p>

            <h2>INFORMATION FORMATION</h2>
            <h3>
                {{ $item->titre }}
            </h3>
            <p>
                {{ $item->lieu."; le ".date('d M Y', strtotime($item->firstDate)) }}
            </p>

        </div>
        <div class="col-6" style="text-align:center ; padding-top:5px ; ">
            <img style="margin-top: 15px" src="{{ $chemin }}" alt="" width="250px" height="250px">

        </div>
    </div>
    <div class="row" style="border: 2px solid blue ; text-align:center" >
        <div class="col-6">
            2022@eTicket_Leonsultant
        </div>
        <div class="col-6">
            Généré le {{ date('d M Y') }}
        </div>
    </div>
</div>

@endforeach
