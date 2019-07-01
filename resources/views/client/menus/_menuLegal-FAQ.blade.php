@foreach ($pages_footer as $page_footer)
	<span class="menu-footer__delimiter">
	    <a href="{{route('client::pages.show', $page_footer->index)}}" class="menu-footer__link">{{ $page_footer->label }}</a>
	</span>
@endforeach

<span class="menu-footer__delimiter">
    <a href="{{route('client::pages.show', 'nosotros#contacto')}}" class="menu-footer__link">Contacto</a>
</span>