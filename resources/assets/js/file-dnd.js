import _ from 'ramda';
import debounce from 'lodash.debounce';

export var fileDnD = function(opts) {
	var addEventHandler = function(obj, evt, handler) {
					if(obj.addEventListener) {
					   // W3C method
					   obj.addEventListener(evt, handler, false);
					} else if(obj.attachEvent) {
					   // IE method.
					   obj.attachEvent('on'+evt, handler);
					} else {
					   // Old school method.
					   obj['on'+evt] = handler;
					}
				}; 
	return {
		container: document.getElementById('media-manager__drop-container'),
		droppable_area: document.getElementById('media-manager__droppable-area'),
		droppable_input: document.getElementById('media-manager__droppable-input'),
		reader: new FileReader(),
		file: {},
		list: document.getElementById('list'),
		bin: '',
		init: function() {
			if(!window.FileReader) { return alert('Your browser does not support the HTML5 FileReader. For a better experience with the media manager please the latest version of Chrome or Firefox');}
				var self = this,
				droppable_container = this.container,
				droppable_area   = this.droppable_area,
				droppable_input   = this.droppable_input,
				file,
				bin;

				//register event handlers
				addEventHandler(droppable_container, 'dragover', function(event) {
					event.preventDefault();
				});

				droppable_container.addEventListener("dragover", function( event ) {
					self.onDragOver();
					droppable_area.classList.add('active')
					droppable_input.classList.add('active')
					event.preventDefault();
				}, false);

				droppable_area.addEventListener("dragleave", function( event ) {
					self.onGeneralDraggend();
					droppable_area.classList.remove('active')
					droppable_input.classList.remove('active')
				}, false);

				droppable_container.addEventListener("dragend", function( event ) {
					self.onGeneralDraggend();
					droppable_area.classList.remove('active')
					droppable_input.classList.remove('active')
				}, false);

				addEventHandler(droppable_input, 'drop', function (e) {
					self.onChange(e.target)
					self.onGeneralDraggend();
					droppable_area.classList.remove('active')
					droppable_input.classList.remove('active')
					return false;
				});

			
		},

		onChange: typeof opts.onChange === 'function' ? opts.onChange : debounce(function(e_target) {
			var self = this;
			setTimeout(function() {
				self.file = _.head(e_target.files);
				self.reader.readAsDataURL(self.file);
			}, 50);
			addEventHandler(this.reader, 'loadend', function(e, files) {
				self.bin = this.result; 
			});
		},150),

		onDragOver: typeof opts.onDragOver === 'function' ? opts.onDragOver : () => '',

		onGeneralDraggend: typeof opts.onGeneralDraggend === 'function' ? opts.onGeneralDraggend : () => ''
	}
};
