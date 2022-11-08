@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>AGREGACIÓN IP</strong></a>
        </li>
        <li class="active">
            <a><strong>CADENA DE AGG</strong></a>
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
                    <h5>LISTADO DE CADENA</h5>
                    <div class="ibox-tools">
                        <a onclick="create_chain();" class="btn btn-success" data-toggle="modal" data-target="#crear_cadena_pop">
                            Nuevo Cadena
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_cadena">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>BW</th>
                                    <th>Extremo 1</th>
                                    <th>Extremo 2</th>
                                    <th>Estado</th>
                                    <th>Descripción</th>
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
@include('cadena.popcrear')
@include('cadena.popequipoAGG')
@include('cadena.popmodificar')
@include('cadena.popasignarAGG')
@include('cadena.poprelacionar_puertos')
@include('cadena.poprelacionar_puertos_si')
@include('cadena.popnew_puerto_alta')
@include('admin_radio.poplist_puerto_radio')
@include('cadena.poplist_agg')
@include('confir')
@endsection
