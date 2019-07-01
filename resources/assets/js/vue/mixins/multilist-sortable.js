import R from 'ramda';
import Vue from 'vue';
import Sortable from 'vue-sortable';
import {removeAndInsert} from '../../functions/pure';

export const multilistSortable = {
	props: ['list'],
	
	data: function(){
		return {
			sortable_lists: [],
		}
	},

	ready() {
		console.log('corre');
	},

	computed: {
		sorted_ids() {
	     	return R.map(elem => elem.id, this.list || []);
		}
	},

	methods: {
		onUpdate(event) {
			console.log('corre update');
			//return this.list = removeAndInsert(event, this.list);
	   },
	   onMove(event, originalEvent) {
	   		console.log('event', event.related);

	   },
	   onDrag($event) {
	   	console.log($event);
	   }
	},

	watch: {
		list() {
			this.sortable_lists = R.map(list => list.allies, this.list || []);
		}
	}
};

Vue.use(Sortable);