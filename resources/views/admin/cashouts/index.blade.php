@extends('layouts.admin')


@section('title')
    Lista de retiros
@endsection

@section('h1')
    Lista de retiros
@endsection

@section('content')

    <cashouts :list="store.cashouts.data"></cashouts>

    <script type="x/templates" id="cashouts-template">

        <div class="row">

            <div class="col-xs-12">

        		@include('admin.cashouts.index._table')

        	</div>

        </div>

    </script>

@endsection

@section('modals')
    @include('admin.cashouts.status._modal-edit')
@endsection

@section('vue_store')
    <script>
        mainVueStore.cashouts = { data: {!! json_encode($cashouts) !!} };
    </script>
@endsection
