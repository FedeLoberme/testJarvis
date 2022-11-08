@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>RADIO</strong></a>
        </li>
        <li class="active">
            <a><strong>ADMIN RADIO</strong></a>
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
                            <a class="btn btn-success" data-toggle="modal" data-target="#crear_radio_pop" onclick="alta_radio_crear();"><i class="fa fa-sitemap"></i>
                                Nuevo Radio
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="jarvis_radio">
                        <input type="hidden" name="functi" id="functi" value="RADIO">
                        <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                        <thead>
                            <tr>
                                <th>Acrónimo</th>
                                <th>Cliente</th>
                                <th>Ip</th>
                                <th>Modelo</th>
                                <th>Enlace</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Dirección</th>
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
@include('admin_agg.popinfor_placa')
@include('admin_cpe.popbaja')
@include('admin_agg.popcrear_recurso')
@include('admin_lanswitch.poplist_placa')
@include('admin_lanswitch.poplist_placa_nuevo')
@include('admin_cpe.popinfo_servicio')
@include('admin_radio.popup_wizard_radio')
@include('admin_radio.popeditar')
@include('admin_radio.popeditar_node')
@include('list_crear')
@include('servicio.popcrear')
@include('nodo.popcrear')
@include('nodo.poplist_nodo')
@include('admin_lanswitch.poplist_puerto')
@include('admin_radio.poprelacionar_puertos_equipos')
@include('admin_radio.poplist_equipo_gral')
@include('admin_radio.poplist_puerto_gral')
@include('admin_radio.popdesconectar_puertos_equipos')
@include('admin_lanswitch.popmodificar_recurso')
@include('client.popcrear')
@include('admin_cpe.popclient')
@include('direccion.poplist_address')
@include('direccion.popaddress')
@include('servicio.poplist_address')
@include('admin_lanswitch.poplist_equipo')
@include('servicio.poplist_equipo')
@include('admin_lanswitch.poplist_servicio')
@include('admin_lanswitch.popadmin_ip')
@include('admin_lanswitch.popadmin_ip_wan')
@include('admin_cpe.popadmin_ip')
@include('servicio.popnew_puerto_alta')
@include('admin_ip.rama.popeliminar')
@include('admin_ip.rama.popcrear_red')
@include('admin_radio.poplist_equipo')
@include('admin_radio.poplist_puerto')
@include('admin_radio.poplist_puerto_radio')
@include('admin_radio.popdetalle_puerto')
@include('admin_agg.popcomentario')
@include('admin_cpe.popreservar_puerto')
@include('equipment_model.popimg_equip')
@include('admin_radio.popeditar_odu_antena')
@include('confir')
@include('confirmar')

@endsection
