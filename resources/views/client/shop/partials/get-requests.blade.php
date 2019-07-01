<script>

	mainVueStore.categories = mainVueStore.ajaxData({ get: '{{route('client::micro_services.categories.index')}}'})


	mainVueStore.types = mainVueStore.ajaxData({ get: '{{route('client::micro_services.types.index')}}'})

	mainVueStore.subcategories = mainVueStore.ajaxData({ get: '{{route('client::micro_services.subcategories.index')}}'})
	mainVueStore.subtypes = mainVueStore.ajaxData({ get: '{{route('client::micro_services.subtypes.index')}}'})
	mainVueStore.subtypes.selected = {!!json_encode($subtypes)!!}
	mainVueStore.subcategories.selected = {!!json_encode($subcategories)!!}
	mainVueStore.products = mainVueStore.ajaxData({ get: '{{route('client::shop.ajax.index')}}'})

</script>
