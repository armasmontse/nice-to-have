import R from 'ramda';
import qs from 'qs';
import {menuTreeToggler} from '../../menu-tree-toggler';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';

import {idsByParentIds,
		objsById,
		nestedPropToUpperLevel,
		doubleMapNestedAndReturnInUpperLevel,
		additiveFilter,
		rangeFilter,
		orderAscending
	} from '../../functions/pure';


export const shop = {
	mixins: [shoppingBagDataAndComputedProps],
	data: {
		is_special_event: false,
		location: '',
		selected_subcategories: [],
		selected_subtypes: [],
		categories:{},
		types:{},
		subcategory_ids_by_category_ids: {},
		category_ids_by_subcategory_ids: {},
		subtype_ids_by_type_ids: {},
		type_ids_by_subtype_ids: {},
		categories_by_id: {},
		categories_by_order: {},
		categories_by_name: {},
		subcategories_by_id: {},
		types_by_id: {},
		types_by_order: {},
		subtypes_by_id: {},
		price_range: {
			from: '',
			to: ''
		},
	},

	computed: {
		filterableProducts() {
			let initalizePrice = R.compose(
				n => parseInt(n, 10),
				n => n === "" ? 0 : n
			)
			return R.compose(//registra filtros
				rangeFilter(['price'], [initalizePrice(this.price_range.from), initalizePrice(this.price_range.to)]),
				additiveFilter(['subtypes_ids'], this.selected_subtypes),
				additiveFilter(['subcategories_ids'], this.selected_subcategories))(this.products || []);
		},

		products() {
			return	R.map(nestedPropToUpperLevel(['default_sku', 'price_with_discount'], 'price'))(this.store.products.data || []);
		}
	},

	ready() {
		this.is_special_event = this.store.current_event !== null ? true : false;
		this.selected_subcategories = this.store.subcategories.selected;
		this.selected_subtypes = this.store.subtypes.selected;
		this.location  = window.location.pathname;
		this.createQueryString();
	},

	methods: {
		toggleSelectionOnAllParentCheckboxes(kind, kind_plural, kind_id) {
			let sub_ids = R.pathOr([], [`sub${kind}_ids_by_${kind}_ids`, kind_id], this),
				selected = this[`selected_sub${kind_plural}`] || [],
				all_are_selected = R.intersection(sub_ids, selected).length === sub_ids.length;

			if (all_are_selected) {
				this[`selected_sub${kind_plural}`] = R.without(sub_ids, selected)
			} else {
				this[`selected_sub${kind_plural}`] = R.uniq(R.concat(sub_ids, selected))
			}
		},

		clearFilters() {
			if (!this.store.is_event_shop) {
				this.selected_subtypes = [];
			}
			this.selected_subcategories = [];	
			this.price_range = {from: '', to: ''}
		},

		clearPriceFilter() {
			this.price_range = {from: '', to: ''}	
		},

		createQueryString() {
			let querystring = qs.stringify({ subcategories: this.selected_subcategories, subtypes: this.selected_subtypes }, { arrayFormat: 'brackets' , encode: false})
			if(querystring !== '') {
				history.replaceState({}, '', this.location+'?'+querystring)
			} else {
				history.replaceState({}, '', this.location)
			}
		}
	},

	watch: {
		'store.categories.data': function() {
			// Seteamos las categorias en un objeto (que las refiere por nombre) para que puedan recibir los ids de las subcategorias correspondientes
			let category_names = R.map(cat => cat.slug.replace(/-/g,'_'), this.store.categories.data)
			R.forEach(cat => this.$set('categories.'+cat, []), category_names)

			this.categories_by_id = objsById('id', this.store.categories.data);
			this.categories_by_order = objsById('order', this.store.categories.data);
			this.$nextTick(() => menuTreeToggler('.toplevel_JS', '.sublevel_JS', '.select-arrow_JS'));
		},
		'store.types.data': function() {
			// Seteamos las categorias en un objeto (que las refiere por nombre) para que puedan recibir los ids de las subcategorias correspondientes
			let type_names = R.map(type => type.slug.replace(/-/g,'_'), this.store.types.data)
			R.forEach(type => this.$set('types.'+ type, []), type_names)

			this.types_by_id = objsById('id', this.store.types.data);
			this.types_by_order = objsById('order', this.store.types.data);
			this.$nextTick(() => menuTreeToggler('.toplevel_JS', '.sublevel_JS', '.select-arrow_JS'))
		},
		'store.subcategories.data': function() {
			this.subcategories_by_id = objsById('id', R.pathOr([], ['store', 'subcategories', 'data'], this));
			this.subcategory_ids_by_category_ids = R.map(arr => orderAscending(arr))(idsByParentIds('category_id', 'id', R.pathOr([], ['store', 'subcategories', 'data'], this)));
			this.category_ids_by_subcategory_ids = idsByParentIds('id', 'category_id', R.pathOr([], ['store', 'subcategories', 'data'], this));
		},
		'store.subtypes.data': function() {
			this.subtypes_by_id = objsById('id', R.pathOr([], ['store', 'subtypes', 'data'], this));
			this.subtype_ids_by_type_ids = R.map(arr => orderAscending(arr))(idsByParentIds('type_id', 'id', R.pathOr([], ['store', 'subtypes', 'data'], this)));
			this.type_ids_by_subtype_ids = idsByParentIds('id', 'type_id', R.pathOr([], ['store', 'subtypes', 'data'], this));
		},

		selected_subcategories() {
			this.createQueryString();
		},
		selected_subtypes() {
			this.createQueryString();
		}
	}

};
