<div class="modal inmodal fade" id="popedit" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
<div class="modal-dialog">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close"  id="cerrar_edic_client" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-building modal-icon"></i>
            <h4 class="modal-title">MODIFICAR CLIENTE</h4>
        </div>
        <form role="form" method="POST" name="clip_edit" id="clip_edit">
            <div class="modal-body">
                <div class="form-group">
                    <label>CUIT</label> 
                        <input onkeypress="return esNumero(event);" maxlength="11" type="text" id="cuit"  class="form-control">
                </div>
                <div class="form-group">
                    <label>Razón Social</label> 
                        <input  style="text-transform: uppercase;" type="text" id="name"  class="form-control" >
                        <input  type="hidden" id="id" name="id">
                </div>
                <div class="form-group">
                        <label>Acrónimo</label> 
                        <div class="bw_all" id="bw_all" > 
                            <input onkeypress="return letra(event);" onkeypress="mayus(this);" style="text-transform: uppercase;" type="text" placeholder="----" maxlength="4"autocomplete="off" id="acronimo" name="acronimo"class="form-control">

                            <a class="ico_input btn btn-info " onclick="acronimo_client();"> <i class="fa fa-rotate-left" title="Generar Acrónimo"> </i> G. Acrónimo</a>
                        </div>
                </div>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" onclick="edict_validate_acronimo();" type="button"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>
</div>