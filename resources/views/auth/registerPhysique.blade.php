@extends('layout.userLayout.template-auth')

@section('titre')
<title>Le consultant | Inscription - Entreprise</title>
@endsection

@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:py-14 py-6">
        <div class="container">
            <h1 class="text-center text-white lg:text-5xl text-3xl font-bold">
                Inscription - Personne Physique
            </h1>
        </div>
    </div>
</section>
@endsection

@section('contenu')
<div class="py-12">
    <div class="container">
        <h3 class="lg:text-2xl text-lg text-consultant-gris text-center font-medium mb-12">
            S'inscrire en tant que personne:
        </h3>
        <div class="flex flex-wrap justify-center space-x-24 mb-20">
            <div class="">
                <a href="{{ route('register.morale' )}}" >
                    <button class="px-14 py-6 text-black hover:text-white transition active:text-white active:bg-consultant-blue border border-consultant-blue rounded-lg bg-transparent hover:bg-consultant-blue">
                        <i class="fi-xtluh4-house-thin"></i>
                    </button>
                </a>
                <div class="text-consultant-gris lg:text-2xl text-lg font-medium text-center mt-2">
                    Morale
                </div>
            </div>

            <div class="">
                <a href="{{ route('register.physique') }}">
                    <button class="px-14 py-6 text-white bg-consultant-blue border border-consultant-blue rounded-lg  hover:bg-consultant-blue">
                        <i class="fi-ctlux4-user-circle-thin"></i>
                    </button>
                </a>
                <div class="text-consultant-gris lg:text-2xl text-lg font-medium text-center mt-2">
                    Physique
                </div>
            </div>

        </div>
        <form name="PhysForm" method="POST" onsubmit="return verificationPhysique()" action="{{ route('register') }}" class="flex flex-col items-center">
            @csrf
            <input type="hidden" name="typeActor" value="1" >

            <span class="text-left text-consultant-rouge mb-1 " id="nomMsg"></span>
            <input id="nom" type="text"  class="inp-sign" placeholder="Nom *"
            name="nom" value="{{ old('nom') }}" autocomplete="nom" autofocus>

            <span class="text-left text-consultant-rouge mb-1 " id="prenomsMsg"></span>
            <input id="prenoms" type="text" class="inp-sign" placeholder="Prénom(s) *"
            name="prenoms" value="{{ old('prenoms') }}" autocomplete="prenoms" autofocus>


            <span class="text-left text-consultant-rouge mb-1 " id="adresseMsg"></span>
            <input id="adresse" type="text" class="inp-sign" name="adresse" placeholder="Adresse *"
            value="{{ old('adresse') }}" autocomplete="adresse" autofocus>

            <span class="text-left text-consultant-rouge mb-1 " id="telephoneMsg">
                @error('telephone')
                <span>Verifiez le format du numéro (Ex:+229 62 00 00 00 )</span>
                @enderror
            </span>
            <input id="telephone" type="text" class="inp-sign" name="telephone" placeholder="Numéro de téléphone (Ex: +229 61 00 00 00 )*"
            value="{{ old('telephone') }}" autocomplete="telephone" autofocus>

            <span class="text-left text-consultant-rouge mb-1 " id="emailMsg">
                @error('email')
                <span>Email deja utilisé</span>
                @enderror
            </span>
            <input id="email" type="email" class="inp-sign" name="email" placeholder="Email *"
             value="{{ old('email') }}"  autocomplete="email">


             <span class="text-left text-consultant-rouge mb-1 " id="mdp1Msg"></span>
             <input onkeyup="controlMdp1()" id="password" type="password" class="inp-sign" placeholder="Définir un mot de passe *"
             name="password"  autocomplete="new-password">

             <span class="text-left text-consultant-rouge mb-1 " id="mdp2Msg"></span>
           <input id="password-confirm" type="password" class="inp-sign" placeholder="Confirmer le mot de passe *"
           name="password_confirmation"  autocomplete="new-password">

            <div class="lg:w-3/5 w-full flex items-center mb-2">
                <input type="checkbox" name="" class="border-black w-6 h-6 mr-4">
                <span class="text-consultant-gris lg:text-lg text-sm font-medium text-left">
                    J'accepte de recevoir des alertes de marchés
                </span>
            </div>
            <div class="lg:w-3/5 w-full flex items-center mb-5">
                <input type="checkbox" name="conditions" required class="border-black w-6 h-6 mr-4">
                <span class="text-consultant-gris lg:text-lg text-sm font-medium text-left">
                    J'ai lu et accepté les conditions d'utilisation
                </span>
            </div>
            <div class="text-center">
                <button type="submit" class="px-6 py-5 text-white bg-consultant-rouge lg:text-2xl text-lg mb-6 rounded-md font-semibold inline-block">
                    Créer mon compte
                </button>
            </div>
            <div class="text-center flex items-center">
                <h3 class="lg:text-2xl text-lg font-medium">
                    J'ai déjà un compte -
                </h3>
                <span class="text-consultant-rouge lg:text-2xl ml-2 text-lg font-medium">
                    <a href="{{ Route('login') }}">Me connecter</a>
                </span>
            </div>
        </form>
    </div>
