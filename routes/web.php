<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Jarvis\Reserve;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/', 'UsersController@authori_login');

Auth::routes();

Route::get('/home', 'HomeController@index');


Route::get('ver/perfil', 'ControllerProfile@index');
Route::post('crear/perfil', 'ControllerProfile@create');
Route::get('eliminar/perfile/{id}', 'ControllerProfile@delate');
Route::post('buscar/perfil', 'ControllerProfile@search_perfil');
Route::post('registrar/perfil', 'ControllerProfile@insert_update_porfil');



// --------------------------Usuarios--------------------------------------
Route::get('ver/usuario', 'UsersController@index');
Route::post('desactivar/usuario', 'UsersController@deactivate');
Route::post('activar/usuario', 'UsersController@activate');
Route::get('modificar/perfil/{id}', 'UsersController@profile');
Route::post('editar/perfil', 'UsersController@update_profile');
Route::get('historial/usuario', 'ControllerUser_history@index');
Route::post('cerrar/usuario', 'UsersController@fin_login');
Route::post('consul/usuario', 'UsersController@consul');
Route::post('permiso/usuario', 'UsersController@authori_ajax');
Route::get('listar/historial', 'ControllerUser_history@index_list');
Route::get('lista/usuario', 'UsersController@index_list');



// --------------------------Cliente--------------------------------------
Route::get('ver/cliente', 'ControllerClient@index');
Route::get('crear/cliente', 'ControllerClient@create');
Route::post('registrar/cliente', 'ControllerClient@store');
Route::post('modificar/cliente', 'ControllerClient@client');
Route::post('editar/cliente', 'ControllerClient@update_client');
Route::post('buscar/acronimo', 'ControllerClient@client_acronimo');
Route::post('buscar/cliente', 'ControllerClient@client_name');
Route::post('buscar/cuit', 'ControllerClient@client_cuit');
Route::get('listar/cliente', 'ControllerClient@index_list');
Route::post('agregar/acronimo', 'ControllerClient@acronimo');
Route::post('validar/acronimo', 'ControllerClient@data_client');
Route::post('asignar/cliente', 'ControllerClient@client_selec');

// --------------------------Modelo--------------------------------------
Route::get('ver/inventario', 'ControllerEquipment_Model@index');
Route::post('gestion/equipo', 'ControllerEquipment_Model@all_equipment');
Route::post('detalle/modelo', 'ControllerEquipment_Model@search_model_detal');
Route::post('buscar/modelo', 'ControllerEquipment_Model@search_model');
Route::post('editar/inventario', 'ControllerEquipment_Model@update_inventario');
Route::get('listar/modelo', 'ControllerEquipment_Model@index_list');
Route::post('listar/puerto', 'ControllerPort_Equipment_Model@inf_equip');
Route::post('validar/modelo', 'ControllerEquipment_Model@validation_equipment');
Route::post('imagen/modelo', 'ControllerEquipment_Model@ver_img');
Route::post('funsion/modelo', 'ControllerEquipment_Model@function_model');
Route::post('asignar/modelo', 'ControllerEquipment_Model@model_selec');
Route::post('buscar/odu/antena', 'ControllerPort_Equipment_Model@BoardRadioAll');
Route::post('buscar/puerto/radio', 'ControllerEquipment_Model@PortRadioAll');
Route::post('buscar/puerto/if/radio', 'ControllerEquipment_Model@PortIfRadioAll');

// --------------------------Puerto de Inventario---------------------------
Route::get('ver/puerto', 'ControllerPort_Equipment_Model@index');
Route::get('crear/puerto/{id}', 'ControllerPort_Equipment_Model@crear');
Route::post('buscar/puerto', 'ControllerPort_Equipment_Model@port');
Route::get('listar/placa', 'ControllerPort_Equipment_Model@index_list');
Route::post('tipo/puerto', 'ControllerPort_Equipment_Model@type_board_name');
Route::post('agregar/puerto', 'ControllerPort_Equipment_Model@add_port');
Route::post('asignar/puerto', 'ControllerPort_Equipment_Model@add_port_ONBOARD');
Route::post('registrar/puerto', 'ControllerPort_Equipment_Model@insert_update_placa');
Route::get('listar/puerto/ocupado/{id}', 'ControllerPort_Equipment_Model@list_port_occupied');
Route::get('listar/puerto/libre/{id}', 'ControllerPort_Equipment_Model@list_port_free');
Route::post('relacionar/equipos/puertos', 'ControllerPort@relate_equip_ports');
Route::post('desconectar/equipos/puertos', 'ControllerPort@disconnect_port');

