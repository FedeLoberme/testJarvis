@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>MODELADO</strong></a>
        </li>
        <li class="active">
            <a><strong>MODELOS DE EQUIPOS</strong></a>
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
                    <h5>MODELADO DE EQUIPOS</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success  dim" onclick="new_equipment_function();" data-toggle="modal" data-target="#crear_equipo" > <i class="fa fa-plus"></i> Crear</a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="claro_modelo">
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <!-- <th>Bandwitdh max</th> -->
                                <th>Descripción</th>
                                @if($authori_status['permi'] >= 3)
                                    <th>Opciones</th>
                                @endif
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @include('equipment_model.popcrear_equipo')
    @include('equipment_model.popdetal')
    @include('equipment_model.popinfor_port')
    @include('equipment_model.popimg_equip')
    @include('equipment_model.popfuntion')
    @include('confir')
    @include('list_crear')
@endsection
