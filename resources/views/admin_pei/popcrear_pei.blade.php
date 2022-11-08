<div class="modal inmodal fade pop_equi_general overflow-modal" id="crear_pei_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_pei_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_pei"></h4> 
                <input type="hidden" name="id_function" id="id_function" value="6">
            </div>
            <form role="form" method="POST" id="alta_pei">
                {{ csrf_field() }}
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Nodo*</label>
                        <div class="bw_all" id="bw_all" >  
                            <select class="form-control hide-arrow-select" id="nodo_al" name="nodo_al" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                            <a onclick="node_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar nodo"><i class="fa fa-search"  > </i> Buscar</a>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popcrear_nodo" onclick="crear_nodo('10');" title="Agregar Nodo"> <i class="fa fa-plus"> </i></a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label >Ir Alta*</label>  
                        <input onkeypress="return Number_letra(event);" type="text" placeholder="xxxxxx" autocomplete="off" id="alta" name="alta"class="form-control" maxlength="10">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Acronimo*</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Acronimo" maxlength="20" autocomplete="off" id="name" name="name"class="form-control">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>IP de Gestión*</label> 
                        <div class="bw_all" id="bw_all" > 
                            <select class="form-control hide-arrow-select" id="ip_admin" name="ip_admin" disabled="true">
                                <option selected disabled value="">seleccionar</option>      
                            </select>
                            <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,4);" data-toggle="modal" data-target="#ip_admin_sele"><i class="fa fa-search" title="Buscar IP" > </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Localización</label>
                        <div class="bw_all" id="bw_all" > 
                            <input type="text" placeholder="Localización" autocomplete="off" id="local_equipmen" name="local_equipmen"class="form-control" maxlength="50" readonly>
                            <a class="ico_input btn btn-info" onclick="localizacion();" data-toggle="modal" data-target="#new_localización_alta"  title="Buscar Localización"><i class="fa fa-plus"> </i> Localización</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Modelo*</label>
                        <div class="bw_all" id="bw_all" >
                            <select onchange="EquipmentBoard();" disabled="true" class="form-control hide-arrow-select" id="equi_alta" name="equi_alta">
                                <option selected disabled value="">Seleccionar</option>
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_all" title="Buscar equipo" id="boton_buscar_equipo_all"><i class="fa fa-search"> </i> Buscar</a>
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
                        <label>Zona</label>
                        <select class="form-control" id="zone_sel" name="zone_sel">
                            <option selected value="">Seleccionar</option>
                            @foreach ($zones as $z)
                                <option value="{{$z->value}}">{{$z->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Comentario</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" name="commen"class="form-control" maxlength="255" id="commen">
                    </div>
                </div>
                <input type="hidden" name="id_equipos" id="id_equipos" value="0">
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" id="baja_pei_pop" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_pei_pop" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
            </div> 
        </div>
    </div>
</div>
