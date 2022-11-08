@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>INVENTARIO</strong></a>
    </li>
    <li class="active">
        <a><strong>RADIO</strong></a>
    </li>
    <li class="active">
        <a><strong>RADIO ENLACE</strong></a>
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
                    <h5>Listado de Equipos Radio Enlace</h5>
                    <div class="ibox-tools">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="ListRadioEnlace">
                        <input type="hidden" name="functi" id="functi" value="RADIO_ENLACE">
                        <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Extremo 1</th>
                                <th>Extremo 2</th>
                                <th>BW</th>
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
@include('admin_cpe.popinfo_servicio')
@include('confir')
@include('confirmar')
@endsection
