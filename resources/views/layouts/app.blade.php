<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'BlogCMS') }}</title>
 
  <link rel="stylesheet" href="source/lightbox/css/lightbox.css" />
  <link rel="stylesheet" href="justifiedGallery/justifiedGallery.min.css" />

  <script src="source/jquery/jquery-3.4.1.min.js"></script>
  <script src="justifiedGallery/jquery.justifiedGallery.min.js"></script>
  <script src="source/lightbox/js/lightbox.js"></script>
<style>
body {
  background-color: #708090;
}
@import url(http://fonts.googleapis.com/css?family=Raleway);
#cssmenu,
#cssmenu ul,
#cssmenu ul li,
#cssmenu ul li a {
  margin: 0;
  padding: 0;
  border: 0;
  list-style: none;
  line-height: 1;
  display: block;
  position: relative;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
#cssmenu:after,
#cssmenu > ul:after {
  content: ".";
  display: block;
  clear: both;
  visibility: hidden;
  line-height: 0;
  height: 0;
}
#cssmenu {
  width: auto;
  /* border-bottom: 3px solid #47c9af; */
  font-family: Raleway, sans-serif;
  line-height: 1;
}
#cssmenu ul {
  /* background: #ffffff; */
}
#cssmenu > ul > li {
  float: left;
}
#cssmenu.align-center > ul {
  font-size: 0;
  text-align: center;
}
#cssmenu.align-center > ul > li {
  display: inline-block;
  float: none;
}
#cssmenu.align-right > ul > li {
  float: right;
}
#cssmenu.align-right > ul > li > a {
  margin-right: 0;
  margin-left: -4px;
}
#cssmenu > ul > li > a {
  z-index: 2;
  padding: 18px 25px 12px 25px;
  font-size: 15px;
  font-weight: 400;
  text-decoration: none;
  color: #444444;
  -webkit-transition: all .2s ease;
  -moz-transition: all .2s ease;
  -ms-transition: all .2s ease;
  -o-transition: all .2s ease;
  transition: all .2s ease;
  margin-right: -4px;
}
#cssmenu > ul > li.active > a,
#cssmenu > ul > li:hover > a,
#cssmenu > ul > li > a:hover {
  color: #696969;
}
#cssmenu > ul > li > a:after {
  position: absolute;
  left: 0;
  bottom: 0;
  right: 0;
  z-index: -1;
  width: 100%;
  height: 120%;
  border-top-left-radius: 8px;
  border-top-right-radius: 8px;
  content: "";
  -webkit-transition: all .2s ease;
  -o-transition: all .2s ease;
  transition: all .2s ease;
  -webkit-transform: perspective(5px) rotateX(2deg);
  -webkit-transform-origin: bottom;
  -moz-transform: perspective(5px) rotateX(2deg);
  -moz-transform-origin: bottom;
  transform: perspective(5px) rotateX(2deg);
  transform-origin: bottom;
}
#cssmenu > ul > li.active > a:after,
#cssmenu > ul > li:hover > a:after,
#cssmenu > ul > li > a:hover:after {
  background: #708090;
}
  </style>
</head>

<body>

<div id="cssmenu">
  
<ul>
   <li class='active'><a href='{{url("/")}}'>Latest</a></li>
   <li><a href='{{url("yearly")}}'>Yearly</a></li>
   <li><a href='{{url("event")}}'>Event</a></li>
</ul>
</div>

  <h3 class="page-title">@yield('page_title')</h3>
  <!-- End Page Header -->
  <div class="row" >
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
  

</body>
</html>