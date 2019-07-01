{{-- siguientes pantallas --}}
	{{-- Types --}}
<div v-if="selected_shop_submenu === 'types'" class="menuResponsive__screen" transition="slideRight">
	<div v-if="selected_type_id === -1" transition="fade">
		@include('client.menus.menu-mobile-header', ['name'	=> 	'Tipo de Evento', 'back_button'	=> 	true, 'reset_filters'	=> 	false])
		<h3 v-for="type in store.types.data"
			class="shop__ttl shop__ttl--filter"
			@click="selected_type_id = type.id"
		>
			@{{type.label}}
			<div class="menuResponsive__arrow-container">			
				{!! file_get_contents('images/menu-arrow-right.svg') !!}
			</div>
		</h3>
	</div>
</div>
	{{-- SubTypes --}}
<div v-if="selected_type_id > -1" class="menuResponsive__screen menuResponsive__screen2" transition="slideRight">
	@include('client.menus.menu-mobile-header--types', ['name'	=> 	'Tipo de Evento'])
	<div class="menuResponsive__container-padding">
		
		<label class="input__checkbox-label shop__checkbox-label--todos shop__checkbox-label"
			@click.self="toggleSelectionOnAllParentCheckboxes('type', 'types', selected_type_id)">
			todos
		</label>
	</div>
	<div 
		v-for="subtype in selectedType.subtypes"
		class="menuResponsive__container-padding"
	>

		<input
				:id="selectedType.label+'__'+subtype.label"
				type="checkbox"
				class="input__checkbox shop__checkbox"
				:value="subtype.id"
				v-model="selectedSubtypes"
			>
		<label
			:for="selectedType.label+'__'+subtype.label" 
			class="input__checkbox-label shop__checkbox-label">
			@{{subtype.label}}
		</label>
	</div>
</div>

	{{-- Categories --}}
<div v-if="selected_shop_submenu === 'categories'" class="menuResponsive__screen" transition="slideRight">
	<div v-if="selected_category_id === -1" transition="fade">
		@include('client.menus.menu-mobile-header', ['name'	=> 	'Categorías', 'back_button'	=> 	true, 'reset_filters'	=> 	false])
		<h3 v-for="category in store.categories.data"
			class="shop__ttl shop__ttl--filter"
			@click="selected_category_id = category.id"
		>
			@{{category.label}}
			<div class="menuResponsive__arrow-container">			
				{!! file_get_contents('images/menu-arrow-right.svg') !!}
			</div>
		</h3>
	</div>
</div>
	{{-- Subcategories --}}
<div v-if="selected_category_id > -1" class="menuResponsive__screen menuResponsive__screen2" transition="slideRight">
	@include('client.menus.menu-mobile-header--categories', ['name'	=> 	'Categorías'])
	<div class="menuResponsive__container-padding">
		<label class="input__checkbox-label shop__checkbox-label shop__checkbox-label"
				@click.self="toggleSelectionOnAllParentCheckboxes('category', 'categories', selected_category_id)">
				todos
		</label>
	</div>
	<div 
		v-for="subcategory in selectedCategory.subcategories"
		class="menuResponsive__container-padding"
	>
		<input
				type="checkbox"
				class="input__checkbox shop__checkbox"
				:id="selectedCategory.label+'__'+subcategory.label" 
				:value="subcategory.id"
				v-model="selectedSubcategories"
			>
		<label
			:for="selectedCategory.label+'__'+subcategory.label"
			class="input__checkbox-label shop__checkbox-label">
			@{{subcategory.label}}
		</label>
	</div>
</div>

<div v-if="selected_shop_submenu === 'price-range'" class="menuResponsive__screen" transition="slideRight">
	@include('client.menus.menu-mobile-header', ['name'	=> 	'Rango de Precios', 'back_button'	=> 	true, 'reset_filters'	=> 	false, 'reset_range_filters'	=> 	true])
	<div class="menuResponsive__container-padding">
		<div class="shop__price-range-input-container">{{-- para que sirva el last-of-type de shop__checkbox-container --}}
			<input type="number" class="input shop__price-range-input" step="100" placeholder="desde MXN" v-model="priceRange.from">
			<span class="shop__price-range-separator">–</span>
			<input type="number" class="input shop__price-range-input" step="100" placeholder="hasta MXN" v-model="priceRange.to">
		</div>
	</div>
</div>
