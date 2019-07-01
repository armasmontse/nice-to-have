<footer class="footer">
    <div class="grid__row">
        <div class="grid__container">
            <div class="footer__container" @if (isset($event)) style="max-width: 824px; width: 100%;" @endif>
                <div class="footer__logo-container">
                    <a href="{{ route("client::pages.index") }}">
                        {!! file_get_contents('images/NTHLogoBlanco.svg')!!}
                    </a>
                </div>

                <div class="footer__menus-container">

                   @include('client.menus._menuFooter')

                    <nav class="footer__help menu-footer">
                        @if (isset($event))
                            <span class="menu-footer__delimiter">
                                <a href="#" class="menu-footer__link">
                                    <span class="menu-footer__link-create">crear un evento</span>
                                    <span class="menu-footer__link-coming-soon">próximamente</span>
                                </a>
                            </span>

                            <span class="menu-footer__delimiter">
                                <a href="#" class="menu-footer__link">carrito</a>
                            </span>
                        @endif
                        @include('client.menus._menuLegal-FAQ')
                    </nav>
                </div>

                <div class="footer__info-container">
                    <span class="footer__text">Diseño: <a href="#" class="footer__link">Cardumen | 467</a></span>
                    <span class="footer__text">Programación: <a href="http://www.elcultivo.mx/" target="_blank" class="footer__link">El Cultivo</a></span>
                </div>
            </div>
        </div>
    </div>
</footer>
