<header id="header" class="header" @if (isset($event)) style="margin-bottom: 0;" @endif>
	@include('client.menus._menuTop')
	@if (!isset($event))
		<div class="header__logo-container">
			<div id="header__logo" class="header__logo">
				<a href="{{ route("client::pages.index") }}">
					{!! file_get_contents('images/NTHLogoNegro.svg') !!}
				</a>
			</div>
		</div>
		@include('client.menus._menuMain')
	@endif
</header>
