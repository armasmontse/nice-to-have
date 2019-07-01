<div class="row">
    @foreach ($photos_order as $photo_order)

        <div class=" {{ $photo_order["class"] }}  text-center" >
                <single-image
                    v-ref:{{$product_edit->id.'_details_'.$photo_order["order"]}}
                    :type="'product-photos'"
                    :current-image="{{ json_encode($product_edit->getFirstPhotoTo( [ "use" => 'details', "order" => $photo_order['order'] ] ))   }}"
                    :photoable-id="{{ $product_edit->id }}"
                    :photoable-type="'{{ $product_edit->getPhotoableCode() }}'"
                    :use="'details'"
                    :class="''"
                    :default-order="{{$photo_order["order"]}}"
                >
                </single-image>
        </div>
    @endforeach
</div>
