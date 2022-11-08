<div class="modal inmodal fade" id="popasignar_recurso" role="dialog"  aria-hidden="true" style="overflow-y: auto; max-height: 1000px;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_ser" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_recurso"></h4> 
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <input type="hidden" name="serv_id_inp" id="serv_id_inp">
                    <input type="hidden" name="serv_type_inp" id="serv_type_inp">
                    <input type="hidden" name="agg_type_inp" id="agg_type_inp">
                    <input type="hidden" name="agg_id_inp" id="agg_id_inp">
                    <input type="hidden" name="ring_id_inp" id="ring_id_inp">
                    <input type="hidden" name="grupo_puerto" id="grupo_puerto">
                    <input type="hidden" name="ip_admin_servi_id" id="ip_admin_servi_id">
                    <input type="hidden" name="ip_rank_servi_id" id="ip_rank_servi_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo de equipo*</label>
                                <select class="form-control" id="type_equip_sel" name="type_equip_sel">
                                    <option selected disabled value="0">seleccionar</option>
                                    @foreach($functi as $functi)
                                        <option value="{{ $functi->id }}">{{$functi->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Equipo*</label>
                                <div class="bw_all" id="bw_all" > 
                                    <select class="form-control equip hide-arrow-select" id="equip_sel" name="equip_sel" disabled="true">
                                        <option selected disabled value="">seleccionar</option>
                                    </select>
                                    <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_all" title="Buscar Equipo" id="equip_btn" name="equip_btn" onclick="list_equipmen_servi($('#type_equip_sel :selected').text(), 1)">
                                        <i class="fa fa-search"> </i> Buscar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Anillo*</label>
                                <input type="text" placeholder="" id="ring_name_inp" name="ring_name_inp" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Agregador*</label>
                                <input type="text" placeholder="" id="agg_acr_inp" name="agg_acr_inp" class="form-control" disabled="true">
                            </div>
                        </div>
                    </div>                    

                    <div id="form1">
                        <div class="row" id="ds_mh_div">
                            <br>
                            <div class="col-sm-6" id="mh_col">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="mh_check_1" onchange="mh_switch_1()">
                                    <label class="custom-control-label" for="mh_check">Multihome</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="ds_check_1" onchange="ds_switch_1()">
                                    <label class="custom-control-label" for="ds_check">Dual stack (IPv4 + IPv6)</label>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Frontera</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Capacidad</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ocupaci&oacute;n</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Puertos*</label> <br>
                                            <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(2,1)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div id="campos_port_1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="ip_wan_div_1">
                                            <label>IP WAN Internet</label>
                                            <div class="bw_all" id="bw_all">
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi" name="ip_admin_servi"class="form-control" value="{{old('ip_admin_servi')}}">
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_wan(2);" data-toggle="modal" data-target="#ip_admin_sele_lans" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>

                                        <div class="form-group" id="subred_30_div_1" style="display: none">
                                            <label>Subred /30</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="ctag_row_1" style="display: none">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ctag (DS)</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>VLAN Metro-tag</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pei_h_div">
                                            <label>PEI Home</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pei_mh_div" style="display: none">
                                            <label>PEI Multihome</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pei_h_int_div">
                                            <label>Interface PEI Home</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pei_mh_int_div" style="display: none">
                                            <label>Interface PEI Multihome</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pei_h_subint_div">
                                            <label>Subinterface PEI Home</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pei_mh_subint_div" style="display: none">
                                            <label>Subinterface PEI Multihome</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Rango IP P&uacute;blico</label>
                                            <div class="bw_all" id="bw_all"> 
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_rank" name="ip_admin_rank"class="form-control" value="{{old('ip_admin_rank')}}">
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div id="form2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>VLAN Metro-tag</label>
                                    <input type="text" id="" disabled="true" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <br>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="ds_check_2" onchange="ds_switch_2()">
                                    <label class="custom-control-label" for="ds_check">Dual stack (IPv4 + IPv6)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" id="ip_wan_div_2">
                                    <label>IP WAN Internet</label>
                                    <div class="bw_all" id="bw_all">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi" name="ip_admin_servi" class="form-control" value="{{old('ip_admin_servi')}}">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,0);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                                <div class="form-group" id="subred_30_div_2" style="display: none">
                                    <label>Subred /30</label>
                                    <input type="text" id="" disabled="true" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Rango IP P&uacute;blico</label>
                                    <div class="bw_all" id="bw_all">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_rank" name="ip_admin_rank"class="form-control" value="{{old('ip_admin_rank')}}">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Puertos*</label> <br>
                                    <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(2,2)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div id="campos_port_2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form3" style="display: none">
                        <div class="row" id="ds_mh_div">
                            <br>
                            <div class="col-sm-6" id="mh_col">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="mh_check_3" onchange="mh_switch_3()">
                                    <label class="custom-control-label" for="mh_check">Multihome</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="ds_check_3" onchange="ds_switch_3()">
                                    <label class="custom-control-label" for="ds_check">Dual stack (IPv4 + IPv6)</label>
                                </div>
                            </div>
                            <br>
                            <br>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Frontera</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Capacidad</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ocupaci&oacute;n</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Puertos*</label> <br>
                                            <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(2,3)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div id="campos_port_3">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="ip_wan_div_3">
                                            <label>IP WAN Internet</label>
                                            <div class="bw_all" id="bw_all">
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi" name="ip_admin_servi" class="form-control" value="{{old('ip_admin_servi')}}">
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,0);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="subred_30_div_3" style="display: none">
                                            <label>Subred /30</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="ctag_row_3" style="display: none">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ctag (DS)</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>VLAN Metro-tag</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pe_h_div">
                                            <label>PE Home</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pe_mh_div" style="display: none">
                                            <label>PE Multihome</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pe_h_int_div">
                                            <label>Interface PE Home</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pe_mh_int_div" style="display: none">
                                            <label>Interface PE Multihome</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pe_h_subint_div">
                                            <label>Subinterface PE Home</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pe_mh_subint_div" style="display: none">
                                            <label>Subinterface PE Multihome</label>
                                            <input type="text" id="" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Rango IP P&uacute;blico</label>
                                            <div class="bw_all" id="bw_all">
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_rank" name="ip_admin_rank" class="form-control" value="{{old('ip_admin_rank')}}">
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div id="form4" style="display: none">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>VLAN Metro-tag</label>
                                    <input type="text" id="" disabled="true" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <br>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="ds_check_4" onchange="ds_switch_4()">
                                    <label class="custom-control-label" for="ds_check">Dual stack (IPv4 + IPv6)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" id="ip_wan_div_4">
                                    <label>IP WAN Internet</label>
                                    <div class="bw_all" id="bw_all"> 
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi" name="ip_admin_servi"class="form-control" value="{{old('ip_admin_servi')}}">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,0);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                                <div class="form-group" id="subred_30_div_4" style="display: none">
                                    <label>Subred /30</label>
                                    <input type="text" id="" disabled="true" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Rango IP P&uacute;blico</label>
                                    <div class="bw_all" id="bw_all">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_rank" name="ip_admin_rank"class="form-control" value="{{old('ip_admin_rank')}}">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Puertos*</label> <br>
                                    <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(2,4)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div id="campos_port_4">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form5" style="display: none">
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Puertos*</label> <br>
                                    <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(2,5)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Vlan*</label>
                                    <input type="text" class="form-control" placeholder="" id="" name="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div id="campos_port_5">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group" id="ip_wan_div_4">
                                    <label>IP WAN Internet</label>
                                    <div class="bw_all" id="bw_all"> 
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_servi" name="ip_admin_servi"class="form-control" value="{{old('ip_admin_servi')}}">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,0);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Rango IP PÚBLICO</label> 
                                    <div class="bw_all" id="bw_all" > 
                                        <input  type="hidden" id="ip_rank_servi_id">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_admin_rank" name="ip_admin_rank"class="form-control" value="{{old('ip_admin_rank')}}">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn" data-dismiss="modal">
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