// --------------------relacion de puerto y Inventario-------------------------
Route::post('registar/relacion', 'ControllerRelation_Port_Model@store');
Route::get('desactivar/relacion/{id}','ControllerRelation_Port_Model@deactivate');
Route::get('activar/relacion/{id}', 'ControllerRelation_Port_Model@activate');
Route::post('editar/relacion', 'ControllerRelation_Port_Model@relation_edit');
Route::post('modificar/relacion', 'ControllerRelation_Port_Model@update_relation');
Route::post('etiqueta/relacion', 'ControllerRelation_Port_Model@description_label');

// --------------------------Equipo--------------------------------------
Route::get('ver/equipo', 'ControllerEquipment@index');
Route::get('ver/CPE', 'ControllerEquipment@index_cpe');
Route::get('ver/AGG', 'ControllerEquipment@index_agg');
Route::get('ver/AGG/{modal}', 'ControllerEquipment@index_agg');
Route::get('ver/lanswitch', 'ControllerEquipment@index_lanswitch');
Route::get('ver/PE', 'ControllerEquipment@index_pe');
Route::get('ver/DM', 'ControllerEquipment@index_dm');
Route::get('ver/PEI', 'ControllerEquipment@index_pei');
Route::get('ver/RADIO', 'ControllerEquipment@index_radio');
Route::get('ver/RADIO/ENLACE', 'ControllerEquipment@index_radio_enlace');
Route::get('crear/AGG', 'ControllerEquipment@create_agg');
Route::get('crear/equipo', 'ControllerEquipment@create');
Route::post('buscar/equipo', 'ControllerEquipment@search_equip');
Route::post('registrar/agregador', 'ControllerEquipment@store_update_agg');
Route::post('registrar/lanswitch/ipran', 'ControllerEquipment@store_update_lsw');
Route::post('registrar/cpe', 'ControllerEquipment@store_update_cpe');
Route::post('registrar/lanswitch', 'ControllerEquipment@store_update_lanswitch');
Route::get('listar/equipo/{function}', 'ControllerEquipment@index_list');
Route::get('listar/todo/equipo/{function}', 'ControllerEquipment@index_list');
Route::post('buscar/ip/lanswitch', 'ControllerIP@buscar_ip_admin_lanswitch');
Route::post('buscar/ip/wan/lanswitch', 'ControllerIP@buscar_ip_wan_admin_lanswitch');
Route::post('buscar/ip/wan/cpe', 'ControllerIP@buscar_ip_wan_admin_cpe');
Route::post('agregar/vlan/wan/anillo','ControllerRing@vlan_anillo_insert_wan_equipmen');
Route::post('acronimo/lanswitch', 'ControllerClient@acronimo_lanswitch');
Route::post('puerto/lanswitch', 'ControllerPort@port_lanswitch_selec');
Route::post('buscar/puerto/migrar', 'ControllerPort@port_migration_selec');
Route::post('equipo/lanswitch', 'ControllerEquipment@equipment_lanswitch');
Route::get('listar/seleccion/{function}', 'ControllerEquipment@index_list_select');
Route::post('baja/equipo', 'ControllerEquipment@down_equipmen');
Route::post('servicio/equipo', 'ControllerEquipment@service_equipmen');
Route::post('acronimo/equipo', 'ControllerEquipment@equipment');
Route::post('puerto/equipo', 'ControllerPort@inf_equip_port');
Route::get('puerto/equipo/get_ports', 'ControllerPort@inf_equip_port_detailed');
Route::post('reservar/puerto', 'ControllerPort@reser_port_equipmen');
Route::post('equipo/anillo', 'ControllerEquipment@equipment_rign');
Route::post('liberar/puerto', 'ControllerPort@free_port_equipmen');
Route::post('buscar/placa/equipo', 'ControllerBoard@buscar_placa');
Route::post('buscar/posicion/placa', 'ControllerBoard@sele_board_new');
Route::post('registrar/placa', 'ControllerBoard@inser_board_new');
Route::post('buscar/posicion', 'ControllerBoard@sele_board_update');
Route::post('modificar/posicion', 'ControllerBoard@pose_board_update');
Route::post('quitar/placa', 'ControllerBoard@delecte_board');
Route::post('equipo/localizacion', 'ControllerEquipment@location');
Route::post('asignar/equipo', 'ControllerEquipment@equipment_selec');
Route::post('ip/wan/lanswitch', 'ControllerIP@buscar_ip_wan_lanswitch');
Route::post('puerto/comentario', 'ControllerPort@commen_port_all');
Route::post('registrar/comentario/puerto', 'ControllerPort@insert_update_commen_port');
Route::get('listar/seleccion/equipo/ip', 'ControllerService@index_list_ip');
Route::post('registrar/PE', 'ControllerEquipment@store_update_pe');
Route::post('registrar/DM', 'ControllerEquipment@store_update_dm');
Route::post('registrar/PEI', 'ControllerEquipment@store_update_pei');
Route::post('puerto/ls/anillo', 'ControllerEquipment@port_equipment_lsw_ring');
Route::post('modificar/puerto/ls', 'ControllerEquipment@update_port_lsw_ring');
Route::post('detalle/puerto/servicio', 'ControllerPort@detal_port_equipmen_new_all');
Route::get('listar/seleccion/link/{data}', 'ControllerLink@select_list_node');
Route::post('asignar/link', 'ControllerLink@link_selec');
Route::post('puerto/lsw/link', 'ControllerLink@port_lsw_selec_link');
Route::post('puerto/link/lanswitch', 'ControllerLink@port_lanswitch_link');
Route::post('puerto/nuevo/lanswitch', 'ControllerLink@port_new_link_lsw');
Route::post('acrinimo/lsw/link', 'ControllerNode@acronimo_port_lsw');
Route::post('registar/radio', 'ControllerEquipment@store_radio');
Route::post('asignar/puerto/equipo', 'ControllerPort@new_port_equipmen_lsw');
Route::post('asignar/equipo/radio', 'ControllerEquipment@equipment_selec_radio');
Route::get('listar/radio/{data}', 'ControllerEquipment@list_radio_node');
Route::post('acronimo/radio/nodo', 'ControllerEquipment@acronimo_radio_nodo');
Route::post('acronimo/radio/cliente', 'ControllerEquipment@acronimo_radio_cliente');
Route::post('modificar/radio/nodo', 'ControllerEquipment@update_radio_nodo');
Route::post('modificar/radio', 'ControllerEquipment@update_radio');
Route::post('buscar/antena/odu', 'ControllerPort@inf_equip_port_radio_antena_odu');
Route::get('radio/enlace/listar', 'ControllerEquipment@list_index_radio_enlace');
Route::post('buscar/nueva/antena/odu', 'ControllerPort@modify_port_radio_antena_odu');
Route::post('guardar/nueva/antena/odu', 'ControllerPort@update_port_radio_antena_odu');
Route::post('buscar/anillo/lsw/servico', 'ControllerRing@BwRingRadioService');
Route::post('migrar/puerto/modelo/equipo', 'ControllerEquipment@MigrationModelNewAndPort');
Route::get('migrar/modelo/puertos/{id}', 'ControllerEquipment@ChangeModel');
Route::post('relacion/lanswitch/uplink', 'ControllerEquipment@relate_ls_uplink');
Route::post('relacionar/agregador/pepei', 'ControllerEquipment@relate_agg_pe_pi');
Route::get('listar/zonas', 'ControllerEquipment@index_zone');
Route::get('listar/pe/zona/{zone_id}/{eq_type}', 'ControllerEquipment@pe_by_zone');
Route::post('registrar/agregador/asociacion', 'ControllerAgg_Association@create');
Route::get('ver/SAR', 'ControllerEquipment@index_sar');
Route::post('registrar/SAR', 'ControllerEquipment@store_update_sar');
Route::get('ip/wan/vlan/{vlan_id}', 'ControllerIP@ip_wan_by_vlan');
Route::get('ip/wan/equip/{equip_id}/{vlan_id}', 'ControllerIP@assigned_ip_wan');

