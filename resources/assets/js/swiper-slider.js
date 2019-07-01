import R from 'ramda';
import Swiper from 'swiper';

export const swiperSlider = function(selector, opts = {}) {
	let slider = new Swiper (selector, R.merge({
		breakpoints: {
			600:  {
				slidesPerView: 1,
			},
			768: {
				slidesPerView: 2
			}
		},
		direction: 'horizontal',
		loop: true,
		pagination: '.slider__pagination',
		paginationClickable: true,
		freeMode: true,
		slidesPerView: 3,
		spaceBetween: 50,
		grabCursor: true,
		prevButton: selector+'-nav--prev',
		nextButton: selector+'-nav--next',
		autoplay: 2000
	}, opts));
	return slider;
};
