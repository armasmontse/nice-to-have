@php

    use App\Models\Shop\Bag;
    use App\Models\Shop\BagDiscount;
    use App\Models\Shop\Discounts\DiscountCode;
    use App\Models\Shop\Discounts\DiscountCodeType;
    use App\Models\Events\Event;
    use Carbon\Carbon;

    use App\Models\Products\Product;

    $product = Product::find(1)->seo()->create([
        'route_name' => 'client.single.show'
    ]);

    dd($product);


@endphp
