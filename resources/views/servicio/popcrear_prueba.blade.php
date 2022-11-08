<div class="modal inmodal fade overflow-modal" id="crear_servicio_pop_prueba" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_crear_ser" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_service">CREAR SERVICIO</h4> 
            </div>
                <div class="row">
                    <div class="col-lg-12">
                            <div class="ibox-content">
    
                                <form id="form" class="wizard-big" role="form" method="POST" id="alta_serv">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="reques_ip" id="reques_ip">
                                    <input type="hidden" name="reques_rank" id="reques_rank">
                                    <input type="hidden" name="grupo_puerto" id="grupo_puerto">
                                    <h1>Servicio</h1>
                                    <fieldset>
                                        <h2>Caracteristicas del Servicio </h2>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group col-md-6 pl-0" style="padding-left: 0px">
                                                    <label>Nro Servicio<span style=color:red;>*</span></label>
                                                    <input id="service" name="service" type="text" placeholder="Ingrese el numero de enlace..." class="form-control required" onkeypress="return esNumero(event);" autocomplete="off"  value="{{old('service')}}" maxlength="20">
                                                </div>

                                                <div class="form-group col-md-6" style="padding-right: 0px">
                                                    <label>Orden<span style=color:red;>*</span></label>
                                                    <input id="ord" name="ord" type="text" class="form-control required" placeholder="Ingrese el numero de orden..." onkeypress="return esNumero(event);" autocomplete="off"  value="{{old('ord')}}" maxlength="20">
                                                </div>

                                                <div class="form-group">
                                                    <label>Tipo<span style=color:red;>*</span></label>
                                                        <select class="form-control required" id="type_servi" onchange="type_service_bw();" name="type_servi">
                                                            <option selected disabled value="">Seleccionar el tipo de servicio</option>
                                                            @foreach($list_service as $service)
                                                                    @if (old('type_servi') == $service->id)
                                                                    <option value="{{ $service->id }}" selected>{{ $service->name }}</option>
                                                                @else
                                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                </div>

                                                <div class="form-group">
                                                    <label>Cliente<span style=color:red;>*</span></label>
                                                    <div class="bw_all" id="bw_all" > 
                                                        <select class="form-control required" id="id_client_servi" name="id_client_servi">
                                                            <option selected disabled value="">Seleccionar cliente</option>
                                                            @foreach($Client as $client)
                                                                 @if (old('id_client_servi') == $client->id)
                                                                    <option value="{{ $client->id }}" selected>{{ '"'.$client->acronimo.'"' }} {{ $client->business_name }}</option>
                                                                @else
                                                                    <option value="{{ $client->id }}">{{ '"'.$client->acronimo.'"' }} {{ $client->business_name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                        <a class="ico_input btn btn-info" id="bus_client" onclick="detal_client();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search" title="Buscar Cliente" > </i> Buscar</a>
                                                        <a class="ico_input btn btn-info" id="new_clit" data-toggle="modal" data-target="#popcrear"><i class="fa fa-plus" title="Nuevo Cliente" ></i></a>
                                                    </div>
                                                </div>
                                                

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="text-center ">
                                                    <div style="margin-top: 30px;">
                                                        <i class="fa fa-cog fa-spin" style="font-size: 180px;color: #f86161 "></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                    </fieldset>
                                    <h1>Ficha técnica</h1>
                                    <fieldset>
                                        <h2> Servicio de Padres</h2>
                                        <div class="row">
                                            <div class="col-md-8">

                                                <div id="bw_service_input">
                                                    <div class="form-group">
                                                        <label>Ancho de Banda<span style=color:red;>*</span></label>
                                                        <div class="bw_all" id="bw_all" >
                                                            <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max" id="n_max" class="form-control required" value="{{old('n_max')}}">
                                                            <select class="form-control required" id="max" name="max">
                                                                @foreach($bw as $key => $licen)
                                                                    @if (old('max') == $key)
                                                                        <option value="{{ $key }}" selected>{{ $licen }}</option>
                                                                    @else
                                                                        <option value="{{ $key }}">{{ $licen }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="service_input_relation">
                                                    <div class="form-group">
                                                        <label>Servicio Relacionado<span style=color:red;>*</span></label>
                                                        <input type="text" placeholder="Ingrese el nro de servicio..." onkeypress="return esNumero(event);" autocomplete="off" id="servi_relation" name="servi_relation"class="form-control required" value="{{old('servi_relation')}}" maxlength="20">
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="text-center ">
                                                    <div style="margin-top: 0px;">
                                                        <i class="fa fa-wpforms" style="font-size: 180px;color: #f86161 "></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
    
                                    <h1>Direcciones</h1>
                                    <fieldset>
                                        <h2>LoremIpsum</h2>
                                        <div class="row">
                                            <div class="col-md-8">

                                                <div class="form-group"> 
                                                    <label>Dirección A<span style=color:red;>*</span></label>
                                                    <div class="bw_all" id="bw_all" >
                                                        <select class="form-control required" id="direc_a" name="direc_a"> {{-- aca iria el required--}}
                                                            <option selected="selected" disabled value="">Seleccionar dirección A</option>
                                                            @foreach($direcc as $dir)
                                                                @if (old('direc_a') == $dir['id'])
                                                                    <option value="{{ $dir['id'] }}" selected>{{ $dir['direccion'] }} </option>
                                                                @else
                                                                    <option value="{{ $dir['id'] }}">{{$dir['direccion']}}</option>
                                                                @endif
                                                            @endforeach       
                                                        </select>
                                                        <a class="ico_input btn btn-info "onclick="detal_addres(2);" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                                                        <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Dirección B<span style=color:red;>*</span></label>
                                                    <div class="bw_all" id="bw_all" >
                                                         <select class="form-control required" id="direc_b" name="direc_b">  {{-- aca iria el required--}}
                                                            <option selected disabled value="">Seleccionar dirección B</option>
                                                            @foreach($direcc as $dir)
                                                                @if (old('direc_b') == $dir['id'])
                                                                    <option value="{{ $dir['id'] }}" selected>{{ $dir['direccion'] }} </option>
                                                                @else
                                                                    <option value="{{ $dir['id'] }}">{{$dir['direccion']}}</option>
                                                                @endif
                                                            @endforeach       
                                                        </select>
                                                        <a class="ico_input btn btn-info "onclick="detal_addres(3);" data-toggle="modal" data-target="#buscar_direccion_servi"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                                                        <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label>Comentario</label> 
                                                    <input type="text" placeholder="Ingrese un comentario (opcional)" autocomplete="off" id="come" name="come"class="form-control" value="{{old('come')}}" maxlength="50">
                                                    <p class="mensajeInput" id="aconimo_lanswitch_msj"></p>
                                                </div>

                                            </div>

                                            <div class="col-md-4">
                                                <div class="text-center ">
                                                    <div style="margin-top: 20px; padding-left: 20px;">
                                                        <i class="fa fa-address-card-o" style="font-size: 180px;color: #f86161 "></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
    
                                    <h1>Confirmar</h1>
                                    <fieldset>
                                        <h2>Resumen nuevo servicio</h2>

                                        <div id="showFormValues">
                                            {{-- Escribe por wizard.js valores --}}
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="text-center">
                                                                <div class="mb-1">
                                                                    <span><strong>Numero de Servicio: </strong></span><span id="nroServicio"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Tipo de Servicio:</strong> <span id="tipoServicio"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Orden Nro:</strong> <span id="ordenServicio"></span> 
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Cliente del Servicio:</strong> <span id="clienteServicio"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Ancho de banda:</strong> <span id="anchoServicio"></span> <span id="bandaServicio"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Numero relacionado del Servicio:</strong> <span id="relacionadoServicio"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Direccion A:</strong> <span id="direccionA"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Direccion B:</strong> <span id="direccionB"></span>
                                                                </div>
                                                                <div class="mb-1">
                                                                    <strong>Comentario:</strong> <span id="comentario"></span>
                                                                </div>
                                                                
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="text-center ">
                                                        <div style="margin-top: 20px; padding-left: 20px;">
                                                            <i class="fa fa-check-circle " style="font-size: 180px;color: #f86161 "></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">Esta seguro de los cargar los datos ingresados?</label>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
    
                    </div>
            {{--<div class="modal-footer">
                 <div class="col-sm-12">
                    <button type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button onclick="alta_service();" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>  
            </div> --}}
        </div>
    </div>
</div>
