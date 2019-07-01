<div class="row" v-if="filterableAndSortablePhotos.length > 0">
    <div 
        v-for="photo in filterableAndSortablePhotos"
        class="undraggable media-manager__img-container"
        v-bind:class="{
            'col-xs-2': chosen_img.src === '',
            'col-xs-3': chosen_img.src !== '',
            'media-manager__img-container--selected':  isChosenImage(chosen_img.id, photo.id)
        }"
        v-on:click="onChosenImage($event, photo.id)"
    >
        <div
        	data-image-url="@{{photo.thumbnail_url}}"
        	data-id="@{{photo.id}}"
        	data-index="@{{$index}}"
        	class="undraggable media-manager__img-container-position"
        	v-bind:style="{backgroundImage: 'url(' + photo.thumbnail_url +')', height : 100 + '%'}">
        </div>
    </div>
</div>
<div class="row" v-else><h2>Recuperando imágenes...</h2></div>
