<div class="modal inmodal fade overflow-modal" id="crear_servicio_pop" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_crear_ser" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_service"></h4> 
            </div>
            <form role="form" method="POST" id="alta_serv">
                {{ csrf_field() }}
                <input type="hidden" name="id_service" id="id_service" value="0">
                <input type="hidden" name="option_bw_service" id="option_bw_service">
                <input type="hidden" name="option_relation_service" id="option_relation_service">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>N° Servicio*</label> 
                        <input type="text" placeholder="Enlace" onkeypress="return esNumero(event);" autocomplete="off" id="service" name="service"class="form-control" value="{{old('service')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tipo*</label>
                        <select class="form-control" id="type_servi" onchange="type_service_bw();" name="type_servi">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($list_service as $service)
                                    @if (old('type_servi') == $service->id)
                                    <option value="{{ $service->id }}" selected>{{ $service->name }}</option>
                                @else
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Orden*</label> 
                        <input type="text" placeholder="Orden" onkeypress="return esNumero(event);" autocomplete="off" id="ord" name="ord"class="form-control" value="{{old('ord')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Cliente*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" id="id_client_servi" name="id_client_servi" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_client" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search" title="Buscar Cliente" > </i> Buscar</a>
                            <a class="ico_input btn btn-info" id="new_clit" data-toggle="modal" data-target="#popcrear"><i class="fa fa-plus" title="Nuevo Cliente" ></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="bw_service_input">
                    <div class="form-group">
                        <label>Ancho de Banda*</label>
                        <div class="bw_all" id="bw_all" >
                            <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max" id="n_max" class="form-control" value="{{old('n_max')}}">
                            <select class="form-control" id="max" name="max">
                                <option value="0" selected>seleccionar</option>
                                @foreach($bw as $key => $licen)
                                    
                                    <option value="{{ $key }}">{{ $licen }}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="service_input_relation" style="display: none;">
                    <div class="form-group">
                        <label>Servicio Relacionado*</label>
                        <input type="text" placeholder="Servicio" onkeypress="return esNumero(event);" autocomplete="off" id="servi_relation" name="servi_relation"class="form-control" value="{{old('servi_relation')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Dirección A*</label> 
                        <div class="bw_all" id="bw_all">
                            <select class="form-control hide-arrow-select" id="direc_a" name="direc_a" disabled="true" >
                                <option selected disabled value="">seleccionar</option>       
                            </select>
                            <a class="ico_input btn btn-info "onclick="detal_addres(2);" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" id="input_dire_b_all" >
                    <div class="form-group">
                        <label>Dirección B</label> 
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" id="direc_b" name="direc_b" disabled="disabled" >
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info "onclick="detal_addres(3);" data-toggle="modal" data-target="#buscar_direccion_servi"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Comentario</label> 
                        <input type="text" placeholder="Comentario" autocomplete="off" id="come" name="come"class="form-control" value="{{old('come')}}" maxlength="50">
                        <p class="mensajeInput" id="aconimo_lanswitch_msj"></p>
                    </div>
                </div>               
            </form>
            <div class="modal-footer">
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
            </div> 
        </div>
    </div>
</div>
