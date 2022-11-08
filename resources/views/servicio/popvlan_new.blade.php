<div class="modal inmodal fade overflow-modal" id="vlan_pop_new" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_servi_vlan" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"> MODIFICAR VLAN</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="por_id" id="por_id">
                <div class="form-group">
                    <label>Vlan*</label> 
                    <input type="text" onkeypress="return esNumero(event);" placeholder="0000" id="vlan_ser_rec" name="vlan_ser_rec" class="form-control" value="{{old('vlan_ser_rec')}}" maxlength="5">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" id="vlan_service_new_cerra" ><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                <button class="btn btn-primary" type="button" id="vlan_service_new" ><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </div>
    </div>
</div>
