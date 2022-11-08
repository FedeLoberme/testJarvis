@extends('layouts.app')
@section('content')
        <li class="active">
            <a><strong>Aplicación</strong></a>
        </li>
        <li class="active">
            <a href="{{ url('ver/inventario') }}"><strong>Modelos de equipos</strong></a>
        </li>
        <li class="active">
            <a><strong>{{$equipm->equipment}} {{$equipm->mark}} {{$equipm->model}}</strong></a>
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
            <input id="Id" type="hidden" value="{{$id}}">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>PLACAS ASIGNADAS </h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <input type="hidden" id="id_equip" name="id_equip" value="<?=$id?>">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="lis_port_occupied">
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
                                <th>F/S/P</th>
                                <th>P.Lóg</th>
                                @if($authori_status['permi'] >= 5)
                                <th></th>
                                @endif
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                         <h5>ASIGNAR PLACA</h5>
                    <div class="ibox-tools">  
                        <a onclick="crear_port();" class="btn btn-success  dim" data-toggle="modal" data-target="#popcrear_port" > <i class="fa fa-user-circle-o"></i> Crear</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="lis_port_free">
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Tipo de placa</th>
                                <th>Cant</th>
                                <th>P.Fis</th>
                                <th>Tipo de puerto</th>
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
    @include('equipment_model.popFSP')
    @include('confir')
    @include('list_crear')
@endsection
