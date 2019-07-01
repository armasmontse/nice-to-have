<script type="x/templates"  id="shopping-bag-with-prices-template">
	<div>
		<div class="checkout__title-comtainer">
			@include('client.checkout.partials.item-total',[
				'total'	=> ""
			])
		</div>

		@include('client.checkout.partials.cart-items')

        <div class="checkout__title-container--xl">
            <span class="checkout__title">resumen de compra</span>
        </div>
		@include('client.shopping-cart.partials.bill')

		<div v-if="shipping.ocurre_force" class="cart__alert-container cart__text--label">
			{{ trans('checkout.page.ocurre_force') }}
		</div>
	</div>
</script>
