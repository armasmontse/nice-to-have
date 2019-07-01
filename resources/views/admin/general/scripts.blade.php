 <script>
 	@if(env('APP__DEBUG'))
 		var process = { env: {NODE_ENV: 'dev'}}
 	@endif
 </script>
 <!-- Note: jQuery is on the head -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>

 <!-- JavaScripts -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<script type="text/javascript" src="/js/vue-html5-editor.js"></script>

 <!--Summernote -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.1/summernote.js"></script>

 <!-- Data Tables -->
 <script type="text/javascript" src="https://cdn.datatables.net/u/dt/dt-1.10.12/datatables.min.js"></script>
 {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jq-2.2.3/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script> <!-- Data Tables Bootstrap Js --> --}}
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>

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

	bag_key: '0000000000',
	bag: [],
	currency: 'MXN',
	exchange_rate: 1,
	iva: 16,
	current_language: '{{$current_lang_iso}}',
	languages: '{!!json_encode($languages)!!}',
	media_manager: {
		routes: {
			index: '{{route('admin::photos.ajax.index')}}',
			edit: '{{route('admin::photos.ajax.edit',"__image.id__")}}'
		}
	}
};


 {{--
mainVueStore.bag_key = '{!! $bag_key !!}';
mainVueStore.bag = {!! $bag !!};
mainVueStore.currency = '{!! $currency !!}';
mainVueStore.exchange_rate = {!! $exchange_rate !!};
mainVueStore.iva = 16;
  --}}
</script>

@yield('vue_store'){{-- debe estar antes del admin functions --}}

 {{-- @if($asset_versioning) --}}
	 {{-- {!! Html::script(elixir('js/admin-functions.js')) !!} --}}
 {{-- @else --}}
	 {!! Html::script('js/admin-functions.js') !!}
 {{-- @endif --}}
