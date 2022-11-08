<div class="modal inmodal fade" id="popcrear_radio_editar" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="cerrar_radio_editar" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title"> MODIFICAR RADIO</h4>
            </div>
            <form role="form" method="POST" id="radio_edi">
                <input type="hidden" name="mark" id="mark">
                <div class="modal-body">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Cliente*</label>
                            <div class="bw_all">
                                <select disabled="true" class="form-control hide-arrow-select" id="edi_client" name="edi_client">
                                    <option selected disabled value="">Seleccionar Puerto</option>
                                </select>
                                <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i>Buscar </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Acronimo*</label>
                            <input type="text" autocomplete="off"  id="edi_acro_radio" name="edi_acro_radio" class="form-control" maxlength="20">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Dirección*</label>
                            <div class="bw_all">
                                <select disabled="true" class="form-control hide-arrow-select" id="edi_address" name="edi_address">
                                    <option selected disabled value="">Seleccionar Puerto</option>
                                </select>
                                <a class="ico_input btn btn-info "onclick="detal_addres_radio();" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                                <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label>Modelo de Radio*</label>
                            <select disabled="true" class="form-control hide-arrow-select" id="edi_model" name="edi_model">
                                <option selected disabled value="">Seleccionar Puerto</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label>Comentarios</label> 
                            <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commen_edi" maxlength="100" name="commen_edi"class="form-control">
                        </div>             
                    </div> 
                    <div class="col-lg-4" id="input_edi_ne_id">
                        <div class="form-group">
                            <label>NE-ID*</label>
                            <input type="text" autocomplete="off"  id="edi_ne_id_radio" name="edi_ne_id_radio" class="form-control" maxlength="20">
                        </div>
                    </div>
                    <div class="col-lg-4" id="input_edi_loopback">
                        <div class="form-group">
                        <label>IP de LoopBack*</label>
                            <div class="bw_all">
                                <select disabled="true" class="form-control hide-arrow-select" id="edi_loopback" name="edi_loopback">
                                    <option selected disabled value="">Seleccionar Puerto</option>
                                </select>
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,7);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP"><i class="fa fa-search"> </i> Buscar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal" id="edi_cancel" ><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" id="edi_save" ><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
