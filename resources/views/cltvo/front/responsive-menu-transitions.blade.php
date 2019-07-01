@extends('layouts.client',  ['body_id' => 'shop-vue'])

@section('content')
<button @click.stop="toggleMenu('filters')">Filters</button>
<button @click.stop="toggleMenu('shop')">Shop</button>
<menu-mobile :menu="'main'" :is-open="store.menus.main.isOpen"></menu-mobile>

<menu-mobile 
	:menu="'filters'"
	:is-open="store.menus.filters.isOpen"
	opening-transition="slideRight"
	
	:types-by-id="types_by_id" 
	:subtypes-by-id="subtypes_by_id" 
	:subtype-ids-by-type-ids="subtype_ids_by_type_ids"
	:selected-subtypes.sync="selected_subtypes"
	:type-ids-by-subtype-ids="type_ids_by_subtype_ids"

	:categories-by-id="categories_by_id" 
	:subcategories-by-id="subcategories_by_id" 
	:subcategory-ids-by-category-ids="subcategory_ids_by_category_ids"
	:selected-subcategories.sync="selected_subcategories"
	:category-ids-by-subcategory-ids="category_ids_by_subcategory_ids"
	
	:price-range.sync="price_range"
	>	
</menu-mobile>
<menu-mobile 
	:menu="'shop'"
	:is-open="store.menus.shop.isOpen"
	opening-transition="slideRight"
	
	:types-by-id="types_by_id" 
	:subtypes-by-id="subtypes_by_id" 
	:subtype-ids-by-type-ids="subtype_ids_by_type_ids"
	:selected-subtypes.sync="selected_subtypes"
	:type-ids-by-subtype-ids="type_ids_by_subtype_ids"

	:categories-by-id="categories_by_id" 
	:subcategories-by-id="subcategories_by_id" 
	:subcategory-ids-by-category-ids="subcategory_ids_by_category_ids"
	:selected-subcategories.sync="selected_subcategories"
	:category-ids-by-subcategory-ids="category_ids_by_subcategory_ids"
	
	:price-range.sync="price_range"
	>	
</menu-mobile>
@include('client.menus.menu-mobile-template')
@endsection

@section('vue_store')
	@include('client.shop.partials.get-requests', [ 'subtypes'	=> 	[], 'subcategories'	=> 	[]])
@endsection
