/**
 * An object that posts the credit card details to Conekta and has default methods to automaticall post the full checkout form to the server.
 * Requires this.checkout_form to be defined in calling component
 * @type {Object}
 */
export const conekta = {
	data: {
		conekta: {
			token: {},
			error: {}
		},
	},

	methods: {
		conektaPost(credit_card_details) {
			const {number, name, exp_year, exp_month, cvc} = credit_card_details,
				tokenParams = {
				  "card": {
				    "number": number,
				    "name": name,
				    "exp_year": exp_year,
				    "exp_month": exp_month,
				    "cvc": cvc
				  }
				};
			Conekta.token.create(tokenParams, this.conektaSuccess, this.conektaError);
		},

		conektaSuccess(token) {
			this.conekta.token = token;
			this.$nextTick(()=>{ document.getElementById(this.checkout_form).submit()});
		},

		conektaError(error) {
 			let body = {
 				error: error.message_to_purchaser
 			};
			this.waiting_for_conekta = false;
			this.alertError(body);
		},
	}
};
