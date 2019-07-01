@extends('layouts.admin')


@section('title')
    Ajustes
@endsection

@section('h1')
    Ajustes
@endsection


@section('content')

        {{-- Description --}}

        @include('admin.settings.setting._description')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Blog --}}

        @include('admin.settings.setting._blog')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Redes sociales --}}

        @include('admin.settings.setting._social')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Mail --}}

        @include('admin.settings.setting._mail')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Authentication --}}

        @include('admin.settings.setting._authentication')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Copies --}}

        @include('admin.settings.setting._copys')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

		@include('admin.settings.setting._event_create_images')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        @include('admin.settings.setting._event_image_search')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Event expiration --}}

        @include('admin.settings.setting._event_expiration')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

		{{-- porcentage minimo de preductos --}}

        @include('admin.settings.setting._checkout_min')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Card cost --}}

        @include('admin.settings.setting._card_cost')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

		{{-- Cashout min amount --}}

		@include('admin.settings.setting._cashout_min_amount')

		<div class="row">
			<div class="col-xs-12 col-md-10 col-md-offset-1">
				<br><hr><br><br><br>
			</div>
		</div>

		{{-- porcentage minimo de preductos --}}

        @include('admin.settings.setting._cash_out_fees')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Shipment --}}

        @include('admin.settings.setting._shipment')

        <div class="row">
            <div class="col-xs-12 col-md-10 col-md-offset-1">
                <br><hr><br><br><br>
            </div>
        </div>

        {{-- Exchange rate --}}

        @include('admin.settings.setting._exchange_rate')

@endsection

@section('modals')
    @include('admin.media_manager._mediaManager')
@endsection

@section('vue_templates')
    @include('admin.media_manager.vue.single-image-template')
@endsection
