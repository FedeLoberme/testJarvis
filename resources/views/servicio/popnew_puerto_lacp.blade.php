<div class="modal inmodal fade overflow-modal" id="port_lacp_sevice_pop" role="dialog" aria-hidden="true"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="exit_port_lacp_sevi"><span
                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title" id="title_port_lacp"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Comentario</label>
                    <input type="text" placeholder="Comentario" autocomplete="off" id="come_lacp_equi"
                           name="come_lacp_equi" class="form-control" value="{{old('come_lacp_equi')}}" maxlength="100">
                    <p class="mensajeInput" id="aconimo_lanswitch_msj"></p>
                </div>
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                    <tr>
                        <th>Puerto</th>
                        <th>Modelo</th>
                        <th>Servicio</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="port_lacp_sevice">

                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn" id="lacp_cancelar"><i class="fa fa-times-rectangle-o"></i><strong>
                            Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" id="lacp_aceptar"><i
                            class="fa fa-floppy-o"></i><strong> Guardar</strong></button>
                </div>
            </div>
        </div>
    </div>
</div>
