import R from 'ramda';
import {alertsController} from '../../alerts-controller.js';

export const wishlistShoppingBagAjax = {
	data() {
		return {
			waiting_for_server: false
			// in_wishlist: false//comentado para otros proyectos en Nice To have usamos una prop heredada al componente que llama este mixin
		};
	},

	methods: {
		alert() {/*no queremos las alertas automáticas*/},
		
		bagAlert(body) {//copiado directamente de ajaxCrud, porque no se usa alerts en el addToBag
			let alert_content = {};
			alert_content.msg = body.message;
			alert_content.success = body.success;
			alertsController.showAlert(alert_content);
		},
/////////////Ajax
//eventualmente todas las lineas comentadas deben dejar de estarlo o ser sustituidas
		dealWithCookieOnAjaxResponse(cookie) {//cuando no se ha seteado una cookie en el bag
			// if (R.path(['bags'], cookie)) {
			// 	this.$root.$data.store.bag_keys = cookie.bags;
			// }
		},

		onAddtobagSuccess(body) {
			this.$root.$data.store.bags = body.bags;
			this.updateBagKeys(body.bags);
			if (this.modal_is_open !== undefined) {
				this.modal_is_open = true;
			}
			this.waiting_for_server = false;
		},

		onAddtobagError(body){
			this.waiting_for_server = false;
			this.bagAlert(this.processError(body));
		},

		onUpdatebagSuccess(body) {
			this.$root.$data.store.bags = body.bags;
			this.updateBagKeys(body.bags);
			this.bagAlert(body);
			this.waiting_for_server = false;
		},
		
		onUpdatebagError(body){
			this.waiting_for_server = false;
			this.bagAlert(this.processError(body));
		},

		onRemovefrombagSuccess(body) {
			this.$root.$data.store.bags = body.bags;
			this.updateBagKeys(body.bags);
			this.bagAlert(body);
			this.waiting_for_server = false;
		},
		
		onRemovefrombagError(body){
			this.waiting_for_server = false;
			this.bagAlert(this.processError(body));
		},

		onAddtowishlistSuccess(body) {
			this.$root.$data.store.products_in_wishlist = R.append(this.id, this.$root.$data.store.products_in_wishlist)
			this.bagAlert(body);
		},

		onRemovefromwishlistSuccess(body) {
			this.$root.$data.store.products_in_wishlist = R.without([this.id], this.$root.$data.store.products_in_wishlist)
			this.bagAlert(body);
		},

		updateBagKeys(bags) {
			let bag_names = R.keys(bags);
			let bag_keys = R.fromPairs(R.map(bag => [ bag, bags[bag].key ], bag_names));
			this.$root.$data.store.bag_keys = bag_keys;
		}
	}
};
