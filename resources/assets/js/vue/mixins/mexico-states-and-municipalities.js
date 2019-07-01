import R from 'ramda';

export const mexicoStatesAndMunicipalities = {

	data() {
		return {
			mex_states_and_municipalitites: {
				state: '',
				municipality: '',
				neighborhood: '',
				city: '',
				zip:'',
				street_1: '',
			},
		}
	},
	computed: {
		states() {
			return R.keys(R.pathOr({}, ['store', 'mexico_states_and_mun'], this))
		},

		municipios() {
			let state = R.path(['item_on_edit', 'state'], this);
			return R.pathOr('', ['store', 'mexico_states_and_mun', state], this);
		},

		stringifiedAddress() {
			let a = this.item_on_edit || {};
			let street_1 = a.street_1 ? `${a.street_1}, ` : '';
			let neighborhood = a.street3 ? `Col. ${a.street3}, ` : '';
			let city = a.city ? `${a.city}, ` : '';
			let municipality = a.street2 ? `${a.street2}, ` : '';
			let state = a.state ? `${a.state}` : '';
			return street_1 + neighborhood + municipality + state;
		}

/*
		inZonaMetropolitana() {
			let municipio = R.find(R.propEq('NOM_MUN,C,110', this.store.shippingAddress.municipio), this.municipios || [])
			return R.pathOr(undefined, ['IS_IN_ZMVM'], municipio)
		}
 */
	}
};
