<section class="shop__index">

	<div class="grid__container">
		<div class="grid__col-1-3" track-by="$index" v-for="product in filterableProducts" >
			<shop-product
				:name="product.title"
				:img_url="product.default_sku.thumbnail_image.url"
				:price="product.default_sku.price_with_discount"
				:link="store.is_event_shop ? product.event_shop_url :  product.client_url"
				:is_published="product.is_publish"
			></shop-product>
		</div>
		<div v-if="products.length === 0" class="grid__col-1-1 text-center">
			@include('client.general.loading-icon')
		</div>
	</div>
</section>
