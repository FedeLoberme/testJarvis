<div class="modal inmodal fade" id="lis_selec" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="exit_pop_cer" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h6 class="modal-title" id="msj_list"></h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_lis">
                    <div class="form-group" id="modelo2">
                            <label>Nombre</label> 
                            <input type="hidden" id="table_list" name="table_list" >
                            <input style="text-transform: uppercase;" type="text" placeholder="Nombre" autocomplete="off" id="name_equip" name="name_equip"class="form-control" value="{{old('name_equip')}}" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" id="list_cerrar" data-dismiss="modal">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary"  id="list_nuevo" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
            </div>
        </div>
    </div>
</div>