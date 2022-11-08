@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>ADMIN VLAN</strong></a>
    </li>
    <li class="active">
        <a><strong>ASIGNACIÓN DE SERVICIO</strong></a>
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
                        <h5>LISTADO DE ASIGNACIONES DE SERVICIOS</h5>
                        <div class="ibox-tools">
                            @if($authori_status['permi'] >= 10)
                                <!--<a onclick="clean_frontier();" class="btn btn-success" data-toggle="modal"
                                   data-target="#popcrear_frontera">
                                    Crear Frontera
                                </a>-->
                            @endif
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <input type="hidden" id="permi" value="{{$authori_status['permi']}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example"
                                   id="list_vlan_services">
                                <thead>
                                <tr>
                                    <th>SERVICIO</th>
                                    <th>TIPO DE SERVICIO</th>
                                    <th>ANCHO DE BW</th>
                                    <th>MTAG</th>
                                    <th>CTAG</th>
                                    <th>FRONTERA</th>
                                    <th>PE/PEI</th>
                                    <th>AGGI</th>
                                    <th>OPCIÓN</th>
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
    @include('admin_vlan.pop_editar_ctag')
@endsection
@section('script')
    <script src="{{asset('public/js/admin_vlan/service.js')}}"></script>
@endsection
