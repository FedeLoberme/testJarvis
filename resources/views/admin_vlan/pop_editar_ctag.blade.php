<div class="modal inmodal fade" id="poplist_ctag" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerrar_ctag_edit" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">Editar CTAG</h4>
            </div>
            <div class="modal-body">
                <div class="form-group" id="edit_frontier_acronimo_parent">
                    <input class="form-control" id="edit_service_ctag" name="ctag" type="number">
                    <input type="hidden" id="service_id" name="service_id" name="service_id">
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="cancelar_edit_acronimo" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_frontera" onclick="save_ctag();" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
