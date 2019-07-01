<script type="x/templates" id="single-product-info-template">
<div class="grid__container--full-width single__container">

    <div class="grid__col-1-2 single__col-1-2 {{isset($special_col_left) ? $special_col_left : ''}}">
		<div v-if="isGift(selected_variant.sku)" class="shopping-cart__logo-regalado">
    		{!! file_get_contents('images/logo-regalado.svg')!!}
		</div>
		<div class="shopping-cart__box--single">
			<a :href="clientUrl">
				<div class="shopping-cart__bg-img" :style="{backgroundImage: selected_variant.image_url ?'url('+selected_variant.image_url+')' : ''}"></div>
			</a>
		</div>
	</div>

	<div class="grid__col-1-2 single__col-1-2 {{isset($special_col_right) ? $special_col_right : ''}}">
		<div class="single__info-box single__info-box--top">

            <h2 class="single__ttl single__ttl--sm"><a :href="clientUrl">@{{title}}</a></h2>

			<div class="single__container--sm">
				<div id="dropdown_select" class="single__select" v-if="variants.length > 1 && isWishlist">
					<p class="single__input-label single__input-label--pointer" v-on:click="dropdown_select_is_open = !dropdown_select_is_open">variaciones:
						{!!file_get_contents('images/flecha-select--flippable.svg')!!}
					</p>
					<ol class="single__select-container" v-bind:class="{ 'open': dropdown_select_is_open }">
						<li class="single__select-option" v-for="variant in variants" @click="selectVariant($index)">@{{variant.description}}</li>
					</ol>
					<p class="single__description--selected-variant truncate-single_JS" v-on:click="dropdown_select_is_open = !dropdown_select_is_open" v-text="selectedVariantWithIndex | truncate 120 '...'"></p>
				</div>
				<div class="shopping-cart__selected-variation" v-else>
					<p class="single__input-label single__input-label--pointer">
						variación
					</p>
					<p class="single__description--selected-variant truncate-single_JS" v-text="selectedVariantWithIndex | truncate 120 '...'"></p>
				</div>

		    		<div class="single__container--sm-cart">
					<div class="single__input-container mb0">
						<label for="quantity" class="single__input-label single__input-label--uppercase">Cantidad:</label>
						<input class="input single__input" type="number" placeholder="0" min="1" v-model="selected_quantity">
					</div>
					<div class="single__link-button single__link-button--update-quantity" v-if="selected_quantity !== quantity" @click="updateBag">Actualizar cantidad</div>
		    		</div>

		    		<div class=" single__price-container">
		    			<p class="single__price--label">precio:</p>
		    			<p class="single__price single__price--sm">@{{selected_variant.price | parseMoney}}</p>
		    		</div>

		    		<div class="single__price-container single__price-container--right">
		    			@if(! is_page('user::wishlist.index'))
			    			<p class="single__price--label">precio total:</p>
		    				<p class="single__price single__price--sm">@{{selected_variant.price * selected_quantity | parseMoney}}</p>
		    			@endif
		    		</div>

				<div v-bind:class="{
					'shopping-cart__buttons-container': !isWishlist,
					'shopping-cart__buttons-container--wishlist': isWishlist
				}">
			    		@include('client.single.vue.forms.shopping-bag--shopping-carts-variation')

			    		@include('client.single.vue.forms.add-to-wishlist')
				</div>
			</div>




		</div>
	</div>
	@include('client.single.vue.modals')
</div>
</script>
