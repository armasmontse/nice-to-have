<!DOCTYPE html>
<html>
    <head>
		<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

			<title>{{ env("APPNOMBRE") }} | @yield('title') </title>

			<!-- Fonts -->
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
			<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{asset('images/favicon/apple-touch-icon-57x57.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/favicon/apple-touch-icon-114x114.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/favicon/apple-touch-icon-72x72.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/favicon/apple-touch-icon-144x144.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{asset('images/favicon/apple-touch-icon-60x60.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{asset('images/favicon/apple-touch-icon-120x120.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{asset('images/favicon/apple-touch-icon-76x76.png')}}" />
			<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{asset('images/favicon/apple-touch-icon-152x152.png')}}" />
			<link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-196x196.png')}}" sizes="196x196" />
			<link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-96x96.png')}}" sizes="96x96" />
			<link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-32x32.png')}}" sizes="32x32" />
			<link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-16x16.png')}}" sizes="16x16" />
			<link rel="icon" type="image/png" href="{{asset('images/favicon/favicon-128.png')}}" sizes="128x128" />
			<meta name="application-name" content="&nbsp;"/>
			<meta name="msapplication-TileColor" content="#FFFFFF" />
			<meta name="msapplication-TileImage" content="{{asset('images/favicon/mstile-144x144.png')}}" />
			<meta name="msapplication-square70x70logo" content="{{asset('images/favicon/mstile-70x70.png')}}" />
			<meta name="msapplication-square150x150logo" content="{{asset('images/favicon/mstile-150x150.png')}}" />
			<meta name="msapplication-wide310x150logo" content="{{asset('images/favicon/mstile-310x150.png')}}" />
			<meta name="msapplication-square310x310logo" content="{{asset('images/favicon/mstile-310x310.png')}}" />
			<link media="all" type="text/css" rel="stylesheet" href="{{asset('css/mazorca.css')}}">
			<script>window.jQuery || document.write('<script src="{{asset('js/jquery.js')}}"><\/script>')</script>
		</head>
        <!-- Styles -->
        <style>
            html, body{
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                overflow: hidden;
                display: table;
            }

            .splash {
                width: calc(100% - 35px);
                max-width: 411px;
                height: 100%;
                margin: 0 auto;
				position: relative;
				top: 0ṕx;
                background-image: url({{ asset('images/NTHLogoNegro.svg') }});
                background-position: center;
                background-repeat: no-repeat;
                -webkit-background-size: 100%;
                -moz-background-size: 100%;
                -o-background-size: 100%;
                background-size: 100%;
            }

            .splash__pleca {
                width: 100%;
                height: 30px;
                background-color: #231F20;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
            }

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.message {
				font-size: 36px;
				margin-bottom: 40px;
				color: #ffffff;
			}

        </style>
    </head>

    <body>
		<header id="header" class="header" >

	 	   <style media="screen">
	 	   .menuTop__searchbar .coming_soon { display: none; }
	 	   .menuTop__searchbar:hover .item { display: none; }
	 	   .menuTop__searchbar:hover .coming_soon { display: inline; }
	 	   </style>

	 	   <nav id="menuTop" class="menuTop">
	 		   <div class="grid__row">
	 			   <div class="grid__container menuTop__container">
	 				   <div class="menuTop__col menuTop__col--left menuTop__col--hamburger">
	 					   <span @click.stop="toggleMenu('main')" v-if="store.menus.filters.isOpen === false && store.menus.shop.isOpen === false">
	 						   &#9776;
	 					   </span>
	 				   </div>
	 			   </div>
	 		   </div>
	 	   </nav>

	 	   <div class="header__logo-container">
			   <a id="header__logo" href="{{ route("client::pages.index") }}" class="header__logo">
				   {!! file_get_contents('images/NTHLogoNegro.svg') !!}
		   		</a>
	 	   </div>
		   @unless (isset($not_nav) &&  !$not_nav)
			   @include('client.menus._menuMain')
		   @endunless
	    </header>
		<section>
			<div class="not-found__container not-found__container--up">
				<h2 class="shop__ttl not-found--ttl">@yield('error')</h2>
			</div>
			<div class="not-found__container">
				<h2 class="shop__ttl not-found--p">@yield('description')</h2>
			</div>
		</section>

		<footer class="footer" style="min-height: {{ isset($not_nav) &&  !$not_nav ? '100px;' : '140px;'}} ">
			<div class="grid__row">
				<div class="grid__container">
					<div class="footer__container" >
						@unless (isset($not_nav) &&  !$not_nav)
							@include('client.menus._menuFooter')
						@endunless
						<div class="footer__info-container">
							<span class="footer__text">Diseño: <a href="#" class="footer__link">Cardumen | 426</a></span>
							<span class="footer__text">Programación: <a href="http://www.elcultivo.mx/" target="_blank" class="footer__link">El Cultivo</a></span>
						</div>
					</div>
				</div>
			</div>
		</footer>

    </body>
</html>
