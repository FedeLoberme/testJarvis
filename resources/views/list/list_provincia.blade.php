<div class="modal inmodal fade" id="pop_list_provincia" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrar_pop_list_provincia" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">PROVINCIA</h6>
            </div>
            <div class="modal-body">
                <center>
                    <a class="btn btn-success" data-toggle="modal" data-target="#lis_edict_province" onclick="list_province_new();" title="Agregar localización"> <i class="fa fa-plus"> </i> Nuevo</a>
                </center>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example" id="jarvis_provincia">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Opción</th>
                            </tr>
                        </thead>
                        <tbody id="all_province_pais">
                            
                        </tbody>

                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>