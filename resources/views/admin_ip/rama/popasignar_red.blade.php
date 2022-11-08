<div class="modal inmodal fade" id="popasignar_red_ip" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrar_pop_asignar_red_ip" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">ASIGNAR RED</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_sub_red">
                    <div class="form-group">
                        <label>Atributo*</label>
                        <select class="form-control" onchange="AsignarAtributo();" id="atributo_red_ip" name="atributo_red_ip">
                            <option selected disabled value="">seleccionar</option>
                            <option value="1">Anillo</option>
                            <option value="2">Cliente</option>
                            <option value="5">Servicio</option>
                            <option value="6">Nodo</option>
                            <option value="4">Otro</option>
                        </select>
                    </div>
                    <div class="form-group" id="anillo_input_red" style="display: none;">
                        <label>Tipo Vlan*</label>
                        <select class="form-control" id="type_vlan_red_ip" name="type_vlan_red_ip">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($vlan_all as $vlan_all)
                                <option value="{{ $vlan_all['id'] }}">{{ $vlan_all['name'] }}</option>
                            @endforeach
                        </select>

                        <label>Vlan*</label>
                        <input class="form-control" type="text" placeholder="Vlan" autocomplete="off" name="vlan_sub_red" id="vlan_sub_red" onkeypress="return esNumero(event);">
                        <div id="anillo_input_red_id" style="display: none;">
                            <label>Anillo*</label>
                            <div class="bw_all"> 
                                <select class="form-control" id="anilo_id_sub_red"  disabled="true" name="anilo_id_sub_red">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                                <a class="ico_input btn btn-info" id="bus_anillo" data-toggle="modal" data-target="#buscar_anillo" onclick="list_anillo_servi();"><i class="fa fa-search" title="Buscar IP" > </i></a>
                            </div>
                        </div>
                        <div id="node_input_red_id" style="display: none;">
                            <label>Nodo*</label>
                            <div class="bw_all"> 
                                <select class="form-control" id="nodo_al"  disabled="true" name="nodo_al">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                                <a onclick="node_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar nodo"><i class="fa fa-search"  > </i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="cliente_input_red" style="display: none;">
                        <label>Cliente*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" disabled="true" id="client_sub_red" name="client_sub_red">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i> </a>
                        </div>
                    </div>
                    <div class="form-group" id="comen_input_red" style="display: none;">
                        <label>COMENTARIO*</label> 
                        <input class="form-control" type="text" placeholder="Comentario" autocomplete="off" name="asignar_sub_red" id="asignar_sub_red">
                    </div>
                    <div class="form-group" id="servicio_input_red" style="display: none;">
                        <label>Servicio*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control servicio_recurso hide-arrow-select" disabled="true" id="id_servicio_sub_red" name="id_servicio_sub_red">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select();"><i class="fa fa-search"> </i></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" id="cancelar_asignar_red_ip">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" id="aceptar_asignar_red_ip" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Aceptar</strong>
                </button>
            </div>
        </div>
    </div>
</div>