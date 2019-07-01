 <!-- JavaScripts -->
 <!-- Note: jQuery is on the head -->
 <!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->
 <script type="text/javascript" src="/js/vue-html5-editor.js"></script>
 @yield('conekta_script')
 <script type="text/javascript">

 // robado de http://stackoverflow.com/questions/7131909/facebook-callback-appends-to-return-url para quitar el #_=_ que ponde facebook despues del login 
    if (window.location.hash && window.location.hash == '#_=_') {
        if (window.history && history.pushState) {
            window.history.pushState("", document.title, window.location.pathname);
        } else {
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop,
                left: document.body.scrollLeft
            };
            window.location.hash = '';
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }
    }
</script>

<script>
var mainVueStore = {

	ajaxData: function(routes_obj) {
{{--/**
	 * Predefine los campos necesarios para hacer un llamado get, y permite guardar otras rutas útiles para ajax.
	 *
	 * El objeto routes_obj debe verse de este modo:
	 * 			 { get: '{{route('client::shop.ajax.index')}}'}
	 * Esto permite introducir una ruta get cuya petición se hará automáticamente en el momento se crea la instancia del mainVue.
	 * @param  {[type]} routes_obj 	debe determinar campos como get, post, etc. cuyo valor es una URL
	 * @return {Object} 			Dos propiedades. La más importante es "data" el cual preinicializa dicho campo para recibir el resultado del get y funcionar reactivamente. El otro es el objeto de rutas que se le ha pasado a la función.
	 */--}}
		return {
			data: undefined,
			routes: routes_obj
		}
	},
	carts: [
		{
			title: 'Comprar para mi',
			total_items: 7,
			cart_url: '#hey',
			content: 'Compras que fueron seleccionadas como personales que se enviarán a tu dirección de envío'
		},
		{
			title: 'Comprar y regalar',
			total_items: 0,
			cart_url: '#youy',
			content: 'Decidiste hacer un regalo. Se deberá hacer un checkout por dirección de envío'
		},
		{
			title: 'Comprar para mesa de regalos',
			total_items: 11,
			cart_url: '#tetra',
			content: 'Seleccionaste uno o varios regalos para enviar a los festejados'
		}
	],
	bag_key: '0000000000',
	bag: [],
    	bags: {!! json_encode($content_bags)   !!},
    	bag_keys: {!!$event_close_bag ? '{"retirar-mesa-de-regalos": "'.$event_close_bag->key.'"}' :  json_encode($cookie_bags) !!} ,//se usa en las formas del single-product para manejar hacia dónde se manda el post (cuando el usuario tiene un evento sin cerrar o cuando no)
	is_shop_close : {!! json_encode($event_close_bag ? true : false )   !!},
    	current_event: {!! json_encode($cookie_event)  !!},
	currency: 'MXN',
	exchange_rate: 1,
	iva: 16,
	current_language: '{{$current_lang_iso}}',
	languages: '{!!json_encode($languages)!!}',
  	products_in_wishlist: {!! ($user ? json_encode($user->wishlist_products_ids) : json_encode([]) )!!},
};
</script>
{{-- Inicializa la variable del store que se usará en el yield --}}
@yield('vue_store'){{-- debe estar antes del admin functions --}}

{!! Html::script('js/functions.js') !!}