// --------------------------lista select--------------------------------------
Route::post('registrar/lista', 'ControllerList_select@store');


// --------------------nodo-------------------------
Route::get('ver/nodo', 'ControllerNode@index');
Route::get('listar/nodo', 'ControllerNode@index_list');
Route::get('listar/nodo/anillo', 'ControllerNode@sele_anillo_list');
Route::post('buscar/nodo', 'ControllerNode@select_nodo');
Route::post('registrar/nodo', 'ControllerNode@insert_update_nodo');
Route::post('seleccion/nodo', 'ControllerNode@nodo_select');
Route::post('consultar/comentario', 'ControllerNode@cometarios');
Route::post('asignar/nodo', 'ControllerNode@node_selec');
Route::post('buscar/vlan/ip/nodo', 'ControllerNode@search_vlan_ip');
Route::post('registrar/vlan/ip/nodo', 'ControllerNode@vlan_ip_nodo_insert');
Route::post('eliminar/vlan/ip/nodo', 'ControllerNode@delete_vlan_ip_nodo');
Route::post('buscar/equipos/nodo', 'ControllerNode@search_equipments_node');

// --------------------lista-------------------------
Route::get('lista/equipo', 'ControllerList_select@equipment_list')->name('lista.equipo');
Route::get('lista/marca', 'ControllerList_select@mark_list')->name('lista.marca');
Route::get('lista/banda', 'ControllerList_select@band_list')->name('lista.banda');
Route::get('lista/radio', 'ControllerList_select@radio_list')->name('lista.radio');
Route::get('lista/alimentacion', 'ControllerList_select@electrical_list')->name('lista.alimentacion');
Route::get('lista/puerto', 'ControllerList_select@type_port_list')->name('lista.puerto');
Route::get('lista/conector', 'ControllerList_select@conector_list')->name('lista.conector');
Route::get('lista/etiqueta', 'ControllerList_select@label_list')->name('lista.etiqueta');
Route::get('lista/placa', 'ControllerList_select@m_placa_list')->name('lista.placa');
Route::get('lista/estado', 'ControllerList_select@status_ip')->name('lista.estado');
Route::get('lista/pais', 'ControllerList_select@pais')->name('lista.pais');
Route::get('lista/provincia', 'ControllerList_select@provincia')->name('lista.provincia');
Route::get('lista/baja', 'ControllerList_select@motivo_baja')->name('lista.baja');
Route::get('lista/tipo/servicio', 'ControllerList_select@type_servi_list')->name('lista.tipo.servicio');
Route::get('lista/tipo/localizacion', 'ControllerList_select@localizacion_list')->name('lista.tipo.localizacion');
Route::get('lista/tipo/link', 'ControllerList_select@type_link_list')->name('lista.tipo.link');
Route::post('buscar/lista', 'ControllerList_select@select_list_edict')->name('lista.buscar');
Route::post('eliminar/lista', 'ControllerList_select@delecte_lista')->name('lista.eliminar');
Route::post('lista/servicio', 'ControllerList_select@list_service')->name('lista.servicio');
Route::post('buscar/tipo/servicio', 'ControllerList_select@search_list_service');
Route::post('eliminar/tipo/servicio', 'ControllerList_select@delecte_lista_type_service');
Route::post('mostrar/provincia', 'ControllerAddress@list_provinces_sele');

