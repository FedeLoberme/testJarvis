<div class="modal inmodal fade pop_equi_general overflow-modal" id="editar_recurso_servicio_pop" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_editar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">MODIFICAR RECURSO</h4> 
            </div>
            <form role="form" method="POST" id="edic_recurso">
                {{ csrf_field() }}
                <input type="hidden" name="lacp_id" id="lacp_id">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Servicio*</label>
                        <select class="form-control hide-arrow-select" id="id_service_recur" name="id_service_recur" disabled="true">
                        </select>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label>Equipo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" id="id_equip" name="id_equip" disabled="true">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Vlan LAN</label>
                        <input type="text" placeholder="0000" maxlength="4" onkeypress="return esNumero(event);" autocomplete="off"  id="vlan_recurso_edict" name="vlan_recurso_edict" class="form-control">
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Puertos*</label> <br>
                            <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi_edict();" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                    </div>
                </div>
                <div class="col-sm-12"  >
                    <div class="form-group">
                        <div id="campos_port_all_full">
                               
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-5" id="ip_servicio_wan_edic" style="display: none;">
                    <div class="form-group">
                        <label>IP WAN INTERNET</label> 
                        <div class="bw_all" id="bw_all" > 
                            <input  type="hidden" id="ip_admin_servi_id_edic">
                            <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi_edic" name="ip_admin_servi_edic"class="form-control" value="{{old('ip_admin_servi')}}">
                            <a class="ico_input btn btn-info" onclick="buscar_ip_admin_lanswitch(2);" data-toggle="modal" data-target="#ip_wan_sele_lans" title="Buscar IP"><i class="fa fa-search"> </i></a>
                            <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                        </div>
                    </div>
                </div>             
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button onclick="editar_service_recurso();" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
