<div class="modal inmodal fade" id="new_vlan_anillo_alta" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="exit_alta_vlan"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Asignar Vlan</h4>
                <input  type="hidden" id="rango_ip" > 
            </div>
            <div class="modal-body">
                <form role="form" method="POST" id="vla_all_new">
                    <div class="form-group">
                        <label>Uso de vlan*</label> 
                        <select class="form-control" id="use_vlan" name="use_vlan">
                            <option selected disabled value="">seleccionar</option>
                            
                            @foreach($list_vlan as $list_vlan)
                                @if (old('use_vlan') == $list_vlan->id)
                                    <option value="{{ $list_vlan->id }}" selected>{{ $list_vlan->name }}</option>
                                @else
                                    <option value="{{ $list_vlan->id }}">{{ $list_vlan->name }}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" id="div_frontier">
                        <label>Frontera*</label>
                        <div class="bw_all">
                            <select class="form-control hide-arrow-select" disabled="true" id="select_frontier" name="frontier">
                            </select>
                            <a class="ico_input btn btn-info" id="button_frontier" data-toggle="modal" data-target="#modal_frontier"><i class="fa fa-plus" title="Seleccionar frontera" > </i> Seleccionar</a>
                        </div>
                    </div>
                    <div class="form-group" id="div_vlan">
                        <label>Vlan*</label>
                        <input type="hidden" id="free_vlans_arr" name="free_vlans_arr" value="">
                        <div class="bw_all">
                            <select class="form-control hide-arrow-select" disabled="true" id="free_vlans" name="free_vlans">
                            </select>
                            <a class="ico_input btn btn-info" id="next_free_vlan"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                        </div>
                    </div>
                    <div class="form-group" id="admin_ip_vlan">
                        <label>IP*</label> 
                        <div class="bw_all" id="bw_all" > 
                            <input type="hidden" id="ip_admin_id_anillo">
                            <input type="text" disabled placeholder="000.000.000.000" id="ip_admin_anillo" name="ip_admin_anillo"class="form-control" value="{{old('ip_admin_anillo')}}">
                            <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(2,3);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                        </div>
                    </div> 
                </form>               
            </div>  
            <div class="modal-footer">
                <button type="button" class="btn" id="vlan_cancelar" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" id="vlan_aceptar" type="button"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>

            </div>
        </div>
    </div>
</div>
