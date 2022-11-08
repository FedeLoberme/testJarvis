<div class="modal inmodal fade" id="posicion_placa" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_posicion_placa" class="close" data-dismiss="modal"><span aria-hidden="true"></button>
                <h6 class="modal-title">POSICIÓN DE LA PLACA</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_fsp_board">
                    <input type="hidden" name="separar_pose_alta" id="separar_pose_alta">
                    <div id="all_select_board">
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="exit_alta_placa">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" id="alta_placa" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Aceptar</strong>
                </button>
            </div>
        </div>
    </div>
</div>