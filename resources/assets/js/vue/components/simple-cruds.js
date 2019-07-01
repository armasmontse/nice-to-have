
import R from 'ramda';
import Vue from 'vue';
import {simpleCrudComponentMaker} from '../factories/simple-crud-component-maker.js';
import {sortByNestedProp, toArray, objTextFilter, tapLog} from '../../functions/pure';
import {preSelectOption} from '../../functions/dom';
import {numberFilters} from '../mixins/number-filters';

//TODO crear un simpleCrudWithImage o algo así, la solucion para los cruds de singleSku y singleImage es la misma
import {singleSku} from './single-sku';
import {singleEvent} from './single-event';

var simpleModalCrud = function(name, config ={}) {
	var methods;

	config.methods= config.methods || {};

	return	{
		ready() {
			var first_item = { id:'', es: {name: 'Seleccionar'} };
			// this.sortList(first_item);
				this.onModalOpen();
			if (typeof config.ready === 'function') { config.ready.call(this)};

		},

		props: [].concat(config.props || []),

		data: R.merge({}, config.data || {}),

		computed: R.merge({}, config.computed || {}),

		methods: R.merge({
			sortList(first_item) {
				//this.list = sortByNestedProp(R.pipe(R.prop('order')), this.list);
				this.list.unshift(first_item)
				// this.$parent.$data[name] = this.list;
			},

			onModalOpen(){
				var self = this;
				$('#'+name).on('shown.bs.modal', function (e) {
					self.editIndex = e.relatedTarget.dataset.index;
				})
			},

			onCreateSuccess(body, input) {
				this.list.splice(0, 0, body.data);
				input.target.reset();
				$('#'+name).modal('hide');
			},

			onUpdateSuccess(body, input) {
				var index = input.target.dataset.index;
				this.list.splice(index, 1, body.data);
				input.target.reset();
				$('#'+name).modal('hide');
			}
		}, config.methods),

		watch: config.watch
	};
};

const checkboxesMethods = {
	props:['selectedElems', 'relatedProducts'],

	data: {
		selected_checkboxes: [],
		search: ''
	},

	computed: {
		filterable_elems() {
			return objTextFilter(['title'], this.search, this.list);
		}
	},
	methods: {
		makePost($event) {
   			this.post($event.target.form);
   		},

   		updateSelectedCheckboxes() {
			this.selected_checkboxes = R.map(elem => elem.id+'', this.selectedElems || []);
			this.relatedProducts = this.selected_checkboxes;
   		},

   		onUpdaterelatedproductsSuccess(body) {
   			this.relatedProducts = R.map(prod => prod.id, R.pathOr([], ['data', 'related_products'], body));
   		}
	},

	watch: {
		selectedElems() {
			this.updateSelectedCheckboxes();
		},

		list() {
			this.updateSelectedCheckboxes();
		}
	},

};

const relatedProductsFilter = {
	props: ['products', 'relatedProductsIds'],
	computed: {
		related_products() {
			let related_ids_to_string = R.map(id => id+'')(this.relatedProductsIds || []);
			let with_default_sku = R.filter(prod => prod.default_sku !== null);
			let related = R.filter(prod=> R.contains(prod.id+'', related_ids_to_string));
			return R.map(prod=>({
				title: prod.title,
				img_url: R.pathOr('', ['default_sku', 'thumbnail_image', 'url'], prod),
				alt: R.pathOr('', ['default_sku', 'thumbnail_image', 'alt'], prod),
			}), R.compose(related, with_default_sku)(this.products || []));
		}
	}
};

const bagStatus = {
	props: ['edit-index', 'bag-status'],
	computed: {
		statusEncoded() {
			if (this.bagStatus) this.bagStatus = JSON.parse(this.bagStatus); 
			return this.bagStatus;
		},
	},

	methods: {
		onUpdateSuccess(body, input) {
			var index = input.target.dataset.index;
			$('#bag-status-edit').modal('hide');
		}
	}
}

const cashoutStatus = {
	props: ['edit-index', 'cashout-status'],
	computed: {
		statusEncoded() {
			if (this.cashoutStatus) this.cashoutStatus = JSON.parse(this.cashoutStatus); return this.cashoutStatus;
		}
	}
}