</div>

@endsection

@section('code')
<script>
    function controlMdp1() {
        var password1 = document.forms['PhysForm']['password'];
        var password2 = document.forms['PhysForm']['password_confirmation'];

        if (password.value.length >= 8) {
            $(function () {
                $("#mdp1Msg").empty();
                $("<span style='color:green' >Mot de passe valide</span>").appendTo("#mdp1Msg");
            });
        }
        if (password2.value.length >= 8) {
            if (password2.value != password1.value) {
                $(function () {
                    $("#mdp2Msg").empty();
                    $("<span >Mot de passe non correct</span>").appendTo("#mdp2Msg");
                });
            }
        }

        }

    function verificationPhysique(){

        var nom = document.forms['PhysForm']['nom'];
        var prenoms = document.forms['PhysForm']['prenoms'];
        var adresse = document.forms['PhysForm']['adresse'];
        var telephone = document.forms['PhysForm']['telephone'];
        var email = document.forms['PhysForm']['email'];
        var password1 = document.forms['PhysForm']['password'];
        var password2 = document.forms['PhysForm']['password_confirmation'];
        var conditions = document.forms['PhysForm']['conditions'];

        if(nom.value == ""){
            nom.focus();
           $(function () {
                $("#nomMsg").empty();
                $("<span>Veillez renseigner votre nom</span>").appendTo("#nomMsg");
            });
            return false;
        }

        if(prenoms.value == ""){
            prenoms.focus();
            $(function () {
                $("#prenomsMsg").empty();
                $("<span>Veillez renseigner votre prénom</span>").appendTo("#prenomsMsg");
            });
            return false;
        }
        if(adresse.value == ""){
            adresse.focus();
            $(function () {
                $("#nomMsg").empty();
                $("<span>Veillez renseigner votre Adresse</span>").appendTo("#adresseMsg");
            });
            return false;
        }
        if(telephone.value == "" ){
            telephone.focus();
            $(function () {
                $("#telephoneMsg").empty();
                $("<span>Veillez renseigner votre numéro Tel.</span>").appendTo("#telephoneMsg");
            });
            return false;
        }

        if(email.value.indexOf("@", 0)< 0 ){
            email.focus();
            $(function () {
                $("#emailMsg").empty();
                $("<span>Email Invalide</span>").appendTo("#emailMsg");
            });
            return false;
        }
        if( email.value.indexOf(".", 0) < 0){
            email.focus();
            $(function () {
                $("#emailMsg").empty();
                $("<span>Email Invalide</span>").appendTo("#emailMsg");
            });
            return false;
        }
        if(password1.value.length < 8 ){
            password1.focus();
            $(function () {
                $("#mdp1Msg").empty();
                $("<span>Mot de passe non valide</span>").appendTo("#mdp1Msg");
            });
            return false;
        }
        if(password2.value.length < 8){
            password2.focus();
            $(function () {
                $("#mdp2Msg").empty();
                $("<span>Mot de passe non valide</span>").appendTo("#mdp2Msg");
            });
            return false;
        }

        if( password1.value !=  password2.value){
            password2.value == "";
            password2.focus();
            $(function () {
                $("#mdp2Msg").empty();
                $("<span>Les mots de passe ne sont pas semblable</span>").appendTo("#mdp2Msg");
            });
            return false;
        }

        if(conditions.value == false){
            conditions.focus();
            return false;
        }

        return true;
    }
</script>
@endsection
