<div class="single__submit-container">
	@if($event_close_bag)
		{{-- El ususario tiene un evento en proceso --}}
		@include('client.single.vue.forms.forms',  ['bag_slug' => 'retirar-mesa-de-regalos', 'bag_key' => $event_close_bag->key])
	@else 
		@foreach ($cookie_bags as $bag_slug => $bag_key)
			<div v-if="'{{$bag_slug}}' === bagSlug">
				@include('client.single.vue.forms.forms', ['bag_slug' => $bag_slug, 'bag_key' => $bag_key])
			</div>
		@endforeach
	@endif
</div>
