@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>ADMIN IP</strong></a>
    </li>
        <li class="active">
            <a><strong>STOCK IP</strong></a>
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
                    <h5>Stock IP</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-success" data-toggle="modal" data-target="#popstock_ip" onclick="rank_ip_new_all();" title="Agregar Rango"> <i class="fa fa-plus"> </i> Nuevo Rango</a>
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <input  type="hidden" id="permi" value="{{$autori_status['permi']}}">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_stock_all_ip">
                        <thead>
                            <tr>
                                @if($autori_status['permi'] >= 10)
                                    <th>Rango</th>
                                    <th>Estado</th>
                                    <th>Uso</th>
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
@include('admin_ip.stock.popcrear')
@endsection

