<div class="modal inmodal fade overflow-modal" id="crear_radio_pop" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_radio_all" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;
                    </span><span class="sr-only">Close</span>
                </button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_service">CREAR RADIO</h4> 
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <form class="wizard-big" role="form" method="POST" id="formRadioAll">
                            {{ csrf_field() }}                                    
    {{-------------------------INICIO PRIMER ITEM DEL WIZARD ----------------------}}
                            <h1 >Celda Claro</h1>
                            <fieldset>
                                {{-- <h2> Servicio de Padres</h2> --}}
                                <div class="row">
                                    <div class="col-md-12 rounded" style="border: 2px solid firebrick; width: auto; margin: 30px; border-style: dashed; border-radius: 10px">
                                        <div class="col-md-12" style="padding-top:10px">
                                            <div class=col-md-6>
                                                <div class="form-group col-md-5" style="padding-left:0px" >
                                                    <label style="padding-right:30px">LSW</label>
                                                    <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_lsw" onclick="list_all_equipmen_lsw();"><i class="fa fa-plus" title="Equipo LsW" ></i></a>
                                                                
                                                </div>
                                                <div class="form-group col-md-7" style="padding-left:0px">
                                                    <select class="form-control hide-arrow-select" id="id_lsw" name="id_lsw" disabled="true" onchange="BwRingRadioService();">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class=col-md-6>
                                                <div class="form-group col-md-3" style="padding-left:0px">
                                                    <label for="" style="">Ip Gestion</label>
                                                </div>
                                                <div class="form-group col-md-7" style="padding-left:0px">
                                                    <input type="text" disabled="true" placeholder="IP-Equipo" class="form-control" id="id_ip_lsw"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="padding-top:10px; ">
                                            <div class=col-md-6>
                                                <div class="form-group col-md-3" style="padding-left:0px" >
                                                    <label for="" style="">Puerto LSW DATOS (Nro Servicio)</label>
                                                </div>  
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#equip_port_lsw_radio" title="Asignar Puerto" onclick="equip_port_dato();">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="form-group col-md-7" style="padding-left:0px">
                                                    <select disabled="true" class="form-control hide-arrow-select" id="alta_port_datos" name="alta_port_datos">
                                                        <option selected disabled value="">Seleccionar Puerto</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class=col-md-6>
                                                <div class="form-group col-md-3" style="padding-left:0px">
                                                    <label for="" style="">Puerto LSW Gestion</label>
                                                </div>
                                                <a class="ico_input btn btn-info"  data-toggle="modal" data-target="#equip_port_lsw_radio" title="Asignar Puerto" onclick="equip_port_gestion();">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                                <div class="form-group col-md-7" style="padding-left:0px">
                                                     <select disabled="true" class="form-control hide-arrow-select" id="alta_port_gestion" name="alta_port_gestion">
                                                        <option selected disabled value="">Seleccionar Puerto</option>
                                                    </select> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top:10px">
                                        <div class="form-group col-md-6">
                                            <label>Nodo<span style=color:red;>*</span></label>
                                            <div class="bw_all" id="bw_all" >  
                                                <select class="form-control hide-arrow-select" style="background:white;" id="nodo_al" name="nodo_al" disabled="true" onchange="acro_radio_node();">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                                <a onclick="node_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar nodo"><i class="fa fa-search"  > </i> Buscar</a>
                                                <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popcrear_nodo" onclick="crear_nodo('10');" title="Agregar Nodo"> <i class="fa fa-plus"> </i></a>
                                            </div>
                                            <div>
                                                <label id="posee_radio">Radio existente</label>
                                                <input type="checkbox" class="checkbox_radio" name="checkbox_radio" id="checkbox_radio" onclick="hideSelect()">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <div id="radio_select" class="radio_select" style="display:none">
        {{-- Esto depende del nodo; si ees que tiene radio eel nodo, se activaria esto y te desplegaria el menu del --}}
                                                <label for="">Seleccionar Radio</label>
                                                <div class="bw_all" >
                                                    <select disabled="true" class="form-control hide-arrow-select" id="alta_radio" name="alta_radio">
                                                        <option selected disabled value="">Seleccionar</option>
                                                    </select>
                                                    <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_lsw" title="Buscar Radio" onclick="search_radio_node();"><i class="fa fa-search"  > </i> Buscar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <label for="">Modelo de Radio</label>
                                            <div class="bw_all">
                                                <select disabled="true" class="form-control hide-arrow-select" id="equi_alta" onchange="EquipmentBoardRadio();" name="equi_alta">
                                                    <option selected disabled value="">Seleccionar en el buscador</option>
                                                </select>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_equipo_all" title="Buscar equipo" id="boton_buscar_equipo_all"><i class="fa fa-search"  > </i> Buscar</a>
                                            </div>
                                            {{--<div class="form-group">
                                                <select data-placeholder="Choose a Country..." class="form-control chosen-select">
                                                    <option value="">Select</option>
                                                    <option value="United States">United States</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                </select>--
                                            </div>--}}
                                        </div>
                                        {{-- <div class="col-md-1"> <span></span></div> --}}
                                        <div class="col-md-4">
                                            <label>Acronimo</label>
                                            <input id="acro_radio" name="acro_radio" type="text" disabled class="form-control " placeholder="Autogenerado"> 
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-top:10px;">
                                        <div class="col-md-6">
                                            <label for="">IP de Gestión</label>
                                            <div class="bw_all"> 
                                                <select class="form-control hide-arrow-select" id="ip_admin" name="ip_admin" disabled="true">
                                                    <option selected disabled value="">seleccionar</option>      
                                                </select>
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP" id="boton_buscar_ip"><i class="fa fa-search"> </i> Buscar</a>
                                            </div>
                                        </div>
                                        <div class="col-md-2"> <span></span></div>
                                        <div class="col-md-6" id="input_ip_loopback">
                                            <label for="">IP LoopBack</label>
                                            <div class="bw_all"> 
                                                <select class="form-control hide-arrow-select" id="ip_admin_loopback" name="ip_admin_loopback" disabled="true">
                                                    <option selected disabled value="">seleccionar</option>      
                                                </select>
                                                <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,5);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP" id="boton_buscar_LoopBack"><i class="fa fa-search"> </i> Buscar</a>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="ne_id_input" style="display:none">
                                            <label>NE-ID</label>
                                            <input id="neid" name="neid" type="text" class="form-control " placeholder="NE-ID"> 
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="padding-bottom:10px; padding-top:10px">
                                        
                                        <div class="col-md-6">
                                            <label>Frecuencia (ODU)</label>
                                            <div class="bw_all">
                                                <select class="form-control" id="frecuencia_odu" name="frecuencia_odu">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> <span></span>
                                            <label>Tamaño de Antena </label>
                                            <div class="bw_all" id="bw_all" >
                                                <select class="form-control" id="tamano_antena" name="tamano_antena">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="col-md-12" style="padding-top:10px; ">
                                        <div class=col-md-6>
                                            <div class="form-group col-md-5" style="padding-left:0px" >
                                                <label for="" style="padding-right: 5px;">Puerto IF</label>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#new_port_lsw_radio" onclick="BoardPortIfRadio();" title="Asignar Puerto"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="form-group col-md-7" style="padding-left:0px">
                                                <select class="form-control hide-arrow-select" id="port_radio_if" name="port_radio_if" disabled="true">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class=col-md-6>
                                            <div class="form-group col-md-5" style="padding-left:0px" >
                                                <label for="" style="padding-right: 5px;">Puerto UPLink</label>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#new_port_lsw_radio" onclick="BoardPortRadio();" title="Asignar Puerto"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="form-group col-md-7" style="padding-left:0px">
                                                <select class="form-control hide-arrow-select" id="port_radio" name="port_radio" disabled="true">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
    {{-------------------------INICIO SEGUNDO ITEM DEL WIZARD ----------------------}}
                        <h1>Radio del Cliente</h1>
                        <fieldset>
                            {{-- <h2>Caracteristicas del servicio</h2> --}}
                            <div class="row">
                                <div class="col-md-12" style="padding-top:10px">
                                    <div class="form-group col-md-6 " >
                                        <label>Servicio*</label>
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="servicio_radio" name="servicio_radio" disabled="true" onchange="BwRingRadioService();">
                                                <option disabled selected value="">seleccionar</option>
                                            </select>
                                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select_radio();"><i class="fa fa-search"> </i> Buscar</a>
                                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#crear_servicio_pop" onclick="alta_servicio_crear();" title="Nuevo Servicio"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Nro Orden<span style=color:red;>*</span></label>
                                        <input id="orden_radio" name="orden_radio" type="text" class="form-control" placeholder="Nro OS" onkeypress="return esNumero(event);" autocomplete="off"  value="{{old('orden_radio')}}" maxlength="20">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label>Cliente<span style=color:red;>*</span></label>
                                        <div class="bw_all"> 
                                            <select class="form-control hide-arrow-select" disabled="true" id="client_sub_red" name="client_sub_red" onchange="acro_radio_client();">
                                                <option selected disabled value="">seleccionar</option>
                                            </select>
                                            <a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"> </i>Buscar </a>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Dirección*</label> 
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="id_address" name="id_address" disabled="true">
                                                <option selected disabled value="">seleccionar</option>     
                                            </select>
                                            <a class="ico_input btn btn-info "onclick="detal_addres_radio();" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                                        </div>
                                    </div>
                                </div>
                                            
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label>Modelo de Radio<span style=color:red;>*</span></label>
                                        <div class="bw_all"> 
                                            <select class="form-control hide-arrow-select" disabled="true" id="id_modelo_radio" name="id_modelo_radio" onchange="acro_radio_client();">
                                                <option selected disabled value="">Seleccionar modelo</option>
                                            </select>
                                        </div>
                                    </div>
                                                
                                    <div class="form-group col-md-6">
                                        <label>Acrónimo</label>
                                        <input id="radio_acro_2" name="radio_acro_2" type="text" class="form-control " placeholder="Acrónimo" autocomplete="off"  value="{{old('radio_acro_2')}}" maxlength="20">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group col-md-6" id="input_ne_id">
                                        <label>NE-ID<span style=color:red;>*</span></label>
                                        <input id="ne_id_radio2" name="ne_id_radio2" type="text" class="form-control" placeholder="NE-ID" autocomplete="off" value="{{old('ne_ip_radio2')}}" maxlength="20">
                                    </div>
                                                
                                    <div class="form-group col-md-6" id="input_loopback_ip">
                                        <label>IP LoopBack<span style=color:red;>*</span></label>
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="loopback_ip_admin" name="loopback_ip_admin" disabled="true">
                                                <option selected disabled value="">seleccionar</option>     
                                            </select>
                                            <a class="ico_input btn btn-info" onclick="buscar_ip_admin(1,6);" data-toggle="modal" data-target="#ip_admin_sele" title="Buscar IP en Admin IP"><i class="fa fa-search"> </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 ">
                                    <div class="col-md-6 offset-md-1">
                                        <label>Frecuencia<span style=color:red;>*</span></label>
                                        <div class="bw_all"> 
                                            <select class="form-control" id="id_frecuencia_radio" name="id_frecuencia_radio">
                                                <option selected disabled value="">Seleccionar </option>
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="col-md-6 offset-md-1">
                                        <label>Tamaño de Antena<span style=color:red;>*</span></label>
                                        <div class="bw_all"> 
                                            <select class="form-control" id="id_tamano_antena" name="id_tamano_antena">
                                                <option selected disabled value="">Seleccionar </option>
                                            </select>
                                        </div>
                                    </div>       
                                </div>

                                <div class="col-md-12" style="padding-bottom:10px; padding-top:20px">
                                    <div class=col-md-6>
                                        <div class="form-group col-md-5" style="padding-left:0px" >
                                                <label for="" style="padding-right: 5px;">Puerto IF</label>
                                                <a class="ico_input btn btn-info" data-toggle="modal" data-target="#new_port_lsw_radio" onclick="BoardPortIfRadio2();" title="Asignar Puerto"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="form-group col-md-7" style="padding-left:0px">
                                                <select class="form-control hide-arrow-select" id="port_radio2_if" name="port_radio2_if" disabled="true">
                                                    <option selected disabled value="">seleccionar</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class=col-md-6>
                                        <div class="form-group col-md-5" style="padding-left:0px" >
                                            <label for="" style="padding-right: 10px;">Puerto</label>
                                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#new_port_lsw_radio" onclick="BoardPortRadioNew();" title="Asignar Puerto"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="form-group col-md-7" style="padding-left:0px">
                                            <select class="form-control hide-arrow-select" id="new_port_radio" name="new_port_radio" disabled="true">
                                                <option selected disabled value="">seleccionar</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>       
                            </div>
                        </fieldset>
    {{-------------------------INICIO TERCER ITEM DEL WIZARD ----------------------}}
                        <h1>Confirmar</h1>
                        <fieldset>
                            <h2>Resumen nuevo Radio</h2>
                            <div id="showFormValues">
                                {{-- Escribe por wizard.js valores --}}
                                <div class="row">
                                    <div class="col-md-12" style="padding-top:10px; display:flex; align-items:center;">
                                        <div class="col-md-4">
                                            <table class="table table-striped table-bordered" style="border: solid 2.5px black">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Celda:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexCelda"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Acronimo:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexAcro1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Modelo Radio:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexModelo1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Puerto IF:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexPuertoIF1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>IP Gestión:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexIPGestion"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>IP Loopback:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexIPLoopback1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>NE-ID:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexNEID1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Puerto UPLink:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexPuertoUPLink1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Acrónimo del LSW:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexAcronimoLSW"></span>
                                                        </td>
                                                    </tr>
                                                </thead> 
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Puerto LSW Datos:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexPuertoDatos"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Puerto LSW-RBS</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexPuertoLSW"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                        <div class="col-md-4">
                                            <table class="table table-striped table-bordered" style="border: solid 2.5px black">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <strong>Radio enlace:</strong>
                                                         </th>
                                                        <td>
                                                            <span id="TexAcroEnlace"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <strong>Frecuencia 1:</strong>
                                                         </th>
                                                        <td>
                                                            <span id="TexFrecuencia1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="col">
                                                            <strong>Tamaño de Antena 1:</strong>
                                                         </th>
                                                        <td>
                                                            <span id="TexAntena1"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Frecuencia 2:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexFrecuencia2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Tamaño de Antena 2:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexAntena2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                            
                                        <div class="col-md-4">
                                            <table class="table table-striped table-bordered" style="border: solid 2.5px black">
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Cliente:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexCliente"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Servicio:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexServicio"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Nro Orden:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexOrden"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Dirección:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexAddress"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Acronimo:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexAcronimo2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Modelo Radio:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexModelo2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Puerto IF:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexPuertoIF2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>IP Loopback:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexIPLoopback2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>NE-ID</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexNEID2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                                <thead>
                                                    <tr>
                                                        <th scope="row">
                                                            <strong>Puerto Servico:</strong>
                                                        </th>
                                                        <td>
                                                            <span id="TexPuertoUPLink2"></span>
                                                        </td>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <input type="hidden" name="id_equipos" id="id_equipos" value="0">
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                 <div class="col-sm-12">
                    <button type="button" id="cancelar_radio" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="guardar_radio" disabled="true" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>  
            </div>
        </div>
    </div>
</div>

