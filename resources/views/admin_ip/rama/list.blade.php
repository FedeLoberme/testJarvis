@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMIN IP</strong></a>
        </li>
        <li class="active">
            <a><strong>RAMAS</strong></a>
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
                    <h5>LISTADO DE RAMAS</h5>
                    <div class="ibox-tools">
                        <div id="boton_filter_cerrar" style="display: none;">
                            <a class="btn btn-success" onclick="DelecteFilter();" ><i class="fa fa-filter"></i> Cerrar Filtro</a>
                        </div>
                        <div id="boton_filter">
                            <a class="btn btn-success" data-toggle="modal" data-target="#popfilter" onclick="FilterIP();"><i class="fa fa-filter"></i> Filtro Rango</a>
                            <a class="btn btn-success" data-toggle="modal" data-target="#buscar_list_ip" onclick="ClearFilterIP();"><i class="fa fa-filter"></i> Filtro Lista</a>
                            <a class="btn btn-success" data-toggle="modal" data-target="#buscar_sub_red_ip" onclick="ClearSubRed();"><i class="fa fa-filter"></i> Filtro Sub-Redes</a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content overflow-modal">
                    <input type="hidden" name="functi" id="functi" value="admin_ip">
                    <input  type="hidden" id="id_rama_old" value="0">
                    <input  type="hidden" id="id_rango_old" value="0">
                    <input  type="hidden" id="permi" value="10">
                    <div class="table-responsive">
                        <div class="col-sm-5 table_ramas" id="conten1">
                            <table class="table_ramas hijos">
                                @foreach($branch_base as $base)
                                <ul >
                                    <li><i class="fa fa-plus-square-o" id="positivo<?=$base['id']?>" onclick="ver_mas_rama(<?=$base['id']?>);"></i>
                                        <i class="fa fa-minus-square-o" style="display: none;" id="negativo<?=$base['id']?>" onclick="eliminar_mas_rama('<?=$base['id']?>');"></i></li>
                                    <li>-<i class="fa fa-database"></i> </li>
                                    <li> {{$base['name']}} {{$base['ip_rank']}}</li>
                                    @if($base['permi'] >= 10)
                                        <li title="Modificar Rama"><i class="fa fa-edit" data-toggle="modal" data-target="#popcrear_rama" onclick="modificar_rama('<?=$base['id']?>');"></i> </li>
                                        <li title="Crear Rama Hijo"><i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_sin_rank(<?=$base['id']?>);"></i></li>
                                    @endif
                                    <table class="table_ramas hijos" style="margin-left: 15px;" id="contenedor<?=$base['id']?>">
                                    </table>
                                </ul>
                                @endforeach
                            </table>
                        </div>
                        <div class="col-sm-7 " id="multi_table_ip">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin_ip.rama.poplist_sub_red_publica')
@include('admin_ip.rama.popfiltro')
@include('admin_ip.rama.poplist_ip')
@include('admin_ip.rama.popasignar_red')
@include('admin_ip.rama.popasignar')
@include('admin_ip.rama.popanillo')
@include('admin_ip.rama.poplist_equipo')
@include('admin_lanswitch.poplist_servicio')
@include('admin_cpe.popclient')
@include('admin_ip.rama.popsub_red_all')
@include('admin_ip.rama.popcrear')
@include('admin_ip.rama.popeliminar')
@include('admin_ip.rama.popcrear_red')
@include('admin_ip.rama.popdetal')
@include('admin_ip.rama.popestado')
@include('admin_ip.rama.popliberar')
@include('admin_ip.rama.poplocalizacion')
@include('admin_ip.rama.poplist_stock_ip')
@include('nodo.poplist_nodo')
@include('confirmar')
@include('confir')
@endsection

