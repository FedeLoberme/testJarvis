@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>ADMINISTRATIVO</strong></a>
        </li>
        <li class="active">
            <a><strong>CLIENTES</strong></a>
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
                    <h5>LISTADO DE CLIENTE</h5>
                    <div class="ibox-tools">
                        @if($authori_status['permi'] >= 10)
                            <a onclick="create_client();" class="btn btn-success" data-toggle="modal" data-target="#popcrear">
                                Nuevo Cliente
                            </a>
                        @endif
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <input type="hidden" name="functi" id="functi" value="Cliente">
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$authori_status['permi']}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="cliente">
                        <thead>
                            <tr>
                                <th>Razón social</th>
                                <th>Acrónimo</th>
                                <th>Cuit</th>
                                @if($authori_status['permi'] >= 5)
                                    <th>Opción</th>
                                @endif
                            </tr>
                        </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('client.popcrear')
@include('client.popedit')
@include('confir')
@endsection

