<div class="modal inmodal fade pop_equi_general overflow-modal" id="crear_lanswitch_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_ls_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_lanswitch"></h4> 
            </div>
            <form role="form" method="POST" id="alta_lanswitch">
                {{ csrf_field() }}
                <input type="hidden" name="id_equipos" id="id_equipos" value="0">
                <input type="hidden" name="id_function" id="id_function" value="4">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label>Anillo*</label>
                        <div class="bw_all" id="bw_all" > 
                            <input type="text" disabled="true" placeholder="Anillo" id="anilo_name" name="anilo_name"class="form-control" value="{{old('anilo_name')}}">
                            <input type="hidden" name="anilo_id" id="anilo_id">
                            <a class="ico_input btn btn-info" id="bus_anillo" data-toggle="modal" data-target="#buscar_anillo" onclick="list_ring_metro_all();"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                            <a class="ico_input btn btn-info" id="mas_anillo" onclick="crear_new_anillo();" data-toggle="modal" data-target="#popcrear_anillo" title="Nuevo Anillo"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>            
                <div class="col-sm-5">
                    <div class="form-group">
                        <label>IP de Gestión*</label> 
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" id="ip_admin" name="ip_admin" disabled="true">
                                <option selected disabled value="">seleccionar</option>      
                            </select>
                            <a class="ico_input btn btn-info" onclick="buscar_ip_lanswitch(2);" data-toggle="modal" data-target="#ip_admin_sele_lans" title="Buscar IP"><i class="fa fa-search"> </i> Buscar</a>
                            @if(Auth::user()->id_profile == 2)
                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,4);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP"><i class="fa fa-search"> </i> Buscar</a>
                            @endif
                        </div>
                    </div>
                </div>
<!--                 <div id="equi_all_lanswitch">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Equipo de Conexión 1*</label> 
                            <select class="form-control" onchange="equipment_lanswitch();" id="equi_con_1" name="equi_con_1">
                                    <option selected disabled value="">seleccionar</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6" id="equip_2_mostar">
                        <div class="form-group">
                            <label>Equipo de Conexión 2*</label> 
                            <select class="form-control" id="equi_con_2" name="equi_con_2">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                        </div>
                    </div>
                </div> -->
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>N° Enlace*</label> 
                        <input type="text" placeholder="Enlace" onkeypress="return esNumero(event);" autocomplete="off" id="enlace" name="enlace"class="form-control" value="{{old('enlace')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Orden o IR Alta*</label> 
                        <input type="text" placeholder="Orden o IR Alta" onkeypress="return Number_letra(event);" autocomplete="off" id="orden" name="orden"class="form-control" value="{{old('orden')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" id="max2">
                        <label>Sitio Cliente*</label>
                        <select class="form-control" onchange="sitio_web();" id="sitio" name="sitio">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="form-group">
                        <label>Cliente*</label>
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select " disabled="true" onchange="acronimo_lanswitch();" id="client" name="client">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" id="bus_client" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search" title="Buscar Cliente" > </i> Buscar</a>
                            <a onclick="create_client();" class="ico_input btn btn-info" id="new_clit" data-toggle="modal" data-target="#popcrear"><i class="fa fa-plus" title="Nuevo Cliente" ></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Acrónimo*</label> 
                        <input type="text" placeholder="Acrónimo" autocomplete="off" id="acro" name="acro"class="form-control" value="{{old('acro')}}" maxlength="20">
                        <p class="mensajeInput" id="aconimo_lanswitch_msj"></p>
                    </div>
                </div>
                <div class="col-sm-12" id="nodo_all" style="display: none;" >
                    <div class="form-group">
                        <label>Nodo*</label>
                        <div class="bw_all" id="bw_all" >  
                            <select class="form-control hide-arrow-select" id="nodo_al" name="nodo_al" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                                     
                            </select>
                            <a onclick="node_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar Nodo"><i class="fa fa-search"  > </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" id="direc_all" style="display: none;">
                    <div class="form-group">
                        <label>Dirección*</label> 
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" id="direc" name="direc" disabled="true">
                                <option selected disabled value="">seleccionar</option>      
                            </select>
                            <a class="ico_input btn btn-info" onclick="detal_addres(1);" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Localización</label>
                        <div class="bw_all" id="bw_all" > 
                            <input type="text" placeholder="Localización" autocomplete="off" id="local_equipmen" name="local_equipmen"class="form-control" value="{{old('local_equipmen')}}" maxlength="50" disabled="true">
                        
                            <a class="ico_input btn btn-info" onclick="localizacion();" data-toggle="modal" data-target="#new_localización_alta"  title="Buscar Localización"><i class="fa fa-plus"> </i> Localización</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Modelo*</label>
                        <div class="bw_all" id="bw_all" >
                            <select onchange="EquipmentBoard();" disabled="true" class="form-control hide-arrow-select" id="equi_alta" name="equi_alta">
                                <option selected disabled value="">Seleccionar en el buscador</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_all" title="Buscar equipo" id="boton_buscar_equipo_all"><i class="fa fa-search"  > </i> Buscar</a>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#img_equip" title="Buscar imagen" id="img_alta_equipo" style="display: none;" onclick="img_equip_alta();"><i class="far fa-image"> </i> IMG</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" style="display: none;" id="all_board">
                    <div class="form-group">
                        <label>Placa* </label> 
                        <a style="display: none;" id="agregador" data-toggle="modal" data-target="#new_placa_alta" onclick="Agregarplaca();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar Placa</a>
                        <div id="campos">
                                    
                        </div>
                    </div>
                </div> 
                <div class="col-sm-12" id="port_lanswitch_list">
                    <div class="form-group">
                        <label>Puertos de Anillo*  </label> 
                        <a id="port_mas" data-toggle="modal" data-target="#new_placa_lans_alta" onclick="port_lanswitch_selec();" ><i class="fa fa-plus" title="Agregar Puertos"> </i> Agregar y/o Quitar Puerto</a>
                        <div id="campos_port_all">
                                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Comentario</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commentary" name="commentary"class="form-control" maxlength="255" value="{{old('commentary')}}">
                    </div>
                </div>                 
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="baja_ls_pop" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_ls_pop" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
