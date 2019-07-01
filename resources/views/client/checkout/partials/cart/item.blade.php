<div class="checkout__cart-items-container" >
	@if (is_page('admin::bags.show') && $bag_sku->product->provider )
		<span class="checkout__title checkout__title-sku"> Proveedor: {{ $bag_sku->product->provider->label }}</span>
		<br>
	@endif
    <span class="checkout__title-italic checkout__title-italic--small">({{ $bag_sku->pivot->quantity }}) {{ $bag_sku->product->title }} </span>
    <p class="checkout__text checkout__text--big checkout__text-subtitle">
        {{ ($bag_sku->description)  }}
    </p>
    <span class="checkout__text-price checkout__text-price--small">$ {{ number_format($bag_sku->pivot->quantity*($bag->is_active ? $bag_sku->price_with_discount : $bag_sku->pivot_price_with_discount) ,2) }} MXN</span>
    <span class="checkout__title checkout__title-sku">sku: #{{ $bag_sku->sku  }}</span>
</div>
