import R from 'ramda';
//para pagesectionsSort
export const addedCheckboxElem = function(section) { this.sortable_list = R.append(section, this.sortable_list);}

//para pagesectionsSort
export const removedCheckboxId = function(section_id) {
	let index = R.findIndex(R.propEq('id', section_id), this.sortable_list);
	this.sortable_list = R.remove(index, 1, this.sortable_list);
}

export const pageSectionsCheckboxUpdateSuccess = function(body) {
		let is_associated = R.pathOr(false, ['data','is_associated'], body);
		let id = R.pathOr(false, ['data','section_id'], body);
		if (is_associated === true) {
			let selected = R.filter(elem => elem.id === id, this.list)[0];
			this.$dispatch('onAssociatedCheckbox', selected)
		} else {
			this.$dispatch('onDissociatedCheckbox', id)
		}
}

