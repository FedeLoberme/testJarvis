<div class="modal inmodal fade pop_equi_general" id="crear_cpe_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_cpe_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_cpe"></h4>
            </div>
            <form role="form" method="POST" id="alta_cpe">
                {{ csrf_field() }}
                <input type="hidden" name="id_equipos" id="id_equipos" value="0">
                <input type="hidden" name="id_function" id="id_function" value="2">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Cliente*</label>
                        <div class="bw_all" id="bw_all">
                            <select class="form-control hide-arrow-select" onchange="aconimo_cpe();" id="client" name="client" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search" title="Buscar Cliente" > </i> Buscar</a>

                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#popcrear"><i class="fa fa-plus" title="Nuevo Cliente" ></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group" id="max2">
                        <label>RPV*</label>
                        <select class="form-control" onchange="RPV_web();" id="rpv" name="rpv">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
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
                <div class="col-sm-4">
                    <div class="form-group" id="max2">
                        <label>Gesti??n Cliente*</label>
                        <select class="form-control" id="management" name="management">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Acronimo*</label>
                        <input onkeypress="return Number_letra(event);" style="text-transform: uppercase;" type="text" placeholder="Acronimo" autocomplete="off" id="acro" name="acro"class="form-control" value="{{old('acro')}}" maxlength="11">
                        <p class="mensajeInput" id="aconimo_cpe_msj"></p>
                    </div>
                </div>
                <div class="col-sm-4">
                     <div class="form-group">
                        <label>IR OS ALTA*</label>
                        <input onkeypress="return Number_letra(event);" style="text-transform: capitalize;" type="text" placeholder="ALTA" maxlength="10" autocomplete="off" id="ir_alta" name="ir_alta"class="form-control" value="{{old('ir_alta')}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>N?? Enlace*</label>
                        <input type="text" placeholder="Enlace" onkeypress="return esNumero(event);" autocomplete="off" id="enlace" name="enlace"class="form-control" value="{{old('enlace')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-4" id="ip_rpv_all" style="display: none;">
                    <div class="form-group">
                        <label>IP WAN RPV*</label>
                        <input onkeypress="return val_ip(event);" type="text" placeholder="000.000.000.000" maxlength="15" autocomplete="off" id="ip_wan" name="ip_wan"class="form-control">
                    </div>
                </div>
                <div class="col-sm-4" id="ip_all" style="display: none;">
                    <div class="form-group">
                        <label>IP WAN*</label>
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" id="ip_admin" name="ip_admin" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info "onclick="buscar_ip_admin(1);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8" id="nodo_all" style="display: none;" >
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
                <div class="col-sm-8" id="direc_all" style="display: none;">
                    <div class="form-group">
                        <label>Direcci??n*</label>
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control hide-arrow-select" id="direc" name="direc" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" onclick="detal_addres(1);" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Direcci??n" > </i> Buscar</a>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Direcci??n"> <i class="fa fa-plus"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Localizaci??n</label>
                        <div class="bw_all" id="bw_all" >
                            <input type="text" placeholder="Localizaci??n" autocomplete="off" id="local_equipmen" name="local_equipmen"class="form-control" value="{{old('local_equipmen')}}" maxlength="50" readonly>

                            <a class="ico_input btn btn-info" onclick="localizacion();" data-toggle="modal" data-target="#new_localizaci??n_alta"  title="Buscar Localizaci??n"><i class="fa fa-plus"> </i> Localizaci??n</a>
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
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Comentario</label>
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commentary" name="commentary"class="form-control" maxlength="255" value="{{old('commentary')}}">
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="baja_cpe_pop" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_cpe_pop" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
