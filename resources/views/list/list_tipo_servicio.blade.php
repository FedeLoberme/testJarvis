@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>LISTA</strong></a>
    </li>
    @if(Route::is('lista.tipo.servicio'))
        <li class="active">
            <a><strong>TIPO DE SERVICIO</strong></a>
        </li>
    @endif
    @if(Route::is('lista.tipo.localizacion'))
        <li class="active">
            <a><strong>TIPO DE LOCALIZACIÓN</strong></a>
        </li>
    @endif
    @if(Route::is('lista.tipo.link'))
        <li class="active">
            <a><strong>TIPO DE LINK</strong></a>
        </li>
        @endif
    </ol>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <p>Corrige los siguientes errores:</p>
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>LISTA TIPO DE SERVICIO</h5>
                    <div class="ibox-tools">
                        <a onclick="clip_new_list_servi();" class="btn btn-success" data-toggle="modal" data-target="#lis_crear_servi" title="Agregar Tipo"><i class="fa fa-plus"> </i>
                            Agregar Tipo
                        </a>

                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$autori_status['permi']}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="claro_jarvis">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>IP</th>
                                <th>Ragon IP</th>
                                <th>Ancho de Banda</th>
                                <th>Relación</th>
                                @if($autori_status['permi'] >= 5)
                                    <th>Opción</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                             @foreach($data as $datos)
                                <tr id="elimi{{$datos->id}}">
                                    <td>{{$datos->name}}</td>
                                    <td>{{$datos->require_ip}}</td>
                                    <td>{{$datos->require_rank}}</td>
                                    <td>{{$datos->require_bw}}</td>
                                    <td>{{$datos->require_related}}</td>
                                    @if($autori_status['permi'] >= 5)
                                        <td>
                                            <center>
                                                <a data-toggle="modal" data-target="#lis_crear_servi" onclick="selec_lista_service(<?=$datos->id?>);" title="Editar valor de lista"> <i class="fa fa-edit"> </i></a>
                                                <a data-toggle="modal" data-target="#confimacion_full" onclick="delecte_lista_type_service(<?=$datos->id?>);" title="Eliminar"> <i class="fa fa-trash-o" > </i></a>
                                            </center>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('list.list_crear_servicio')
@include('confir')
@include('confirmar')
@endsection

