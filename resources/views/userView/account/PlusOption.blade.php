@extends('layout.userLayout.template-profil')

@section('titre')
<title>Le consultant | Appels d'Offres</title>
@endsection


@section('banner')

@endsection


@section('contenu')
<div class="tab-pane show active fade p-8 bg-white shadow" id="tabs-profilJustify" role="tabpanel"
    aria-labelledby="tabs-profil-tabJustify">

    @if($action == "photo")
    <form action="{{ route('moncompte.photo.save') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-wrap lg:mb-6 mb-12">
            <div class=" mr-8 w-auto mb-8">
                <input type="file" name="maphoto" id=""> <br>
                @error('maphoto')
                <span class="text-consultant-rouge">Une erreur s'est produite</span>
                @enderror
            </div>
            <div class="lg:ml-64 rounded-checkbox  ">
                <button type="submit" class="mt-4 btn bg-consultant-blue text-white px-5 py-2">Sauvegarder la
                    photo</button>
            </div>
        </div>
    </form>

    @elseif($action =="surMoi")

    <form action="{{ route('moncompte.surMoi.save') }}" method="post" >
        @csrf

        <div class="flex flex-wrap">

            <label for="surmoi" class="block mb-2 text-lg font-medium text-gray-900 dark:text-gray-400">Dites nous plus, sur vous</label>
            <textarea id="surmoi" rows="4" name="surmoi"
                class="block p-5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Your message..."></textarea>

            @error('surmoi')
                <span class="text-consultant-rouge">Une erreur s'est produite</span>
            @enderror
        </div>

        <div class="lg:mx-auto rounded-checkbox mt-5 ">
            <button type="submit" class="mt-4 btn bg-consultant-blue text-white px-5 py-2">Enregistrer</button>
        </div>
    </form>


    @endif
</div>
@endsection
