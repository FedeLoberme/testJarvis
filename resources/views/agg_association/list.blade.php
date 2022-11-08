@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMIN VLAN</strong></a>
        </li>
        <li class="active">
            <a><strong>ASOCIACIONES DE AGREGADOR</strong></a>
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
                    <h5>LISTADO DE ASOCIACIONES DE AGREGADOR</h5>
                    <div class="ibox-tools">
                        <a onclick="relate_agg_pe_pei();" class="btn btn-success" data-toggle="modal" data-target="#poprelate_agg_pe_pei">
                            Nueva Asociaci&oacute;n
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="agg_assoc_table">
                            <thead>
                                <tr>
                                    <th>Agregador</th>
                                    <th>IP de Gesti&oacute;n</th>
                                    <th>Zona Home</th>
                                    <th>PE Home</th>
                                    <th>PEI Home</th>
                                    <th>Zona Multihome</th>
                                    <th>PE Multihome</th>
                                    <th>PEI Multihome</th>
                                    <th>Estado</th>
                                    <th>Opci&oacute;n</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('agg_association.poprelacionar_agg_pe_pei')
@include('admin_pe.poplist')
@include('cadena.poplist_agg')
@endsection
