<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    @yield('titre-site')

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @include('includes.adminLink.cssLink')

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
            @include('layout.adminLayout.header')
        </nav>

        <aside class="main-sidebar elevation-4 sidebar-light-warning">
            <!-- Brand Logo -->
            <a href="#" class="brand-link navbar-light">
                <img src="{{ asset('logo.png')}}" alt="AdminLTE Logo">
            </a>


            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('adminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> {{  Auth::User()->name }}</a>
                    </div>
                </div>
                <div class="text-center">
                    <div class="info">
                        @switch(Auth::User()->role)
                            @case(1)
                            <span class="badge badge-secondary px-3 text-md">Tous les droits</span>
                            @break
                            @case(2)
                            <span class="badge badge-secondary px-3 text-md">Rédacteur</span>
                            @break
                            @case(3)
                            <span class="badge badge-secondary px-3 text-md">Gère le site web</span>
                            @break
                            @case(4)
                            <span class="badge badge-secondary px-3 text-md">Gère les formations</span>
                            @break
                        @endswitch
                    </div>
                </div>

                <!-- Le menu  -->
                <nav class="mt-2">
                    @include('layout.adminLayout.menu')
                </nav>
                <!-- Fin du menu  -->

            </div>


        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield('titre')
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">

                    @yield('contenu')

                </div>
            </section>
        </div>


        <footer class="main-footer">
            @include('layout.adminLayout.footer')
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>

    </div>

    @include('includes.adminLink.jsLink')

    @yield('code')
</body>



</html>
