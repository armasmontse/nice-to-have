import R from 'ramda';
export const makePost = function($event) {
	this.post($event.target.form);
}

export const openModal = function(name, $index) {
	if ($index === undefined) {return}
	this.edit_index = $index;
	$(name).modal('show');
}

export const openModalFromSimpleImageCrud = function(name, $index) {
	if ($index === undefined) {return}
	this.$parent.$data.edit_index = $index;
	$(name).modal('open');
}


export const postWithMaterialNote = function($event) {
	let mn = $($event.target).find('.materialnote_JS')
	mn.each(function() {
		let $this = $(this),
		     note = $this.siblings('.note-editor').find('.note-editable');	
	     
	     $this.text(note.html())
	});
	this.post($event)
};

export const checkboxesMethods = function(options) {
	let toNumberMap = R.map(n => Number(n));

	return {
		props:['currentPage'],

		data: {
			selected_checkboxes: [],
			search: ''
		},

		ready() {
			this.selected_checkboxes = R.map(n => n+'', this.currentPage.sections_ids);
		},

		methods: R.merge({
			openModal,

			makePost,

	   		updateSelectedCheckboxes() {
				this.selected_checkboxes = R.map(elem => elem.id+'', this.selectedElems || []);
	   		},

			is_checked(id) {
				return R.contains(Number(id), toNumberMap(this.selected_checkboxes)) ? true : false;
			}
		}, options.methods || {})
	}
}