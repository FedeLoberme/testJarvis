<div class="modal inmodal fade overflow-modal" id="buscar_list_ip" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_all_list_ip" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">INFORMACIÓN IP</h4> 
            </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Atributo*</label>
                        <select class="form-control" onchange="FiltroAtributoLista();" id="atributo_ip_lista" name="atributo_ip_lista">
                                <option selected disabled value="">seleccionar</option>
                                <option value="1">Anillo</option>
                                <option value="2">Cliente</option>
                                <option value="3">Equipo</option>
                                <option value="4">IP</option>
                                <option value="5">Servicio</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" id="anillo_input_list" style="display: none;">
                        <label>Anillo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" disabled="true" id="anillo_id_list" name="anillo_id_list">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_anillo" data-toggle="modal" data-target="#buscar_anillo" onclick="list_anillo_filter();"><i class="fa fa-search" title="Buscar IP" > </i></a>
                        </div>
                    </div>
                    <div class="form-group" id="cliente_input_list" style="display: none;">
                        <label>Cliente*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" disabled="true" id="client_list" name="client_list">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select_ip();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i> </a>
                        </div>
                    </div>
                    <div class="form-group" id="equipo_input_list" style="display: none;">
                        <label>Equipo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control equip hide-arrow-select" id="equip_list" name="equip_list" disabled="true">
                                 <option selected disabled value="">seleccionar</option>
                            </select>
                            <a onclick="equipo_table_select_ip();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_all_equipo_ip" title="Buscar Equipo"><i class="fa fa-search"> </i></a>
                        </div>
                    </div>
                    <div class="form-group" id="ip_input_list" style="display: none;">
                        <label>IP*</label> 
                        <input type="text" onkeypress="return val_ip(event);" placeholder="000.000.000.000" autocomplete="off" name="ip_filter_list" id="ip_filter_list"  class="form-control">
                    </div>
                    <div class="form-group" id="servicio_input_list" style="display: none;">
                        <label>Servicio*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control servicio_recurso hide-arrow-select" disabled="true" id="id_servicio_list" name="id_servicio_list">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select_ip();"><i class="fa fa-search"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <center><a class="btn btn-success" onclick="FilterBuscar();"><i class="fa fa-search"></i> Buscar</a></center>
                </div>
                <div class="col-sm-12">
                  <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis" id="list_all_info_ip">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Estado</th>
                                <th>Atributo</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer"> 
                </div>
        </div>
    </div>
</div>
