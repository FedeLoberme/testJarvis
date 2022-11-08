@extends('layouts.app')
@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>ADMINISTRATIVO</strong></a>
        </li>
        <li class="active">
            <a><strong>STOCK PRODUCTO</strong></a>
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
                    <h5>LISTADO DE MERCANCIA</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_stock">
                            <thead>
                                <tr>
                                    <th>Código SAP</th>
                                    <th style="width: 150px;">Tecnología</th>
                                    <th style="width: 150px;">Marca</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
