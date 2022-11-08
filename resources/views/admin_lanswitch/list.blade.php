@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>RED METRO</strong></a>
        </li>
        <li class="active">
            <a><strong>LANSWITCH</strong></a>
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
                            <a class="btn btn-success" data-toggle="modal" data-target="#crear_lanswitch_pop" onclick="alta_lanswitch_crear();">
                                <i class="fa fa-sitemap"></i>
                                LANSWITCH METROETHERNET
                            </a>
                            <a class="btn btn-success" data-toggle="modal" data-target="#crear_lsw_pop" onclick="create_lsw_new();">
                                <i class="fa fa-sitemap"></i>
                                LANSWITCH IPRAN
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="lanswitch_list">
                            <input type="hidden" name="functi" id="functi" value="LANSWITCH">
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
@include('admin_lanswitch.poppuerto_anillo')
@include('admin_lanswitch.poppuerto_nuevo_link')
@include('admin_lanswitch.popvincular_uplink_equipo')
@include('link.poplist')
@include('admin_cpe.popinfo_servicio')
@include('admin_lanswitch.popmodificar_recurso')
@include('admin_lanswitch.poplist_placa')
@include('admin_lanswitch.poplist_placa_nuevo')
@include('admin_cpe.poplabel')
@include('admin_lanswitch.popcrear_recurso')
@include('servicio.popcrear')
@include('admin_lanswitch.popcrear_lanswitch')
@include('admin_lanswitch.popcrear_lsw')
@include('anillo.popcrear')
@include('anillo.popnew_placa_alta')
@include('anillo.popnew_puerto_anillo_ipran_cliente')
@include('admin_lanswitch.popanillo')
@include('admin_lanswitch.poppuerto')
@include('admin_agg.popnew_placa_alta')
@include('admin_agg.poplabel')
@include('admin_cpe.popclient')
@include('client.popcrear')
@include('admin_agg.popinfor_placa')
@include('direccion.poplist_address')
@include('direccion.popaddress')
@include('admin_lanswitch.poplist_equipo')
@include('admin_lanswitch.popasignar_recurso')
@include('admin_lanswitch.poplist_frontier')
@include('admin_lanswitch.poplist_vlan')
@include('admin_cpe.popbaja')
@include('servicio.popnew_puerto_alta')
@include('admin_lanswitch.popadmin_ip_wan')
@include('admin_lanswitch.popvlan_ip')
@include('anillo.popnew_vlan_alta')
@include('admin_cpe.popadmin_ip')
@include('admin_lanswitch.popadmin_ip') //
@include('admin_ip.rama.popeliminar')
@include('admin_ip.rama.popcrear_red')
@include('admin_lanswitch.poplist_servicio')
@include('servicio.poplist_address')
@include('admin_lanswitch.poplist_puerto')
@include('admin_radio.poprelacionar_puertos_equipos')
@include('admin_radio.poplist_equipo_gral')
@include('admin_radio.poplist_puerto_gral')
@include('admin_radio.popdesconectar_puertos_equipos')
@include('nodo.poplist_nodo')
@include('admin_agg.poplist_agg')
@include('admin_cpe.popreservar_puerto')
@include('servicio.popcomentarior')
@include('equipment_model.popimg_equip')
@include('admin_lanswitch.poplocalizacion')
@include('servicio.popnew_puerto_recurso')
@include('servicio.popnew_puerto_lacp')
@include('list_crear')
@include('admin_lanswitch.pop_small_reserve_list')
@include('admin_agg.popcomentario')
@include('admin_lanswitch.popdetalle_puerto_servicio')
@include('admin_lanswitch.poplist_link')
@include('admin_lanswitch.poppuerto_link')
@include('confirmar')
@include('confir')
@endsection

@section('script')
    <script src="{{asset('public/js/inventario/red_metro/lanswitch/list.js')}}"></script>
    <script src="{{asset('public/js/inventario/red_metro/lanswitch/service_assignment.js')}}"></script>
    <script src="{{asset('public/js/inventario/red_metro/lanswitch/service_assignment_rpv.js')}}"></script>


@endsection
