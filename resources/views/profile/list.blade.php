@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>ADMINISTRADOR</strong></a>
        </li>
        <li class="active">
            <a><strong>PERFILES</strong></a>
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
                    <h5>LISTADO DE LOS PERFILES</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a class="btn btn-success" data-toggle="modal" data-target="#popcrear_profil" onclick="crear_perfil();"><i class="fa fa-user-circle-o"></i>
                                Nuevo Perfil
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="claro_jarvis">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                @if($authori_status['permi'] >= 5)
                                <th>Opciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($profile as $use)
                                <?php $id =$use['id'] ?>
                                <tr>
                                    <td>{{$use['name']}}</td>
                                    @if($authori_status['permi'] >= 5)
                                        <td>
                                            <center>
                                                <a data-toggle="modal" data-target="#popcrear_profil" onclick="search_perfil('<?=$id?>');"> <i class="fa fa-edit" title="Editar perfil"> </i></a>
                                                <a onclick="return confirmation('../eliminar/perfile/<?= $id ?>', 'Esta seguro de la eliminación')"> <i class="fa fa-trash-o" title="Eliminar"> </i></a>
                                            </center>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('profile.popcrear')
@include('confir')
@endsection
