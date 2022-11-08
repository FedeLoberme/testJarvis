@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMINISTRADOR</strong></a>
        </li>
        <li class="active">
            <a><strong>IMPORTAR</strong></a>
        </li>
        <li class="active">
            <a><strong>AGREGADORES</strong></a>
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
                    <h5>Importar Excel</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#impor_agg_all" ><i class="fa fa-cloud-upload"></i>
                                Subir Nuevo Excel
                            </a>
                        @endif
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="impor_agg_data">
                            <thead>
                                <tr>
                                    <th>IP</th>
                                    <th>Hostname</th>
                                    <th>Interface</th>
                                    <th>Admin Status</th>
                                    <th>Oper Status</th>
                                    <th>Descripcion</th>
                                    <th>Nombre Modulo</th>
                                    <th>Descripcion Modulo</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('import.popimpor_agg')
@endsection
