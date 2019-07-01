@for ($i = 0; $i < 3; $i++) {{-- $stock_movement->skus as $sku --}}

    <div class="checkout__cart-items-container">
        <span class="checkout__title-italic">(1) Maina Medallion {{-- ({{ $sku->pivot->quantity }}) {{  $sku->skuable->garment->translation()->name }} --}}</span>
        {{-- @if ($sku->skuable->color) --}}
            <p class="checkout__delimiter checkout__text checkout__text-subtitle">
                <span>color:</span>
                <span class="checkout__text">black {{-- {{$sku->skuable->color->translation()->name}} --}} </span>
            </p>
        {{-- @endif --}}
        {{-- @if ($sku->skuable->size) --}}
            <p class="checkout__delimiter checkout__text checkout__text-subtitle">
                <span>tamaño:</span>
                <span class="checkout__text">large {{-- {{$sku->skuable->size->translation()->name}} --}}</span>
            </p>
        {{-- @endif --}}
        <span class="checkout__text-price">$ 1,800.00 {{-- {{ $sku->pivot->quantity > 1 ? "(". $sku->pivot->quantity."x)" : "" }} $ {{ number_format( getPriceForSkuOrPivot($sku->pivot)/$stock_movement->salePayment->currency,2) }} {{ $stock_movement->salePayment->currency_type }} --}}</span>
        <span class="checkout__title">sku: #39036959</span>
    </div>

@endfor

<div class="divisor-checkout"></div>