export const providers = simpleCrudComponentMaker('#providers-template');
export const providersModal = simpleCrudComponentMaker('#providers-modal-template', simpleModalCrud('provider-create'));
export const providersModalEdit = simpleCrudComponentMaker('#providers-modal-edit-template', simpleModalCrud('provider-edit',{props:['edit-index']}));
export const providersSelect = simpleCrudComponentMaker('#providers-select-template',{props:['current-product']});
export const categories = simpleCrudComponentMaker('#categories-template');
export const categoriesModalEdit = simpleCrudComponentMaker('#categories-modal-edit-template', simpleModalCrud('category-edit',{props:['edit-index']}));
export const subcategories = simpleCrudComponentMaker('#subcategories-template', simpleModalCrud('subcategory-create', {props:['categories','current-language','edit-index']}));
export const subcategoriesModalEdit = simpleCrudComponentMaker('#subcategories-modal-edit-template', simpleModalCrud('subcategory-edit', {props:['categories','current-language','edit-index']}));
export const subcategoriesCheckboxes = simpleCrudComponentMaker('#subcategories-checkboxes-template', checkboxesMethods);

export const types = simpleCrudComponentMaker('#types-template', {components:{singleEvent}});
export const typesModalEdit = simpleCrudComponentMaker('#types-modal-edit-template', simpleModalCrud('type-edit',{props:['edit-index']}));

export const subtypes = simpleCrudComponentMaker('#subtypes-template', simpleModalCrud('subtype-create', {props:['types','edit-index']}));
export const subtypesModalEdit = simpleCrudComponentMaker('#subtypes-modal-edit-template', simpleModalCrud('subtype-edit', {props:['types','edit-index']}));
export const subtypesCheckboxes = simpleCrudComponentMaker('#subtypes-checkboxes-template', checkboxesMethods);

export const productSections = simpleCrudComponentMaker('#product-sections-template');
export const productSectionsModalCreate = simpleCrudComponentMaker('#product-sections-modal-create-template', simpleModalCrud('product-section-create'));
export const productSectionsModalEdit = simpleCrudComponentMaker('#product-sections-modal-edit-template', simpleModalCrud('product-section-edit',{props:['edit-index']}));


export const productSkus = simpleCrudComponentMaker('#product-skus-template',{ mixins:[numberFilters], components:{singleSku}});
export const productSkusModalCreate = simpleCrudComponentMaker('#product-skus-modal-create-template', simpleModalCrud('sku-create'));
export const productSkusModalEdit = simpleCrudComponentMaker('#product-skus-modal-edit-template', simpleModalCrud('sku-edit',{props:['editIndex']}));

export const relatedProductsModalCreate = simpleCrudComponentMaker('#related-products-modal-create-template', simpleModalCrud('related-products-modal-create', checkboxesMethods));
export const relatedProducts = simpleCrudComponentMaker('#related-products-template', relatedProductsFilter);

export const bags = simpleCrudComponentMaker('#bags-template');
export const billingModalEdit = simpleCrudComponentMaker('#billing-modal-edit-template', simpleModalCrud('billing-edit',{props:['edit-index']}));
export const bagStatusModalEdit = simpleCrudComponentMaker('#bag-status-modal-edit-template', simpleModalCrud('bag-status-edit', bagStatus));

export const cashouts = simpleCrudComponentMaker('#cashouts-template');
export const cashoutStatusModalEdit = simpleCrudComponentMaker('#cashout-status-modal-edit-template', simpleModalCrud('cashout-status-edit',cashoutStatus));

export const pagesectionsModalCreate = simpleCrudComponentMaker('#pagesections-modal-create-template', simpleModalCrud('pagesections-modal-create', {data: { item_on_create: {description: '' } }}));
export const pagesectionsModalEdit = simpleCrudComponentMaker('#pagesections-modal-edit-template', simpleModalCrud('pagesections-modal-edit', {props:['edit-index']}));
export const pagesections = simpleCrudComponentMaker('#pagesections-template');

