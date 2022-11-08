@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>APN</strong></a>
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
                    <h5>LISTADO DE ANILLO</h5>
                    <div class="ibox-tools">

                            <a class="btn btn-success" data-toggle="modal" data-target="#admin_apn_crear"  ><i class="fa fa-circle-o-notch"></i>
                                Nuevo APN
                            </a>

                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="functi" value="APN">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="anillo_apn">
                        <thead>
                            <tr>
                                <th>Acrónimo</th>
                                <th>Agregador</th>
                                <th>Tipo</th>
                                <th>Dedicado</th>
                                <th>Estado</th>
                                <th>Equipos</th>
                                <th>Capacidad</th>
                                <th>Utilizado</th>
                                <th>Cap. - Util</th>
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

@include('admin_apn.popcrear')
@include('confir')
@include('confirmar')
@endsection

