<script type="x/templates" id="shop-product-template">
	<div>
		<a :href="link" class="pointer" target="_blank">
			<div class="shop-product">
				<div class="shop-product__aspect-ratio-container">
					<div class="shop-product__no-image-container">
						<div class="shop-product__no-image no-image fa fa-eye"></div>
					</div>
					<div :style="{backgroundImage: img_url ? 'url('+ img_url + ')' : ''}" alt="" class="shop-product__image"></div>
				</div>
				<div class="shop-product__published-flag" v-if="!is_published">
					Borrador
				</div>
			</div>
			<div class="shop-product__info">
				<h3 class="shop-product__name shop-product__name--small">
					@{{name}}
				</h3>
				<p class="shop-product__price shop-product__price--small">
					@{{price | parseMoney}}
				</p>
			</div>
		</a>
	</div>
</script>