// --------------------anillo-------------------------
Route::get('ver/anillo', 'ControllerRing@index');
Route::get('listar/anillo', 'ControllerRing@index_list');
Route::post('AGG/anillo', 'ControllerRing@select_nodo');
Route::post('puerto/anillo', 'ControllerRing@search_port_bw');
Route::post('mostrar/puertos', 'ControllerRing@label_pantalla_anillo');
Route::post('registrar/anillo', 'ControllerRing@insert_update_anillo');
Route::post('buscar/anillo', 'ControllerRing@search_anillo');
Route::post('seleccionar/anillo', 'ControllerRing@search_anillo_lanswitch');
Route::post('buscar/vlan', 'ControllerRing@search_vlan_ip');
Route::post('eliminar/vlan', 'ControllerRing@delete_vlan_ip');
Route::post('registrar/vlan', 'ControllerRing@vlan_anillo_insert');
Route::post('vlan/rango', 'ControllerRing@search_vlan_rank');
Route::post('eliminar/anillo', 'ControllerRing@delete_ring');
Route::post('anillo/puerto', 'ControllerRing@search_port_ring');
Route::post('modificar/puerto/anillo', 'ControllerRing@update_port_ring');
Route::get('servicio/anillo/{id}', 'ControllerRing@service_anillo');
Route::get('agregador/servicio/anillo/{id}', 'ControllerRing@service_anillo_agg');
Route::post('anillo/acronimo', 'ControllerRing@acronimo_anillo');
Route::post('seleccionar/anillo/ip', 'ControllerRing@selec_anillo_ip');
Route::post('puerto/ipran/anillo', 'ControllerRing@search_port_bw_ring_ipran');
Route::get('anillo/metroethernet', 'ControllerRing@index_list_Metroethernet');
Route::post('listar/puerto/anillo', 'ControllerRing@PortRingAll');
Route::post('eliminar/puerto/anillo', 'ControllerRing@PortRingDelete');
Route::post('listar/puerto/nuevo/anillo', 'ControllerRing@PortRingNetList');
Route::post('registrar/puerto/nuevo/anillo', 'ControllerRing@PortRingNewInsert');


// --------------------anillo ipran-------------------------
Route::post('registrar/anillo/ipran', 'ControllerRing@CreateRingIpran');
Route::get('LSW/anillo/{id}', 'ControllerRing@select_nodo_lsw_ipran');
Route::get('anillo/ipran', 'ControllerRing@index_list_Ipran');
Route::post('seleccionar/anillo/ipran', 'ControllerRing@search_ring_lanswitch_ipran');

// -------------------- acronimo de equipo generales-------------------------
Route::post('lista/acronimo', 'ControllerAgg_Acronimo@search_acronimo');
Route::post('registar/acronimo', 'ControllerAgg_Acronimo@inser_update_acronimo');
Route::post('cpe/acronimo', 'ControllerClient@acronimo_equipo');
Route::post('consultar/acronimo', 'ControllerEquipment@consultar_acronimo');




