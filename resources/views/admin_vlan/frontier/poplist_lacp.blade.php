<div class="modal inmodal fade" id="poplist_lacp" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerrar_lacp_frontier" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">Puertos LACP</h4> 
            </div>
            <center id="new_lacp_boton" style="display: block;">
                <a class="btn btn-success" data-toggle="modal" data-target="#port_lacp_sevice_pop" onclick="lacp_frontier();">
                    <i class="fa fa-pencil" aria-hidden="true"></i> Nuevo LACP
                </a>
            </center>
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Grupo</th>
                            <th>Puerto</th>
                            <th>Atributo</th>
                            <th>Descripci&oacute;n</th>
                            <th>Opci&oacute;n</th>
                        </tr>
                    </thead>
                    <tbody id="list_all_lacp_equipmen">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"> 
            </div>
        </div>
    </div>
</div>