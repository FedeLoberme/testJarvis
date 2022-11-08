<div class="modal inmodal fade" id="popeditar_frontera" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerrar_frontera_pop_edit" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fas fa-kaaba modal-icon" style=""></i>
                <h4 class="modal-title" id="title_frontier">Editar Frontera</h4>
            </div>
            <div class="modal-body" style="padding-right: 50px; padding-left: 50px;">

                <form role="form" method="POST" id="alta_frontera">
                    {{ csrf_field() }}
                    <input type="hidden" value="" name="id_type_equip_A" id="id_type_equip_A">
                    <input type="hidden" value="" name="id_type_equip_B" id="id_type_equip_B">
                    <input type="hidden" value="" name="modify_this" id="modify_this">
                    <input type="hidden" value="" name="bw_lacp_A" id="bw_lacp_A">
                    <input type="hidden" value="" name="bw_lacp_B" id="bw_lacp_B">
                    <input type="hidden" name="id_frontier" id="id_frontier">
                    <input type="hidden" value="" id="equip_to_work">
                    <div style="display: flex; justify-content:center; align-items:center;"class="col-sm-12">
                        <div class="form-group col-sm-2">
                            <label>Frontera</label>
                            <div class="input-group">
                                <input type="text" id="frontier_number_edit"class="form-control" placeholder="Nro Frontera" aria-label="Nro Frontera" aria-describedby="basic-addon1" value="{{ $n_frontier + 1}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tipo Frontera <span class="type_frontier"></span><span style=color:red;>*</span></label>
                                <div class="bw_all" id="bw_all" >
                                    <select class="form-control" id="id_type_frontier_edit" name="id_type_frontier" onchange="choose_type_equipment();">
                                        <option disabled value="0">seleccionar</option>
                                        <option value="1">Metro</option>
                                        <option value="2">AL</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tipo servicio <span class="type_service"></span><span style=color:red;>*</span></label>
                                <div class="bw_all" id="bw_all" >
                                    <select class="form-control" id="id_type_service_edit" name="id_type_service" onchange="choose_type_equipment();">
                                        <option selected disabled value="0">seleccionar</option>
                                        {{-- @foreach($type_services as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach --}}
                                        <option value="1">Internet</option>
                                        <option value="2">RPV</option>
                                        <option value="3">M&oacute;vil</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="border-frontier col-sm-12 m-t-none" style="display: flex; flex-direction: column; justify-content:center; align-items:center;">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Zona<span style=color:red;>*</span></label>
                                <div class="bw_all" id="bw_all" >
                                    <select class="form-control" id="id_zone_edit" name="id_zone">
                                        <option selected  value="0">seleccionar</option>
                                        @foreach($zones as $value)
                                            <option value="{{ $value['value'] }}">{{ $value['description'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="col-md-offset-1 col-md-5">
                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <label>Equipo <span class="equip_type_A_edit"></span> <span style=color:red;>*</span></label>
                                        <div class="bw_all" id="bw_all" >
                                            <select class="form-control old_agg hide-arrow-select" disabled="true" id="equip_A_edit" name="equip_A" onchange="">
                                                <option selected disabled value="0">seleccionar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="port_input_chain">
                                    <label>Puerto(s)<span style=color:red;>*</span></label>
                                    <a id="agregador" data-toggle="modal" data-target="#poplist_lacp" onclick="load_lacp_frontier_edit(0);" ><i class="fa fa-plus" title="Agregar LACP"> </i> Editar Puertos del LACP</a>

                                    <div id="ports_frontier_A_edit" >

                                    </div>
                                    <input type="hidden" id="lacp_id_A" value="">
                                </div>
                                <div class="col-md-12" >
                                    <br>
                                    <div class="form-group">
                                        <label>Nombre Interfaz:</label>
                                        <input type="text" placeholder="Bundle..." autocomplete="off" id="interfaz_a_edit" name="coment_1"class="form-control" value="" maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">

                                <div class="col-md-12">
                                    <br>
                                    <div class="form-group">
                                        <label>Equipo <span class="equip_type_B_edit"></span><span style=color:red;>*</span></label>
                                        <div class="bw_all" id="bw_all" >
                                            <select class="form-control old_agg hide-arrow-select" disabled="true" id="equip_B_edit" name="equip_B" onchange="">
                                                <option selected disabled value="0">seleccionar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="port_input_chain">
                                    <label>Puerto(s)<span style=color:red;>*</span></label>
                                    <a id="agregador_b" data-toggle="modal" data-target="#poplist_lacp" onclick="load_lacp_frontier_edit(1);" ><i class="fa fa-plus" title="Agregar LACP"> </i> Editar Puertos del LACP</a>
                                    <div id="ports_frontier_B_edit" >

                                    </div>
                                    <input type="hidden" id="lacp_id_B" value="">
                                </div>
                                <div class="col-md-12" >
                                    <br>
                                    <div class="form-group">
                                        <label>Nombre Interfaz:</label>
                                        <input type="text" placeholder="Bundle..." autocomplete="off" id="interfaz_b_edit" name="interfaz_b"class="form-control" value="" maxlength="100">
                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                    <div style="display: flex; justify-content:center; align-items:center;"class="col-sm-12">
                        <div class="form-group col-sm-4">
                            <label>Acronimo</label>
                            <div class="input-group">
                                <input type="text" disabled class="form-control" id="acronimo_frontier_edit" placeholder="FR-SRV-ASU-_0458" aria-label="Acronimo" aria-describedby="basic-addon1" value="">
                            </div>
                        </div>
                        <div class="form-group col-sm-4">
                            <label>Bw Calculado Frontera</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="bw_total_frontier_edit" readonly aria-label="bw" aria-describedby="basic-addon1" value="">
                            </div>
                        </div>
                    </div>
                </form>
                <span style="color: transparent">a</span>

            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button data-dismiss="modal" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="equipment_data"></div>
