<style media="screen">
    .footer__social{ max-width: 400px; width: 100%; }
    .item-hide { display: none; }
    .menu_footer_link:hover .item-show { display: none; }
    .menu_footer_link:hover .item-hide { display: inline; }
</style>

<nav class="footer__social menu-social">
    <a href="{{ isset($social_networks['facebook']) ? $social_networks['facebook'] : '#' }}" target="_blank" class="menu-social__link {{ isset($social_networks['facebook']) ? '' : 'menu_footer_link' }}">
        <span class="item-show">facebook</span>
        <span class="item-hide">próximamente</span>
    </a>
    <a href="{{ isset($social_networks['instagram']) ? $social_networks['instagram'] : '#' }}" target="_blank" class="menu-social__link {{ isset($social_networks['instagram']) ? '' : 'menu_footer_link' }}">
        <span class="item-show">instagram</span>
        <span class="item-hide">próximamente</span>
    </a>
    <a href="{{ isset($blog['url']) ? $blog['url'] : '#' }}" target="_blank" class="menu-social__link {{ isset($blog['url']) ? '' : 'menu_footer_link'}}">
        <span class="item-show">blog</span>
        <span class="item-hide">próximamente</span>
    </a>
</nav>