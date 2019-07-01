<section class="shop__event-info" v-if="store.is_event_shop">
	<div>
		<h3 class="shop__ttl--serif--sm">{{$cookie_event->name }}</h3>
		<p class="shop__ttl--serif--sm">No: <span style="text-transform: uppercase;">{{  $cookie_event->key }}</span></p>
		@if ($cookie_event->template_is_publish)
			<div class="shop__submit-container">
				<a href="{{ $cookie_event->public_url }}" class="input__submit input__submit--black shop__submit">Ver página del evento</a>
			</div>
		@endif
	</div>
	<a href="{{route('client::events.search')}}" class="shop__link-button">Buscar otro evento</a>
</section>
