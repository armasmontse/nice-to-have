import {nonCyclingMoveInArray} from '../../functions/pure';

export const sortableListByClick = {
	data() {
		return {
			sortable_list: []
		}
	},

	ready() {
		this.sortable_list = this.list
	},

	computed: {
		sorted_ids() {
			return this.sortable_list.map(page => page.id)
		}
	},

	methods: {
		//Int 1(down) | -1( up:) -> Int -> IO VueData this.sortable_list
		move(direction, index, list) {
			this.sortable_list = nonCyclingMoveInArray(direction, index, list);
		}
	}
};

//agregar o hacer merge en metodos del objeto, si se quiereon estos callbacks, no agregar desde el mixin porque n algun momento podr'ian verse sobreescritos
export const sortableOnClickCbs = {
	onCreateSuccess:  function(body, input) {
		this.sortable_list.push(body.data);
	}, 
	onDeleteSuccess: function(body, input) {
		let index = input.target.dataset.index;
		this.sortable_list.splice(index, 1);
	}
};