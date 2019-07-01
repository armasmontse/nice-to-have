import _ from 'ramda';
import {denullify, lensPropMaker} from '../../functions/pure';

export var getStockMovement = {
	data: function() {
		return {
			movement: {
				id: '',
				out:'',
				in: '',
				username:'',
				description: '',
				skus: [],
			}
		}
	},

	methods: {

		onGetSuccess(body, input) {
			var data = body.data;
			this.movement.id = _.pathOr('No Disponible', ['stock_movement', 'key'], data);
			this.movement.out = _.pathOr('No Aplica', ['stock_movement', 'out_stock', 'label'], data);
			this.movement.in = _.pathOr('No Aplica', ['stock_movement', 'in_stock', 'label'], data);
			this.movement.username = _.pathOr('No Disponible', ['stock_movement', 'stock_movement_user', 'name'], data);
			this.movement.description = _.pathOr('No Disponible', ['stock_movement', 'description'], data);
			this.movement.skus = this._processSkus(_.path(['skus'], data));
		},

		_processSkus(skus) {
			var L = lensPropMaker(['color', 'size'])
			return _.map(_.compose(_.over(L.color, denullify), _.over(L.size, denullify)), skus);
		},
	},
};
