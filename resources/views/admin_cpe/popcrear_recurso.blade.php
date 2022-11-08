<div class="modal inmodal fade" id="recurso_servicio_pop" role="dialog"  aria-hidden="true" style="overflow-y: auto; max-height: 635px;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_ser" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_recurso"></h4> 
            </div>
            <form role="form" method="POST" id="alta_recurso">
                {{ csrf_field() }}
                <input type="hidden" name="reques_ip" id="reques_ip">
                <input type="hidden" name="reques_rank" id="reques_rank">
                <input type="hidden" name="grupo_puerto" id="grupo_puerto">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Equipo*</label>
                        <input type="hidden" name="equip" id="equip">
                        <input type="text" id="equip_name" disabled="true" class="form-control">
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label>Servicio*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control servicio_recurso hide-arrow-select" disabled="true" onchange="validar_servi();" id="id_servicio_recurso" name="id_servicio_recurso">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select();"><i class="fa fa-search"> </i> Buscar</a>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#crear_servicio_pop" onclick="alta_servicio_crear();" title="Nuevo Servicio"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Vlan</label>
                        <input type="text" placeholder="0000" maxlength="4" onkeypress="return esNumero(event);" autocomplete="off"  id="vlan_recurso" name="vlan_recurso" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6" id="por_all_recuso_servi" style="display: none;">
                    <div class="form-group">
                        <label>Puertos*</label> <br>
                        <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi();" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>    
                    </div>
                </div>
                    
                <div class="col-sm-12"  >
                    <div class="form-group">
                        <div id="campos_port">
                               
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6" id="ip_servicio" style="display: none;">
                    <div class="form-group">
                        <label>IP WAN INTERNET</label> 
                        <div class="bw_all" id="bw_all" > 
                            <input  type="hidden" id="ip_admin_servi_id">
                            <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi" name="ip_admin_servi"class="form-control" value="{{old('ip_admin_servi')}}">
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#ip_admin_sele_cpe" title="Buscar IP"><i class="fa fa-search"> </i></a>
                            <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="rango_servicio" style="display: none;">
                    <div class="form-group">
                        <label>Rango IP PÚBLICO</label> 
                        <div class="bw_all" id="bw_all" > 
                            <input  type="hidden" id="ip_rank_servi_id">
                            <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_rank" name="ip_admin_rank"class="form-control" value="{{old('ip_admin_rank')}}">
                            <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                            <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
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
                    <button onclick="alta_service_recurso();" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
