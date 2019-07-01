import R from 'ramda';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';

import {objsById, orderAscending, idsByParentIds, headOr, realAndMeridianHoursByInterval} from '../../functions/pure';


export const updateEvent = {
	mixins: [shoppingBagDataAndComputedProps],

	data: {
		activated_event_modal_is_open: false,
		published_event_modal_is_open: false,
		close_event_modal_is_open: false,

		event_type_load_event: true,
		//inputs
		event_type: '',
		type_variation: '',
		event_name: '',
		event_people: '',
	event_date: '',
		is_exclusive: '',
		accepted_terms: '',
		event_url: '',
		hours_array: realAndMeridianHoursByInterval(["00", "30"]),
		selected_hour: '',

		errors: {
			event_type: 'El tipo de evento no puede estar vacío',
			event_name: 'El nombre del evento no puede estar vacío',
			event_people: 'Tienes que indicar por lo menos un festejado',
			event_date: 'La fecha del evento tiene que estar definida',
			is_exclusive: 'Por favor dinos si tu mesa de regalos es única',
			accepted_terms: 'Es necesario que aceptes los términos y condiciones de NICE TO HAVE'
		},
		event_date_label_display: true,

		arrow_is_flipped: false,

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
				// municipio: "-1",
				street1: '',
				street2: '',//Se convirtió en municipio
				street3: '',
				zip_code: '',
				references: '',
			},
		}
	},

	ready() {
		this.selected_hour = this.store.event_hour;
		//datepicker
		let that = this
		let dp = $('.jq-datepicker_JS').datepicker( {
			dateFormat: "yy-mm-dd",
			onClose(date, obj) {
				that.event_date = date
			}
		})

		//scrollTo Hash
		$('a[href*=\\#]').on('click', function(e){
			var href = $(this).attr('href');
			var hash = href.substr(href.indexOf("#"));
			if ($(hash).length != 0) {
				e.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top - 85
				});
			} else {
				// $('html,body').animate({
				// 	scrollTop: $(window.location.hash).offset().top - 85
				// });
			}
		});

		//Time Input
		$("#time_input_JS").on('change', function() {
			var before = this.defaultValue;
			var after = this.value;
			var partsBefore = before.split(':');
			var partsAfter = after.split(':');
			this.defaultValue = after;
		});

		if (this.store.publish_event === true) { this.activatedEvent()}
		if (this.store.publish_template_event === true) { this.publishedEvent()}

		this.$nextTick(() => {

			this.store.shippingAddress.street2 = this.store.selected_street2 !== "" ?  this.store.selected_street2 : '-1'
		})
	},


	computed: {
		municipios() {
			let state = this.store.shippingAddress.state;
			return R.pathOr('', ['store', 'states_and_mun', state], this);
		},

		inZonaMetropolitana() {
			let municipio = R.find(R.propEq('NOM_MUN,C,110', this.store.shippingAddress.street2), this.municipios || [])
			return R.pathOr(undefined, ['IS_IN_ZMVM'], municipio)
		},

		typesById() {
			return objsById('id', R.path(['store', 'types', 'data'],this) || []);
		},

		subtypesById() {
			return objsById('id', R.pathOr({}, ['store', 'subtypes', 'data'], this));
		},

		subtypeIdsByTypeId(){
			return R.map(arr =>
				orderAscending(arr))
				(idsByParentIds
					(
						'type_id', 'id',
						R.pathOr([], ['store', 'subtypes', 'data'], this)
					)
				);
		},

		//availableSubtypes:: Int event_type -> subtypeIdsByTypeId {type_id: [subtype_id]} -> subtypesById {id:subtype} -> [subtypes]
		availableSubtypes() {
			let type = this.event_type || -1
			let available_st_ids = R.pathOr([], ['subtypeIdsByTypeId', type], this)
			let available_st = R.map(id => this.subtypesById[id] , available_st_ids)
			return available_st
		},

		typeLabel() {
			let types =  R.pathOr([], ['store', 'types','data'], this);
			return R.compose(
				R.pathOr('Cargando...', ['es_label']),
				headOr({}),
				R.filter(type => type.id === this.event_type)
			)(types)

		},

		subtypeLabel() {
			let subtypes =  R.pathOr([], ['store', 'subtypes','data'], this);
			return R.compose(
				R.pathOr('Cargando...', ['es_label']),
				headOr({}),
				R.filter(type => type.id === this.type_variation)
			)(subtypes)
		},
	},

	methods: { //IO

		datePickerOnFocus() {
			this.event_date_label_display = false;
			this.arrow_is_flipped = true;
		},

		unFlip() {//del datepicker
			this.arrow_is_flipped = false
			if (this.event_date === "") {
				// La siguiente línea toggolea el  label en el focusout cuando no hay fecha en el evento,
				// pero si se tiene una fecha de tipo 03/dd/2017, el input no la manda y el label regresa.
				// Si esto se activa, hay que considerar ese problema

				// this.event_date_label_display = true;
			}
		},

		closeModal(modal_name) {
			this[`${modal_name}_is_open`] = false;
		},


		//métodos que pueden ser provisionales
		activatedEvent() {
			this.activated_event_modal_is_open = true;
		},

		publishedEvent() {
			this.published_event_modal_is_open = true;
		},

		closeEventOpenModal() {
			this.close_event_modal_is_open = true;
		},

		closeEvent(form) {
			document.getElementById(form).submit()
		},

		toggleForms() {
			var selection = $('input[name="bank_account_id"]:checked');
			var add_account = $('#add_account_JS');
			var request_withdraw = $('#request_withdraw_JS');
			if (selection.val() === '') {
				add_account.slideDown('fast');
				request_withdraw.slideUp('fast');
			} else {
				add_account.slideUp('fast');
				request_withdraw.slideDown('fast');
			}
		}

	},

	watch: {
		'store.types.data'() {
			let personal_event_obj_type = R.path(['store', 'personal_event', 'typeable', 'object_type'], this)
			if(personal_event_obj_type === 'type') {
				this.event_type =  R.pathOr('', ['store', 'personal_event', 'typeable', 'id'], this)
			} else  if(personal_event_obj_type === 'subtype'){
				this.event_type =  R.pathOr('', ['store', 'personal_event', 'typeable', 'type', 'id'], this)
			}
		},

		'store.subtypes.data'() {
			let personal_event_obj_type = R.path(['store', 'personal_event', 'typeable', 'object_type'], this)
			if(personal_event_obj_type === 'subtype'){
				this.type_variation =  R.pathOr('', ['store', 'personal_event', 'typeable', 'id'], this)
			}
		},

		event_type() {
			if(!this.event_type_load_event) {
				this.type_variation = ""
			}
			this.event_type_load_event = false;//después de la primera carga de store.types.data, se vuelve falso y permite reiniciaizar el select de type_variation
		},

	}
};
