@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>Administrador</strong></a>
        </li>
        <li class="active">
            <a href="{{ url('ver/usuario') }}"><strong>Usuarios</strong></a>
        </li>
        <li class="active">
            <a><strong>MODIFICAR PERFIL</strong></a>
        </li>
    </ol>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Modificar perfil</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form role="form" method="POST" action="{{ url('editar/perfil') }}">
                            {{ csrf_field() }}
                            <div class="col-sm-6 b-r">
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
                               
                                <div class="form-group">
                                    <label>Usuario</label> 
                                    <input  type="text" class="form-control" value="{{$users->username}}" disabled>
                                    <input  type="hidden" class="form-control" value="{{$users->id}}" name="id">
                                </div>
                                <div class="form-group">
                                    <label>Nombre</label> 
                                    <input  type="text" class="form-control" value="{{$users->name}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Apellido</label> 
                                    <input  type="text" class="form-control" value="{{$users->last_name}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Email</label> 
                                    <input  type="text" class="form-control" value="{{$users->email}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>status</label> 
                                    <input  type="text" class="form-control" value="{{$users->status}}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Perfil</label>
                                        <select class="perfil form-control" id="perfil" name="perfil" onchange="ShowSelected();">
                                            @foreach($profile as $pro)
                                                <option value="{{$pro->id}}"@if($pro->id == $users->id_profile) selected='selected' @endif>{{ $pro->name }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                                </div>    
                            </div>
                            
                            <div class="col-sm-6">
                                <label>Permiso del perfil</label>
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>Modulo</th>
                                            <th>Permiso</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyprofile">
                                         @foreach($prof as $prof)
                                            <tr>
                                                <td>{{$prof->name}}</td>
                                                <td>{{trans('user.permi.'.$prof->permi)}}</td>
                                            </tr>  
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
