@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMIN CELDA</strong></a>
        </li>
        <li class="active">
            <a><strong>RESERVA</strong></a>
        </li>
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
                    <h5>LISTADO DE RESERVAS</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                        <a onclick="create_reserve();" class="btn btn-success" data-toggle="modal" data-target="#crear_reserva_pop">
                            Crear Reserva
                        </a>
                        @endif
                        @if($authori_status['permi'] >= 90)
                        <a onclick="create_service_reserve();" class="btn btn-success" data-toggle="modal" data-target="#crear_reserva_servicio_pop">
                            Crear Reserva Sobre Servicio
                        </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_reserve">
                            <thead>
                                <tr>
                                    <th>Nro Reserva</th>
                                    <th>Bw Reserva</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th>Fecha de Inicio</th>
                                    <th>Dias restantes</th>
                                    <th>Oportunidad</th>
                                    {{-- <th>Tipo Servicio</th> --}}
                                    <th>Nodo</th>
                                    <th>Nro Servicio</th>
                                    {{-- <th>Bw reservado</th> --}}
                                    <th>Comentario</th>
                                    <th>Opción</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('reserve.popcrear')
@include('reserve.popservice_crear')
@include('admin_lanswitch.poplist_servicio')
@include('reserve.pop_edic_alta_reserve')
@include('nodo.poplist_nodo')
@include('reserve.pop_info_celda')
@include('reserve.poplist_link')
@include('admin_cpe.popclient')
@include('reserve.pop_small_info_create')
@include('reserve.popaplicar_reserva_servicio')
@include('confir')
@endsection