// --------------------relacion agregador acronimo-------------------------
Route::post('buscar/relacion', 'ControllerRelation_Agg_Acronimo@rela_acro_agg');





// --------------------placa-------------------------
Route::post('buscar/placa', 'ControllerBoard@index_equipo');



// --------------------admin_ip-------------------------
Route::get('ver/rama', 'ControllerBranch@index');
Route::get('listar/rama', 'ControllerBranch@index_list');
Route::post('buscar/rama', 'ControllerBranch@search_rama');
Route::post('registar/rama', 'ControllerBranch@insert_update_rama');
Route::post('mas/rama', 'ControllerBranch@ver_mas_rama');
Route::post('ver/ip', 'ControllerIP@ver_rengo');
Route::post('subred/ip', 'ControllerIP@mostar_subred_eliminar');
Route::post('liberar/rango', 'ControllerIP@subred_eliminar');
Route::post('registrar/subred', 'ControllerIP@insert_update_sub_red');
Route::post('buscar/ip', 'ControllerIP@ip_extracion');
Route::post('detalle/ip', 'ControllerIP@detalle_ip');
Route::post('liberar/ip', 'ControllerIP@libera_ip');
Route::post('asignar/ip', 'ControllerIP@asignar_ip');
Route::post('asignar/grupo/ip', 'ControllerIP@asignar_ip_grupo');
Route::post('estado/ip', 'ControllerIP@status_ip');
// Route::post('atributo/ip', 'ControllerIP@search_attribute');
Route::post('ip/wan', 'ControllerIP@ip_wan_equipment');
Route::post('ip/subred/rango', 'ControllerIP@all_subred');
Route::post('filtrar/ip', 'ControllerBranch@search_ip_branch');
Route::post('asignar/subred', 'ControllerIP@asignar_red_all');
Route::post('liberar/subred', 'ControllerIP@liberar_red_all');
Route::get('ver/stock/IP', 'ControllerList_Stock_IP@index');
Route::get('listar/stock/IP', 'ControllerList_Stock_IP@index_list');
Route::post('detalle/subred', 'ControllerBranch@detal_branch');
Route::post('buscar/stock/IP', 'ControllerList_Stock_IP@search');
Route::post('registar/stock/IP', 'ControllerList_Stock_IP@insert_update_stock_ip');
Route::get('seleccionar/IP/stock', 'ControllerList_Stock_IP@list_select');
Route::post('borrar/rama/ip', 'ControllerBranch@DelecteBranch');

// --------------------Uplink-------------------------
Route::get('ver/uplink', 'ControllerUplink@index');
Route::get('listar/uplink', 'ControllerUplink@index_list');
Route::post('buscar/uplink', 'ControllerUplink@select_uplink');
Route::post('registrar/uplink', 'ControllerUplink@insert_update_uplink');
Route::get('ver/uplink/servicios/{id}', 'ControllerLink@service_by_uplink');





// --------------------grupo ip-------------------------
Route::get('ver/grupo', 'ControllerGroup_IP@index');
Route::post('registar/grupo', 'ControllerGroup_IP@insert_update_group');
Route::post('buscar/grupo', 'ControllerGroup_IP@search_group');
Route::get('listar/grupo', 'ControllerGroup_IP@index_list');



// --------------------grupo ip permisos-------------------------
Route::post('ver/permisos', 'ControllerPermissions_IP@search_group_permi');
Route::post('registrar/permisos', 'ControllerPermissions_IP@store_update');


// --------------------grupo ip users-------------------------
Route::post('ver/usuarios', 'ControllerGroup_Users@search_group_user');
Route::post('agregar/usuarios', 'ControllerGroup_Users@store');
Route::post('quitar/usuarios', 'ControllerGroup_Users@delete_user');


// --------------------permiso especial ip-------------------------
Route::get('ver/permiso', 'ControllerPermissions_IP@index');
Route::post('registro/especial', 'ControllerPermissions_IP@store_update_especial');
Route::get('listar/permiso', 'ControllerPermissions_IP@index_list');
Route::post('buscar/permiso', 'ControllerPermissions_IP@search_permiss');




// ---------------------------direccion------------------------------
Route::get('ver/direccion', 'ControllerAddress@index');
Route::get('listar/direccion', 'ControllerAddress@index_list');
Route::post('registrar/direccion', 'ControllerAddress@insert_update_address');
Route::post('buscar/direccion', 'ControllerAddress@search_address');
Route::post('asignar/direccion', 'ControllerAddress@address_selec');
Route::get('buscar/contenido/direccion/{id}', 'ControllerAddress@address_content_search');



