{{-- Este template se usa con dos componentes de Vue ligeramente distintos
	1. shoppingBagWithPrices
	2. shoppingBagForCheckout
	Por ello la manera en la que se derivan los valore de sus propiedades son distintos
 --}}
<div class="shopping-cart__bill-container">
    <span class="shopping-cart__text">subtotal:</span>
    <span class="shopping-cart__text">@{{subtotal | parseMoney}} @{{currency}} </span>
</div>

<div class="shopping-cart__bill-container">
    <span class="shopping-cart__text">i.v.a.</span>
    <span class="shopping-cart__text">@{{iva_price | parseMoney}} @{{currency}}</span>
</div>

<div class="shopping-cart__bill-container" v-if="!isShoppingBag && !isEvent" >
    <span class="shopping-cart__text">costo de envío:</span>
    <span class="shopping-cart__text">@{{shipping_costs | parseMoney}} @{{currency}}</span>
</div>

<div class="shopping-cart__bill-container" v-if="friendly_card_price !== undefined && friendly_card_price !== null && friendlyMessageCard === true && isEvent === true" >
    <span class="shopping-cart__text">Tarjeta Impresa:</span>
    <span class="shopping-cart__text">@{{friendly_card_price | parseMoney}} @{{currency}}</span>
</div>

<div v-if="discountInfo && discountInfo.type" class="shopping-cart__bill-container">
    <span class="shopping-cart__text">Código de descuento:</span>
    <span class="shopping-cart__text">@{{ discount | parseMoney }} @{{ currency }}</span>
</div>

<div class="shopping-cart__bill-container">
    <span class="shopping-cart__text">total:</span>
    <span class="shopping-cart__text">@{{order_total | parseMoney}} @{{currency}}</span>
</div>
