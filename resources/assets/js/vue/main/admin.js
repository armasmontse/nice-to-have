import R from 'ramda';
import {mexicoStatesAndMunicipalities} from '../mixins/mexico-states-and-municipalities';

export var adminVue = {
	el: '#admin-vue',
	mixins:[mexicoStatesAndMunicipalities],

	methods: {
		openMediaManager() {
			$('#media-manager').modal('show');
			this.$refs.media_manager.getPhotos();
		},

		closeMediaManager() {
			$('#media-manager').modal('hide');
		},

		openComponent(ref) {
			R.path(['$refs', ref, 'open'], this) ? this.$refs[ref].open() : '';
		},

		closeComponent(ref){
			R.path(['$refs', ref, 'close'], this) ? this.$refs[ref].close() : '';
		},
		onGetAllProductsSuccess(body, input) {
			if (R.path(['store', 'products','data'])) {
				this.store.products.data = body;
			} else {
				console.log('por favor define la propiedad store.products.data en store para recibir esto', body);
			}
		}
	},
	events: {
		onAssociatedCheckbox(elem) {
			console.log('elem', elem);
			this.$broadcast('addedCheckboxElem', elem);
		}, 
		onDissociatedCheckbox(id) {
			console.log('id', id);
			this.$broadcast('removedCheckboxId', id);
		}
	}
};
