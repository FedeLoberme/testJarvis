@extends('layouts.app')

@section('content')
    <li class="active">
        <a><strong>SITIOS JARVIS</strong></a>
    </li>
        <li class="active">
            <a><strong>LEDZITE</strong></a>
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
                    <h5>Listado de Nodos Ledzite</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="list_ledzite">
                        <thead>
                            <tr>
                                <th>Cell id</th>
                                <th>Nodo</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                {{-- <th>Direccion</th> --}}
                                <th>Fecha Contrato</th>
                                <th>Dueño</th>
                                <th>Comentario</th>
                                {{-- <th>Id uplink</th> --}}
                                <th>SIT_CODIGO</th>
                                <th>CLU_CODIGO</th>
                                <th>GEO_ID</th>
                                <th>ALM_CODIGO</th>
                                <th>SIT_NOMBRE</th>
                                <th>SIT_LATITUD</th>
                                <th>SIT_LONGITUD</th>
                                <th>SIT_CALLE</th>
                                <th>SIT_NUMERO</th>
                                <th>SIT_ADDRESS</th>
                                <th>SIT_HSNM</th>
                                <th>SIT_PREFIJO_TELCO</th>
                                <th>SIT_PREFIJO_CTI</th>
                                <th>SIT_AREA_EXPLOTACION</th>
                                <th>SIT_COMMON_BCCH</th>
                                <th>SIT_OBSERVACIONES</th>
                                <th>SIT_COUBICACION</th>
                                <th>TSI_CODIGO</th>
                                <th>SIT_GSM</th>
                                <th>SIT_UMTS</th>
                                <th>SIT_ID_FIJA</th>
                                <th>LCC_ID</th>
                                <th>PRO_ID</th>
                                <th>SIT_NS_ACTIVO</th>
                                <th>SIT_NS_INTEGRADO</th>
                                <th>SIT_NS_TIPO_CELDA</th>
                                <th>SIT_NS_CI</th>
                                <th>CCN_ID</th>
                                <th>SIT_NS_CLASIFICACION</th>
                                <th>SIT_NS_CREACION</th>
                                <th>SIT_NS_ACTUALIZACION</th>
                                <th>LOCL_CODIGO</th>
                                <th>SIT_ESTADO</th>
                                <th>SIT_FECHA_CARGA</th>
                                <th>SIT_OWNER</th>
                                <th>SIT_FECHA_VENCIMIENTO</th>
                                <th>SIT_TIPO_ESTRUCTURA</th>
                                <th>SIT_LTE</th>
                                <th>SIT_FACTOR_FO</th>
                                <th>OPR_ID</th>
                                <th>TE_ID</th>
                                <th>SIT_TE_ALTURA</th>
                                <th>SIT_TE_CAMUFLAJE</th>
                                <th>SIT_TE_COMPARTIBLE</th>
                                <th>SIT_FECHA_BAJA</th>
                                <th>TIPOS_SOLUCIONES</th>
                                <th>SIT_FECHA_ALTA</th>
                                <th>SIT_GRANJA</th>
                                <th>SIT_ESTADO_AUX</th>
                                <th>SIT_DISTRIBUCION_SM_3G</th>
                                <th>SIT_VIP</th>
                                <th>LOC_AREA_CODIGO</th>
                                <th>SIT_DISTRIBUCION_SM_4G</th>
                                <th>SIT_DISTRIBUCION_SM_2G</th>
                                <th>ALTURA_ESTRUCTURA</th>
                                <th>DATOS_ENLACE_TX_ID</th>
                                <th>SIT_UBICACION_TEC_MOVIL</th>
                                <th>SIT_UBICACION_TEC_FIJA</th>
                                <th>SIT_UBICACION_TEC_INMUEBLE</th>
                                <th>SIT_COUBICACION_OTROS_CLARO</th>
                                <th>SIT_PAGA_TASA_RECURRENTE</th>
                                <th>SIT_FECHA_ALTA_MUNICIPIO</th>
                                <th>SIT_ALQUILADO</th>
                                <th>ORD_JUDICIALIZADA_HAB</th>
                                <th>ORD_JUDICIALIZADA_TASAS</th>
                                {{-- <th>aud_fecha_ins</th>
                                <th>aud_fecha_upd</th>
                                <th>aud_usr_ins</th>
                                <th>aud_usr_upd</th> --}}
                                <th>SIT_RAN_SHARING</th>
                                <th>SIT_RAN_SHARING_PROVEEDOR</th>
                                <th>SIT_ROAMING</th>
                                <th>SIT_ROAMING_PROVEEDOR</th>
                                <th>SIT_PROPIETARIO</th>
                                <th>SIT_CODIGO_ANTERIOR</th>
                                <th>SIT_FRONTERIZO</th>
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
