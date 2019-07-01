import R from 'ramda';
import debounce from 'lodash.debounce';
import {numberFilters} from '../mixins/number-filters';
import {crudAjax} from '../mixins/crud-ajax';
import {conekta} from '../mixins/conekta';
import {discountHTTP} from '../mixins/discount-http';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';
import {validateEmail, fieldValidator, noKeyIsEmpty} from '../../functions/pure';
import {jQScrollUp} from '../../scroll-up.js';


export var checkout =  {
	el: 'body',
	mixins: [crudAjax, conekta, shoppingBagDataAndComputedProps, numberFilters, discountHTTP],
	data: {
		step: 2, //debe comenzar en el paso 2, el paso 1 es login o registro
		show_message_box: '0', //para el friendly message
		friendly_message_card: false,
		friendly_message: '',
		new_card: false,
		checkout_form: 'checkout_form',
		create_account: false,
		waiting_for_conekta: false,
		show_billing: false,
		payment_method: '',

		is_deposit: false,
		cash_out_total: 0,
		is_over_minimum: true,


		store: {
			shipping: {
				cost: 0,
				type: '',
				ocurre_force: false
			},

			termsAccepted: false,

			creditCardDetails: {
				card_id: '',
				number:'',
				name:'' ,
				exp_year:'',
				exp_month:'',
				cvc: '',
				last_digits: '',
				provider_key: '',
				details_are_complete: false
		    	},

		    	bankAccount: {
				bank_account_id: -1,
				bank:'',
				branch:'',
				name: '',
				account_number: '',
				CLABE: ''
		    },

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
		    	street2: "-1",
		    	street1: '',
		    	street2: '',//Se convirtió en municipio
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
			let municipio = R.find(R.propEq('NOM_MUN,C,110', this.store.shippingAddress.street2), this.municipios || [])
			return R.pathOr(undefined, ['IS_IN_ZMVM'], municipio) === '0' ? false : true;
		},

		hide_invalid_email_message() {
			if (this.store.shippingAddress.email === '') {return true};//si el ususario no ha ingresado un email
			return validateEmail(this.store.shippingAddress.email);
		}
	},

	ready() {
		this.store.shippingAddress.country_id = this.store.preloaded_country_id !== '' ? this.store.preloaded_country_id : -1;
		this.new_card = R.pathOr(0, ['store', 'user_cards', 'length'], this) === 0 ? true : false;
		let municipio = R.find(R.propEq('NOM_MUN,C,110', this.store.preloaded_municipio), this.municipios || []);
		this.$nextTick(() => {
			this.store.shippingAddress.street2 = this.store.preloaded_municipio !== '' ? R.pathOr(-1, ['NOM_MUN,C,110'], municipio) : -1;
			this.getLastDigits();
		})
	},

	methods: {
		placeOrderPost() {
			let msgs = this.getErrorMsgsForStep3();

			if (this.friendly_message_card === true && this.friendly_message === '') {
				this.step = 2;
				this.alertError(['Seleccionaste que quieres mandar un mensaje con tu regalo, pero el mensaje está vacío']);
				return;
			}

			if (msgs.length > 0) {
				this.alertError(msgs);
				return;
			}

			this.waiting_for_conekta = true;

			if (this.new_card && this.payment_method === 'tarjeta') {
				this.conektaPost(this.store.creditCardDetails);
				return;
			}

			document.getElementById(this.checkout_form).submit();

			return;
		},

		getErrorMsgsForStep3() {
			//personal info
			let personal_info_errors = {
				name: 'El campo "Nombre" en la sección "Tu Información" no puede estar vació',
				last_name: 'El campo "Apellidos" en la sección "Tu Información" no puede estar vació',
				contact_phone: 'El campo para Teléfono en la sección "Tu Información" no puede estar vació'
			};

			let personal = fieldValidator(this.store.shippingAddress, personal_info_errors)

			//pago
			let 	card_id_errors = [], credit_card_errors = [], payment_method_errors = []

			let credit_card_details = {//si new_card
				name: 'El campo "Nombre" en la sección de "Métodos de Pago" no puede estar vació',
				number: 'El campo "Número de tarjeta" en la sección de "Métodos de Pago" no puede estar vació',
				exp_month: 'El campo "Mes de vencimiento" en la sección de "Métodos de Pago" no puede estar vació',
				exp_year: 'El campo "Año de vencimiento" en la sección de "Métodos de Pago" no puede estar vació',
				cvc: 'El campo "Código de Seguridad" en la sección de "Métodos de Pago" no puede estar vació'
			};

			let card_id = {
				card_id: 'En la sección "Métodos de Pago", es necesario seleccionar una de tarjeta de credito ya registrada, o agregar una nueva'
			}

			if (this.payment_method === '' && !this.is_deposit) {
				payment_method_errors = ['En la sección "Métodos de Pago", es necesario seleccionar un método de pago']
			}

			if (this.payment_method === 'tarjeta' && !this.new_card) {
				card_id_errors = fieldValidator(this.store.creditCardDetails, card_id)
			}
			if (this.payment_method === 'tarjeta' && this.new_card){
				credit_card_errors = fieldValidator(this.store.creditCardDetails, credit_card_details)
			}

			//deposito
			let bank_id_errors = [], clabe_errors = [], account_number_errors = [], general_bank_errors = [];

			let clabe_bank_account_details = {//si bank_id es 'new_account' y bankAccount.CLABE !== ''
				bank: 'El campo "Banco" en la sección de "Cuenta bancaria para depósito" no puede estar vació',
				name: 'El campo "Nombre y Apellidos" en la sección de "Cuenta bancaria para depósito" no puede estar vació'
			};

			let account_number_details = R.merge({//si bank_id es 'new_account' y bankAccount.account_number !== ''
				branch: 'El campo "Sucursal" en la sección de "Cuenta bancaria para depósito" no puede estar vació'
			}, clabe_bank_account_details);


			if (this.is_deposit && (this.store.bankAccount.bank_account_id === '' || this.store.bankAccount.bank_account_id === -1)) {
				bank_id_errors = ['En la sección "Cuenta Bancaria para Depósito", es necesario seleccionar una de cuenta ya registrada, o agregar una nueva']
			}

			if (	this.is_deposit && //es CLABE
				this.store.bankAccount.bank_account_id === 'new_account' &&
				this.store.bankAccount.CLABE !== '' ) {
				clabe_errors = fieldValidator(this.store.bankAccount, clabe_bank_account_details)
			}

			if (	this.is_deposit && //es account_number
				this.store.bankAccount.bank_account_id === 'new_account' &&
				this.store.bankAccount.account_number !== '' ) {
				account_number_errors = fieldValidator(this.store.bankAccount, account_number_details)
			}

			if (	this.is_deposit &&
				this.store.bankAccount.bank_account_id === 'new_account' &&
				this.store.bankAccount.account_number === ''  &&
				this.store.bankAccount.CLABE === '' ) {
				general_bank_errors = ['En la sección "Cuenta Bancaria para Depósito", es necesario agregar o CLABE o Surcursal y Número de Cuenta']
			}

			//terminos y condiciones
			let terms_error = []
			if (this.store.termsAccepted !== true) {
				terms_error = ['Es necesario aceptar los "Términos y Condiciones"']
			}

			return R.flatten([
				personal,
				payment_method_errors,
				card_id_errors,
				credit_card_errors,
				bank_id_errors,
				clabe_errors,
				account_number_errors,
				general_bank_errors,
				terms_error
			])
		},

		setCreditCardProviders(number) {
			var mastercard_range = R.range(2221, 2720);
			number = number+'';
			if (number[0] === '4') {
				this.store.creditCardDetails.provider_key = 'V';
			} else if (number.slice(0,2) === '34' || number.slice(0,2) === '37') {
				this.store.creditCardDetails.provider_key = 'A';
			} else if (number[0]=== '5' || R.indexOf(Number(number.slice(0,4)), mastercard_range) > -1) {
				this.store.creditCardDetails.provider_key = 'M';
			} else {
				this.store.creditCardDetails.provider_key = '';
			}
		},

		getLastDigits(number) {
			var take;
			number = number || R.map(digit => digit, this.store.creditCardDetails.number);
			if (number.length === 15) {
				take = 5;
			}
			else if (number.length === 16) {
				take = 4;
			} else {
				take = 0;
			}

			this.store.creditCardDetails.last_digits = R.join('', R.takeLast(take, number));
		},

		toggleBilling(boolean) {
			this.show_billing = boolean;
		},

		goToStep3() {
			let msgs = this.getErrorMsgsForShippingInfo();
			if(msgs.length > 0 && this.store.is_event_checkout === false) {
				this.alertError(msgs);
			} else {
				this.step = 3;
				jQScrollUp();
			}
		},

		scroll2PaymentMethod() {
			$('html,body').animate({ scrollTop: $('#checkout_left_JS').offset().top }, 'fast');
		},

		getErrorMsgsForShippingInfo() {
			let errors = {
				contact_name: 'El campo "Nombre de contacto" es obligatorio',
				phone: 'El campo "Teléfono de contacto" es obligatorio',
				country_id: 'El campo "País" es obligatorio',
				state: 'El campo "Estado" es obligatorio',
				municipio: 'El campo "Municipio" es obligatorio',
				city: 'El campo "Ciudad" es obligatorio',
				zip_code: 'El campo "Código Postal" es obligatorio',
				street1: 'El campo "Calle y Número" es obligatorio' ,
				street3: 'El campo "Colonia" es obligatorio'
			};

			let fields = R.keys(errors);

			let fields_with_errors = R.filter(field =>
				this.store.shippingAddress[field] === '' ||
				this.store.shippingAddress[field] == -1,
			fields);

			let msgs = R.map(field =>  errors[field], fields_with_errors);

			return msgs
		}
	},

	watch: {
		municipios() {
			this.store.shippingAddress.street2 = -1;
		},

		'store.creditCardDetails.number': function() {
			let number = R.map(digit => digit, this.store.creditCardDetails.number);//using takeLast directly on this.creditCardDetails.number breaks the binding
			this.getLastDigits(number);
			this.setCreditCardProviders(number.join(''))
		},

		show_message_box() {
			this.friendly_message_card = this.show_message_box === '0' ? false : this.friendly_message_card;
		},
	},

	events: {
		onTransferTotalChange(total) {
			this.is_deposit = total > 0;
			this.cash_out_total = total > 0 ? total : 0;
		},

		onOverMinimumChange(bool) {
			this.is_over_minimum = bool;
		}
	}
};
