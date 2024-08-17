@extends('layout.userLayout.template')

@section('titre')
<title>Le consultant | Les services</title>
@endsection


@section('banner')
<section id="banner" class="relative overflow-hidden bg-cover bg-center"
style="background-image: linear-gradient(to bottom, rgba(1, 64, 186, 0.6), rgba(1, 64, 186, 0.6)), url('{{ asset('assets/img/african-american-businesswoman-working-on-laptop-in-cafe 1.png') }}');">

    <div class="lg:pt-92 lg:pb-64 pt-40 pb-28">
        <div class="container">
            <h1 class="text-white text-center lg:text-6xl text-4xl font-bold mb-9">
                Nos services
            </h1>
            <p class="text-white text-justify lg:text-lg text-sm mb-3">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
            </p>
            <p class="text-white text-justify lg:text-lg text-sm">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
            </p>
        </div>
    </div>
</section>
@endsection


@section('contenu')

<section id="services" class="relative">
    <div class="container">
        <div class="grid lg:grid-cols-2 grid-cols-1 gap-16">

            @foreach ($services as $item)
            <div class="card-service">
                <div class="flex flex-col">
                    <h2 class="lg:text-4xl text-2xl font-bold text-consultant-blue mb-4">
                        {{$item->titre}}
                    </h2>
                    <p class="lg:text-lg text-sm text-justify text-consultant-gris mb-13">
                        {{$item->description}}
                    </p>
                    <!--div class="flex justify-end">
                        <a href="" class="text-lg text-consultant-blue">
                            Voir Plus
                        </a>
                    </div-->
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
