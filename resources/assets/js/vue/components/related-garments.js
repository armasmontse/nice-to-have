import _ from 'ramda';
var Vue = require('vue');
// var VueResource = Vue.use(require('vue-resource'));
import {crudAjax} from '../mixins/crud-ajax';
import {moveInArray} from '../../functions/pure';
import {initPropsFromJSON} from '../helpers';


export var relatedGarments = Vue.extend({
	template: '#related-garments-template',

	data: function() {
		return {
			garments_array: {
				//genders 1 and 2
				[1]: [],
				[2]: []
			},
			relatable_garments: [],
			genders: [],
			registered_genders:{}
		};
	},

	props: ['relatedGarments', 'photoableId'],

	init() {
	},

	create() {
	},

	ready() {
		initPropsFromJSON.call(this, this.$options.props);
		this.genders = this.$root.store.genders;
		this.registered_genders = this.$root.gender;
		this.getRelatableGarments();

		_.forEach(garment=> {
			if (garment.gender_id !== null) {
				this.garments_array[garment.gender_id].push(garment.related_garment_id + '')
			}
		}, this.relatedGarments)
		
	},

	mixins: [crudAjax],

	methods: {
		getRelatableGarments() {
			this.urlGet(window.location.origin + '/admin/garments/related/', {success: 'onGetRelatedGarmentsSuccess'});
		},

		onGetRelatedGarmentsSuccess(body) {
			this.relatable_garments = body;
		},

		isGarmentForThisGender(garment, gender_id) {
			return _.path(['gender_ids', '0'], garment) == gender_id ||  _.path(['gender_ids', '1'], garment) == gender_id;
		},

		addToGarmentsArray($event) {
						
		},

		relatedGarmentSrc(garment_id, gender_id) {
			var garment = _.filter(relatable => {return relatable.id == garment_id}, this.relatable_garments);
				return _.path(['photos_by_gender', gender_id], _.head(garment));
		},

		onUpdateassociateSuccess(body, elem) {
		},

		validateSelection($event) {
			//máximo 3 elementos
			if (this.garments_array.length > 3) {
				this.garments_array.pop();
				return false;
			}
			return true;
		},

		makePost($event) {
			this.post($event.target.form);
		}
	},

	watch: {
	},

	events: {
	},
});
