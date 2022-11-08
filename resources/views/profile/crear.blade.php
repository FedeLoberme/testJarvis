@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>Administrador</strong></a>
        </li>
        <li class="active">
            <a href="{{ url('ver/perfil') }}"><strong>Perfiles</strong></a>
        </li>
        <li class="active">
            <a><strong>Creación de perfil</strong></a>
        </li>
    </ol>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>CREAR PERFIL</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <form role="form" method="POST" action="{{ url('registar/perfil') }}">
                            {{ csrf_field() }}
                            <div class="col-sm-4 b-r">
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
                                    <label>Nombre del Perfil</label> 
                                    <input style="text-transform: capitalize;" type="text" placeholder="NOMBRE" autocomplete="off" name="name"class="form-control" value="{{old('name')}}">
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                                </div>    
                            </div>
                            
                            <div class="col-sm-8">
                                <label>Selecione su permiso</label>
                                <table class="table table-striped table-bordered table-hover dataTables-example" id="claro_jarvis">
                                    <thead>
                                        <tr>
                                            <th>Modulo</th>
                                            <th colspan="4">Permiso</th>
                                        </tr>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Sin acceso</th>
                                            <th>Lectura</th>
                                            <th>Modificar</th>
                                            <th>Crear</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $contador = 0;
                                        ?>
                                        @foreach($application as $appli)
                                        <tr>
                                            <td>{{$appli['name']}}</td> 

                                            <input type="hidden" value="{{$appli['id']}}" name="applicati[<?=$contador?>]"> 

                                            <td><center><input type="radio" value="0" name="permission[<?=$contador?>]" checked="checked"> </center> </td>
                                               
                                            <td><center><input type="radio" value="3" name="permission[<?=$contador?>]"></center></td>
                                                
                                            <td><center><input type="radio" value="5" name="permission[<?=$contador?>]"> </center></td>
                                                
                                            <td><center><input type="radio" value="10" name="permission[<?=$contador?>]"> </center></td> 
                                        </tr>
                                        <?php
                                        $contador = $contador +1;
                                        ?> 
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
