@foreach ($discount_codes as $discount_code)
	@foreach ($discount_code->bags()->get() as $bag)
		{{ dump('Discount Code = ' . $discount_code->id . ', Bag Id = ' . $bag->id . ', Bag Amount = ' . $bag->pivot->amount) }}
	@endforeach
@endforeach