@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMINISTRADOR</strong></a>
        </li>
        <li class="active">
            <a><strong>USUARIOS</strong></a>
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
                    <h5>LISTADO DE USUARIOS</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="user_lis_all">
                            <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                        <thead>
                            <tr>
                                <th>Nombre y Apellido</th>
                                <th>Departamento</th>
                                <th>Perfil</th>
                                <th>Estatus</th>
                                <th>Inicio</th>
                                <th>Final</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('confir')
@include('confirmar')
@endsection
