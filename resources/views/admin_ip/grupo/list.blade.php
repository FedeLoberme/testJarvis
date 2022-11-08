@extends('layouts.app')
@section('content')
        <li class="active">
            <a><strong>ADMIN IP</strong></a>
        </li>
        <li class="active">
            <a><strong>GRUPOS</strong></a>
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
                    <h5>LISTADO DE LOS GRUPOS</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-success" onclick="crear_group();" data-toggle="modal" data-target="#popcrear_grupo"><i class="fa fa-group"></i>
                            Nueva Grupo
                        </a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <input  type="hidden" id="permi" value="10">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="lis_group_ip">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('admin_ip.grupo.popcrear')
@include('admin_ip.grupo.popusuario')
@include('admin_ip.grupo.poppermiso')
@include('confir')
@endsection
