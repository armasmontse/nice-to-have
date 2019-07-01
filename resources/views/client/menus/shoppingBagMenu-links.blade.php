<div class="shoppingBagMenu__link-container">
    <a v-if="bag.total == 0" class="shoppingBagMenu__link" v-for="bag in printableBags">
        <span class="shoppingBagMenu__dash" v-if="$index > 0">_</span>
        (@{{bag.total}}) @{{bag.name.es}}
    </a>
    <a v-if="bag.total > 0" href="{{ route("client::bags.index") }}" class="shoppingBagMenu__link" v-for="bag in printableBags">
        <span class="shoppingBagMenu__dash" v-if="$index > 0">_</span>
        (@{{bag.total}}) @{{bag.name.es}}
    </a>
</div>
