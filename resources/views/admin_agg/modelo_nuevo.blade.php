@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>Inventario</strong></a>
        </li>
        <li class="active">
            <a><strong>Equipo</strong></a>
        </li>
    </ol>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Cambiar Modelo del Equpo: {{$equip->acronimo}}, Modelo {{$equip->model}}</h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <form method="POST" id="FormMigrationAll" role="form" accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" id="id_equipos" name="id_equipos" value="0">
                        <input type="hidden" id="id" name="id" value="{{$id}}">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Modelo*</label>
                                <div class="bw_all">
                                    <select onchange="EquipmentBoard();" class="form-control" id="equi_alta" name="equi_alta">
                                        <option selected disabled value="">Seleccionar</option>
                                        @foreach($datos as $data)
                                            @if (old('equi_alta') == $data['id'])
                                                <option value="{{ $data['id'] }}" selected>{{ $data['option'] }}</option>
                                            @else
                                                <option value="{{ $data['id'] }}">{{ $data['option'] }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <a class="ico_input btn btn-info" data-toggle="modal" data-target="#img_equip" title="Buscar imagen" id="img_alta_equipo" style="display: none;" onclick="img_equip_alta();"><i class="far fa-image"> </i> IMG</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="display: none;" id="all_board">
                            <div class="form-group">
                                <label>Placa* </label> 
                                <a style="display: none;" id="agregador" data-toggle="modal" data-target="#new_placa_alta" onclick="Agregarplaca();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar Placa</a>
                                <div id="campos">
                                            
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>

                        <div class="col-sm-12">
                            <div class="col-sm-8">
                                <label>Puerto Modelo Viejo</label>
                            </div>
                            <div class="col-sm-4">
                                <label>Puerto Modelo Nuevo</label>
                            </div>
                        </div>
                        @foreach($port_all_inf as $n => $val)
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="col-sm-3">
                                        <p class="form-control">{{$val['port']}}</p>
                                    </div>
                                    <div class="col-sm-5">
                                        <p class="form-control">{{$val['status']}}, {{$val['atributo']}}</p>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="hidden"  name="id_port[]" value="{{$val['id']}}">
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select port_new" id="port_new{{$n}}" readonly="readonly" name="port_new[]">
                                                <option selected disabled value="">Seleccionar Puerto</option>
                                            </select>
                                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#new_port_migratxxxxion" title="Buscar Puerto" onclick="MigrationPortModelNew({{$n}});"><i class="fa fa-search"> </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-sm-12 text-center">
                            <button class="btn btn-primary text-center" type="submit" >
                                <i class="fa fa-floppy-o"></i><strong>  Guardar</strong>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin_agg.popnew_placa_alta')
@include('admin_agg.poplabel')
@include('admin_agg.poppuerto_migracion')
@endsection

