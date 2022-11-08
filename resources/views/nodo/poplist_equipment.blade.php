<div class="modal inmodal fade" id="pop_list_equipments_node" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="close_pop_list_equipment_node" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-share-alt modal-icon"></i>
                <h4 class="modal-title">EQUIPOS ASOCIADOS A: </h4>
                <h4 id="node_list_name"></h4>
            </div>
                <div class="col-sm-12">
                  <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis" id="list_equipment_node">
                        <thead>
                            <tr>
                                <th>Acrónimo</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Servicio</th>
                                <th>Comentario</th>
                            </tr>
                        </thead>
                        <tbody id="list_new_equipment_node">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"> 
                </div>
        </div>
    </div>
</div>
