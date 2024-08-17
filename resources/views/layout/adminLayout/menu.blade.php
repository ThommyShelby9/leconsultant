@if( Auth::User()->role == 1)

  @include('layout.adminLayout.menu-adminAll')

@elseif(Auth::User()->role == 2)

    @include('layout.adminLayout.menu-adminRed')

 @elseif(Auth::User()->role == 3)

    @include('layout.adminLayout.menu-adminSite')

 @elseif(Auth::User()->role == 4)

    @include('layout.adminLayout.menu-adminForm')

@endif
