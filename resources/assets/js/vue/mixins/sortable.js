import R from 'ramda';
import Vue from 'vue';
import Sortable from 'vue-sortable';
import {removeAndInsert} from '../../functions/pure';


/**
 * Sortea listas sencillas, a veces puede tener problemas con listas complejas, y tampoco funciona con tablas
 *
 * El layout del template debe obecer cierto formato:
 * <template id="...">
	<--- .... -->
	<div v-sortable="{onUpdate: onUpdate, ...}"> otras opciones onMove (fn), handle (class)
		<div v-for="item in list">
			IMPORTANTE: el v-for debe ser un hijo inmediateo de v-sortable
		</div>
	</div>
 * </template>
 *
 * La lista que recibe debe contener objetos con una prop "id".  El objeto manejará una array que contiene los ids ordenados "sorted_ids"
 * 
 * @type {Object}
 */
export const sortable = {
	props: ['list'],

	data: function() {
		return {
		}
	},

	computed: {
		sorted_ids() {
	     		return R.map(elem => elem.id, this.list || []);
		}
	},

	methods: {
		onUpdate(event) {
			return this.list = removeAndInsert(event, this.list);
	   }
	}
};

Vue.use(Sortable);