<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @yield('titre')

    @include('includes.userLink.cssLink')

</head>

<body>
    <header class="relative">
        <nav id="main-menu" class="lg:flex lg:flex-wrap justify-between unsticky py-2 lg:px-12 px-4">

            @include('layout.userLayout.menu')

        </nav>

        @yield('banner')

    </header>

    <main class="relative py-12">
        @yield('contenu')
    </main>

    <footer class="relative bg-consultant-blue lg:pt-12 pt-4 lg:pb-4 pb-2">
        @include('layout.userLayout.footer')
    </footer>

    @include('includes.userLink.jsLink')

    @yield('code')

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

</body>

</html>
