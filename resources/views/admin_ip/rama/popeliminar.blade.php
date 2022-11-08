<div class="modal inmodal fade" id="popeliminar" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" id="cerrar_eliminar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">ELIMINAR RANGO</h4>
            </div>
            <form role="form" method="POST" id="eliminar_rango">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Rango</label>
                        <select class="form-control" id="rango_exis" name="rango_exis">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="eliminar_rango_listo();"><i class="fa fa-floppy-o"></i><strong>  Eliminar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
