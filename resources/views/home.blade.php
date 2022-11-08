@extends('layouts.app')

@section('content')

    </ol>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-lg-12">
                <div class="row" style="max-width:80vh; display: flex; justify-content: center; align-items:center; margin: auto">
                    <div class="col-lg-6" style="padding-left: inherit; min-height: 200px; min-width: 400px;">
                            <img src="public/img/jarvis_negro.png" alt="new01" align="right" width="100%" height="auto">
                    </div>
                </div>
               
            </div>
        </div>
        <hr>
    </div>
    <div class=" offset-md-3 wrapper wrapper-content">
            <div class="row col-lg-12">
                <div class="col-lg-offset-2 col-lg-4">
                    {{-- GIGABIT  --}}
                    <a onclick="ports_agg_home(1);" title="Estado puertos giga" data-toggle="modal" data-target="#list_agg_port">
                         <div class="widget style1 navy-bg"{{-- {{$color_ports[1][0]}}"  --}}>
                            <div class="row vertical-align">
                                <div class="col-xs-3">
                                    <i class="fas fa-ethernet fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span> Puertos GigaEth</span> <span style=font-size:10px > <i class="fas fa-sort" aria-hidden="true"></i></span>
                                    <h6 class="no-margins"><span>Agregadores analizados</span></h6>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[9]>0?$data[9]:0)}}</span> 
                                    </h2>
                                </div>
                                <div class="col-xs-12 text-right">
                                    <span class="label label-danger">Saturados: {{$ports_info['giga']['saturado']}}</span>
                                    <span class="label label-warning">Criticos: {{$ports_info['giga']['critico']}}</span>
                                    <span class="label label-info ">Analisis: {{$ports_info['giga']['analisis']}}</span>
                                    <span class="label label-plain ">Ok: {{$ports_info['giga']['ok']}}</span>
                                </div>
                            </div>
                            
                        </div>
                        
                    </a>
                </div>
                <div class="col-lg-4">
                    {{-- TENGIGA  --}}
                    <a onclick="ports_agg_home(0);" title="Estado puertos tengiga" data-toggle="modal" data-target="#list_agg_port">
                        <div class="widget style1 blue-bg" {{-- {{$color_ports[0][0]}}" --}} >
                            <div class="row vertical-align">
                                <div class="col-xs-3">
                                    <i class="fab fa-megaport fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span> Puertos TenGiga</span> <span style=font-size:10px > <i class="fas fa-sort" aria-hidden="true"></i></span>
                                    <h6 class="no-margins"><span>Agregadores analizados</span></h6>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[8]>0?$data[8]:0)}}</span> 
                                    </h2>
                                </div>
                                <div class="col-xs-12 text-right">
                                    <span class="label label-danger">Saturados: {{$ports_info['tengiga']['saturado']}}</span>
                                    <span class="label label-warning">Criticos: {{$ports_info['tengiga']['critico']}}</span>
                                    <span class="label label-info ">Analisis: {{$ports_info['tengiga']['analisis']}}</span>
                                    <span class="label label-plain ">Ok: {{$ports_info['tengiga']['ok']}}</span>
                                </div>
                               
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row col-lg-12">
                <div class="col-lg-2">
                    <a href="{{ url('ver/servicio') }}" title="Servicios">
                        <div class="widget style1 navy-bg m-t-xs">
                            <div class="row vertical-align max-h-4vh">
                                <div class="col-xs-3">
                                    {{-- <img src="{{ asset('public/icono/ja-service.svg') }}"> --}}
                                    <i class="fa fa-wrench fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span>Servicio</span> <span style=font-size:10px ><i class="fa fa-external-link" aria-hidden="true"></i>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[0]>0?$data[0]:0)}}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="{{ url('ver/cliente') }}" title="Cliente">
                        <div class="widget style1 navy-bg m-t-xs">
                            <div class="row vertical-align max-h-4vh">
                                <div class="col-xs-3">
                                    <i class="fa fa-drivers-license-o fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span>Clientes</span> <span style=font-size:10px ><i class="fa fa-external-link" aria-hidden="true"></i>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[1]>0?$data[1]:0)}}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="{{ url('ver/nodo') }}" title="Nodo">
                        <div class="widget style1 blue-bg m-t-xs">
                            <div class="row vertical-align max-h-4vh">
                                <div class="col-xs-3">
                                    {{-- <img src="{{ asset('public/icono/ja-node.svg') }}"> --}}
                                    <i class="fa fa-stumbleupon fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span>Nodos</span> <span style=font-size:10px ><i class="fa fa-external-link" aria-hidden="true"></i>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[2]>0?$data[2]:0)}}</span> 
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="{{ url('ver/CPE') }}">
                        <div class="widget style1 blue-bg m-t-xs">
                            <div class="row vertical-align max-h-4vh">
                                <div class="col-xs-3">
                                    {{-- <img src="{{ asset('public/icono/ja-node.svg') }}"> --}}
                                    <i class="fa fa-hdd-o fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span> Router</span> <span style=font-size:10px > <i class="fa fa-external-link" aria-hidden="true"></i></span>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[3]>0?$data[3]:0)}} </span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="{{ url('ver/lanswitch') }}">
                        <div class="widget style1 yellow-bg m-t-xs">
                            <div class="row vertical-align max-h-4vh">
                                <div class="col-xs-3">
                                    {{-- <img src="{{ asset('public/icono/ja-ls.svg') }}"> --}}
                                    <i class="fa fa-flickr fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span>LSwitch</span><span style=font-size:10px > <i class="fa fa-external-link" aria-hidden="true"></i>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[4]>0?$data[4]:0)}}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2">
                    <a href="{{ url('ver/stock') }}">
                        <div class="widget style1 yellow-bg m-t-xs">
                            <div class="row vertical-align max-h-4vh">
                                <div class="col-xs-3">
                                    <i class="fa fa-database fa-2x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <span>Stock</span> <span style=font-size:10px > <i class="fa fa-external-link" aria-hidden="true"></i>
                                    <h2 class="font-bold">
                                        <span class="count">{{($data[5]>0?$data[5]:0)}}</span>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row col-lg-12">
                <div class="col-lg-offset-2 col-lg-2 ">
                    <div class="widget navy-bg p-md text-center">
                        <div class="m-b-md max-h-126">
                            <i class="fas fa-user-astronaut fa-4x"></i>
                            <h1 class="m-xs count">{{($data[7]>0?$data[7]:0)}}</h1>
                            <h3 class="font-bold no-margins"> Cantidad de usuarios que se sumaron a JARVIS</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 ">
                    <a href="{{ url('ver/importar/stock') }}">
                        <div class="widget blue-bg p-md text-center">
                            <div class="m-b-md max-h-126">
                                <i class="fa fa-file-excel-o fa-4x"></i>
                                <h1 class="m-xs">Excell</h1>
                                <h3 class="font-bold no-margins">
                                    Stock sap [Importar] <span><i class="fa fa-external-link" aria-hidden="true"></i></span>
                                </h3>
                                <small></small>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 ">
                    <a href="{{ url('ver/reserva') }}">
                        <div class="widget red-bg p-md text-center">
                            <div class="m-b-md max-h-126">
                                <i class="fa fa-ticket fa-4x"></i>
                                <h1 class="m-xs">{{($data[6]>0?$data[6]:0)}}</h1>
                                <h3 class="font-bold no-margins">
                                    Reservas a vencer
                                </h3>
                                <small>Reservas con fecha de vencimiento menor a 30 dias (a partir de hoy).</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
@include('list_agg_port.list')
@endsection
