import R from 'ramda';
import {headOr} from '../../functions/pure';
import debounce from 'lodash.debounce';
export const discountHTTP = {
	data: function() {
		return {
			store: {
				discount: {}
			},
			discount_code: '',
			discount_code_form_id: 'discountcodevalidation_form'
		}
	},

	ready() {
		if (this.discount_code !== '') {
			this.post(document.getElementById(this.discount_code_form_id))
		}
	},

	methods: {
		makePost: debounce(function() {
			this.post(document.getElementById(this.discount_code_form_id))
		}, 500, {leading: true, trailing:false}),

		onDiscountcodevalidationSuccess(body) {
			let types = R.pathOr([], ['store', 'discount_codes_types'], this);

			let type = R.compose(
				headOr({}),
				R.filter(type=> type.id === body.data.discount_code_type_id)
			)(types);

			if (R.equals({}, type) ) {
				this.generalError()
				return;
			}

			this.store.discount =  {
				type: type.name,
				value: body.data.value
			}
		}
	}
};
