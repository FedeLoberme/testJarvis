<div class="modal inmodal fade" id="pop_edic_alta_reserve" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="pop_edic_alta_reserve_close" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-ticket modal-icon" style="color: darkorange"></i>
                <h4 class="modal-title" id="title_reserve">Editar Reserva</h4>
                <h2 class="modal-subtitle subtitle" id="edic_number_reserve"></h2>
            </div>
            <div class="modal-body">
                
            <form role="form" method="POST" id="edit_alta_reserve">
                {{ csrf_field() }}
                    <input type="hidden" id="id_reserve_edit">
                    <input type="hidden" id="bw_limit_pop_info">
                    <div class="col-sm-6">
                        <div class="form-group col-md-12">
                            <label>Celda<span style=color:red;>*</span></label>
                                <div class="bw_all">  
                                    <select class="form-control hide-arrow-select" id="edic_nodo_al_lsw" name="edic_nodo_al_lsw" onchange="" disabled="true"></select>
                                </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Cliente<span style=color:red;>*</span></label>
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" disabled="true" id="edic_client_sub_red" name="edic_client_sub_red">
                                </select>
                                <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i>Buscar </a>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Fecha inicio reserva</label>
                            <input type="text" disabled maxlength="100" value="" autocomplete="off" id="edit_date_reserve" name="edit_date_reserve"class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Fecha Fin Reserva</label>
                            <input type="text" disabled maxlength="100" value="" autocomplete="off" id="edit_end_reserve" name="edit_end_reserve"class="form-control" readonly>
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
                        
                        <div class="form-group col-md-12">
                            <label>Link<span style=color:red;>*</span></label> 
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" id="edic_id_link" name="edic_id_link" disabled="true">
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label>Oportunidad<span style=color:red;>*</span></label>
                            <input id="edic_oportunity" name="edic_oportunity" type="text" class="form-control" placeholder="Oportunidad" autocomplete="off" value="" maxlength="20">
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Tipo servicio<span style=color:red;>*</span></label>
                                <div class="bw_all" id="bw_all" >
                                    <select class="form-control" id="edic_id_type_service" name="edic_id_type_service">
                                        <option selected disabled value="">seleccionar</option>
                                        @foreach($type_services as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>BW (maximo aceptado:<span class="bw_limit_pop_info text-info"></span>kbps)</label>
                                <div class="bw_all" id="bw_all" >
                                    <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="edic_BW_reserve" id="edic_BW_reserve" class="form-control" value="">
                                    <select class="form-control" id="edic_bw_max_size" name="edic_bw_max_size">
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
                           <input type="text" placeholder="Comentario" maxlength="100" autocomplete="off" id="edic_commentary_reserve" name="edic_commentary_reserve"class="form-control" value="">
                       </div>
                   </div>
            </form>
            <small class="small" style="color:transparent">a</small>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="edit_cancell_reserve" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="edit_alta_reserve_save" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>