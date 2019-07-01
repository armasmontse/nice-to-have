import {w} from './cltvo/constants.js';

export var productsModal = function() {
	var modal = $('#mediaPopUp');
	var img = $('.mediaSingleProduct__img_JS');
	var close = $('#mediaPopUp__close');

	var positionClose = function() {
		var container = $('.grid__container'),
			container_width = container.width(),
			w_width,
			right_offset;

		var position = function() {
			w_width   = $(window).width();
			right_offset = (w_width - container_width)/2;

			// if (w_width >= 1200) {
			// 	right_offset = (w_width - container_width)/2;
			// } else if (w_width < 1200) 	{
			// 	right_offset = 100;
			// } else if (w_width < 768) 	{
			// 	right_offset = 50;
			// }

			if (w_width < 1200) {
				right_offset = 100;
			}
			if (w_width < 768) 	{
				right_offset = 50;
			}

			close.css({
				position: 'fixed',
				right: right_offset
			});
		}
		position();
		$(window).on('resize', position);
	};

	img.on('click', function(){
		var id = $(this).data('thumbnail'),
			full_img = $(`[data-full=${id}]`);
		modal.fadeIn();
		setTimeout(function() {
			modal.animate({ scrollTop: full_img.position().top});
			$('body').css('overflow', 'hidden');
		}, 100);
		positionClose();
	});

	close.on('click',  function() {
		modal.fadeOut();
		$('body').css('overflow', 'auto');
	});
};
