@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>INVENTARIO</strong></a>
    </li>
    <li class="active">
        <a><strong>RED METRO</strong></a>
    </li>
    <li class="active">
        <a><strong>AGREGADOR</strong></a>
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
                                <a class="btn btn-success" data-toggle="modal" data-target="#crear_agg_pop"
                                   onclick="alta_agg_crear();"><i class="fa fa-sitemap"></i>
                                    Nuevo Agregador
                                </a>
                            @endif
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                   id="claro_agregador">
                                <input type="hidden" name="functi" id="functi" value="AGG">
                                <input type="hidden" id="permi" value="{{$authori_status['permi']}}">
                                <thead>
                                <tr>
                                    <th>Nodo CID</th>
                                    <th>Agregador</th>
                                    <th>Ip Gestión</th>
                                    <th>Estado</th>
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
    @include('admin_lanswitch.poplist_placa')
    @include('admin_lanswitch.poplist_placa_nuevo')
    @include('admin_cpe.poplabel')
    @include('admin_agg.popcrear_recurso')
    @include('admin_agg.popcrear_agg')
    @include('admin_agg.pop_vlan_range_config')
    @include('admin_agg.pop_add_range_vlan')
    @include('servicio.popcrear')
    @include('admin_agg.popnew_placa_alta')
    @include('admin_agg.poplabel')
    @include('admin_agg.list_acronimo')
    @include('admin_agg.list_crear')
    @include('admin_cpe.popclient')
    @include('client.popcrear')
    @include('admin_agg.popinfor_placa')
    @include('nodo.popcrear')
    @include('nodo.poplist_nodo')
    @include('direccion.poplist_address')
    @include('direccion.popaddress')
    @include('admin_lanswitch.poplist_equipo')
    @include('agg_association.poprelacionar_agg_pe_pei')
    @include('admin_pe.poplist')
    @include('admin_cpe.popbaja')
    @include('admin_cpe.popinfo_servicio')
    @include('servicio.popnew_puerto_alta')
    @include('admin_cpe.popadmin_ip')
    @include('admin_ip.rama.popeliminar')
    @include('admin_ip.rama.popcrear_red')
    @include('anillo.poplist_servicio')
    @include('admin_lanswitch.poplist_servicio')
    @include('servicio.poplist_address')
    @include('admin_lanswitch.poplist_puerto')
    @include('admin_radio.poprelacionar_puertos_equipos')
    @include('admin_radio.poplist_equipo_gral')
    @include('admin_radio.poplist_puerto_gral')
    @include('admin_radio.popdesconectar_puertos_equipos')
    @include('admin_cpe.popreservar_puerto')
    @include('servicio.popcomentarior')
    @include('equipment_model.popimg_equip')
    @include('admin_lanswitch.poplocalizacion')
    @include('servicio.popnew_puerto_recurso')
    @include('servicio.popnew_puerto_lacp')
    @include('admin_agg.popdetalle_puerto')
    @include('list_crear')
    @include('admin_agg.popcomentario')
    @include('admin_lanswitch.popdetalle_puerto_servicio')
    @include('confirmar')
    @include('confir')
@endsection

