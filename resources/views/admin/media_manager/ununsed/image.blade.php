<div class="image__col image__col--{{$type}} image__col--@{{image ? image.type : ''}} {{$class}}">
    <div class="image--{{$type}}">
        <div class="image--{{$type}}__aspect-ratio-container">
            <div class="inline-block relative">
                <div class="image__overlay">
                    <div class="image__icon-container">
                        <span class="fa image__icon"></span>
                        <span class="image__icon-text" v-on:click="removeImage($index, $event)">{{$text}}</span>
                    </div>
                </div>
                <img class="image" src="{{asset('images/'.$image_name)}}">
            </div>
        </div>
    </div>
</div>