// ---------------------------servicio------------------------------
Route::get('ver/servicio', 'ControllerService@index');
Route::get('listar/servicio', 'ControllerService@index_list');
Route::get('detalle/servicio/{id}', 'ControllerService@service_details');
Route::post('registrar/servicio', 'ControllerService@insert_update_service');
Route::post('buscar/servicio', 'ControllerService@search_service');
Route::post('puerto/servicio', 'ControllerService@port_service');
Route::post('agregar/puerto/servicio', 'ControllerService@port_service_mostrar');
Route::post('ip/recurso', 'ControllerService@list_ip_service');
Route::post('eliminar/ip', 'ControllerService@delete_ip_service');
Route::post('agregar/ip', 'ControllerService@ip_rank_new_servi');
Route::post('modificar/vlan', 'ControllerService@vlan_new_servi');
Route::post('baja/servicio', 'ControllerService@down_service');
Route::post('cancelar/servicio', 'ControllerService@cancel_service');
Route::post('alta/servicio', 'ControllerService@up_service');
Route::post('bw/servicio', 'ControllerService@search_bw_service_list');
Route::post('asignar/servicio', 'ControllerService@service_selec');
Route::get('todos/servicio/selecion', 'ControllerService@index_list_select');
Route::post('modificar/recurso/mostrar', 'ControllerLacp_Port@resource_service_edit');
Route::post('modificar/recurso', 'ControllerLacp_Port@resource_service_modificar');

// ---------------------------recurso------------------------------
Route::post('registrar/recurso', 'ControllerService_Port@insert_update_resources');
Route::post('ver/recurso', 'ControllerService_Port@service_port_list');
Route::post('ip/rango/recurso', 'ControllerService@type_service');
Route::post('eliminar/recurso', 'ControllerService_Port@delete_port_service');
Route::post('puerto/recurso', 'ControllerService_Port@port_libre');
Route::post('nuevo/recurso', 'ControllerService_Port@insert_port_service');
Route::post('grupo/puerto', 'ControllerService_Port@index_port_service_group');
Route::post('eliminar/puerto/grupo', 'ControllerService_Port@delete_port_service_group');
Route::post('puerto/lacp', 'ControllerService_Port@insert_port_lacp');
Route::post('eliminar/lacp', 'ControllerService_Port@index_port_group');
Route::post('eliminar/puerto/lacp', 'ControllerService_Port@delecte_port_group');


// ---------------------------grupo de puerto------------------------------
Route::post('registrar/lacp', 'ControllerLacp_Port@insert_lacp_port');
Route::post('editar/lacp', 'ControllerLacp_Port@edit_lacp');
Route::post('eliminar/lacp/equipo', 'ControllerLacp_Port@delecte_lacp_equipmen');
Route::post('eliminar/puerto/lacp/equipo', 'ControllerLacp_Port@port_delecte_lacp_search');
Route::post('buscar/comentario/lacp/equipo', 'ControllerLacp_Port@commen_port_all');
Route::post('registrar/comentario/lacp/equipo', 'ControllerLacp_Port@insert_update_commen_group');



// --------------------------Importar Excel--------------------------

Route::get('ver/importar/agregadores','ControllerImport_Excel@agg_post');
Route::get('listar/importar/agregadores','ControllerImport_Excel@index_lis_impor_agg');
Route::get('exportAgg','ControllerImport_Excel@export_agg');
Route::post('importAgg','ControllerImport_Excel@import_agg');
Route::post('ver/puerto/agg','ControllerImport_Excel@detal_port_equipmen');

Route::get('listar/importar/stock','ControllerImport_Excel@index_lis_impor_stock');

Route::get('ver/importar/stock',        'ControllerImport_Excel@stock_post');
Route::post('importStocks',             'ControllerImport_Excel@import_stock');

Route::get('ver/stock', 'ControllerImport_Excel@index');
Route::get('listar/stock', 'ControllerImport_Excel@index_list');

Route::get('ver/importar/anillo/{acronimo?}','XlAnilloController@post');
Route::get('importar/anillo/lista', 'XlAnilloController@index_list');
Route::post('importAnillo','XlAnilloController@import_anillos');
Route::post('lista/importar/puerto','XlAnilloController@search_port');

// --------------------------Filtro admin ip--------------------------------
Route::get('filtro/ip/equipo/{data}', 'ControllerEquipment@list_ip_equipment_all');
Route::get('filtro/ip/cliente/{data}', 'ControllerClient@list_ip_client_all');
Route::get('filtro/ip/anillo/{data}', 'ControllerRing@list_ip_ring_all');
Route::get('filtro/ip/{data}', 'ControllerIP@list_ip_all');
Route::get('filtro/ip/servicio/{data}', 'ControllerService@list_ip_service_all');
Route::get('filtro/sub/red/{data}/{dato}', 'ControllerIP@list_sub_red_all');
// --------------------------Seleccion--------------------------------------
// Route::get('seleccion/nodo', 'ControllerNode@index_list_select');

