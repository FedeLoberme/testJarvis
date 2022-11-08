<div class="modal inmodal fade" id="lis_edict_province" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="exit_pop_cerra_province" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title" id="title_provinse"></h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_lis_edict_province">
                    <div class="form-group">
                        <label>Pais*</label>
                        <input type="hidden" id="list_id_pais" name="list_id_pais" >
                        <input type="text" disabled="true" id="name_pais" name="name_pais"class="form-control" maxlength="50">
                    </div>
                    <div class="form-group">
                        <label>Provincia*</label> 
                        <input type="hidden" id="list_id_provice" name="list_id_provice" >
                        <input style="text-transform: uppercase;" type="text" placeholder="Nombre" autocomplete="off" id="name_lis_povince" name="name_lis_povince"class="form-control" value="{{old('name_lis_povince')}}" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" onclick="new_list_index(12);" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
            </div>
        </div>
    </div>
</div>