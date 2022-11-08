@extends('layouts.app')
@section('content')
        <li class="active">
            <a><strong>MODELADO</strong></a>
        </li>
        <li class="active">
            <a><strong>MODELO DE PLACA</strong></a>
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
                    <h5>MODELADO DE PLACAS</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a onclick="crear_port();" class="btn btn-success  dim" data-toggle="modal" data-target="#popcrear_port" > <i class="fa fa-plus"></i> Crear</a>

                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="claro_placa">
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Placa</th>
                                <th>Cant</th>
                                <th>P.Fis</th>
                                <th>Tipo</th>
                                <th>Conector</th>
                                <th>BW</th>
                                <th>Label</th>
                                <th>P.Lóg</th>
                                <th></th>
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('equipment_model.popcrear_port')
@include('confir')
@include('list_crear')
@endsection
