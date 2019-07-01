<div class="checkout__input-container">
    @unless (empty($bag->bagBilling->status) )
        <div class="checkout__invoice-info-container">
            <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->status }}</span>
        </div>
    @endunless

    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->rfc }}</span>
    </div>
    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->razon_social }}</span>
    </div>
    @if ($bag->bagBilling->info)
        <div class="checkout__invoice-info-container">
            <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->info}}</span>
        </div>
    @endif

    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->email }}</span>
    </div>

    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->country->official_name }}</span>
    </div>

    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->state }}</span>
    </div>
    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->city }}</span>
    </div>

    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->zip }}</span>
    </div>

    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->street1 }}</span>
    </div>
    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->street2 }}</span>
    </div>
    <div class="checkout__invoice-info-container">
        <span class="checkout__text checkout__text-grey">{{ $bag->bagBilling->address->street3 }}</span>
    </div>
</div>

<div class="divisor"></div>