Route::get('ver/migracion',        'ControllerPort@migracion');
Route::get('acronimo/equipo/todo',        'ControllerEquipment@acronimo_equimenp_all');
Route::get('migracion/ip/anillo',        'ControllerRing@migrate_ring');
Route::get('migracion/bw/anillo',        'ControllerRing@migrate_ring_bw_full');
Route::get('migracion/puerto/anillo',        'ControllerRing@migrate_ring_port');
Route::get('migracion/reservar/puerto',        'ControllerPort@migrate_port_reser');

// --------------------------Module--------------------------------------
Route::get('ver/importar/module', 'ModuleController@index');
Route::get('listar/importar/module', 'ModuleController@index_list');
Route::post('registrar/module', 'ModuleController@insert_update_module');

// --------------------cadena-------------------------
Route::get('ver/cadena', 'ControllerChain@index');
Route::get('listar/cadena', 'ControllerChain@index_list');
Route::post('registrar/cadena', 'ControllerChain@create');
Route::post('buscar/cadena', 'ControllerChain@edic');
Route::post('modificar/cadena', 'ControllerChain@update');
Route::post('borrar/cadena','ControllerChain@delete');
Route::post('listar/equipo/agregador', 'ControllerChain@list_equipmen_agg');
Route::get('agregar/equipo/agregador', 'ControllerChain@search_equipmen_agg');
Route::post('buscar/puerto/agregador', 'ControllerChain@port_chain');
Route::post('recurso/cadena/agregador', 'ControllerChain@resource_agg');
Route::post('registrar/recurso/agregador', 'ControllerChain@insert_resource');
Route::post('agregador/cadena/asignada', 'ControllerChain@search_equipmen_agg_chain');
Route::post('relacionar/puerto/agregador', 'ControllerChain@relate_port_agg');
Route::post('mostrar/puertos/agregador', 'ControllerChain@show_ports_agg');
Route::post('relacionar/puertos/agregadores/cadena', 'ControllerChain@relate_chain_ports');
Route::post('buscar/cadena/relaciones', 'ControllerChain@search_chain_relations');
Route::post('eliminar/relacion', 'ControllerChain@delete_chain_ports');
Route::post('mostrar/equipos/cadena', 'ControllerChain@search_equipments_chain');
Route::post('listar/filtrar/puertos/cadena','ControllerChain@port_chain_list');
Route::post('guardar/puertos/seleccionados','ControllerChain@add_selected_ports');
Route::post('borrar/puertos/agregador/seleccionados','ControllerChain@delete_selected_ports');
Route::post('borrar/puertos/agregador/todos','ControllerChain@delete_all_ports_equipment_chain');



// --------------------------Link--------------------------------------
Route::get('ver/link', 'ControllerLink@index');
Route::get('listar/link', 'ControllerLink@index_list');
Route::post('registrar/link', 'ControllerLink@insert_update_link');
Route::post('editar/link', 'ControllerLink@edic');
Route::post('buscar/link', 'ControllerLink@edic_info');
Route::post('acronimo/link', 'ControllerLink@acronimo_link');
Route::get('listar/frontera/equipo/{id_equip}', 'ControllerLink@list_frontier');

// --------------------------Link CELDA--------------------------------------
Route::get('ver/link/celda', 'ControllerLink@index_ipran');
Route::get('listar/link/ipran', 'ControllerLink@index_list_ipran');
Route::post('eliminar/link','ControllerLink@delete');
Route::post('listar/link/ipran/nodo', 'ControllerLink@uplink_by_equipment');


// --------------------------Reservas--------------------------------------
Route::get('ver/reserva', 'ControllerReserve@index');
Route::get('listar/reserva', 'ControllerReserve@index_list');
Route::post('reserve/mostrar/equipos', 'ControllerReserve@index_reserves_equipment');
Route::post('buscar/reserva', 'ControllerReserve@info_edic');
Route::post('cancelar/reserva', 'ControllerReserve@cancell');
Route::post('registrar/reserva', 'ControllerReserve@create');
Route::post('agregar/tiempo/reserva', 'ControllerReserve@add_time');
Route::post('modificar/reserva', 'ControllerReserve@edic');
Route::post('listar/links/nodo', 'ControllerReserve@list_links_related_node');
Route::post('info/reserva/nodo', 'ControllerReserve@details_reserve');
Route::post('info/link', 'ControllerReserve@get_info_bw_link');
Route::post('reserve/equipment', 'ControllerReserve@info_bW_equipment');
Route::get('aplicar/reserva/{reserve_id}', 'ControllerReserve@apply_service_reserve');
Route::get('info/reserva/{reserve_id}', 'ControllerReserve@info_service_reserve');

