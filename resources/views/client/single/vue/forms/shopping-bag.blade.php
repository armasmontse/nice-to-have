<div class="single__submit-container">
	@if($event_close_bag)
		{{-- El ususario tiene un evento en proceso --}}
		@include('client.single.vue.forms.forms',  ['bag_slug' => 'retirar-mesa-de-regalos', 'bag_key' => $event_close_bag->key])
	@else 
		{{-- Comprando para personal o para agregar a mesa de regalos --}}
		@foreach ($cookie_bags as $bag_slug => $bag_key)
			@if($bag_slug == 'agregar-a-mesa-de-regalos' && $is_event_shop || $bag_slug == 'personal' && !$is_event_shop)
				@include('client.single.vue.forms.forms',  ['bag_slug' => $bag_slug, 'bag_key' => $bag_key])
			@endif
		@endforeach
	@endif
</div>
