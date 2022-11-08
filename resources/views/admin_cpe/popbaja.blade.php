<div class="modal inmodal fade" id="pop_baja_equipo" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_equipo_dow" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">BAJA DEL EQUIPO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_equi" id="id_equi">
                <div class="form-group">
                    <label>Orden de Baja</label> 
                    <input type="text" placeholder="Orden de Baja" onkeypress="return esNumero(event);" autocomplete="off" id="down" name="down"class="form-control" value="{{old('down')}}" maxlength="20">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                <button class="btn btn-primary" type="button" onclick="down_equipmen();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </div>
    </div>
</div>
