<div class="modal inmodal fade overflow-modal" id="mostrar_recurso_servicio_pop" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="exit_port_recur"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">RECURSO DEL SERVICIO</h4> 
            </div>
            <input type="hidden" name="id_servicio_recurso" id="id_servicio_recurso">
            <input type="hidden" name="id_servicio_tipo" id="id_servicio_tipo">
            <div class="modal-body">
                <center>
                        <a class="btn btn-success" data-toggle="modal" data-target="#recurso_servicio_pop" id="new_resource" onclick="alta_servicio_recurso(document.getElementById('id_servicio_tipo').value)"><i class="fa fa-pencil"></i> 
                                Nuevo recurso
                            </a>
                    </center><br>
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                     
                        <thead>
                            <tr>
                                <th>Puerto</th>
                                <th>Equipo</th>
                                <th>Grupo</th>
                                <th>Vlan</th>
                                <th>Comentario</th>
                                <th style="width: 40px">Seleccinar</th>
                            </tr>
                        </thead>
                        <tbody id="por_alta_recursos">
                            
                        </tbody>
                        </table>
                <div class="modal-footer">
                </div>
            </div>  
        </div>
    </div>
</div>
