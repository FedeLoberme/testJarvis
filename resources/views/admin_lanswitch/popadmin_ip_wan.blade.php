<div class="modal inmodal fade overflow-modal" id="ip_wan_sele_lans" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_bus_ip_wan_lans" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">BUSCAR Y SELECIONAR IP</h4>
            </div>
            <div class="col-sm-12">
                <center>
                        <a class="btn btn-success" data-toggle="modal" data-target="#new_vlan_anillo_alta" onclick="crear_vlan_rango_ip_wan();"><i class="fa fa-pencil"></i> 
                                Nueva Vlan
                            </a>
                    </center>
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Uso</th>
                            <th>Vlan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="ip_wan_lanswitch_table">
                                           
                    </tbody>
                </table>
            </div> 
            <div class="modal-footer">
            </div> 
        </div>
    </div>
</div>
