<!DOCTYPE html>
<html>
    <head>
        <title>UoS³{{ isset($title) ? " -- ".$title : '' }}</title>
        <link rel="stylesheet" href="{{ elixir("css/app.css") }}">
	<link href="https://fonts.googleapis.com/css?family=Coda|Raleway:400,400i,700" rel="stylesheet">
	<meta name="robots" content="noindex">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body class="">
      <nav class="navbar navbar-default navbar-static-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand logo" href="/"><img src="/img/uos3.png">
          <div>Data<br />Storage</div></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <p class="navbar-text navbar-right">

            </p>
            <ul class="nav navbar-nav navbar-right">
              <li><a class="active" href="/satellite-info">Satellite info</a></li>
              <li><a href="/collected-data">Collected data</a></li>
              <li><a href="/leaderboard">Leaderboard</a></li>
              <li><a href="http://uos3.space">About UoS<sup>3</sup></a></li>
              @if (Auth::check())
                @if (Auth::user()->name == '')
                  <?php $usermenu_label=Auth::user()->email ?>
                @else
                  <?php $usermenu_label=Auth::user()->name ?>
                @endif
                <li class="dropdown">
                  <a href="/Profile" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $usermenu_label }} <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <li><a href="/profile">Profile</a></li>
                    <li><a href="/logout">Log out</a></li>
                  </ul>
                </li>
              @else
                    <li><a href="/login" class="login-link">Log in</a></li>
              @endif
            </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="l-wrapper">
			@if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
           	@elseif (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

    		@yield('content')
    </div>
    <footer class="footer">
		    <p>© 2016 UoS³. All Rights Reserved.</p>
		</footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
