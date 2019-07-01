import R from 'ramda';
import Vue from 'vue';
import {sortable} from '../mixins/sortable';
import {crudAjax} from '../mixins/crud-ajax';

export const templatesSortableList = Vue.extend({
	template: '#templates-sortable-list-template',
	mixins:[sortable, crudAjax],
	props:['sectionNames'],
	data() {
		return {
			selected_section: -1,
		}
	},
	methods: {
		selectSection(section_id, selected_by_click) {
			this.$dispatch('selectedSection', section_id, selected_by_click)
			this.selected_section = section_id
		},

		onDeletesectionsSuccess(body, input) {
			let sections = R.pathOr([], ['$root', 'store', 'personal_event', 'event_template', 'event_template_sections'], this)
			let id = Number(input.target.dataset.id);
			let index = R.findIndex(R.propEq('id', id), sections)
			this.$root.store.personal_event.event_template.event_template_sections.splice(index, 1);
			this.$dispatch('onDeletedSection');
		},

		onUpdatesortedidsSuccess(body) {
			// no hacemos nada
		},

	}
});
