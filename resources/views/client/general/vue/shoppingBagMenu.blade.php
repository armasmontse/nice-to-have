<script type="x/templates" id="shopping-bag-menu-template">
    <div v-on:click.stop>
        <div  v-on:click="toggleMenu('shoppingBag')">
            <a id="shoppingBag__quantity">(@{{totalItemsInBags}})</a>
            Regalos
        </div>
        <div id="shoppingBagMenu" class="shoppingBagMenu" v-if="isOpen">
            @include('client.menus.shoppingBagMenu-links')
        </div>
    </div>
</script>
