<div class="modal inmodal fade" id="pop_ip_anillo_vlan" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_vlan" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-sitemap modal-icon"></i>
            <h4 class="modal-title">VLAN Y RANGO IP</h4>
            <center>
                <a class="btn btn-success" data-toggle="modal" data-target="#new_vlan_anillo_alta" onclick="crear_vlan_rango_ip(2);"><i class="fa fa-plus"></i> 
                    Nueva Vlan
                </a>
            </center>
        </div>
        <input  type="hidden" id="id_equip_vlan" value="0">
        <input  type="hidden" id="id_anillo_vlan" value="0">
        <form role="form" method="POST" id="vlan_new">
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <thead>
                        <tr>
                            <th>Uso</th>
                            <th>Vlan</th>
                            <th>Frontera</th>
                            <th>IP Red</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="list_ip_vlan_mostrar">
                                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </form>
    </div>
</div>

</div>
