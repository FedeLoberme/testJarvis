@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>LISTA</strong></a>
    </li>
    @if(Route::is('lista.equipo'))
        <li class="active">
            <a><strong>EQUIPOS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.marca'))
        <li class="active">
            <a><strong>MARCAS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.banda'))
        <li class="active">
            <a><strong>BANDAS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.radio'))
        <li class="active">
            <a><strong>RADIOS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.alimentacion'))
        <li class="active">
            <a><strong>ALIMENTACIONES</strong></a>
        </li>
    @endif
    @if(Route::is('lista.puerto'))
        <li class="active">
            <a><strong>PUERTOS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.conector'))
        <li class="active">
            <a><strong>CONECTORES</strong></a>
        </li>
    @endif
    @if(Route::is('lista.etiqueta'))
        <li class="active">
            <a><strong>ETIQUETAS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.placa'))
        <li class="active">
            <a><strong>MODELOS DE PLACAS</strong></a>
        </li>
    @endif
    @if(Route::is('lista.estado'))
        <li class="active">
            <a><strong>ESTADO IP</strong></a>
        </li>
    @endif
    @if(Route::is('lista.pais'))
        <li class="active">
            <a><strong>PAÍS Y PROVINCIA</strong></a>
        </li>
    @endif
    @if(Route::is('lista.provincia'))
        <li class="active">
            <a><strong>PROVINCIA</strong></a>
        </li>
    @endif
    @if(Route::is('lista.baja'))
        <li class="active">
            <a><strong>BAJAS DE SERVICIO</strong></a>
        </li>
    @endif
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
                            <h5>LISTA {{$name}}</h5>
                            <div class="ibox-tools">
                                <a class="btn btn-success" data-toggle="modal" data-target="#lis_selec"
                                   onclick="list_database(<?=$lis?>);" title="Agregar localización"> <i
                                        class="fa fa-plus"> </i> Nuevo</a>
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <input type="hidden" id="permi" value="{{$autori_status['permi']}}">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example"
                                       id="claro_jarvis">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        @if($autori_status['permi'] >= 5)
                                            <th>Opción</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $datos)
                                        <tr id="elimi{{$datos->id}}">
                                            <td>{{$datos->name}}</td>
                                            @if($autori_status['permi'] >= 5)
                                                <td>
                                                    <center>
                                                        <a data-toggle="modal" data-target="#lis_edict"
                                                           onclick="selec_lista(<?=$datos->id?>, <?=$lis?>);"
                                                           title="Editar valor de lista"> <i
                                                                class="fa fa-edit"> </i></a>
                                                        <a onclick="delecte_lista(<?=$datos->id?>, <?=$lis?>);"
                                                           title="Eliminar"> <i class="fa fa-trash-o"> </i></a>
                                                        @if($lis == 11)
                                                            <a data-toggle="modal" data-target="#pop_list_provincia"
                                                               onclick="provincia_lista(<?=$datos->id?>);"
                                                               title="Ver provincia"> <i class="fa fa-desktop"> </i></a>
                                                        @endif
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
        @include('list.list_provincia')
        @include('list.list_provincia_editar')
        @include('list.list_edict')
        @include('list_crear')
        @include('confir')
        @endsection

