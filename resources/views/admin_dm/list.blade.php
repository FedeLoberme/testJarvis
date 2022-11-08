@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>AGREGACIÓN IP</strong></a>
        </li>
        <li class="active">
            <a><strong>DM</strong></a>
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
                    <h5>Listado de Equipos</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#crear_dm_pop" onclick="alta_dm_crear();"><i class="fa fa-sitemap"></i>
                                Nuevo DM
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="jarvis_dm">
                            <input type="hidden" name="functi" id="functi" value="DM">
                            <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                            <thead>
                                <tr>
                                    <th>Nodo CID</th>
                                    <th>Acronimo</th>
                                    <th>Ip Gestión</th>
                                    <th>Estado</th>
                                    <th>Zona</th>
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
@include('admin_cpe.popbaja')
@include('admin_lanswitch.poplist_placa')
@include('admin_lanswitch.poplist_placa_nuevo')
@include('admin_lanswitch.poplist_puerto')
@include('admin_cpe.popreservar_puerto')
@include('servicio.popnew_puerto_lacp')
@include('servicio.popnew_puerto_recurso')
@include('admin_agg.popdetalle_puerto')
@include('admin_agg.popinfor_placa')
@include('admin_dm.popcrear_dm')
@include('admin_lanswitch.poplocalizacion')
@include('admin_agg.popnew_placa_alta')
@include('admin_agg.poplabel')
@include('admin_radio.poprelacionar_puertos_equipos')
@include('admin_radio.poplist_equipo_gral')
@include('admin_radio.poplist_puerto_gral')
@include('admin_radio.popdesconectar_puertos_equipos')
@include('admin_cpe.poplabel')
@include('nodo.popcrear')
@include('nodo.poplist_nodo')
@include('direccion.poplist_address')
@include('direccion.popaddress')
@include('admin_cpe.popadmin_ip')
@include('admin_ip.rama.popeliminar')
@include('admin_ip.rama.popcrear_red')
@include('admin_lanswitch.poplist_equipo')
@include('equipment_model.popimg_equip')
@include('admin_agg.popcomentario')
@include('admin_lanswitch.popdetalle_puerto_servicio')
@include('confirmar')
@include('confir')
@endsection

