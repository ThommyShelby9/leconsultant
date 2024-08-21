@extends('layout.userLayout.template-auth')

@section('titre')
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<title>Le consultant | Inscription - Entreprise</title>
@endsection

@section('banner')
<section id="banner" class="relative overflow-hidden">
    <div class="bg-consultant-blue lg:py-14 py-6">
        <div class="container">
            <h1 class="text-center text-white lg:text-5xl text-3xl font-bold">
                Inscription - Personne Morale
            </h1>
        </div>
    </div>
</section>
@endsection

@section('contenu')
<div class="py-12">
    <div class="container">
        <!-- Contenu de la page d'inscription -->
        <h3 class="lg:text-2xl text-lg text-consultant-gris text-center font-medium mb-12">
            S'inscrire en tant que personne:
        </h3>
        <div class="flex flex-wrap justify-center space-x-24 mb-20">
            <!-- Sélection du type d'inscription -->
            <div class="">
                <a href="{{ Route('register.morale') }} ">
                    <button
                        class="px-14 py-6 text-white bg-consultant-blue border border-consultant-blue rounded-lg  hover:bg-consultant-blue">
                        <i class="fi-xtluh4-house-thin"></i>
                    </button>
                </a>
                <div class="text-consultant-gris lg:text-2xl text-lg font-medium text-center mt-2">
                    Morale
                </div>
            </div>

            <div class="">
                <a href="{{ Route('register.physique') }}">
                    <button
                        class="px-14 py-6 text-black hover:text-white transition active:text-white active:bg-consultant-blue border border-consultant-blue rounded-lg bg-transparent hover:bg-consultant-blue">
                        <i class="fi-ctlux4-user-circle-thin"></i>
                    </button>
                </a>
                <div class="text-consultant-gris lg:text-2xl text-lg font-medium text-center mt-2">
                    Physique
                </div>
            </div>
        </div>

        <!-- Formulaire d'inscription -->
        <form method="POST" name="MoralForm" id="registerForm" action="{{ route('register') }}"
            class="flex flex-col items-center">
            @csrf
            <input type="hidden" name="typeActor" value="2">

            <select name="societeType" id="societeType" class="inp-sign">
                <option class="text-2xl" value="Societe">Société</option>
                <option class="text-2xl" value="SARL">SARL</option>
                <option class="text-2xl" value="Etablissement">Etablissement</option>
                <option class="text-2xl" value="Autres">Autres</option>
            </select>

            <span class="text-left text-consultant-rouge mb-1 " id="nomSocieteMsg"></span>
            <input id="nomSociete" type="text" class="inp-sign" name="nomSociete" placeholder="Dénomination sociale *"
                value="{{ old('nomSociete') }}" autocomplete="nomSociete" autofocus>

            <span class="text-left text-consultant-rouge mb-1 " id="adresseMsg"></span>
            <input id="adresse" type="text" class="inp-sign" name="adresse" value="{{ old('adresse') }}"
                autocomplete="adresse" autofocus placeholder="Adresse de l'entreprise *">

            <span class="text-left text-consultant-rouge mb-1 " id="telephoneMsg">
                @error('telephone')
                <span>Vérifiez le format du numéro (Ex:+229 62 00 00 00 )</span>
                @enderror
            </span>

            <input id="telephone" type="tel" class="inp-sign" name="telephone" value="{{ old('telephone') }}"
                placeholder="Numéro de téléphone (Ex: +229 61 00 00 00 )*" autocomplete="telephone" autofocus>

            <span class="text-left text-consultant-rouge mb-1 " id="emailMsg">
                @error('email')
                <span>Email déjà utilisé</span>
                @enderror
            </span>
            <input id="email" type="email" class="inp-sign" placeholder="Votre mail *" name="email"
                value="{{ old('email') }}" autocomplete="email">

            <span class="text-left text-consultant-rouge mb-1 " id="mdp1Msg"></span>
            <input onkeyup="controlMdp1()" id="password" type="password" class="inp-sign"
                placeholder="Définir un mot de passe *" name="password">

            <span class="text-left text-consultant-rouge mb-1 " id="mdp2Msg"></span>
            <input onkeyup="controlMdp1()" id="password-confirm" type="password" class="inp-sign"
                placeholder="Confirmer le mot de passe *" name="password_confirmation">

            <div class="lg:w-3/5 w-full flex items-center mb-2">
                <input type="checkbox" name="" class="border-black w-6 h-6 mr-4">
                <span class="text-consultant-gris lg:text-lg text-sm font-medium text-left">
                    J'accepte de recevoir des alertes de marchés
                </span>
            </div>
            <div class="lg:w-3/5 w-full flex items-center mb-5">
                <input type="checkbox" required name="conditions" class="border-black w-6 h-6 mr-4">
                <span class="text-consultant-gris lg:text-lg text-sm font-medium text-left">
                    J'ai lu et accepté les conditions d'utilisation
                </span>
            </div>
            <div class="text-center">
                <button type="submit"
                    class="px-6 py-5 text-white bg-consultant-rouge lg:text-2xl text-lg mb-6 rounded-md font-semibold inline-block">
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

        var password1 = document.forms['MoralForm']['password'];
        var password2 = document.forms['MoralForm']['password_confirmation'];

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

    function verificationMoral() {

        var nomSociete = document.forms['MoralForm']['nomSociete'];
        var adresse = document.forms['MoralForm']['adresse'];
        var telephone = document.forms['MoralForm']['telephone'];
        var email = document.forms['MoralForm']['email'];
        var password1 = document.forms['MoralForm']['password'];
        var password2 = document.forms['MoralForm']['password_confirmation'];
        var conditions = document.forms['MoralForm']['conditions'];

        if (nomSociete.value == "") {

            nomSociete.focus();
            $(function () {
                $("#nomSocieteMsg").empty();
                $("<span>Veillez renseigner votre dénomination</span>").appendTo("#nomSocieteMsg");
            });
            return false;
        }

        if (adresse.value == "") {
            adresse.focus();
            $(function () {
                $("#adresseMsg").empty();
                $("<span>Veillez renseigner votre adresse </span>").appendTo("#adresseMsg");
            });
            return false;
        }
        if (telephone.value == "") {

            telephone.focus();
            $(function () {
                $("#telephoneMsg").empty();
                $("<span>Veillez renseigner votre numéro Tel.</span>").appendTo("#telephoneMsg");
            });
            return false;
        }


        if (email.value.indexOf("@", 0) < 0) {
            email.focus();
            $(function () {
                $("#emailMsg").empty();
                $("<span>Email Invalide</span>").appendTo("#emailMsg");
            });
            return false;
        }
        if (email.value.indexOf(".", 0) < 0) {
            email.focus();
            $(function () {
                $("#emailMsg").empty();
                $("<span>Email Invalide</span>").appendTo("#emailMsg");
            });
            return false;
        }
        if (password1.value.length < 8) {
            password1.focus();
            $(function () {
                $("#mdp1Msg").empty();
                $("<span>Mot de passe non valide</span>").appendTo("#mdp1Msg");
            });
            return false;
        }
        if (password2.value.length < 8) {
            password2.focus();
            $(function () {
                $("#mdp2Msg").empty();
                $("<span>Mot de passe non valide</span>").appendTo("#mdp2Msg");
            });
            return false;
        }

        if (password1.value != password2.value) {
            password2.value == "";
            password2.focus();
            $(function () {
                $("#mdp2Msg").empty();
                $("<span>Les mots de passe ne sont pas semblable</span>").appendTo("#mdp2Msg");
            });
            return false;
        }

        if (conditions.value == false) {
            conditions.focus();
            return false;
        }


        return true;
    }

</script>
@endsection
