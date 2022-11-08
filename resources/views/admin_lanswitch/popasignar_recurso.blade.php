<div class="modal inmodal fade" id="popasignar_recurso" role="dialog"  aria-hidden="true" style="overflow-y: auto; max-height: 1000px;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="internet_wan_assign_close" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_recurso"></h4>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <input type="hidden" name="equip_id_inp" id="equip_id_inp">
                    <input type="hidden" name="serv_type_inp" id="serv_type_inp">
                    <input type="hidden" name="serv_bw_inp" id="serv_bw_inp">
                    <input type="hidden" name="agg_type_inp" id="agg_type_inp">
                    <input type="hidden" name="agg_id_inp" id="agg_id_inp">
                    <input type="hidden" name="ring_id_inp" id="ring_id_inp">


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Equipo</label>
                                <input type="text" id="equip_acr_inp" name="equip_acr_inp" disabled="true" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Servicio* <small class="text-navy">Bw Servicio: <span class="bw_service" id="bw_service_label"></span> [Byte]</small></label>
                                <div class="bw_all" id="bw_all" >
                                    <select class="form-control hide-arrow-select" disabled="true" onchange="validar_servi();" id="service_sele" name="service_sele">
                                    </select>
                                    <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select_2();" id="serv_search_btn"><i class="fa fa-search"> </i> Buscar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Anillo</label>
                                <input type="text" placeholder="" id="ring_name_inp" name="ring_name_inp" class="form-control" disabled="true">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label id="agg_label">Agregador</label>
                                <input type="text" placeholder="" id="agg_acr_inp" name="agg_acr_inp" class="form-control" disabled="true">
                            </div>
                        </div>
                    </div>

                    <div id="form1">
                        <input type="hidden" name="grupo_puerto" id="grupo_puerto">
                        <input type="hidden" name="ip_id" id="ip_id">
                        <input type="hidden" name="ip_rank_servi_id" id="ip_rank_servi_id">
                        <input type="hidden" name="wan_subnet_id" id="wan_subnet_id">
                        <input type="hidden" name="vlan_type_inp" id="vlan_type_inp">
                        <input type="hidden" name="frt_id_inp" id="frt_id_inp">
                        <input type="hidden" name="frt_avail_inp" id="frt_avail_inp">
                        <input type="hidden" name="public_subnet_id" id="public_subnet_id">
                        <input type="hidden" name="ds_subnet_id" id="ds_subnet_id">
                        <input type="hidden" name="ctag_arr" id="ctag_arr">
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
                                            <div class="bw_all" id="bw_all">
                                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="frt_name_sel" name="frt_name_sel">
                                                    <option selected disabled value=""></option>
                                                </select>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#frontier_list" title="Seleccionar Frontera"
                                                    onclick="frontier_by_assoc(
                                                        document.getElementById('serv_type_inp').value,
                                                        document.getElementById('serv_bw_inp').value,
                                                        document.getElementById('ring_id_inp').value,
                                                        document.getElementById('agg_id_inp').value,
                                                        document.getElementById('mh_check_1').checked)"
                                                    id="frt_select_btn"><i class="fa fa-search"> </i> Seleccionar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Capacidad</label>
                                            <input type="text" id="frt_cap_inp" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ocupaci&oacute;n</label>
                                            <input type="text" id="frt_occ_inp" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Puertos*</label> <br>
                                            <a class="ico_input btn btn-info" id="" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(1,1)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
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
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_number" name="ip_number" class="form-control">
                                                <a class="ico_input btn btn-info" id="select_ip_wan_btn" name="select_ip_wan_btn" data-toggle="modal" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>
                                        <div class="form-group" id="subred_30_div_1" style="display: none">
                                            <label>Subred /30</label>
                                            <div class="bw_all" id="bw_all">
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="ds_subnet_number" name="ds_subnet_number" class="form-control" value="">
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,153);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="ctag_row_1" style="display: none">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ctag (DS)</label>
                                            <div class="bw_all">
                                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="ctag_name_sel" name="ctag_name_sel">
                                                </select>
                                                <a class="ico_input btn btn-info" id="next_ctag_btn" onclick="next_vlan(7);"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label id="vlan_label">VLAN Metro-tag</label>
                                            <div class="bw_all" id="bw_all">
                                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="vlan_name_sel" name="vlan_name_sel">
                                                    <option selected disabled value=""></option>
                                                </select>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#vlan_list" title="Seleccionar Vlan"
                                                    onclick="vlan_by_frontier(
                                                        document.getElementById('vlan_type_inp').value,
                                                        document.getElementById('equip_id_inp').value,
                                                        document.getElementById('frt_id_inp').value,
                                                        document.getElementById('serv_type_inp').value,
                                                        document.getElementById('mh_check_1').checked)"
                                                    id=""><i class="fa fa-search"> </i> Seleccionar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pei_h_div">
                                            <label>PEI Home</label>
                                            <input type="text" id="pei_h_name_inp" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pei_mh_div" style="display: none">
                                            <label>PEI Multihome</label>
                                            <input type="text" id="pei_mh_name_inp" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pei_h_int_div">
                                            <label>Interface PEI Home</label>
                                            <input type="text" id="pei_h_int_inp" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pei_mh_int_div" style="display: none">
                                            <label>Interface PEI Multihome</label>
                                            <input type="text" id="pei_mh_int_inp" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pei_h_subint_div">
                                            <label>Subinterface PEI Home</label>
                                            <input type="text" id="pei_h_sub_inp" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pei_mh_subint_div" style="display: none">
                                            <label>Subinterface PEI Multihome</label>
                                            <input type="text" id="pei_mh_sub_inp" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Rango IP P&uacute;blico</label>
                                            <div class="bw_all" id="bw_all">
                                                <input type="text" disabled="true" placeholder="000.000.000.000" id="public_subnet_number" name="public_subnet_number" class="form-control" value="{{old('ip_admin_rank')}}">
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,152);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                                <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div id="form2">
                        <input type="hidden" name="mtag_arr" id="mtag_arr">
                        <input type="hidden" name="wan_subnet_id_2" id="wan_subnet_id_2">
                        <input type="hidden" name="ip_id_2" id="ip_id_2">
                        <input type="hidden" name="public_subnet_id_2" id="public_subnet_id_2">
                        <input type="hidden" name="ds_subnet_id_2" id="ds_subnet_id_2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label id="vlan_label_2">VLAN Metro-tag</label>
                                    <div class="bw_all" id="bw_all">
                                        <select class="form-control hide-arrow-select" disabled="true" onchange="" id="vlan_name_sel_2" name="vlan_name_sel_2">
                                            <option selected disabled value=""></option>
                                        </select>
                                        <a class="ico_input btn btn-info" id="next_mtag_btn" onclick="next_vlan_form_2()"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                                    </div>
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
                                    <div class="bw_all">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ip_number_2" name="ip_number_2" class="form-control">
                                        <a class="ico_input btn btn-info" id="select_ip_wan_btn_2" name="select_ip_wan_btn_2" data-toggle="modal" title="Buscar IP"><i class="fa fa-search"> </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(1);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                                <div class="form-group" id="subred_30_div_2" style="display: none">
                                    <label>Subred /30</label>
                                    <div class="bw_all" id="bw_all">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="ds_subnet_number_2" name="ds_subnet_number_2" class="form-control" value="">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,156);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Rango IP P&uacute;blico</label>
                                    <div class="bw_all" id="bw_all">
                                        <input type="text" disabled="true" placeholder="000.000.000.000" id="public_subnet_number_2" name="public_subnet_number_2" class="form-control">
                                        <a class="ico_input btn btn-info" onclick="buscar_ip_admin_all_red(1,155);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP"><i class="fa fa-search"  > </i></a>
                                        <a class="ico_input btn btn-info" onclick="quitar_ip_admin(0);" title="Quitar IP"><i class="fa fa-trash-o"> </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Puertos*</label> <br>
                                    <a class="ico_input btn btn-info" id="" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(1,2)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div id="campos_port_2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="form3" style="display: none">

                        <!--free vlans-->
                        <input type="hidden" name="ctag_arr_rpv" id="ctag_arr_rpv">

                        <input type="hidden" name="frt_id_inp_rpv" id="frt_id_inp_rpv">
                        <input type="hidden" name="vlan_type_inp_rpv" id="vlan_type_inp_rpv">

                        <div class="row" id="ds_mh_div">
                            <br>
                            <div class="col-sm-6" id="mh_col">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="mh_check_3" onchange="mh_switch_3()">
                                    <label class="custom-control-label" for="mh_check">Multihome</label>
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
                                            <div class="bw_all" id="bw_all">
                                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="frt_name_sel_rpv" name="frt_name_sel">
                                                    <option selected disabled value=""></option>
                                                </select>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#frontier_list" title="Seleccionar Frontera"
                                                   onclick="frontier_by_assoc(
                                                        document.getElementById('serv_type_inp').value,
                                                        document.getElementById('serv_bw_inp').value,
                                                        document.getElementById('ring_id_inp').value,
                                                        document.getElementById('agg_id_inp').value,
                                                        document.getElementById('mh_check_1').checked)"
                                                   id="frt_select_btn"><i class="fa fa-search"> </i> Seleccionar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Capacidad</label>
                                            <input type="text" id="frt_cap_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Ocupaci&oacute;n</label>
                                            <input type="text" id="frt_occ_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Puertos*</label> <br>
                                            <a class="ico_input btn btn-info" id="port_mas" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(1,3)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
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



                                <input type="hidden" name="mtag_arr" id="mtag_arr">
                                <input type="hidden" name="wan_subnet_id_2" id="wan_subnet_id_2">
                                <input type="hidden" name="ip_id_2" id="ip_id_2">
                                <input type="hidden" name="public_subnet_id_2" id="public_subnet_id_2">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row" id="ctag_row_3">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Ctag</label>
                                                    <div class="bw_all">
                                                        <select class="form-control hide-arrow-select" disabled="true" onchange="" id="ctag_name_sel_rpv" name="ctag_name_sel_rpv">
                                                        </select>
                                                        <a class="ico_input btn btn-info" id="next_ctag_btn_rpv"><i class="fa fa-plus" title="Proxima VLAN disponible" > </i> Pr&oacute;xima</a>
                                                    </div>
                                                </div>
                                            </div>
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
                                            <label id="vlan_label_rpv">VLAN Metro-tag</label>
                                            <div class="bw_all" id="bw_all">
                                                <select class="form-control hide-arrow-select" disabled="true" onchange="" id="vlan_name_sel_rpv" name="vlan_name_sel">
                                                    <option selected disabled value=""></option>
                                                </select>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#vlan_list" title="Seleccionar Vlan"
                                                   onclick="vlan_by_frontier(
                                                        document.getElementById('vlan_type_inp_rpv').value,
                                                        document.getElementById('equip_id_inp').value,
                                                        document.getElementById('frt_id_inp_rpv').value,
                                                        document.getElementById('serv_type_inp').value,
                                                        document.getElementById('mh_check_3').checked)"
                                                   id=""><i class="fa fa-search"> </i> Seleccionar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pe_h_div">
                                            <label>PE Home</label>
                                            <input type="text" id="pe_h_name_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pe_mh_div" style="display: none">
                                            <label>PE Multihome</label>
                                            <input type="text" id="pe_mh_name_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pe_h_int_div">
                                            <label>Interface PE Home</label>
                                            <input type="text" id="pe_h_int_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pe_mh_int_div" style="display: none">
                                            <label>Interface PE Multihome</label>
                                            <input type="text" id="pe_mh_int_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group" id="pe_h_subint_div">
                                            <label>Subinterface PE Home</label>
                                            <input type="text" id="pe_h_sub_inp_rpv" disabled="true" class="form-control">
                                        </div>
                                        <div class="form-group" id="pe_mh_subint_div" style="display: none">
                                            <label>Subinterface PE Multihome</label>
                                            <input type="text" id="pe_mh_sub_inp_rpv" disabled="true" class="form-control">
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
                                    <label>Puertos*</label> <br>
                                    <a class="ico_input btn btn-info" id="" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="port_selec_servi(1,4)" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>VLAN</label>
                                    <input type="text" id="vlan_inp" class="form-control" placeholder="0000">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div id="campos_port_4">
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
                    <button class="btn btn-primary" type="button" id="int_serv_save_btn">
                        <i class="fa fa-floppy-o"></i>
                            <strong>  Guardar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
