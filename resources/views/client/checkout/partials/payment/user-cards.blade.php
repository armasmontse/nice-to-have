@unless ( empty($cards))

    @foreach ($cards as $card)
        <div class="input__radio-container" v-if="!new_card">
            <label for="card_id-{{$card->id}}" class="input__radio-label">
                {!! Form::radio('card_id',$card->id,null, [
                    'class'  =>  'input__radio',
                    'id'     =>  'card_id-'.$card->id,
                    'form'   => 'checkout_form',
                    'name'    =>     'card_id',
                    'v-model'           =>  'store.creditCardDetails.card_id',
                    'v-bind:required'   =>  '!new_card'
                    ]) !!}

                    {{$card->display_number}}
            </label>
        </div>
    @endforeach

@endunless
