<div class="grid__container--full-width single__container">
    <div class="grid__col-1-2 single__col-1-2 h-initial {{isset($special_col_left) ? $special_col_left : ''}}">
		<div class="shopping-cart__logo-regalado">
    		{!! file_get_contents('images/logo-regalado.svg')!!}
		</div>
		<div class="shopping-cart__box--single">
			<a href="{{ $sku->product->clientUrl }}">
				<div class="shopping-cart__bg-img shopping-cart__bg-img--full-height" style="background-image: url('{{ $sku->thumbnail_image->url }}')"></div>
			</a>
		</div>
	</div>

	<div class="grid__col-1-2 single__col-1-2 {{isset($special_col_right) ? $special_col_right : ''}}">
		<div class="single__info-box">

            <h2 class="single__ttl single__ttl--sm"><a href="{{ $sku->product->clientUrl }}">{{ $sku->product->title }}</a></h2>
			<div class="single__container--sm-cart">
				<p class="single__input-label mb0">Fecha de Regalo</p>
				<p class="single__input-label">{{ $bag->purshased_at->format('d/m/y') }}</p>
	    		</div>
			<div class="single__container--sm">
				<div class="shopping-cart__selected-variation">
					<p class="single__input-label single__input-label--pointer">
						variación
					</p>
					<p class="single__description--selected-variant truncate-single_JS">{{ $sku->description }}</p>
				</div>

{{-- Cantidad --}}
		    		<div class="single__container--sm-cart">
					<div class="single__input-container flex-cont--sb">
						<label for="quantity" class="single__input-label single__input-label--uppercase">Cantidad:</label>
						<span class="single__input-label">{{ $sku->pivot->quantity }}</span>
					</div>
		    		</div>

{{--Prices --}}
		    		<div class="single__price-container single__price-container--mb-sm">
		    			<p class="single__price--label">precio:</p>
		    			<p class="single__price single__price--sm">${{ number_format($sku->pivot->price * (1-$sku->pivot->discount/100), 2, '.', ',') }}</p>
		    		</div>

		    		<div class="single__price-container single__price-container--right single__price-container--mb-sm">
		    			@if(! is_page('user::wishlist.index'))
			    			<p class="single__price--label">precio total:</p>
		    				<p class="single__price single__price--sm">${{ number_format($sku->pivot->price * (1-$sku->pivot->discount/100) * $sku->pivot->quantity, 2, '.', ',') }}</p>
		    			@endif
		    		</div>
{{-- regalo de --}}
		    		<div class="single__container--sm-cart">
						<p class="single__input-label ttn">Regalo de:</p>
						<p class="single__input-label ttn mb0">{{ $bag->bagUser->name }}</p>
						<p class="single__input-label ttn">{{ $bag->bagUser->email }}</p>
						<p class="single__input-label ttn">{!! nl2br($bag->message)  !!}</p>
		    		</div>


			</div>
		</div>
	</div>
</div>
