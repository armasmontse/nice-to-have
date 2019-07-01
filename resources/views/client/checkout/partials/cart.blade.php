<div class="checkout__title-container">
    <p class="checkout__title" {{-- v-if="total_garment_quantity == 1" --}}>
        resumen del pedido con ({{ $bag->bag_totals["items"]  }}) {{$bag->bag_totals["items"] == 1 ? "artículo" : "artículos"}}
    </p>

</div>

@foreach ($bag->skus as $bag_sku)
    @include('client.checkout.partials.cart.item')
@endforeach


<div class="divisor-checkout"></div>
