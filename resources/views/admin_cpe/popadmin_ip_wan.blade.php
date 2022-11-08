<div class="modal inmodal fade overflow-modal" id="ip_admin_sele_cpe" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_bus_ip_admin_cpe" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">BUSCAR Y SELECIONAR IP</h4>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label>Anillo*</label>
                    <div class="bw_all" id="bw_all" > 
                        <select class="form-control servicio_recurso hide-arrow-select" disabled="true" onchange="ip_wan_anillo_sele_cpe();" id="anillo_id_ip_wan" name="anillo_id_ip_wan">
                            <option selected disabled value="">seleccionar</option>
                        </select>
                        <a class="ico_input btn btn-info" id="bus_anillo" data-toggle="modal" data-target="#buscar_anillo" onclick="selec_ring_ip_wan();"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                    </div>
                </div>
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
                    <tbody id="ip_cpe_table">
                                           
                    </tbody>
                </table>
            </div> 
            <div class="modal-footer">
            </div> 
        </div>
    </div>
</div>
