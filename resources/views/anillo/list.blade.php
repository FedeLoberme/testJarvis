@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>RED METRO</strong></a>
        </li>
        <li class="active">
            <a><strong>ANILLO</strong></a>
        </li>
    </ol>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
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
                    <h5>LISTADO DE ANILLO</h5>
                    <div class="ibox-tools">
                        @if($autori_status['permi'] >= 10)
                            <a class="btn btn-success" onclick="crear_new_anillo();" data-toggle="modal" data-target="#popcrear_anillo"  ><i class="fa fa-circle-o-notch"></i>
                                Nuevo Anillo Metroethernet
                            </a>
                            <a class="btn btn-success" onclick="create_new_ring_ipran();" data-toggle="modal" data-target="#popcreate_ring_ipran"  ><i class="fa fa-circle-o-notch"></i>
                                Nuevo Anillo Ipran
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$autori_status['permi']}}">
                    <input  type="hidden" id="id_function" value="1">
                    <input  type="hidden" id="functi" value="anillo">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="anillo_list">
                        <thead>
                            <tr>
                                <th>Acrónimo</th>
                                <th>Agregador</th>
                                <th>Tipo</th>
                                <th>Dedicado</th>
                                <th>Estado</th>
                                <th>Equipo</th>
                                <th>Capacidad</th>
                                <th>Utilizado</th>
                                <th>Util</th>
                                <th>Asignación FO</th>
                                <th>Anillo</th>
                                <th>Opción</th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</div>
@include('anillo.poppuerto_anillo')
@include('anillo.poppuerto_nuevo_anillo')
@include('anillo.poplist_servicio')
@include('anillo.popcrear')
@include('anillo.popcrear_ipran')
@include('anillo.popeditar')
@include('anillo.poppuerto')
@include('admin_agg.popcrear_agg')
@include('anillo.popnew_placa_alta')
@include('anillo.popnew_port_ipran')
@include('anillo.poplist_vlan_ip')
@include('anillo.popnew_vlan_alta')
@include('admin_cpe.popadmin_ip')
@include('admin_ip.rama.popeliminar')
@include('admin_ip.rama.popcrear_red')
@include('nodo.poplist_nodo')
@include('nodo.popcrear')
@include('direccion.poplist_address')
@include('direccion.popaddress')
@include('admin_agg.poplist_agg')
@include('anillo.poplist_lsw')
@include('anillo.poplist_equipo')
@include('link.poplist_frontier')
@include('admin_lanswitch.poplist_puerto')
@include('admin_cpe.popreservar_puerto')
@include('admin_agg.popdetalle_puerto')
@include('confir')
@include('confirmar')
@endsection

