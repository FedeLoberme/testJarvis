<div class="modal inmodal fade" id="inf_equip_port" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_bus_equipo_servi" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-keyboard-o modal-icon"></i>
                <h4 class="modal-title">PUERTOS</h4> 
                <h5 class="modal-title" id="acro_equi_por"></h5> 
            </div>
            <div class="table-responsive">
                <input  type="hidden" id="equip" value="0">
                <center id="new_lacp_boton" style="display: none;">
                    <a class="btn btn-success" data-toggle="modal" data-target="#port_lacp_sevice_pop" onclick="new_lacp();">
                        <i class="fa fa-pencil"></i> Nuevo LACP
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
                    <br>
                    <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis" >
                        <thead>
                            <tr>
                                <th>Puerto</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>BW</th>
                                <th>Atributo</th>
                                <th>Oper/Admin</th>
                                <th>Descripci&oacute;n</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="list_all_port_equipmen">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer"> 
            </div>
        </div>
    </div>
</div>
