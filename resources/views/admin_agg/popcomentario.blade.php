<div class="modal inmodal fade" id="popcomen_port" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-ml">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerrar_comen_puerto" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-twitch modal-icon"></i>
                <h4 class="modal-title">COMENTARIO</h4>
                <h4 class="modal-title" id="title_port_commen"></h4>
            </div>
            <form method="POST" id ="port_commen_detal">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Comentario*</label>  
                        <input class="form-control" maxlength="300" type="text" id="commen_port_all" placeholder="Comentario" autocomplete="off" name="commen_port_all" value="{{old('commen_port_all')}}">
                    </div>
                </div>   
                <div class="modal-footer">
                    <button type="button" id="button_cancelar" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="button_aceptar" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>   
                </div>
            </form>
        </div>
    </div>
</div>
