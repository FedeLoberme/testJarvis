<div class="modal inmodal fade pop_equi_general" id="popcrear_anillo" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" id="cerrar_anillo_register" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-circle-o-notch modal-icon"></i>
                <h4 class="modal-title">CREAR ANILLO</h4>
            </div>
            <form role="form" method="POST" id="anillo_n">
                <div class="modal-body" >
                    <input  type="hidden" id="id_anillo" name="id_anillo" value="0">
                    <div class="form-group">
                        <label>Nodo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" disabled="true" onchange="nodo_agg_alta();" id="nodo_al_anillo" name="nodo_al_anillo">
                                <option selected disabled value="">seleccionar</option>      
                            </select>
                            <a onclick="node_table_select_anillo();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar Nodo"><i class="fa fa-search"> </i> Buscar</a> 
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Agregador*</label>
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" disabled="true" onchange="acronimo_agg_anillo_alta();" id="agg" name="agg" >
                                <option selected disabled value="">seleccionar</option>       
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_agg_all"><i class="fa fa-search" title="Buscar Agregador" > </i> Buscar</a>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nombre de anillo*</label>
                        <div class="bw_all" id="bw_all" >
                            <input style="width:53px;" disabled="true" type="text" class="form-control" value="ME-">
                            <select class="form-control" id="acro_selec" name="acro_selec" onchange="acronimo_anillo_alta();">
                                <option selected disabled value="">seleccionar</option>
                                         
                            </select>
                            <input type="text" style="width:60px;" placeholder="0000" maxlength="4" autocomplete="off" name="num_acro" id="num_acro"  class="form-control" value="{{old('num_acro')}}">
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Pre-view</label>
                            <input type="text" placeholder="00000000000" disabled="true" autocomplete="off" name="acro_anillo" id="acro_anillo" maxlength="50" class="form-control" value="{{old('acro_anillo')}}">
                            <p class="mensajeInput" id="acro_anillo_msj"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Dedicado*</label>
                            <select class="form-control" id="dedica" name="dedica">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($confi as $key => $con)
                                    @if (old('dedica') == $key)
                                        <option value="{{ $key }}" selected>{{ $con }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $con }}</option>
                                    @endif
                                @endforeach    
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Tipo de anillo*</label>
                        <select class="form-control" id="type_anillo" name="type_anillo">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Bifilar">Bifilar</option>
                            <option value="Unifilar">Unifilar</option>
                                     
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_me_vlan_ls">
                            <label>Vlan Gesti&oacute;n LS*</label>
                            <input type="hidden" id="me_vlan_ls_arr" name="me_vlan_ls_arr" value="">
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="me_vlan_ls" name="me_vlan_ls">
                                </select>
                                <a class="ico_input btn btn-info" id="next_me_vlan_ls" onclick="next_vlan(5);"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_me_vlan_radio">
                            <label>Vlan Gesti&oacute;n Radio</label>
                            <input type="hidden" id="me_vlan_radio_arr" name="me_vlan_radio_arr" value="">
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="me_vlan_radio" name="me_vlan_radio">
                                </select>
                                <a class="ico_input btn btn-info" id="next_me_vlan_radio" onclick="next_vlan(6);"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_me_ip_ls">
                            <label>IP Gesti&oacute;n LS*</label> 
                            <div class="bw_all" id="bw_all" > 
                                <input type="hidden" id="me_ip_ls_id">
                                <input type="text" disabled placeholder="000.000.000.000" id="me_ip_ls" name="me_ip_ls" class="form-control" value="{{old('ipran_ip_ls')}}">
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(2,13);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_me_ip_radio">
                            <label>IP Gesti&oacute;n Radio</label> 
                            <div class="bw_all" id="bw_all" > 
                                <input type="hidden" id="me_ip_radio_id">
                                <input type="text" disabled placeholder="000.000.000.000" id="me_ip_radio" name="me_ip_radio" class="form-control" value="{{old('ipran_ip_radio')}}">
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(2,14);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                            </div>
                        </div> 
                    </div>
                                   
                    <div class="form-group">
                        <label>Puertos* </label> 
                        <a id="port_mas" data-toggle="modal" data-target="#new_placa_anillo_alta" onclick="port_anillo_selec();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar y/o Quitar Puerto</a>
                        <div id="campos_port_ani">
                                    
                        </div>
                    </div>
                    <!--
                    <div class="form-group">
                        <label>Vlan* </label> 
                        <a id="port_mas" data-toggle="modal" data-target="#new_vlan_anillo_alta" onclick="vlan_anillo_selec();" ><i class="fa fa-plus" title="Agregar Vlan"> </i> Agregar Vlan</a>
                        <div id="campos_vlan_plus">
                                  
                        </div>
                    </div>
                    -->
                    <div class="form-group" id="descri2">
                        <label>Comentarios</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commen_anillo" maxlength="100" name="commen_anillo"class="form-control" value="{{old('commen_anillo')}}">
                    </div>             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="register_port_anillo_selec();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
