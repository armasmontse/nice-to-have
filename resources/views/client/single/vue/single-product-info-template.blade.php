<script type="x/templates" id="single-product-info-template">
	<div class="grid__container single__container">
		<div class="grid__col-1-2 single__col-1-2--info single__col-1-2--image">
			<img :src="selected_variant.image_url" alt="">
		</div>
		<div class="grid__col-1-2 single__col-1-2--info">
			<div class="single__info-box">
				<h2 class="single__ttl single__ttl--small">@{{title}}</h2>
				<p class="single__price single__price--small">@{{selected_variant.price | parseMoney}}</p>
				<p class="single__description single__description--small">@{{{mainDescription}}}</p>
				<div class="single__container--sm single__container--info-favorites-buttons-container">
					<span class="input__submit" @click="goToInfoSections">Más info</span>
{{-- Wishlist --}}
					@include('client.single.vue.forms.add-to-wishlist')
				</div>

				<div class="single__container--sm"
					v-on:mouseleave="closeOnMouseout"{{-- hace un debounce por UX, por eso lo metemos en un método --}}
					v-on:mouseenter="cancelClose"
				>
						<div v-if="variants.length > 1" id="dropdown_select" class="single__select">
							<p class="single__input-label single__input-label--pointer single__input-label--small"
								v-on:click="dropdown_select_is_open = !dropdown_select_is_open"
							>
								Variaciones:
								{!!file_get_contents('images/flecha-select--flippable.svg')!!}
							</p>
							<ol class="single__select-container" v-bind:class="{ 'open': dropdown_select_is_open }">
								<li class="single__select-option" v-for="variant in variants" @click="selectVariant($index)">@{{variant.description}}</li>
							</ol>
							<p class="single__description--selected-variant truncate-single_JS" 		v-on:click="dropdown_select_is_open = !dropdown_select_is_open" 	v-text="selectedVariantWithIndex | truncate 120 '...'"></p>
						</div>
						<div class="single-select" v-else>
							<p class="single__input-label single__input-label--pointer" style="display:none;">Variación</p>
							<p class="single__description--selected-variant truncate-single_JS" v-text="selectedVariantWithIndex | truncate 120 '...'" style="cursor:default;"></p>
						</div>

						<div class="single__input-container">
							<label for="quantity" class="single__input-label">Cantidad:</label>
							<input class="input single__input" type="number" placeholder="0" min="1" v-model="selected_quantity" min="1">
						</div>
{{-- Forma --}}
						@include('client.single.vue.forms.shopping-bag')
				</div>
			</div>
			<div class="single__logo-regalado" style="display: none;">
				{!! file_get_contents('images/logo-regalado.svg') !!}
			</div>
		</div>

{{-- Modales --}}
		@include('client.single.vue.modals')
	</div>
</script>
