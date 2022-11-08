<div class="modal inmodal fade overflow-modal" id="ip_new_ser_baja" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_servi_dow" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">BAJA DE SERVICIO</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Orden de Baja*</label> 
                    <input type="text" placeholder="Orden de Baja" onkeypress="return esNumero(event);" autocomplete="off" id="down" name="down"class="form-control" value="{{old('down')}}" maxlength="20">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="cancelar_recurso_servi_dow" ><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                <button class="btn btn-primary" type="button" id="aceptar_recurso_servi_dow" ><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </div>
    </div>
</div>
