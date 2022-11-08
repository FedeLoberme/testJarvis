<div class="modal inmodal fade overflow-modal" id="new_puerto_servicio_alta" role="dialog" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="exit_port_servi"><span
                        aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">ASIGNAR PUERTOS</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="target_form" value="">
                <!--
                <center>
                    <a class="btn btn-success" data-toggle="modal" data-target="#port_lacp_sevice_pop"
                        onclick="new_lacp();"><i class="fa fa-pencil"></i>
                        Nuevo LACP
                    </a>
                </center>
                -->
                <table class="table table-striped table-bordered table-hover dataTables-example" id="assign_port_list">
                    <thead>
                        <tr>
                            <th>Posición</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Servicio</th>
                            <th>Comentario</th>
                            <th>Opción</th>
                        </tr>
                    </thead>
                    <tbody id="por_alta_servicio">

                    </tbody>
                </table>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i
                            class="fa fa-times-rectangle-o"></i><strong> Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="port_servi_pantalla(document.getElementById('target_form').value)"><i
                            class="fa fa-floppy-o"></i><strong> Guardar</strong></button>
                </div>
            </div>
        </div>
    </div>
</div>
