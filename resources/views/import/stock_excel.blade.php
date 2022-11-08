@extends('layouts.app')

@section('content')



        <li class="active">
            <a><strong>ADMINISTRADOR</strong></a>
        </li>
        <li class="active">
            <a><strong>IMPORTAR</strong></a>
        </li>
        <li class="active">
            <a><strong>STOCK SAP</strong></a>
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
                    <h5>Importar Excel Stock SAP</h5>
                    <div class="ibox-tools">

                        {{--
                        @if($authori_status['permi'] >= 10)
                        --}}
                        @if(true)
                            <a class="btn btn-success" data-toggle="modal" data-target="#import_stock_all" ><i class="fa fa-cloud-upload"></i>
                                Subir Nuevo Excel
                            </a>
                        @endif

                    </div>


                </div>
<!-- Encabezado de tabla. Inicia la impresión de títulos de columnas de Excel de Stock -->
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="impor_stock_data">
                            <thead>
                                <tr>
                                    <th>TECN.</th>
                                    <th>Marca</th>
                                    <th>Cod.SAP SINERGIA</th>
                                    <th>futuro uso 1</th>
                                    <th>Descripcion Completa</th>
                                    <th>STOCK de Inst. Benavidez</th>
                                    <th>STOCK de Inst. CORDOBA</th>
                                    <th>STOCK Mantenimiento</th>
                                    <th>STOCK Proy. Especiales</th>
                                    <th>EN TRASLADO DESDE ORIGEN (std + esp)</th>
                                    <th>OC GENERADA (estandar + especial)</th>
                                    <th>STOCK Minimo reposicion</th>
                                    <th>Stock Devoluciones Benavidez</th>
                                    <th>Stock Devoluciones Cordoba</th>
                                    <th>Costo U$S Nacionalizado</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('import.popimpor_stock')
@endsection
