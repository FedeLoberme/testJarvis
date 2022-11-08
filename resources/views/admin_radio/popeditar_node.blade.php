<div class="modal inmodal fade" id="popcrear_radio_nodo_editar" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="cerrar_radio_nodo_editar" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title"> MODIFICAR RADIO</h4>
            </div>
            <form role="form" method="POST" id="radio_nodo_edi">
                <input type="hidden" name="mark_radio" id="mark_radio">
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nodo*</label>
                            <div class="bw_all"> 
                                <select disabled="true" class="form-control hide-arrow-select" id="edi_node" name="edi_node">
                                    <option selected disabled value="">Seleccionar Puerto</option>
                                </select>
                                <!-- <a onclick="node_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar nodo"><i class="fa fa-search"  > </i> Buscar</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Acronimo*</label>
                            <input type="text" autocomplete="off"  id="edi_radio_acro" name="edi_radio_acro" class="form-control" maxlength="20">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Modelo de Radio*</label>
                            <select disabled="true" class="form-control hide-arrow-select" id="edi_model_radio" name="edi_model_radio">
                                <option selected disabled value="">Seleccionar Puerto</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>IP de Gestión*</label>
                            <div class="bw_all"> 
                                <select disabled="true" class="form-control hide-arrow-select" id="edi_ip_gestion" name="edi_ip_gestion">
                                    <option selected disabled value="">Seleccionar Puerto</option>
                                </select>
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,9);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP" id="boton_buscar_ip"><i class="fa fa-search"> </i> Buscar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" id="input_radio_neid">
                        <div class="form-group">
                            <label>NE-ID*</label>
                            <input type="text" autocomplete="off"  id="edi_radio_ne_id" name="edi_radio_ne_id" class="form-control" maxlength="20">
                        </div>
                    </div>
                    <div class="col-lg-6" id="input_radio_ip_loopback">
                        <div class="form-group">
                        <label>IP de LoopBack*</label>
                            <div class="bw_all">
                                <select disabled="true" class="form-control hide-arrow-select" id="edi_ip_loopback" name="edi_ip_loopback">
                                    <option selected disabled value="">Seleccionar Puerto</option>
                                </select>
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,8);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP"><i class="fa fa-search"> </i> Buscar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Comentarios</label> 
                            <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commen_edi_radio" maxlength="100" name="commen_edi_radio"class="form-control">
                        </div>             
                    </div>             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal" id="cancel_edi"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" id="save_edict" ><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
