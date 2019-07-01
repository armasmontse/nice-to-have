var _ = require('ramda');

export var alertsController = function() {
	return {
		is_open: false,
		container: $('#alerts__container'),
		success_container: $('#alert__success'),
		danger_container:$('#alert__danger'),
		msg: [],
		success: '',
		close_btn: $('.alert__hide_JS'),

		init() {
			//placeholder method for the helpers.ifExistsThenLaunch, do not delete
			////TO DO: arreglar esta necesidad en el "ifExistsThenLaunch"
			this.hideAlert();
			this.hideOnOutsideClick();
			this.is_open = this.loadedOpen();
		},

		loadedOpen() {//set the alert's open status, when it was opened by the backend
			if (! this.success_container.hasClass('hidden') ||
				! this.danger_container.hasClass('hidden'))  {
				return true;
			}
			return false;
		},

		showAlert(obj) {
			var type;
			//console.log('obj', obj);
			this.hideAlreadyOpenContainer();
			this.msg = obj.msg || [];
			//console.log('this.msg', this.msg);
			this.success = obj.success;
			if(this.success === true) {
				type = 'success';
			} else if(this.success === false || this.success === '' || this.success === false) {
				type = 'danger';
			}
			//console.log('type', type);
			this.alert(type);
			this.is_open = true;
		},

		hideAlreadyOpenContainer() {
			this.success_container.addClass('hidden');
			this.danger_container.addClass('hidden');
		},

		hideAlert() {
			this.close_btn.on('click', function() {
				$(this).parent().addClass('hidden');
			});
		},

		hideOnOutsideClick() {
			this.container.on('click', function(e) {
				e.stopPropagation();
			});
			$(document).on('click',(e) => {
				if (this.is_open) {
					this.success_container.addClass('hidden');
					this.danger_container.addClass('hidden');
					this.is_open = false;
				}
			});
		},

		alert(type) {
			var $li, $ul;
			this[`${type}_container`].removeClass('hidden');
			$ul = $(this[`${type}_container`].find('ul')[0]);
			$ul.html('');
			this.msg.forEach(function(msg) {
				$li = $(`<li class="text__alert-${type} text__alert-${type}_JS">`);
				$li.text(msg).appendTo($ul);
			});
		}
	}
}(jQuery);
 