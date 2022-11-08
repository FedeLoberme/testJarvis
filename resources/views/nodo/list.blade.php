@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>NODO</strong></a>
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
                    <h5>LISTADO DE NODO</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#popcrear_nodo" onclick="crear_nodo();"><i class="fa fa-share-alt"></i>
                                Nuevo Nodo
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input type="hidden" name="id_function" id="id_function" value="Nodo">
                    <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                    <input  type="hidden" id="functi" value="anillo">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="nodo_list">
                        <thead>
                            <tr>
                                <th>CELL ID</th>
                                <th>Nodo</th>
                                <th>Tipo</th>
                                <th>Propietario</th>
                                <th>Fecha de Contrato</th>
                                <th>Dirección</th>
                                <th>Estado</th>
                                <th>Apta</th>
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
@include('nodo.popcrear')
@include('nodo.popcomentario')
@include('direccion.poplist_address')
@include('direccion.popaddress')
@include('nodo.poplist_vlan_ip')
@include('nodo.poplist_equipment')
@include('anillo.popnew_vlan_alta')
@include('admin_cpe.popadmin_ip')
@include('confir')
@endsection

