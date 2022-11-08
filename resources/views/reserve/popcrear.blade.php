<div class="modal inmodal fade" id="crear_reserva_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerrar_reserva_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-ticket modal-icon" style="color: darkorange"></i>
                <h4 class="modal-title" id="title_reserve">Crear Reserva</h4> 
            </div>
            <form role="form" method="POST" id="alta_reserva">
                {{ csrf_field() }}
                <input type="hidden" name="id_chain" id="id_chain">
                    <div class="col-sm-6">
                        <div class="form-group col-md-12">
                            <label>Celda<span style=color:red;>*</span></label>
                                <div class="bw_all">  
                                    <select class="form-control hide-arrow-select" id="nodo_al_lsw" name="nodo_al_lsw" onchange="" disabled="true">
                                        <option selected disabled value="">seleccionar</option>
                                    </select>
                                    <a onclick="node_table_select_lsw_new();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar Nodo" id="node_button"><i class="fa fa-search"  > </i> Buscar</a>
                                    {{-- &nbsp
                                    <a onclick="node_info_unique();" class="btn-sm btn-warning" data-toggle="modal" data-target="#nodo_info_pop" title="Info Nodo" id="info_node_button"><i class="fa fa-info-circle fa-2x " aria-hidden="true"></i></a> --}}
                                </div>
    
                        </div>

                        <div class="form-group col-md-12">
                            <label>Link<span style=color:red;>*</span></label> 
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" id="id_link" name="id_link" disabled="true">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                                <a class="ico_input btn btn-warning "onclick="select_link_list();" data-toggle="modal" data-target="#buscar_link_selected"><i class="fa fa-search" title="Buscar Link" > </i> Buscar</a>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Cliente<span style=color:red;>*</span></label>
                            <div class="bw_all"> 
                                <select class="form-control hide-arrow-select" disabled="true" id="client_sub_red" name="client_sub_red">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                                <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i>Buscar </a>
                            </div>
                        </div>
    
                        <div class="form-group col-md-12">
                            <label>Oportunidad<span style=color:red;>*</span></label>
                            <input id="oportunity" name="oportunity" type="text" class="form-control" placeholder="Oportunidad" autocomplete="off" value="" maxlength="20">
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tipo servicio<span style=color:red;>*</span></label>
                                <div class="bw_all" id="bw_all" >
                                    <select class="form-control" id="id_type_service" name="id_type_service">
                                        <option selected disabled value="">seleccionar</option>
                                        @foreach($type_services as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Fecha inicio reserva</label>
                            <input type="text" disabled maxlength="100" value="" autocomplete="off" id="date_reserve" name="date_reserve"class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Fecha Fin Reserva</label>
                            <input type="text" disabled maxlength="100" value="" autocomplete="off" id="end_reserve" name="end_reserve"class="form-control" readonly>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Usuario solicitante</label>
                            <div class="input-group mb-3">
                                <div class="input-group-addon" style="background-color: #23c6c8">
                                  <span class="input-group-text" id="basic-addon1"><i style="color:white "class="fa fa-user fa-1x" aria-hidden="true"></i></span>
                                </div>
                                <input type="text" class="form-control" readonly placeholder="Nombre de Usuario" aria-label="Nombre de Usuario" aria-describedby="basic-addon1" value="{{ Auth::user()->name.' '.Auth::user()->last_name }}">
                              </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="col-md-12" style="margin-top: 15px">
                            <div class="centericon">
                                <center style="max-height: 36px">
                                    <i class="fa fa-info-circle"></i>
                                </center>
                            </div>
    
                            <div class="border-info-reserva " style="margin-top: 13px; margin-bottom: 10px; padding: 10px; min-height:395px;">
                                {{-- CELDA INFO --}}
                                <small>Información de <b>celda</b> al momento de reservar</small>
                                <br>
                                <div class="col-md-12 border-top" style="padding-top:7px">
                                    <div class="col-xs-6 no-top-border">
                                        <strong><span class="label label-info">Estado</span></strong>&nbsp
                                        <span class= "text-muted" id="status_node"> </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-xs-12 m-t-xs">
                                        <span class="label label-info"><strong>Tipo</strong></span>
                                        <span class="text-muted" id="node_info_plus"> </span>
                                    </div>
                                </div>
                                <div class="col-md-12 m-b-md">
                                    <div class="col-xs-12 m-t-xs">
                                        <span class="label label-info"><strong>Comentario</strong></span>
                                        <span class="text-muted" id="commentary_node_info"> </span>
                                    </div>
                                </div>
                                {{-- LINK INFO --}}
                                <small>Información de <b>link</b> al momento de reservar</small>
                                <br>
                                
                                <div class="col-md-12 border-top" style="padding-top:7px">
                                    <div class="col-xs-12 m-b-xs m-t-xs" style="padding-left: 0px;">
                                        <div class="progress" style="margin-bottom:2px">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" id="proggressbar_link_info" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 no-top-border ">
                                        <strong><span class="label label-warning">Estado</span></strong>&nbsp
                                        <span class= "text-muted" id="status_link"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 m-b-md">
                                    <div class="col-xs-12 m-t-sm">
                                        <span class="label label-warning"><strong>Comentario</strong></span>
                                        <span class="text-muted" id="commentary_link_info"> </span>
                                    </div>
                                </div>

                                <div class="row m-t-xl">
                                    <div class="col-md-12">
                                        <div class="col-md-6 border-right border-bottom" style="padding-bottom:5px">
                                            <center>
                                                <p class="m-b-xs"><strong>Celda (Uplink)</strong></p>
                                                    <h1 class="no-margins"><span id="bw_limit_info">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="bw_size_info">Mbps</span>]</b></small></h1>
                                            </center>
                                        </div>
                                        <div class="col-md-6 border-bottom" style="padding-bottom: 5px;">
                                            <center>
                                                <p class="m-b-xs"><strong>Usado</strong></p>
                                                <h1 class="no-margins"><span id="bw_used_info">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="bw_used_size">Mbps</span>]</b></small></h1>
                                            </center>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6 border-right">
                                            <center>
                                                <p class="m-b-xs"><strong>Reservado</strong></p>
                                                    <h1 class="no-margins"><span id="bw_pre_reserved">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="bw_pre_reserve_size">Mbps</span>]</b></small></h1>
                                            </center>
                                        </div>
                                        <div class="col-md-6">
                                            <center>
                                                <p class="m-b-xs"><strong>Remanente</strong></p>
                                                    <h1 class="no-margins"><span id="bw_available">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="bw_available_size">Mbps</span>]</b></small></h1>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>BW</label>
                                <div class="bw_all" id="bw_all" >
                                    <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="BW_chain" id="BW_chain" class="form-control" value="{{old('BW_chain')}}">
                                    <select class="form-control" id="bw_max_size" name="bw_max_size">
                                        <option selected value="">seleccionar</option>
                                        <option value="1">Kbps</option>
                                        <option value="2">Mbps</option>
                                        <option value="3">Gbps</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-sm-12">
                        <div class="col-md-12 form-group">
                           <label>Comentario</label> 
                           <input type="text" placeholder="Comentario" maxlength="100" autocomplete="off" id="commentary_chain" name="commentary_chain"class="form-control" value="{{old('commentary_chain')}}">
                       </div>
                   </div>
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_reserve" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>