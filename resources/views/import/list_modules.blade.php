@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMINISTRADOR</strong></a>
        </li>
        <li class="active">
            <a><strong>IMPORTAR</strong></a>
        </li>
        <li class="active">
            <a><strong>MÓDULOS</strong></a>
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
                    <h5>MODULOS (AGG)</h5>
                    <div class="ibox-tools">
                         <a class="btn btn-success" data-toggle="modal" data-target="#popadd_module" onclick="popadd_module_clean();">{{--<i class="fa fa-ethernet"></i> --}}
                                Nuevo Modulo
                            </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="impor_list_module">
                            <thead>
                                <tr>
                                    <th>Nombre Modulo</th>
                                    <th>Tipo de Modulo</th>
                                    <th>Distancia</th>
                                    <th>Fibra</th>
                                    <th>Corta|Larga</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('import.popadd_module')
@endsection
