<div class="modal inmodal fade" id="etiquetas" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                    <h6 class="modal-title">POSICIÓN DE LA PLACA</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_fsp">
                    <input id="port_ini" type="hidden">
                    <input id="port_fin" type="hidden">
                    <input id="t_label" type="hidden">
                    <input id="nom_placa" type="hidden">
                    <input id="id_placa" type="hidden">
                    <input id="serapador_alta" type="hidden">

                    <div class="form-group" id="elemen1_camp">
                        <label id="elemen1_title"></label>
                        <select class="form-control" id="elemen1" name="elemen1">
                        </select>
                    </div>

                    <div class="form-group" id="elemen2_camp">
                        <label id="elemen2_title"></label>
                        <select class="form-control" id="elemen2" name="elemen2">
                        </select>
                    </div>

                    <div class="form-group" id="elemen3_camp">
                        <label id="elemen3_title"></label>
                        <select class="form-control" id="elemen3" name="elemen3">
                        </select>
                    </div>

                    <div class="form-group" id="elemen4_camp">
                        <label id="elemen4_title"></label>
                        <select class="form-control" id="elemen4" name="elemen4">
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="exit_alta">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" onclick="AgregarCampos();" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Aceptar</strong>
                </button>
            </div>
        </div>
    </div>
</div>