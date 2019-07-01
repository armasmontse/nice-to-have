import R from 'ramda';
import {shoppingBagDataAndComputedProps} from '../mixins/shopping-bags-data-and-computed-props';
import {jQScrollUp} from '../../scroll-up.js';
import {objsById, orderAscending, idsByParentIds} from '../../functions/pure';


export const createEvent = {
	mixins: [shoppingBagDataAndComputedProps],

	data: {
		step: 2,//step 1 es login y no se usa, el primero es 2
		//inputs
		step_2:  {
			event_type: '',
			type_variation: ''
		},
		step_3:  {
			event_name: '',
			event_people: '',
			event_date: ''
		},
		step_4:  {
			is_exclusive: '',
			accepted_terms: ''
		},
		errors: {
			step_2:  {
				event_type: 'El tipo de evento no puede estar vacío',
				// type_variation: 'La variación del tipo de evento no puede estar vacía'
			},
			step_3:  {
				event_name: 'El nombre del evento no puede estar vacío',
				event_people: 'Tienes que indicar por lo menos un festejado',
				event_date: 'La fecha del evento tiene que estar definida'
			},
			step_4:  {
				is_exclusive: 'Por favor dinos si tu mesa de regalos es única',
				accepted_terms: 'Es necesario que aceptes los términos y condiciones de NICE TO HAVE'
			}
		},
		event_date_label_display: true,

		arrow_is_flipped: false
	},

	ready() {},

	computed: {
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
			return R.compose(
				R.pathOr([], [0, 'subtypes']),
				R.filter(type => type.id === (this.step_2.event_type || -1))
			)( R.pathOr([], ['store', 'types', 'data'], this))
		},

		currentImage() {
			if (Object.keys( this.store.new_event).length === 0) {
				return this.store.view_images[`step_${this.step}`]
			} else {
				return this.store.view_images[`step_5`]
			}
		}
	},

	methods: {//IO
		goToStep(step) {
			let msgs = this.getErrorMsgsForStep(step, this.errors[`step_${step - 1}`])//errores del paso actual
			if (msgs.length === 0) {
				if (step === 5) {
					document.getElementById('create_event_form').submit();
				} else {
					this.step = step;
					jQScrollUp();
				}
			} else {
				this.alertError(msgs);
			}
		},

		getErrorMsgsForStep(step, errors) {
			let fields = R.keys(errors);

			let fields_with_errors = R.filter(field =>
				this[`step_${step - 1}`][field] === '' ||
				this[`step_${step - 1}`][field] === false,
			fields);

			let msgs = R.map(field =>  errors[field], fields_with_errors);

			return msgs
		},

		notNewEvent(store_new_event) {
			return Object.keys(store_new_event).length === 0;
		},

		datePickerOnFocus() {
			this.event_date_label_display = false;
			this.arrow_is_flipped = true;
		},

		unFlip() {//del datepicker
			this.arrow_is_flipped = false
		}
	},

	watch: {
		step() {
			//setea la fecha
			if (this.step === 3 && $.datepicker) {
				let that = this
				let dp = $('.jq-datepicker_JS').datepicker( {
					dateFormat: "yy-mm-dd",
					onClose(date, obj) {
						that.step_3.event_date = date
					}
				})
			}
		}
	}
};
