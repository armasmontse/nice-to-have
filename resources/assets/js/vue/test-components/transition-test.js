import R from 'ramda';
import Vue from 'vue';

Vue.transition('slide', {
  enterClass: 'slideInRight',
  leaveClass: 'slideOutRight'
})


export const transitionTest = Vue.extend({
	template: '#transition-test-template',
	data() {
		return {
			selected_shop_submenu: '',
			selected_category_id: -1,
			selected_type_id: -1
		}
	},
	props: [
	'menu',
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
				s += `${item.parent}: ${item.child}, `
			}, arr_of_selected || []);

			return R.dropLast(2, s);//quita la última coma y el espacio
		}
	},

	computed: {
		selected_subcategories_with_category() {
			return R.map(id => ({
				parent: this.categoriesById[this.categoryIdsBySubcategoryIds[id]].label,
				child: this.subcategoriesById[id].label
			}), this.selectedSubcategories || [])
	 	}, 
	 	selected_subtypes_with_type() {
			return R.map(id => ({
				parent: this.typesById[this.typeIdsBySubtypeIds[id]].label,
				child: this.subtypesById[id].label
			}), this.selectedSubtypes || [])
	 	}, 
	},

	methods: {
		selectCategory(id) {
			this.selected_category_id = id;
			console.log('this.selected_category_id', this.selected_category_id);
		}
	}
});
