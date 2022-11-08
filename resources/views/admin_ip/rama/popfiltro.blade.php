<div class="modal inmodal fade" id="popfilter" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrar_pop_filter" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">BUSCAR IP</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_filter">
                    <div class="form-group">
                        <label>Atributo*</label>
                        <select class="form-control" onchange="FiltroAtributo();" id="atributo_ip" name="atributo_ip">
                            <option selected disabled value="">seleccionar</option>
                            <option value="1">Anillo</option>
                            <option value="2">Cliente</option>
                            <option value="3">Equipo</option>
                            <option value="4">IP</option>
                            <option value="5">Servicio</option>
                        </select>
                    </div>
                    <div class="form-group" id="anillo_input" style="display: none;">
                        <label>Anillo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <input type="text" disabled="true" placeholder="Anillo" id="anilo_name" name="anilo_name"class="form-control" value="{{old('anilo_name')}}">
                            <input type="hidden" name="anilo_id" id="anilo_id">
                            <a class="ico_input btn btn-info" id="bus_anillo" data-toggle="modal" data-target="#buscar_anillo" onclick="list_anillo_servi();"><i class="fa fa-search" title="Buscar IP" > </i></a>
                        </div>
                    </div>
                    <div class="form-group" id="cliente_input" style="display: none;">
                        <label>Cliente*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" disabled="true" id="client" name="client">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i> </a>
                        </div>
                    </div>
                    <div class="form-group" id="equipo_input" style="display: none;">
                        <label>Equipo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control equip hide-arrow-select" id="equip" name="equip" disabled="true">
                                 <option selected disabled value="">seleccionar</option>
                            </select>
                            <a onclick="equipo_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_all_equipo_ip" title="Buscar Equipo"><i class="fa fa-search"> </i></a>
                        </div>
                    </div>
                    <div class="form-group" id="ip_input" style="display: none;">
                        <label>IP*</label> 
                        <input type="text" onkeypress="return val_ip(event);" placeholder="000.000.000.000" autocomplete="off" name="ip_filter" id="ip_filter"  class="form-control">
                    </div>
                    <div class="form-group" id="servicio_input" style="display: none;">
                        <label>Servicio*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control servicio_recurso hide-arrow-select" disabled="true" id="id_servicio_recurso" name="id_servicio_recurso">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select();"><i class="fa fa-search"> </i></a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="cancelar_filtro">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" id="aceptar_filtro" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Aceptar</strong>
                </button>
            </div>
        </div>
    </div>
</div>