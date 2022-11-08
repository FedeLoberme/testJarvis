<div class="modal" tabindex="-1" role="dialog" id="attach_uplink_equipment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">VINCULAR EQUIPO A UPLINK</h5>
                <button type="button" id="close_attach_uplink_equipment" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <form method="POST">
                        <input type="hidden" id="attach_board_id" name="attach_board_id" value="">
                        <input type="hidden" id="attach_port_n" name="attach_port_n" value="">
                        <label>Uplink*</label>
                        <div class="bw_all" id="bw_all">
                            <select class="form-control equip hide-arrow-select" onchange="" id="uplink_field" name="" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="uplink_search_anchor" data-toggle="modal" data-target="#list_link_pop" title="Buscar Uplink">
                                <i class="fa fa-search"> </i> Buscar</a>
                        </div>
                        <div id="port_div">
                            <label>Puerto del equipo a vincular*</label>
                            <div class="bw_all" id="bw_all">
                                <select class="form-control equip hide-arrow-select" onchange="" id="port_field" name="" disabled="true">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                                <a class="ico_input btn btn-info" id="port_search_anchor" data-toggle="modal" data-target="#port_list_modal" title="Buscar Puerto">
                                    <i class="fa fa-search"> </i> Buscar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" id="">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong> Cancelar</strong>
                </button>
                <button class="btn btn-primary" id="" type="button" onclick="relate_ls_uplink()">
                    <i class="fa fa-floppy-o"></i>
                    <strong> Aceptar</strong>
                </button>
            </div>
        </div>
    </div>
</div>
