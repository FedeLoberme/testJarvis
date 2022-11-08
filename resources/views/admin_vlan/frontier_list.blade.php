@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>ADMIN VLAN</strong></a>
    </li>
    <li class="active">
        <a><strong>FRONTERA</strong></a>
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
                        <h5>LISTADO DE FRONTERAS</h5>
                        <div class="ibox-tools">
                            @if($authori_status['permi'] >= 10)
                                <a onclick="clean_frontier();" class="btn btn-success" data-toggle="modal"
                                   data-target="#popcrear_frontera">
                                    Crear Frontera
                                </a>
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
                                   id="list_frontier_adm_vlan">
                                <thead>
                                <tr>
                                    <th>Acronimo</th>
                                    <th>Nro de Frontera</th>
                                    <th>Equipo PE/PEI</th>
                                    <th>Bundle PE/PEI</th>
                                    <th>Equipo DM/SAR</th>
                                    <th>Bundle DM/SAR</th>
                                    <th>Zona</th>
                                    <th>Status</th>
                                    <th>BW</th>
                                    <th>Opcion</th>
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
    @include('admin_vlan.frontier.popcrear_frontera')
    @include('admin_vlan.frontier.popeditar_frontera')
    @include('admin_vlan.frontier.poplist_equipment')
    @include('admin_vlan.frontier.poplist_lacp')
    @include('servicio.popnew_puerto_lacp')
    @include('admin_vlan.frontier.popeditar_acronimo')
@endsection
@section('script')
    <script src="{{asset('public/js/admin_vlan/frontier.js')}}"></script>
@endsection