// ----------------- Vlan rango ------------------------
Route::post('vlan/rango/equipo', 'ControllerUse_Vlan@index_range');
Route::post('info/rango/edit', 'ControllerUse_Vlan@edit_undo');
Route::post('agregar/rango/vlan', 'ControllerUse_Vlan@add_range');
Route::post('editar/rango/vlan', 'ControllerUse_Vlan@edit_range');
Route::post('borrar/rango/vlan', 'ControllerUse_Vlan@delete_range');

//---------------- Admin VLAN ----------------------
Route::get('ver/vlan', 'ControllerUse_Vlan@index');
Route::get('listar/vlan', 'ControllerUse_Vlan@index_list');
Route::get('ver/frontera', 'ControllerUse_Vlan@index_frontier');
Route::get('listar/frontera', 'ControllerUse_Vlan@list_frontier');
Route::get('frontera/{frontera}', 'ControllerUse_Vlan@get_frontier');
Route::post('listar/equipos/frontera', 'ControllerUse_Vlan@list_equipment_type');
Route::post('listar/puertos/lacp', 'ControllerUse_Vlan@list_lacp_group');
Route::post('agregar/frontera', 'ControllerUse_Vlan@add_frontier');
Route::post('ultima/frontera', 'ControllerUse_Vlan@last_frontier');
Route::post('cambiar/estado/frontera', 'ControllerUse_Vlan@change_status_frontier');
Route::get('ip/obtener/{subnet_ip}/{subnet_prefix}/{branch_id}', 'ControllerIP@ip_by_subnet');
Route::get('vlan/frontera/{id_list_use_vlan}', 'ControllerRing@has_frontier');
Route::get('vlan/proxima/{id_list_use_vlan}/{id_equipment}/{id_frontier}/{last_display}', 'ControllerRing@next_free_vlan');
Route::get('vlan/obtener/{id_list_use_vlan}/{id_equipment}/{id_frontier}', 'ControllerRing@get_free_vlans');
Route::get('frontera/buscar/{srv_type_id}/{service_bw}/{ring_id}/{agg_id}/{multihome}', 'ControllerRing@get_frontiers');
Route::get('equipo/anillo/buscar/{equip_id}', 'ControllerRing@ring_agg_by_equipment');
Route::post('registrar/internet/equipo', 'ControllerService_Port@register_internet_wan_assignment');
Route::post('frontera/editar-acronimo', 'ControllerUse_Vlan@edit_acronimo');
Route::get('ver/servicios', 'ControllerUse_Vlan@services_index');
Route::get('listar/servicios', 'ControllerUse_Vlan@list_services');
Route::post('servicio/eliminar-servicio', 'ControllerUse_Vlan@delete_services');
Route::get('ctag/obtener/{vlan_id}', 'ControllerUse_Vlan@get_free_ctags');
Route::get('servicio/get-ctag', 'ControllerUse_Vlan@get_service_ctag');
Route::post('servicio/guardar-ctag', 'ControllerUse_Vlan@save_service_ctag');
Route::get('vlan/obtener/internet-bv/{ring_id}', 'ControllerUse_Vlan@get_used_or_new_internet_bv');
Route::post('registrar/internet-bv/equipo', 'ControllerService_Port@register_internet_bv_assignment');
Route::post('registrar/servicio/equipo', 'ControllerService_Port@register_service_assignment');
Route::post('registrar/internet-rpv/equipo', 'ControllerService_Port@register_rpv_assignment');

// --------------------------Test api--------------------------------------

// -----------LIST Port Agg-----------------------//
Route::post('listar/port_agg','HomeController@list_port_agg');

// --------------------------Test api--------------------------------------
//Route::get('ejemplo','HomeController@api_request');
Route::get('ejemplo','HomeController@agg_ports_info');

// -----------APN-----------------------//
Route::get('ver/apn','ControllerAPN@index');

// --------------------------JARVIS +|||+ LEDZITE --------------------------------------
Route::get('ver/ledzite', 'ControllerLedzite@index');
Route::get('listar/ledzite', 'ControllerLedzite@index_list');

// --------------------------Asociación agregador--------------------------------------
Route::get('ver/asociacion/agg', 'ControllerAgg_Association@index');
Route::get('listar/asociacion/agg', 'ControllerAgg_Association@index_list');
Route::post('cambiar/agg/estado', 'ControllerAgg_Association@enable_disable_agg');
Route::get('probando/algo/{frt_id}/{available_bw}', 'ControllerService_Port@validate_before_assign');
