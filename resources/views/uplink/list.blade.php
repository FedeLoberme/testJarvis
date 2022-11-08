@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>UPLINK</strong></a>
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
                    <h5>LISTADO DE UPLINK</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#popcrear_uplink" onclick="crear_uplink();"><i class="fa fa-share-alt"></i> 
                                Nuevo Uplink
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
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="uplink_list">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>BW Maximo</th>
                                <th>BW Actual</th>
                                <th>Equipo</th>
                                <th>IP</th>
                                <th>Puerto</th>
                                <th>MT</th>
                                <th>CT</th>
                                <th>Vlan</th>
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
@include('uplink.popcrear')
@include('confir')

@endsection

