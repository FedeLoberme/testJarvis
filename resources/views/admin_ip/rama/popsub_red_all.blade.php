<div class="modal inmodal fade" id="pop_sub_red_all" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_sub_red_all" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-map-marker modal-icon"></i>
            <h4 class="modal-title">CAMBIAR ESTADO</h4>
        </div>
        <form role="form" method="POST" id="sub_red_all_new">
            <div class="modal-body">
                <div class="form-group">
                    <label>Mascara*</label>
                    <input onkeypress="return esNumero(event);" type="text" name="mask_all" maxlength="2" id="mask_all"  class="form-control crear_subred" value="{{old('mask_all')}}">
                </div>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="sub_red_all_cerra"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" type="button" id="sub_red_all_seguir"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
