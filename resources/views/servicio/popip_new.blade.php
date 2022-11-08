<div class="modal inmodal fade overflow-modal" id="ip_new_ser_recu_rank" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_servi_ip_rank" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"> AGREGAR  RANGO IP</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Rango IP*</label> 
                    <div class="bw_all" id="bw_all" > 
                        <select class="form-control hide-arrow-select" id="ip_admin" name="ip_admin" disabled="true">
                            <option selected disabled value="">seleccionar</option>      
                        </select>
                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,1);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                <button class="btn btn-primary" type="button" onclick="ip_rank_new_servi();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </div>
    </div>
</div>
