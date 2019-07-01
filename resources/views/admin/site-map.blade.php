@extends('layouts.admin')

@section('title')
    Mapa de rutas
@endsection

@section('h1')
    Mapa de rutas
@endsection

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <table class="table dataTable_JS ">
            <thead class="text__p text__p-table-head">
                <tr>
                    <th></th>
                    <th>Ruta</th>
                    <th><span class="pull-right">Nombre</span></th>
                </tr>
            </thead>
            <tbody class="text__p">
                @foreach ($routes as $route)
                    <tr class=" ">
                        <td class="routetd_JS">
                            <i class="fa fa-eye infoshow_JS " aria-hidden="true"></i>
                            <i class="fa fa-eye-slash infoshow_JS hidden" aria-hidden="true"></i>
                        </td>
                        <td class="">
                            <div >
                                <strong class="">
                                    {{$route->uri() }}
                                </strong>
                                <br><br>
                            </div>
                            <blockquote class="infoshow_JS hidden">
                                <p>
                                    <strong>Nombre:</strong> {{$route->getName() }}<br>
                                    <strong>Uri:</strong> {{$route->uri() }}<br><br>
                                    <strong>Methods:</strong> {{ implode(' | ', $route->methods()) }} <br>
                                    @if ($route->domain())
                                        <strong>Domain:</strong> {{  $route->domain()}}
                                    @endif<br>
                                    <strong>Controller:</strong> {{$route->getActionName() }}<br>
                                    <strong>Middewares:</strong> {{  is_array($route->getAction()["middleware"]) ? implode(" | ", $route->getAction()["middleware"]) : $route->getAction()["middleware"] }}
                                </p>
                            </blockquote>
                        </td>
                        <td>
                            <small class="pull-right text-right">
                                {{$route->getName() }}<br>
								{{ implode(' | ', $route->methods()) }}
                            </small>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('vue_store')
    <script>
    $(document).ready(function() {
        $(".dataTable_JS").on("click",".routetd_JS",function(e){
            console.log("click")
            $(this).closest("tr").find(".infoshow_JS").toggleClass("hidden");
        })
    });
    </script>
@endsection
