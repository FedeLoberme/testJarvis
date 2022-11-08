@extends('layouts.app')

@section('content')
        <li class="active">
            <a><strong>INVENTARIO</strong></a>
        </li>
        <li class="active">
            <a><strong>RED METRO</strong></a>
        </li>
        <li class="active">
            <a><strong>PLANILLA ANILLOS</strong></a>
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
                    <h5>Importar Excel</h5>
                    <div class="ibox-tools">
                            <a class="btn btn-success" data-toggle="modal" data-target="#impor_ring_all" ><i class="fa fa-cloud-upload"></i>
                                Subir Nuevo Excel
                            </a>
                    </div>

                </div>
                <div class="ibox-content">
                    <input type="hidden" id="data_buscar" name="data_buscar" value="{{$data}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="jarvis_excel_anillo">
                            <thead>
                                <tr>
                                    <th>Anillo</th>
                                    <th>bw_anillo</th>
                                    <th>acronimo_sw</th>
                                    <th>bwcpe</th>
                                    <th>capacidad</th>
                                    <th>ic_alta</th>
                                    <th>cliente</th>
                                    <th>direccion</th>
                                    <th>sw_viejo</th>
                                    <th>ip_gestion</th>
                                    <th>vlan_gestion</th>
                                    <th>by_pass</th>
                                    <th>modelo</th>
                                    <th>bw_migrado</th>
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
@include('import.popimpor_anillo')
@include('import.poppuerto')
@endsection
