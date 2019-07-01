import {toArray} from './functions/pure';

export var select = function(selector) {
	selector = $(`#${selector}`);
	var options_container = selector.siblings('.select__option-container'),
		option = options_container.find('.option'),
		selected_option = options_container.siblings('.select__select-box--dropdown').find('#option--selected');
	
	options_container.is_open = false;

	var open = () => {
		options_container.slideDown();
		options_container.is_open = true;
	}
	var close = () => {
		options_container.slideUp();
		options_container.is_open = false;
	}

	selector.on('click', () => {
		if(options_container.is_open === false) {
			open();
		} else {
			close();
		}
	});

	option.on('click', function() {
		selected_option.text($(this).text());
		close();
	});
	console.log('corre');
};

export var selectMaker = function() {
	var selects = toArray(document.querySelectorAll('.select_JS'));
	selects.forEach((sel) => {
		console.log(sel.id);
		select(sel.id)
	});
};