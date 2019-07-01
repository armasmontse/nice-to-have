import R from 'ramda';
import {numberFilters} from '../mixins/number-filters';
import {crudAjax} from '../mixins/crud-ajax';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';
import {validateEmail} from '../../functions/pure';


export const invoice =  {
	el:'body',
	mixins: [crudAjax, shoppingBagDataAndComputedProps, numberFilters],
	data: {
		store: {
		    shippingAddress: {
		    	name: '',
		    	last_name: '',
		    	contact_name: '',
		    	contact_phone: '',
		    	email: '',
		    	phone: '',
		    	country_id: '-1',
		    	state: "-1",
		    	city: '',
		    	municipio: "-1",
		    	street1: '',
		    	// street2: '',//Se convirtió en municipio
		    	street3: '',
		    	zip_code: '',
		    	references: '',
		    },
		}
	},

	computed: {
		municipios() {
			let state = this.store.shippingAddress.state;
			return R.pathOr('', ['store', 'states_and_mun', state], this);
		},

		inZonaMetropolitana() {
			let municipio = R.find(R.propEq('NOM_MUN,C,110', this.store.shippingAddress.municipio), this.municipios || [])
			return R.pathOr(undefined, ['IS_IN_ZMVM'], municipio)
		},

		shipping_info_is_complete() {
			return (this.store.bag_event !== null && this.store.shippingAddress.contact_phone !== '' && this.store.shippingAddress.email !== '') || //si es evento
				this.store.shippingAddress.name !== '' && //si no lo es
		    	this.store.shippingAddress.last_name !== '' &&
		    	this.store.shippingAddress.phone !== '' &&
		    	this.store.shippingAddress.country_id !== '' &&
		    	this.store.shippingAddress.country_id != -1 &&
		    	this.store.shippingAddress.state !== '' &&
		    	this.store.shippingAddress.state != -1 &&
		    	this.store.shippingAddress.municipio != -1 && // != importante
		    	this.store.shippingAddress.municipio !== '' &&
		    	this.store.shippingAddress.city != -1 &&
		    	this.store.shippingAddress.city !== '' &&
		    	this.store.shippingAddress.zip_code !== '' &&
		    	this.store.shippingAddress.street1 !== '' &&
		    	this.store.shippingAddress.street3 !== '';
		},

		hide_invalid_email_message() {
			if (this.store.shippingAddress.email === '') {return true};//si el ususario no ha ingresado un email
			return validateEmail(this.store.shippingAddress.email);
		}
	},

	ready() {
		this.store.shippingAddress.country_id = this.store.preloaded_country_id !== '' ? this.store.preloaded_country_id : -1; 
		let municipio = R.find(R.propEq('NOM_MUN,C,110', this.store.preloaded_municipio), this.municipios || []);
		this.$nextTick(() => {
			this.store.shippingAddress.municipio = this.store.preloaded_municipio !== '' ? R.pathOr(-1, ['NOM_MUN,C,110'], municipio) : -1; 
		})
	},

	watch: {
		municipios() {
			this.store.shippingAddress.municipio = -1;
		},
	}
};
