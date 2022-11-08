<div class="modal inmodal fade" id="relacionar_puertos_agg_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="relacionar_puertos_agg_cerrar_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">RELACIONAR PUERTOS</h4> 
            </div>
            <form role="form" method="POST" id="asignar_puertos_cadena">
                <input type="hidden" id="id_equipment" name="id_equipment" value="">
                {{ csrf_field() }}

                {{-- 1ER Agregador--}}
                        <div class="col-md-offset-1 col-md-4">
                            <div class="col-md-12">
                                <br>
                                <div class="form-group">
                                    <label>Agregador 1<span style=color:red;>*</span></label> 
                                    <div class="bw_all" id="bw_all" >
                                        <select class="form-control old_agg" disabled="true" id="agg_chain_A" name="agg_chain_A" onchange="alimpiar_puertos_A();">
                                            <option selected disabled value="">seleccionar</option>       
                                        </select>
                                        <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_agg_all" onclick="list_agg_chain_equipment_a();"><i class="fa fa-search" title="Buscar Agregador" > </i> Buscar</a>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-12" id="port_input_chain">
                                <label>Puerto<span style=color:red;>*</span></label> 
                                <a id="agregador" data-toggle="modal" data-target="#new_port_lsw_radio" onclick="show_ports_chain_A();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Seleccionar Puerto</a>
                                
                                <div id="chain_port_first" >
                                </div>
                                <input type="hidden" id="puerto_A" value="">
                            </div>
                            <div class="col-md-12" style="display: none;"id="campo_coment_1">
                                <br>
                                <div class="form-group">
                                    <label>Comentario para el puerto 1 </label> 
                                    <input type="text" placeholder="No obligatorio" autocomplete="off" id="coment_1" name="coment_1"class="form-control" value="" maxlength="100">
                                </div>
                            </div>
                            
                        
                        </div>

                        <div class=" col-md-offset-2 col-md-4">

                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <label>Agregador 2<span style=color:red;>*</span></label> 
                                        <div class="bw_all" id="bw_all" >
                                            <select class="form-control old_agg" disabled="true" id="agg_chain_B" name="agg_chain_B" onchange="alimpiar_puertos_B();">
                                                <option selected disabled value="">seleccionar</option>       
                                            </select>
                                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_agg_all" onclick="list_agg_chain_equipment_b();"><i class="fa fa-search" title="Buscar Agregador" > </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="port_input_chain">
                                    <div class="form-group">
                                            <label>Puerto<span style=color:red;>*</span></label> 
                                            <a id="agregador_b" data-toggle="modal" data-target="#new_port_lsw_radio" onclick="show_ports_chain_B();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Seleccionar Puerto</a>
                                            
                                            <div id="chain_port_second">
                                            </div>
                                            <input type="hidden" id="puerto_B" value="">

                                    </div>
                                </div>
                                <div class="col-md-12" style="display: none;"id="campo_coment_2">
                                    <div class="form-group">
                                        <label>Comentario para el puerto 2</label> 
                                        <input type="text" placeholder="No obligatorio" autocomplete="off" id="coment_2" name="coment_2"class="form-control" value="" maxlength="100">
                                    </div>
                                </div>
                                

                        </div>
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="save_relate_ports" onclick="save_relate_ports()" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar </strong>
                    </button>
                </div> 
                </div> 
            </div>
        </div>
    </div>