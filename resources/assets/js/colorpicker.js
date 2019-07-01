export var colorPicker = function(selector) {
	$(selector).each( function() {
		$(this).minicolors({
			control: $(this).attr('data-control') || 'wheel',
			inline: $(this).attr('data-inline') === 'true',
			letterCase: 'uppercase',
			opacity: false,
			change: function(hex, opacity) {
				if(!hex) return;
				if(opacity) hex += ', ' + opacity;
				try {
				} catch(e) {}
				$(this).select();
			},
			theme: 'bootstrap'
		});
	});
}