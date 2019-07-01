<script type="x/templates" id="user-account-menu-template">
    <div v-on:click.stop>
        <div v-on:click.stop="toggleMenu('userAccount')" style="
    padding-right: 32px;">
            Mi cuenta
            {!! file_get_contents('images/flecha-select--flippable.svg') !!}
        </div>
        <div id="userAccountMenu" class="userAccountMenu" v-if="isOpen">
            @include('client.menus.userAccountMenu-links')
        </div>
    </div>
</script>
