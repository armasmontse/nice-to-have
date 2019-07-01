<div id="{{$modal_id}}" class="modal fade modal__scroll" tabindex="-1" role="dialog" aria-labelledby="labelDetails" aria-hidden="true">
    <div class="modal-dialog modal-lg modal__dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @include('admin.general.modals.partials._header')
            </div>

            <div class="modal-body">
                <div class="row modal__row-title">
                    <div class="col-xs-12">
                        <div class="modal__page-header">
                            <h3 class="text__subtitle text__subtitle--no-margin">@yield('modal-title')</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1">
                        @yield('modal-content')
                    </div>
                </div>
            </div>

            <div class="modal-footer">
               @include('admin.general.modals.partials._footer')
            </div>
        </div>
    </div>
</div>