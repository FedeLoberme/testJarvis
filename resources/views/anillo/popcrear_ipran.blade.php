<div class="modal inmodal fade pop_equi_general" id="popcreate_ring_ipran" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" id="cerrar_anillo_ipran" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-circle-o-notch modal-icon"></i>
                <h4 class="modal-title">CREAR ANILLO IPRAN</h4>
            </div>
            <form role="form" method="POST" id="anillo_ipran">
                <div class="modal-body" >
                    <input  type="hidden" id="id_anillo_ipran" name="id_anillo_ipran" value="0">
                    <div class="form-group col-lg-12">
                        <label>Nodo*</label>
                        <div class="bw_all"> 
                            <select class="form-control hide-arrow-select" id="nodo_all" name="nodo_all" disabled="true" onchange="nodo_lsw_ipran();">
                                <option selected disabled value="">seleccionar</option>      
                            </select>
                            <a onclick="node_table_select_anillo(1);" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar Nodo"><i class="fa fa-search"> </i> Buscar</a> 
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>LSW Ipran*</label>
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" id="id_lsw" name="id_lsw" disabled="true" onchange="">
                                <option selected disabled value="">seleccionar</option>       
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_lsw_all"><i class="fa fa-search" title="Buscar Equipo" > </i> Buscar</a>
                            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nombre de Anillo*</label>
                            <div class="bw_all">
                                <input style="width:53px;" disabled="true" type="text" class="form-control" value="ME-">

                                <input disabled="true" type="text" id="acro_ring_ipran_sele" class="form-control" >

                                <input type="text" style="width:60px;" placeholder="0000" maxlength="4" autocomplete="off" name="num_acro_ipran" id="num_acro_ipran"  class="form-control" value="{{old('num_acro_ipran')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Acronimo</label>
                            <input type="text" placeholder="Acronimo" autocomplete="off" name="ipran_acro_ring" id="ipran_acro_ring" maxlength="50" class="form-control" value="{{old('ipran_acro_ring')}}" readonly>
                            <p class="mensajeInput" id="acro_ring_ipran_msj"></p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Dedicado*</label>
                            <select class="form-control" id="dedica_ipran" name="dedica_ipran">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($confi as $key => $con)
                                    @if (old('dedica_ipran') == $key)
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
                        <select class="form-control" id="type_ipran" name="type_ipran">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Bifilar">Bifilar</option>
                            <option value="Unifilar">Unifilar</option>
                                     
                        </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_ipran_vlan_ls">
                            <label>Vlan Gesti&oacute;n LS*</label>
                            <input type="hidden" id="ipran_vlan_ls_arr" name="ipran_vlan_ls_arr" onchange="" value="">
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="ipran_vlan_ls" name="ipran_vlan_ls">
                                </select>
                                <a class="ico_input btn btn-info" id="next_ipran_vlan_ls" onclick="next_vlan(3);"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_ipran_vlan_radio">
                            <label>Vlan Gesti&oacute;n Radio</label>
                            <input type="hidden" id="ipran_vlan_radio_arr" name="ipran_vlan_radio_arr" value="">
                            <div class="bw_all">
                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="ipran_vlan_radio" name="ipran_vlan_radio">
                                </select>
                                <a class="ico_input btn btn-info" id="next_ipran_vlan_radio" onclick="next_vlan(4);"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_ipran_ip_ls">
                            <label>IP Gesti&oacute;n LS*</label> 
                            <div class="bw_all" id="bw_all" > 
                                <input type="hidden" id="ipran_ip_ls_id">
                                <input type="text" disabled placeholder="000.000.000.000" id="ipran_ip_ls" name="ipran_ip_ls" class="form-control" value="{{old('ipran_ip_ls')}}">
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(2,11);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group" id="div_ipran_ip_radio">
                            <label>IP Gesti&oacute;n Radio</label> 
                            <div class="bw_all" id="bw_all" > 
                                <input type="hidden" id="ipran_ip_radio_id">
                                <input type="text" disabled placeholder="000.000.000.000" id="ipran_ip_radio" name="ipran_ip_radio" class="form-control" value="{{old('ipran_ip_radio')}}">
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(2,12);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                            </div>
                        </div> 
                    </div>
                    <!--
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label>Vlan* </label> 
                            <a id="port_mas" data-toggle="modal" data-target="#new_vlan_anillo_alta" onclick="vlan_anillo_selec(1);" ><i class="fa fa-plus" title="Agregar Vlan"> </i> Agregar Vlan</a>
                            <div id="campos_vlan_ring_ipran">
                            </div>
                        </div>                    
                    </div>
                    -->
                    <div class="form-group col-lg-12">
                        <label>Puertos* </label> 
                        <a id="port_mas" data-toggle="modal" data-target="#new_port_ring_ipran" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar y/o Quitar Puerto</a>
                        <div id="campos_port_ipran">
                                    
                        </div>
                    </div>
                    <div class="form-group col-lg-12">
                        <label>Comentarios</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commen_ring_ipran" maxlength="100" name="commen_ring_ipran"class="form-control" value="{{old('commen_ring_ipran')}}">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button type="button" class="btn " data-dismiss="modal" id="ring_ipran_exi"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                        <button class="btn btn-primary" type="button" id="ring_ipran_new"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
