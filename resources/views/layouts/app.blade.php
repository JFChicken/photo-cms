<!DOCTYPE html>
<html class="no-js h-100" lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'BlogCMS') }}</title>


  <link rel="stylesheet" href="justifiedGallery/justifiedGallery.min.css" />

  <script src="source/jquery/jquery-3.4.1.min.js"></script>
  <script src="justifiedGallery/jquery.justifiedGallery.min.js"></script>
  
</head>

<body class="h-100">
 
            <h3 class="page-title">@yield('page_title')</h3>

    
          <!-- End Page Header -->
          <div class="row">
            <!-- Content -->
            @yield('content')
            <!-- End Content -->
            <script>
// $("#mygallery").justifiedGallery();
</script>
          </div>
    


  <!-- Scripts -->

  <!--LOCAL SCRIPTS -->
  <script src="{{ asset('js/app.js') }}"></script>
  
</body>

</html>