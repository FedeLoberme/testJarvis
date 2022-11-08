@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>ADMINISTRATIVO</strong></a>
        </li>
        <li class="active">
            <a><strong>SERVICIOS</strong></a>
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
                    <h5>Listado de Servicios</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#crear_servicio_pop" onclick="alta_servicio_crear();"><i class="fa fa-sitemap"></i>
                                Nuevo Servicio
                            </a>
                        <!--     <a class="btn btn-success" data-toggle="modal" data-target="#crear_servicio_pop_prueba" onclick="alta_servicio_crear();"><i class="fa fa-sitemap"></i>
                                Test Nuevo Servicio
                            </a> -->

                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="servicios_list">
                            <input type="hidden" name="id_function" id="id_function" value="SERVICIO">
                            <input type="hidden" name="functi" id="functi" value="SERVICIO">
                            <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                            <thead>
                                <tr>
                                    <th>N° Servicio</th>
                                    <th>Tipo</th>
                                    <th>Orden</th>
                                    <th>BW Servicio</th>
                                    <th>Cliente</th>
                                    <th>Estado</th>
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
@include('servicio.poplis_ip_recurso')
@include('servicio.poplist_recurso')
@include('servicio.popvlan_new')
@include('servicio.popcrear')
@include('admin_cpe.popclient')
@include('client.popcrear')
@include('servicio.popasignar_recurso')
@include('servicio.popcrear_recurso')
@include('servicio.popnew_puerto_alta')
@include('servicio.popip_new')
@include('admin_cpe.popadmin_ip')
@include('admin_ip.rama.popeliminar')
@include('admin_ip.rama.popcrear_red')
@include('direccion.poplist_address')
@include('servicio.poplist_address')
@include('direccion.popaddress')
@include('servicio.popnew_puerto_recurso')
@include('servicio.popbaja')
@include('servicio.popcancelar')
@include('servicio.popcomentarior')
@include('servicio.poplist_equipo')
@include('servicio.popnew_puerto_lacp')
@include('list_crear')
@include('admin_agg.popcomentario')
@include('servicio.popredirect_service_assignment')
@include('confirmar')
@include('confir')
@endsection

@section('script')
    <script src="{{asset('public/js/inventario/administrativo/servicios/list.js')}}"></script>
    <script src="{{asset('public/js/inventario/administrativo/servicios/resource.js')}}"></script>
@endsection