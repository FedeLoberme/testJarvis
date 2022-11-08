@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMIN CELDA</strong></a>
        </li>
        <li class="active">
            <a><strong>LINK UPLINK CELDA (IPRAN)</strong></a>
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
                    <h5>Listado de Link Ipran</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#crear_link_pop" onclick="alta_link_crear();"><i class="fa fa-sitemap"></i>
                                Nuevo LINK
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_link_ipran">
                            <thead>
                                <tr>
                                    <th>Acrónimo</th>
                                    <th>Tipo</th>
                                    <th>Nodo</th>
                                    <th>Lanswitch</th>
                                    <th>Estado</th>
                                    <th>BW </th>
                                    <th>Bw reservado </th>
                                    <th>Bw remanente </th>
                                    <th>Bw usado</th>
                                    <th>Estado Nodo</th>
                                    <th>Comentario</th>
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
@include('link.popcrear')
@include('link.pop_modify_link')
@include('nodo.poplist_nodo')
@include('admin_cpe.popinfo_servicio')
@include('admin_lanswitch.popmodificar_recurso')
@include('servicio.popnew_puerto_alta')
@include('admin_agg.popcomentario')
@include('confirmar')
@include('confir')
@endsection

