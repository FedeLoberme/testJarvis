<div class="modal inmodal fade overflow-modal" id="ip_admin_sele_lans" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_bus_ip_admin_lans" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">BUSCAR Y SELECIONAR IP</h4>
                <input  type="hidden" id="id_rama_old" value="0">
                <input  type="hidden" id="id_rango_old" value="0"> 
            </div>
            <div class="col-sm-12">
                <center id="new_lacp_boton" style="display: none;">
                    <a class="btn btn-success" data-toggle="modal" data-target="#" onclick="">
                        <i class="fa fa-pencil"></i> Nombre
                    </a>
                </center>
            </div>
            <div class="col-sm-12">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Uso</th>
                            <th>Vlan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="ip_lanswitch_table">
                                           
                    </tbody>
                </table>
            </div> 
            <div class="modal-footer">
            </div> 
        </div>
    </div>
</div>
