<section id="shop-filters" v-if="store.categories.data && store.types.data">
	{{-- Rango de precio --}}

	<div class="shop__filter-group">
		<div class="divisor shop__divisor--sm"></div>
		<h3 class="shop__ttl shop__ttl--filter">Rango de Precio
			<span class="shop__ttl--filter-clear"@click="clearPriceFilter">X</span>
		</h3>
		<div class="shop__price-range-input-container">{{-- para que sirva el last-of-type de shop__checkbox-container --}}
			<input type="number" class="input shop__price-range-input" step="100" placeholder="desde MXN" v-model="price_range.from" min="0">
			<span class="shop__price-range-separator">–</span>
			<input type="number" class="input shop__price-range-input" step="100" placeholder="hasta MXN" v-model="price_range.to" min="0">
		</div>
		<div class="divisor shop__divisor--sm"></div>
	</div>

	@include('client.shop.partials.filters-vue-loops', ['title' => 'Tipo de Eventos', 'kind_singular' => 'type', 'kind_plural' => 'types'])


	@include('client.shop.partials.filters-vue-loops', ['title' => 'Categorías', 'kind_singular' => 'category', 'kind_plural' => 'categories'])


	<div class="shop__filter-group">
		<h2 class="shop__ttl shop__ttl--sidebar shop__ttl--sidebar-btn shop__ttl--small" @click="clearFilters">Ver Todo</h2>
		<div class="divisor shop__divisor"></div>
	</div>
</section>
<div v-else class="text-center">
	@include('client.general.loading-icon')
</div>
