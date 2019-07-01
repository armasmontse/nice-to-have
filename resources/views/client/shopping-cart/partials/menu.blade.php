<div class="shopping-cart__menu">
    <div class="shopping-cart__link-menu-container">
        @foreach ($menu_items as $item)
            <a v-if="store.bags['{{$item["slug"]}}'].total == 0" class="shopping-cart__link-menu {{ $item["active"] ? "selected" : ""   }} ">
                {{ $item["label"] }}
                <span id="shopping-cart__quantity">(&#123;&#123; store.bags['{{$item["slug"]}}'].total &#125;&#125;)</span>
            </a>
            <a v-if="store.bags['{{$item["slug"]}}'].total > 0" href="{{ $item["url"] }}" class="shopping-cart__link-menu {{ $item["active"] ? "selected" : ""   }} "> {{--route( "client::bags.index" )--}}
                {{ $item["label"] }}
                <span id="shopping-cart__quantity">(&#123;&#123; store.bags['{{$item["slug"]}}'].total &#125;&#125;)</span>
            </a>
        @endforeach
    </div>
    <div class="divisor"></div>
</div>
