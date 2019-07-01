@extends('layouts.admin')


@section('title')
    Media Manager |
@endsection

@section('h1')
    Media Manager
@endsection



@section('content')
<h1>Single Imge</h1>
        <single-image></single-image>
        <single-image
            v-ref:"prueba"
            current-image=""
            type="single"
            photoable-id="0"
            photoable-type="1"
            use="media_manager"
            class=""
            order=""
            >
            <h3 slot="title" class="text__p text__p--garments-sm">titulo</h3>
            @include('admin.media_manager.vue._image-placeholder-slot')
        </single-image>
    <div class="row">

        @include('admin.media_manager.index._trigger')
        <div class="">
            @foreach ($photos as $photo)
                @include('admin.media_manager.index._image')
            @endforeach
        </div>


    </div>
@endsection

@section('modals')
    @include('admin.media_manager._mediaManager')
    @include('admin.general._modal')
    @include('admin.general._modal2')
@endsection

@section('vue_templates')
    @include('admin.media_manager.vue.single-image-template')
@endsection
