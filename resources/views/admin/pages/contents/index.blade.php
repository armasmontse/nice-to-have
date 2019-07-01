@extends('layouts.admin')


@section('title')
    Páginas
@endsection

@section('h1')
    Páginas
@endsection

@section('content')
    <pages :list="store.page_groups.data"></pages>
@endsection


@section('vue_templates')
    <script type="x/templates" id="pages-template">
        <div class="">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="row row-mt" v-for="pages_group in list" track-by="$index">
                    <h5 class="text__subtitle">@{{{pages_group.parent_label}}}</h5>
                    <pages-group :list="pages_group.pages" :index="pages_group.parent_index" :label="pages_group.parent_label"></pages-group>
                </div>
            </div>
            <div class="col-xs-12 ">
                <div class="divisor"></div>
            </div>
        </div>
    </script>
    @include('admin.pages.contents.index._table-row')
@endsection

@section('vue_store')
	<script>
		mainVueStore.page_groups = { data: {!! $pages_groups !!} };
	</script>
@endsection
