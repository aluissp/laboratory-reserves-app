<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
  <div id="app">
    {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> --}}
    <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false"
          aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav me-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ms-auto">
            <!-- Authentication Links -->
            @guest
              @if (Route::has('login'))
                <li class="nav-item">
                  <a class="nav-link"
                    href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                </li>
              @endif
            @else
              {{-- Usuarios --}}
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                  href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">Usuarios</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item d-flex justify-content-between"
                    href="{{ route('register') }}">
                    Agregar usuario
                    <i class="fa-solid fa-user-plus mt-1 ms-1"></i>

                  </a>
                  <a class="dropdown-item d-flex justify-content-between"
                    href="{{ route('users.index') }}">
                    Gestionar usuarios
                    <i class="fa-solid fa-users-gear mt-1 ms-1"></i>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item d-flex justify-content-between"
                    href="{{ route('majors.index') }}">
                    Carreras
                    <i class="fa-solid fa-layer-group mt-1 ms-1"></i>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item d-flex justify-content-between"
                    href="{{ route('roles.index') }}">
                    Roles
                    <i class="fa-solid fa-ruler-horizontal mt-1 ms-1"></i>
                  </a>
                </div>
              </li>
              {{-- Reservas --}}
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                  href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">Reservas</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item d-flex justify-content-between"
                    href="#">
                    Mostrar reservas
                    <i class="fa-solid fa-calendar-days mt-1 ms-1"></i>
                  </a>
                  <a class="dropdown-item d-flex justify-content-between"
                    href="#">
                    Mis reservas
                    <i class="fa-solid fa-calendar-day mt-1"></i>
                  </a>
                </div>
              </li>
              {{-- Laboratorios --}}
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
                  href="#" role="button" aria-haspopup="true"
                  aria-expanded="false">Laboratorios</a>
                <div class="dropdown-menu">
                  <a class="dropdown-item d-flex justify-content-between"
                    href="#">
                    Mostrar laboratorios
                    <i class="fa-solid fa-chalkboard-user mt-1 ms-1"></i>
                  </a>
                  <a class="dropdown-item d-flex justify-content-between"
                    href="#">
                    Registrar laboratorio
                    <i class="fa-solid fa-plus mt-1"></i>
                  </a>
                </div>
              </li>
              {{-- Perfil --}}
              <li class="nav-item dropdown">

                <a id="userDropdown" class="nav-link dropdown-toggle"
                  href="#" role="button" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }} {{ auth()->user()->surname }}
                </a>

                <di v class="dropdown-menu dropdown-menu-end"
                  aria-labelledby="userDropdown">

                  <a class="dropdown-item d-flex justify-content-between"
                    href="#">
                    Perfil
                    <i class="fa-solid fa-user mt-1 ms-1"></i>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item d-flex justify-content-between"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                    <i class="fa-solid fa-right-from-bracket mt-1 ms-1"></i>
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}"
                    method="POST" class="d-none">
                    @csrf
                  </form>
                </di>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>

    <main class="py-4">
      @if ($alert = session()->get('alert'))
        <x-alert :type="$alert['type']" :message="$alert['message']" />
      @endif

      @yield('content')
    </main>
  </div>
</body>

</html>
