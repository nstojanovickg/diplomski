<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>@yield('title'){{ Lang::get('general.APP_TITLE') }}</title>
	

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/style.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>-->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	{!! Html::script('js/additional.js') !!}
	@yield('styles')
	@yield('scripts')
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/dashboard">{{ Lang::get('general.APP_TITLE') }}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					@if (!Auth::guest())
						@foreach (session('myCredentials') as $key => $credentials)
							@if (count($credentials) > 1)
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Lang::get('general.'.$key) }} <span class="caret"></span></a>
									<ul class="dropdown-menu" role="menu">
							@endif
									@foreach ($credentials as $credential)
										@if(session('myPermissions')[$credential['path']]['read'] == 1)
											<li><a href="{{ url('/'.$credential['path']) }}">{{ Lang::get('general.'.$credential['title']) }}</a></li>
										@endif
									@endforeach
							@if (count($credentials) > 1)
									</ul>
								</li>
							@endif
						@endforeach
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">{{ Lang::get('general.LOGIN') }}</a></li>
						<li><a href="{{ url('/auth/register') }}">{{ Lang::get('general.REGISTER') }}</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->getName() }} <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li class="dropdown-submenu">
									<a tabindex="-1" href="#">{{ Lang::get('general.SET_LANGUAGE') }}</a>
									<ul class="dropdown-menu">
										@foreach (Misc::getLocales() as $key => $value)
											<li><a href="{{ url('/admin/locale/'.$key) }}">{{ $value }} <div class="{{ Session::get('lang') == $key ? 'set-language glyphicon glyphicon-ok' : '' }}"></div></a></li>
										@endforeach
									</ul>
								</li>
								
								<li><a href="{{ url('/auth/logout') }}">{{ Lang::get('general.LOGOUT') }}</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@include('flash::message')
	<div style="padding: 0 10px 10px 10px;">
		@yield('content')
	</div>
	

	<!-- Scripts -->
	
	<script>
		$('#flash-overlay-modal').modal();
		$('div.alert').not('alert-important').delay(3000).slideUp(300);
	</script>
</body>
</html>
