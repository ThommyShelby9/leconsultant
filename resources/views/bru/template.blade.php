<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="{{ asset ('bru/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('bru/fiche.css') }}">

</head>
<body>
  <nav id="menu" class="navbar navbar-expand-lg fixed-top" style="" >
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="{{asset('bru/img/logo.png')}}" alt="" width="183px" >
      </a>
      <button style="background-color: orange; width: 25px; height: 25px; " class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span ></span>
        <span></span>
        <span></span>
      </button>



      <div class="collapse navbar-collapse" id="navbarResponsive">
       @include('bru.menu')
      </div>
    </div>
  </nav>


  <div class=" position-relative"  style="margin-top: 100px; height: 450px; background-color: #0140BA; " >

    <div class="position-absolute" >
      <div class="container-fluid " >
        <div class="mx-lg-5 px-5" style=" ">

          <div class="row py-5 px-4   bg-white mb-3" style="margin-top: 100px;" >
            <div class="col-lg-3 ">
              <img class="rounded-circle " alt="" src="{{asset('bru/img/formation.jpg')}}" data-holder-rendered="true" width="250px" height="100%">

              <!--img class="rounded-circle" alt="100x100" src="img/formation.jpg" height="236px" width="340.25px" -->
            </div>
            <div class="col-lg-9 pl-2 pr-5">

              <div class="text-right mb-3" >
                <a class="nav-link" href="{{ route('moncompte.edit') }}" style="color: #0140BA; font-family: Montserrat; font-size: 20px; "> Modifier mon profil</a>
               </div>

              <hr>
              <h3> {{ Auth::user()->nomSociete }} </h3>
              <h3> {{ Auth::user()->nom." ".Auth::user()->prenoms }} </h3>
              <p class="text-justify" >Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore placeat impedit fuga laboriosam ipsum natus cumque nemo repellat ex similique explicabo, asperiores molestias nobis optio doloribus cupiditate ipsam nostrum sed!</p>
            </div>
          </div>

          <div class="row  position-sticky bg-white mb-5 " id="item-profil-block" >
            <div class="col-lg-3 p-3" id="{{ request()->routeIs('moncompte')  ? 'item-profil-active' : 'item-profil'  }}"  >
              <a href="{{ route('moncompte')}} " class="nav-link"  >
                <img src="{{asset('bru/img/icon/compte.png')}}" alt="" id="item-profil-img">
                Mon profil
            </a>
            </div>
            <div class="col-lg-3 p-3" id="{{ request()->routeIs('mesSetting')  ? 'item-profil-active' : 'item-profil'  }}"  >
                <a href="{{ route('mesSetting')}} " class="nav-link">
                    <img src="{{asset('bru/img/icon/setting.png')}}" alt="" id="item-profil-img">
                    Paramètre
                </a>
            </div>
            <div class="col-lg-3 p-3" id="{{ request()->routeIs('mesAbonnements')  ? 'item-profil-active' : 'item-profil'  }}"  >
                <a href="{{ route('mesAbonnements')}} " class="nav-link" >
                    <img src="{{asset('bru/img/icon/pack.png')}}" alt="" id="item-profil-img">
                    Abonnement
                </a>
            </div>
            <div class="col-lg-3 p-3" id="{{ request()->routeIs('mesformations')  ? 'item-profil-active' : 'item-profil'  }}" >
              <a href="{{ route('mesformations') }}" class="nav-link" >
                <img src="{{asset('bru/img/icon/formation.png')}}" alt="" id="item-profil-img">
              Formations
              </a>
            </div>
          </div>

          @yield('contenu')

        </div>




      </div>

      <footer class="pt-5 pb-2" style="background-color: #0140BA; margin-top: 100px; " >
        <div class="container">
          <div class="row text-white">
            <div class="col-md-6">
              <div style="border-left: 8px solid #FF5959;" >
                <h2 style="font-size: 30px;" class="ml-3 py-3" >Suivez-nous</h2>
              </div>
              <div class="ml-4 py-3 pr-3 text-justify" >
                <p style="font-size: 18px; font-family: 'Montserrat'; " >
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>
            </div>
            <div class="col-md-6">
              <div style="border-left: 8px solid #FF5959;" >
                <h2 style="font-size: 30px;" class="ml-3 py-3" >Abonnement newsletter</h2>
              </div>
              <div class="ml-4 py-3 pr-3 text-justify" >
                <p style="font-size: 18px; font-family: 'Montserrat'; " >
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                  quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
              </div>
            </div>

            <div class="col-12 text-center mt-3 mb-2" style="font-size: 20px;">
              ©2022 Bénin || Le Consultant || Conçu par Drwintech Bénin
            </div>
          </div>
        </div>
      </footer>

    </div>


  </div>


</body>


  <!-- Bootstrap core JavaScript -->
  <script src="{{asset('bru/jquery.min.js')}}"></script>
  <script src="{{ asset('bru/bootstrapmin.js')}}"></script>

</html>
