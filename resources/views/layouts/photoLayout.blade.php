<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Photo-CMS') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <link rel="stylesheet" href="{{asset('source/lightbox/css/lightbox.css')}}" />
  <link rel="stylesheet" href="{{asset('justifiedGallery/justifiedGallery.min.css')}}" />

  <script src="{{asset('source/jquery/jquery-3.4.1.min.js')}}"></script>
  <script src="{{asset('justifiedGallery/jquery.justifiedGallery.min.js')}}"></script>
  <script src="{{asset('source/lightbox/js/lightbox.js')}}"></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
  <div id="">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Photo CMS') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Left Side Of Navbar -->
          <ul class="navbar-nav mr-auto">

          </ul>

          <!-- Right Side Of Navbar -->
          <ul class="navbar-nav ml-auto">

            <a class="dropdown-item" href="{{ route('home') }}">Home</a>

          </ul>
        </div>
      </div>
    </nav>
    <h3 class="page-title">@yield('page_title')</h3>
    <!-- End Page Header -->
    <div class="row">
      <!-- Content -->
      @yield('content')
      <!-- End Content -->
    </div>
    <!-- Scripts -->
    <div>
      @yield('pageScripts')
      <!--LOCAL SCRIPTS -->
      <script src="{{ asset('js/app.js') }}"></script>
    </div>

  </div>
</body>

</html>