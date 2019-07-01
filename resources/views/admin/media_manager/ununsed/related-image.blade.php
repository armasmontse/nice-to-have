<div class="image__col image__col--{{$type}} image__col--@{{image ? image.type : ''}} {{$class}}">
    <div class="image--related-garments">
        <div class="image--{{$type}}__aspect-ratio-container h-inherit w-inherit">
            <div class="relative h-inherit w-inherit">
                <div class="image__background--related-garments-container h-inherit w-inherit" v-if="{{$src}}">
                    <div class="image__background--related-garments" v-bind:style=" {
                        backgroundImage: 'url(' + {{$src}} +')'
                    }"></div>
                </div>
                <div class="centerXY" v-else>
                    <span class="fa fa-eye-slash" style="font-size: 31px;"></span>
                </div>
            </div>
        </div>
    </div>
</div>
