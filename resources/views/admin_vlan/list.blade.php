@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMIN VLAN</strong></a>
        </li>
        <li class="active">
            <a><strong>VLANs UTILIZADAS</strong></a>
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
                    <h5>LISTADO DE VLANS</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                        <a onclick="range_vlan_index(0);" class="btn btn-success" data-toggle="modal" data-target="#vlan_range_config">
                            Modificar Rango VLAN
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
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_admin_vlan">
                            <thead>
                                <tr>
                                    <th>Nro Vlan</th>
                                    <th>Tipo de Vlan</th>
                                    <th>Equipo</th>
                                    <th>Anillo</th>
                                    <th>Nodo</th>
                                    <th>Frontera</th>
                                    <th>Ip</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('confir')
@include('agg_association.poprelacionar_agg_pe_pei')
@include('admin_agg.pop_vlan_range_config')
@include('admin_agg.pop_add_range_vlan')
@include('servicio.popnew_puerto_lacp')
@endsection
