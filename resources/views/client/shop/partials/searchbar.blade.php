<div id="shop__searchbar-container" class="shop__searchbar-container">
	<form role="form" method="get" action="{{ route('client::events.search') }}">
		{{-- {{ csrf_field() }} --}}

		<div class="login__input-container">
			<input id="search" type="text" class="input" placeholder="Busca un evento" name="s" value="{{''/* $search_words */}}" required autofocus>
		</div>
		
	</form>
</div>
