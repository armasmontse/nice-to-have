<div class="checkout__data-container">
    <div class="checkout__title-container">
        <span class="checkout__title">¿Tienes un código de descuento?</span>
    </div>
    <div class="checkout__input-container">
        {!! Form::text('discount_code', null, [
            'class'         => 'input checkout__input',
            'placeholder'   => 'Agrega tu código',
            'form'			=>  '',
            'id'			=> 'discount_code',
            'v-model'		=> 'discount_code',
            '@change' 		=> 'makePost("discountcodevalidation_form")',
            '@keydown.enter'=> 'makePost("discountcodevalidation_form")'
        ])!!}
        <span href="{{ route('client::bags.index') }}" class="checkout__link checkout__link-terms" v-if="discount_code" @click='makePost("discountcodevalidation_form")'>
            Validar código de descuento
        </span>
    </div>
</div>
