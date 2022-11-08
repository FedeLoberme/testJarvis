@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>ADMINISTRATIVO</strong></a>
        </li>
        <li class="active">
            <a><strong>DIRECCIONES</strong></a>
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
                    <h5>DIRECCIONES</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-success" data-toggle="modal" data-target="#popaddress_general" onclick="address_general();"><i class="fa fa-map-marker"></i>
                                Nueva Dirección
                            </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                    <input  type="hidden" id="id_function" value="DIRECCION">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_address">
                        <thead>
                            <tr>
                                <th>País</th>
                                <th>Provincia</th>
                                <th>Localidad</th>
                                <th>Calle</th>
                                <th>Altura</th>
                                <th>Piso</th>
                                <th>Casa</th>
                                <th>C. Postal</th>
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
@include('direccion.popaddress')
@include('direccion.poplist_contenido')
@include('admin_cpe.popcrear_recurso')
@include('servicio.popnew_puerto_alta')
@include('admin_lanswitch.poplist_servicio')
@include('servicio.popcrear')
@include('servicio.popnew_puerto_lacp')
@include('servicio.popnew_puerto_recurso')
@include('confir')
@include('list_crear')
@endsection








