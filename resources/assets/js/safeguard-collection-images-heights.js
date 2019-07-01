import _ from 'ramda';
import {diff, toArray} from './functions/pure';

export var safeguardCollectionImagesHeights = function(selector) {
	var media_collection_image = $(selector);
		media_collection_image.removeAttr('style');
	var heights = media_collection_image.map(function() { return $(this).height()})
	var greatest_height = _.compose(_.last, _.sort(diff), toArray)(heights);
		media_collection_image.height(greatest_height);
};
