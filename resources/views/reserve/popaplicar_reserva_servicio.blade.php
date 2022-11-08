<div class="modal inmodal fade pop_equi_general overflow-modal" id="aplicar_reserva_servicio_pop" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" style="width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="apply_serv_res_close" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-clipboard-check modal-icon"></i>
                <h4 class="modal-title">APLICAR RESESRVA</h4> 
            </div>
            <div class="modal-body">
                <p><strong>¿Desea aplicar este cambio sobre el servicio?</strong></p>
                <p>BW Actual: <strong><span id="serv_current_bw"></span></strong></p>
                <p>BW Nuevo: <strong><span id="serv_new_bw"></span></strong></p>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button type="button" class="btn btn-primary" id="apply_serv_res_accept">
                        <i class="fa fa-check"></i>
                        <strong>  Aceptar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
