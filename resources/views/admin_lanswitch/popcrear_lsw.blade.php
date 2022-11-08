<div class="modal inmodal fade overflow-modal" id="crear_lsw_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_lsw_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_lsw"></h4> 
            </div>
            <form role="form" method="POST" id="alta_lsw">
                {{ csrf_field() }}           
                
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>N° Enlace*</label> 
                        <input type="text" placeholder="Enlace" onkeypress="return esNumero(event);" autocomplete="off" id="enlace_lsw" name="enlace_lsw"class="form-control" value="{{old('enlace_lsw')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Orden o IR Alta*</label> 
                        <input type="text" placeholder="Orden o IR Alta" onkeypress="return Number_letra(event);" autocomplete="off" id="orden_lsw" name="orden_lsw"class="form-control" value="{{old('orden_lsw')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group" id="max2">
                        <label>Sitio Cliente*</label>
                        <select class="form-control" onchange="sitio_web_lsw();" id="sitio_lsw" name="sitio_lsw">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div id="nodo_all_lsw" style="display: none;">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nodo*</label>
                            <div class="bw_all">  
                                <select class="form-control hide-arrow-select" id="nodo_al_lsw" name="nodo_al_lsw" onchange="link_table_select_lsw_new();" disabled="true">
                                </select>
                                <a onclick="node_table_select_lsw_new();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar Nodo" id="node_button"><i class="fa fa-search"  > </i> Buscar</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" id="link_all_node" style="display: none;">
                        <div class="form-group">
                            <label>UPLINK CELDA IPRAN*</label>
                            <div class="bw_all">  
                                <select class="form-control hide-arrow-select" id="link_all_lsw" name="link_all_lsw" disabled="true" onchange="link_sar_new();">
                                </select>
                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_link_all" id="link_button" title="Buscar Link"><i class="fa fa-search"  > </i> Buscar</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="sar" style="display: none;">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Equipo Sar*</label> 
                            <input type="text" placeholder="Equipo Sar" autocomplete="off" id="equi_sar" name="equi_sar"class="form-control" value="{{old('equi_sar')}}" maxlength="50">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Puerto Sar*</label>
                            <input type="text" placeholder="Puerto Sar" autocomplete="off" id="port_sar" name="port_sar" class="form-control" value="{{old('port_sar')}}" maxlength="50">
                        </div>
                    </div>
                </div>
                <div class="col-sm-7" id="input_id_ring" style="display: none;">
                    <div class="form-group">
                        <label>Anillo*</label>
                        <div class="bw_all"> 
                            <select class="form-control hide-arrow-select" id="id_ring_new" name="id_ring_new" disabled="true" onchange="acronimo_lanswitch_ipran();">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_ring" data-toggle="modal" data-target="#buscar_anillo" onclick="ring_ipran_all();"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                        </div>
                    </div>
                </div> 
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>IP de Gestión*</label> 
                        <div class="bw_all"> 
                            <select class="form-control hide-arrow-select" id="ip_admin_lsw" name="ip_admin_lsw" disabled="true">
                                <option selected disabled value="">seleccionar</option>      
                            </select>
                            <a class="ico_input btn btn-info" onclick="buscar_ip_admin_lsw_new(1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP" id="boton_ip_admin" style="display: none;">
                                <i class="fa fa-search"> </i> Buscar
                            </a>

                            <a class="ico_input btn btn-info" onclick="buscar_ip_lanswitch(10);" data-toggle="modal" data-target="#vlan_ring_ipran" title="Buscar IP" id="boton_ip_ring" style="display: none;">
                                <i class="fa fa-search"> </i> Buscar
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="direc_all_lsw" style="display: none;">
                    <div class="form-group">
                        <label>Dirección*</label> 
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" id="direc_lsw" name="direc_lsw" disabled="true">     
                            </select>
                            <a class="ico_input btn btn-info" onclick="selec_list_addres_lsw_new();" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" id="client_all_lsw" style="display: none;">
                    <div class="form-group">
                        <label>Cliente*</label>
                        <div class="bw_all"> 
                            <select class="form-control hide-arrow-select " disabled="true" onchange="acronimo_lanswitch_ipran();" id="client_lsw" name="client_lsw">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_client" onclick="client_table_select_lsw();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search" title="Buscar Cliente" > </i> Buscar</a>
                            <a onclick="create_client();" class="ico_input btn btn-info" id="new_clit" data-toggle="modal" data-target="#popcrear"><i class="fa fa-plus" title="Nuevo Cliente" ></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Acrónimo*</label> 
                        <input type="text" placeholder="Acrónimo" autocomplete="off" id="acro_lsw" name="acro_lsw"class="form-control" value="{{old('acro_lsw')}}" maxlength="20">
                        <p class="mensajeInput" id="aconimo_lsw_msj"></p>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Localización</label>
                        <div class="bw_all" id="bw_all" > 
                            <input type="text" placeholder="Localización" autocomplete="off" id="local_equipmen_lsw" name="local_equipmen_lsw"class="form-control" value="{{old('local_equipmen_lsw')}}" maxlength="50" disabled="true">
                        
                            <a class="ico_input btn btn-info" onclick="localizacion();" data-toggle="modal" data-target="#new_localización_alta"  title="Buscar Localización"><i class="fa fa-plus"> </i> Localización</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Modelo*</label>
                        <div class="bw_all">
                            <select onchange="EquipmentBoardLSW();" disabled="true" class="form-control hide-arrow-select" id="equi_alta_lsw" name="equi_alta_lsw">
                                <option selected disabled value="">Seleccionar en el buscador</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_all" title="Buscar equipo" id="boton_buscar_equipo_all_lsw" onclick="list_all_equipmen_lsw();"><i class="fa fa-search"  > </i> Buscar</a>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#img_equip" title="Buscar imagen" id="img_alta_equipo_lsw" style="display: none;" onclick="img_equip_alta();"><i class="far fa-image"> </i> IMG</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="display: none;" id="all_board_lsw">
                    <div class="form-group">
                        <label>Placa* </label> 
                        <a style="display: none;" id="new_board_lsw" data-toggle="modal" data-target="#new_placa_alta" onclick="Agregarplaca();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar Placa</a>
                        <div id="campos_lsw">
                                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" id="port_link_list_lsw">
                    <div class="form-group">
                        <label>Puertos de Link* </label> 
                        <a data-toggle="modal" data-target="#new_placa_link_alta" onclick="port_lsw_selec_link();" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto link</a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group" id="port_ring_list_lsw">
                        <label>Puertos* </label> 
                        <a id="port_mas" data-toggle="modal" data-target="#puerto_anillo_ipran_cliente" onclick="port_lanswitch_ipran_cliente();"><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar y/o Quitar Puerto</a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">

                        <div id="campos_port_link_all">
                                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Comentario</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commentary_lsw" name="commentary_lsw"class="form-control" maxlength="255" value="{{old('commentary_lsw')}}">
                    </div>
                </div>  
                <input type="hidden" name="id_lsw_new" id="id_lsw_new">
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="baja_lsw_pop" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_lsw_pop" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
