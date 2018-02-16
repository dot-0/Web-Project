<!DOCTYPE HTML>
<html>
  <head>
    <title>Shurodhwani</title>
    <link rel='stylesheet prefetch' href="{{URL::asset('http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{URL::asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css')}}" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="{{URL::asset('https://fonts.googleapis.com/css?family=Lato:100,300,400,700')}}">
    <link rel="stylesheet" href="{{URL::asset('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css')}}" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('/bootstrap-select-1.12.2/dist/css/bootstrap-select.css') }}">
    <link href="{{URL::asset('css/select2.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/select2-bootstrap.min.css')}}" rel="stylesheet"> {{--
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{URL::asset('css/bootstrap.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{URL::asset('//fonts.googleapis.com/css?family=Open+Sans:700,700italic,800,300,300italic,400italic,400,600,600italic')}}" rel='stylesheet' type='text/css'>
    <link href="{{URL::asset('css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{URL::asset('css/vote.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{URL::asset('css/MP_style.css')}}" rel='stylesheet' type='text/css' />
    <script src="{{URL::asset('js/jquery.min.js')}}">
    </script>
    <script type="text/javascript" src="{{URL::asset('js/move-top.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('js/easing.js')}}"></script>
    <script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
    function hideURLbar() { window.scrollTo(0, 1); }
    </script>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
    $(".scroll").click(function(event) {
    event.preventDefault();
    $('html,body').animate({ scrollTop: $(this.hash).offset().top }, 900);
    });
    });
    </script>
    <script src="{{URL::asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js')}}" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="{{URL::asset('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js')}}" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    {{--
    <script src="{{ elixir('js/app.js') }}"></script> --}}
    <link href="{{URL::asset('css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{URL::asset('css/icon-font.css')}}" rel="stylesheet">
    <script src="{{asset('js/jquery-2.1.4.js')}}"></script>
  </head>
  <style>
  body {
  background-color: #f1f1f1;
  background-size: 1370px 640px;
  background-repeat: no-repeat;
  }
  </style>
  
  <body  class="sticky-header left-side-collapsed">
    
    <section>
      <div class="left-side sticky-left-side">
        <div class="logo">
          <h1><a href="/">Shuro<span>dhwani</span></a></h1>
        </div>
        <div class="logo-icon text-center">
          <a href="/">S </a>
        </div>
        <div class="hugeGap"></div>
        <div class="left-side-inner">
          <ul class="nav nav-pills nav-stacked custom-nav">
            
            <li><a href="/allArtists"><i class="lnr lnr-users"></i> <span>Artists</span></a></li>
            <li><a href="/albumList"><i class="lnr lnr-music-note"></i> <span>Albums</span></a></li>
            <li><a href="/allTags"><i class="lnr lnr-tag"></i> <span>Genres</span></a></li>
            @guest
            @else
            <li><a href="/showFavourites/{{Auth::user()->id}}"><i class="lnr lnr-heart"></i>  <span>My Favourities</span></a></li>
            <li><a href="/showPersonalList/{{Auth::user()->id}}"><i class="lnr lnr-film-play"></i>  <span>My Playlists</span></a></li>
            @endguest
          </ul>
        </div>
      </div>
    </section>
    <div class="header-section">
      
      <a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
      <div class="clearfix"></div>
      
      <div class="search_box_div">
        {!! Form::open(
        array(
        'method'=>'POST',
        'action' => 'SearchController@showSearchResult',
        'novalidate' => 'novalidate',
        'files' => true)) !!}
        <input id="key" class="search_box" type="search" name="id">
        {!! Form::close() !!}
      </div>
      
      <div class="login_div">
        @guest
        
        <div class="Loginbutton">
          <a href="{{ route('login') }}">Login</a>
        </div>
        <li>
          <a class="loggedInUserID" href="/rankList">Topchart</a>
        </li>
        
        @else
        
        <li>
          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img src="{{asset('images/logout_icon.png')}}" class="logoutText"></a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
        <li>
          <a class="loggedInUserID" href="/user/{{Auth::user()->id}}">{{ Auth::user()->name }}</a>
          <div class="profilePicRoundDiv"><a href="/user/{{Auth::user()->id}}"><img src="{{asset('').Auth::user()->profilePic}}" class="profilePicRound"></a></div>
        </li>
        
        <li>
          <a href="/upload"><img src="{{asset('images/upload_icon.png')}}" class="uploadIcon"></a>
        </li>
        <li>
          <a class="loggedInUserID" href="/rankList">Topchart</a>
        </li>
        
        
        @endguest
      </div>
      
    </div>

      <div class="mainContainer"><div>@yield('content')</div></div>
    
    <footer class="footer_div">
      <p class="footer_CR">&copy; Osprishyo. All Rights Reserved</p>
      <div class="footer_MU"><i class="glyphicon glyphicon-earphone"></i>Call : 01XXXXXXXXX&nbsp &nbsp &nbsp &nbsp<i class="glyphicon glyphicon-envelope"></i> Mail : abc@gmail.com</div>
    </footer>
    <script type="text/javascript" src="{{asset('/bootstrap-select-1.12.2/dist/js/bootstrap-select.js')}}"></script>
    <script type="text/javascript" src="{{asset('/bootstrap-select-1.12.2/dist/js/bootstrap-select.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script type="text/javascript">
    $(".select2-selection--multiple").select2();
    </script>
    <script>
    $(document).ready(function () {
    $('.selectpicker').selectpicker();
    });
    </script>
    <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('js/scripts.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset('js/classie.js')}}"></script>
    <!-- <script src="{{asset('js/uisearch.js')}}"></script> -->
    <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <!--<script>
    new UISearch( document.getElementById( 'sb-search' ) );
    </script>-->
  </body>
</html>