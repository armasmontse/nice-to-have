import R from 'ramda';
import Vue from 'vue';
import {menusMixin} from '../mixins/menus'
import {uppercaseFirst} from '../../functions/pure'

export const menuMobile = Vue.extend({
	template: '#menu-mobile-template',
	data() {
		return {
			selected_shop_submenu: '',
			selected_category_id: -1,
			selected_type_id: -1,
		}
	},
	mixins:[menusMixin],
	props: [
	'menu',
	'isOpen',

	'totalItemsInBags',

	'currentEvent',
	'openingTransition',

	'store',

	//Importante: Posiblemente muchas cosas de las de abajo, a partir del commit 4c33a85 tengan que borrarse o se vuelvan inútiles, resivar con cuidado, ahora pasamos el store y trabajamos con las categorias  y tipos directamente, porque ya traen las subcategorias y subtipos, respectivamente

	'typesById',
	'subtypesById',
	'subtypeIdsByTypeIds',
	'selectedSubtypes',
	'typeIdsBySubtypeIds',

	'categoriesById',
	'subcategoriesById',
	'subcategoryIdsByCategoryIds',
	'selectedSubcategories',
	'categoryIdsBySubcategoryIds',

	'priceRange'
	],

	filters: {
		printSelected(arr_of_selected) {
			let s = '';
			R.forEach(item => {
				if (item.parent.length > 0 && item.child.length > 0) {
					s += `${item.parent}: ${item.child}, `
				}
			}, arr_of_selected || []);

			return R.dropLast(2, s);//quita la última coma y el espacio
		},

		printPriceRange({from, to}) {
			if (from && to) {
				return `Desde $${from}.00, hasta $${to}.00`
			}
			return ''
		}

	},

	computed: {
		selected_subcategories_with_category() {
			return R.map(id => {
		 		let category_id = R.pathOr(-1, ['categoryIdsBySubcategoryIds', id] ,this);
		 		let parent = R.pathOr('', ['categoriesById', category_id, 'label'],this);
		 		let child = R.pathOr('', ['subcategoriesById', id, 'label'],this);
				return { parent: parent, child: child};
			}, this.selectedSubcategories || []);
	 	},

	 	selected_subtypes_with_type() {
			return R.map(id => {
		 		let type_id = R.pathOr(-1, ['typeIdsBySubtypeIds', id] ,this);
		 		let parent = R.pathOr('', ['typesById', type_id, 'label'],this);
		 		let child = R.pathOr('', ['subtypesById', id, 'label'],this);
				return { parent: parent, child: child};
			}, this.selectedSubtypes || []);
	 	},

		sub_something_name() {
			if (this.selected_category_id > -1) {
				return R.pathOr({}, ['categoriesById',this.selected_category_id], this).label;
			} else if (this.selected_type_id > -1) {
				return R.pathOr({}, ['typesById',this.selected_type_id], this).label;
			} else {
				return '';
			}
		},

		selectedType() {
			return R.compose(
				R.pathOr({}, [0]),
				R.filter(type=> type.id === this.selected_type_id)
			)(this.store.types.data || [])
		},

		selectedCategory() {
			return R.compose(
				R.pathOr({}, [0]),
				R.filter(category=> category.id === this.selected_category_id)
			)(this.store.categories.data || [])
		}

	},

	methods: {
		toggleSelectionOnAllParentCheckboxes(kind, kind_plural, kind_id) {
			let uc_kind = uppercaseFirst(kind),
				sub_ids = R.pathOr([], [`sub${kind}IdsBy${uc_kind}Ids`, kind_id], this),
				selected = this[`selectedSub${kind_plural}`] || [],
				all_are_selected = R.intersection(sub_ids, selected).length === sub_ids.length;

			if (all_are_selected) {
				this[`selectedSub${kind_plural}`] = R.without(sub_ids, selected)
			} else {
				this[`selectedSub${kind_plural}`] = R.uniq(R.concat(sub_ids, selected))
			}
		},

		unselectAll() {
			this.selectedSubcategories = [];
			this.selectedSubtypes = this.currentEvent === null ? [] : this.selectedSubtypes;
			this.resetPriceRanges();
		},

		unselectAllSubs(kind, kind_plural, kind_id) {
			let uc_kind = uppercaseFirst(kind),
				selected = this[`selectedSub${kind_plural}`],
				sub_ids = this[`sub${kind}IdsBy${uc_kind}Ids`][kind_id];

			this[`selectedSub${kind_plural}`] = R.without(sub_ids, selected)
		},

		resetPriceRanges() {
			this.priceRange = {from:"", to:""};
		},

		closeOnTap(e) {
			if(R.contains('menuResponsive__outside-click-area', e.target.classList) ||
				R.contains('menuResponsive__fixing-container', e.target.classList)) {
				this.$root.closeOpenStuff()
			}
		}
	},

	watch: {
		selected_shop_submenu() {
			$('.menuResponsive__container_JS').animate({ scrollTop: 0}, 'fast')//puede ser un poco  costoso hacer la selección cada vez, pero simplifica el código, puesto que Vue esconde muy bien este div. si el menu no se enecuentra abierto, por lo que seleccioanrlo y cachearlo causa complicaciones inncesarias en el código
		},

		selected_category_id(){
			$('.menuResponsive__container_JS').animate({ scrollTop: 0}, 'fast')
		},

		selected_type_id(){
			$('.menuResponsive__container_JS').animate({ scrollTop: 0}, 'fast')
		}
	}
});
