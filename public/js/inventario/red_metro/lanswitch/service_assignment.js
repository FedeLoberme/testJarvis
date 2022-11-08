const equip_id = document.getElementById('equip_id_inp');
const equip_acr = document.getElementById('equip_acr_inp');
const agg_type = document.getElementById('agg_type_inp');
const agg_id = document.getElementById('agg_id_inp');
const agg_acr = document.getElementById('agg_acr_inp');
const agg_label = document.getElementById('agg_label');
const ring_id = document.getElementById('ring_id_inp');
const ring_name = document.getElementById('ring_name_inp');
const service = $('#service_sele');
const service_type = document.getElementById('serv_type_inp');
const service_bw = document.getElementById('serv_bw_inp');
const form1 = document.getElementById('form1');
const form2 = document.getElementById('form2');
const form3 = document.getElementById('form3');
const form4 = document.getElementById('form4');
const save_btn = $('#int_serv_save_btn');
const Constants = new ConstantsModel();

/**
 * Función general para asignar servicio a equipo lsw
 * @param {*} id id del lanswitch
 * @param {*} acr acronimo del lanswitch
 */
function equip_service_assignment(id, acr) {
    // Limpia los campos
    service.find('option').remove();
    equip_id.value = id;
    equip_acr.value = acr;
    form1.style.display = 'none';
    form2.style.display = 'none';
    form3.style.display = 'none';
    form4.style.display = 'none';

    /**
     * Busca info del anillo y agg asociados al equipo cambiando el label del agg segun su tipo
     * Llama a la función de asignación correspondiente según el tipo de agregador y de servicio
     */
    $.ajax({
        type: "get",
        url: `${getBaseURL()}equipo/anillo/buscar/${id}`,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                break;
                case "yes":
                    agg_id.value = data['datos'].agg_id;
                    agg_acr.value = data['datos'].agg_acronimo;
                    ring_id.value = data['datos'].ring_id;
                    ring_name.value = data['datos'].ring_name;
                    if (data['datos'].agg_type == 'AGGI') {
                        agg_type.value = 'AGGI';
                        agg_label.innerHTML = 'Agregador BVI';
                    } else {
                        agg_type.value = '';
                        agg_label.innerHTML = 'Agregador';
                    }
                break;
                case "nop":
                    console.log(data['datos']);
                    toastr.error("Error con el servidor");
                break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

    service.off().on('change.select2', function(){
        if (service_type.value == Constants.SERVICE_TYPE_INTERNET_DEDICADO){
            if (agg_type.value != 'AGGI') lanswitch_internet_wan_assignment();
            if (agg_type.value == 'AGGI') lanswitch_internet_bv_assignment();
        }

        if (service_type.value == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS){
            service_type_rpv();
        }

        if (service_type.value != Constants.SERVICE_TYPE_INTERNET_DEDICADO && service_type.value != Constants.SERVICE_TYPE_RPV_MULTISERVICIOS){
            lanswitch_service_assignment();
        }
    });
}

/**
 * Funcion para mostrar info de asignación internet dedicado. Agregador común
 */
function lanswitch_internet_wan_assignment() {
    const frt_name = $('#frt_name_sel');
    const vlan = $('#vlan_name_sel');
    const select_ip = $('#select_ip_wan_btn');
    const ip = $('#ip_number');
    const ip_id = $('#ip_id');
    const frt_cap = document.getElementById('frt_cap_inp');
    const frt_occ = document.getElementById('frt_occ_inp');
    const pei_h = document.getElementById('pei_h_name_inp');
    const pei_h_int = document.getElementById('pei_h_int_inp');
    const pei_h_subint = document.getElementById('pei_h_int_inp');
    const pei_mh = document.getElementById('pei_mh_name_inp');
    const pei_mh_int = document.getElementById('pei_mh_int_inp');
    const pei_mh_subint = document.getElementById('pei_h_int_inp');
    const pe_h = document.getElementById('pei_h_name_inp');
    const pe_h_int = document.getElementById('pei_h_int_inp');
    const pe_h_subint = document.getElementById('pei_h_int_inp');
    const pe_mh = document.getElementById('pei_mh_name_inp');
    const pe_mh_int = document.getElementById('pei_mh_int_inp');
    const pe_mh_subint = document.getElementById('pei_h_int_inp');
    const checkbox = document.getElementById('mh_check_1');
    const vlan_type = 3;
    const ports = document.getElementById('campos_port_1');

    // Limpiar campos
    frt_name.find('option').remove();
    vlan.find('option').remove();
    frt_cap.value = '';
    frt_occ.value = '';
    pei_h.value = '';
    pei_h_int.value = '';
    pei_h_subint.value = '';
    pei_mh.value = '';
    pei_mh_int.value = '';
    pei_mh_subint.value = '';
    pe_h.value = '';
    pe_h_int.value = '';
    pe_h_subint.value = '';
    pe_mh.value = '';
    pe_mh_int.value = '';
    pe_mh_subint.value = '';
    while (ports.firstChild) ports.removeChild(ports.firstChild);

    // Mostrar formulario correspondiente
    form2.style.display = 'none';
    form3.style.display = 'none';
    form4.style.display = 'none';
    form1.style.display = 'block';

    // Busca la asociación de agg y busca la frontera a partir de esa asociacion
    $.ajax({
        type: "get",
        url: getBaseURL() + `frontera/buscar/${service_type.value}/${service_bw.value}/${ring_id.value}/${agg_id.value}/${JSON.stringify(checkbox.checked)}`,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "nop":
                    console.log(data['datos']);
                    toastr.error(data['datos']);
                    break;
                case "yes":
                    set_frt(data['datos'][0], service_type.value, checkbox.checked);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

    // Busca si hay vlans vinculadas a la frontera. Si hay, las trae para armar el listado. Si no hay, se arma el listado con los nros de vlan según el rango
    frt_name.off().on('change.select2', function(){
        $.ajax({
            type: "get",
            url: getBaseURL() + `vlan/obtener/${vlan_type}/${equip_id.value}/${frt_name.find('option').val()}`,
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            cache: true,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "nop":
                        console.log(data['datos']);
                        toastr.error("Error con el servidor");
                        break;
                    case "yes":
                        set_vlan(data['datos'][0], service_type.value, checkbox.checked);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    });

    // Se fija si hay ip asociada a la vlan. Si hay, la asigna. Si no hay, llama a funcion para seleccionarla de listado
    vlan.off().on('change.select2', function(){
        ip.val('');
        if (vlan.find('option').val() != null && vlan.find('option').val() != '') {
            $.ajax({
                type: "get",
                url: getBaseURL() + `ip/wan/equip/${equip_id.value}/${vlan.find('option').val()}`,
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                        break;
                        case 'nop':
                            ip_id.val('');
                            ip.val('');
                            select_ip.attr('onClick', `ip_wan_by_vlan(${vlan.find('option').val()},1)`);
                            select_ip.attr('data-target', '#ip_admin_sele_lans');
                            break;
                        case "yes":
                            ip_id.val(data['datos'].id);
                            ip.val(data['datos'].ip+'/'+data['datos'].prefixes);
                        break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        } else {
            select_ip.attr('onClick', 'buscar_ip_admin_all_red(2,151)');
            select_ip.attr('data-target', '#ip_admin_sele');
        }
    });

    save_btn.off().on('click', () => register_internet_wan_assignment());
}

/**
 * Funcion para mostrar info de asignación internet dedicado, agregador BVI
 */
function lanswitch_internet_bv_assignment() {
    const equip_id = document.getElementById('equip_id_inp');
    const vlan = $('#vlan_name_sel_2');
    const vlans_input = document.getElementById('mtag_arr');
    const ip = $('#ip_number_2');
    const ip_id = $('#ip_id_2');
    const public_subnet_id = document.getElementById('public_subnet_id_2');
    const public_subnet_number = document.getElementById('public_subnet_number_2');
    const ds_subnet_id = document.getElementById('ds_subnet_id_2');
    const ds_subnet_number = document.getElementById('ds_subnet_number_2');
    const select_ip = $('#select_ip_wan_btn_2');
    const ports = document.getElementById('campos_port_2');

    // Limpiar campos
    vlans_input.value = '';
    ip_id.val('');
    ip.val('');
    public_subnet_id.value = '';
    public_subnet_number.value = '';
    ds_subnet_id.value = '';
    ds_subnet_number.value = '';
    while (ports.firstChild) ports.removeChild(ports.firstChild);

    // Mostrar formulario correspondiente
    form1.style.display = 'none';
    form3.style.display = 'none';
    form4.style.display = 'none';
    form2.style.display = 'block';

    // Traer vlans de tipo 6 a partir de anillo y agg
    $.ajax({
        type: "get",
        url: getBaseURL() + `vlan/obtener/internet-bv/${ring_id.value}`,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        cache: false,
        success: (data) => set_vlan_form_2(data),
        error: (error) => ajaxErrorHandler(error)
    });

    // Se fija si hay ip asociada a la vlan. Si hay, la asigna. Si no hay, llama a funcion para seleccionarla de listado
    vlan.off().on('change.select2', function(){
        if (vlan.find('option').val() != null && vlan.find('option').val() != '') {
            $.ajax({
                type: "get",
                url: getBaseURL() + `ip/wan/equip/${equip_id.value}/${vlan.find('option').val()}`,
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                        break;
                        case 'nop':
                            ip_id.val('');
                            ip.val('');
                            select_ip.attr('onClick', `ip_wan_by_vlan(${vlan.find('option').val()},3)`);
                            select_ip.attr('data-target', '#ip_admin_sele_lans');
                            break;
                        case "yes":
                            ip_id.val(data['datos'].id);
                            ip.val(data['datos'].ip+'/'+data['datos'].prefixes);
                        break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        } else {
            ip_id.val('');
            ip.val('');
            select_ip.attr('onClick', 'buscar_ip_admin_all_red(2,154)');
            select_ip.attr('data-target', '#ip_admin_sele');
        }
    });

    save_btn.off().on('click', () => register_internet_bv_assignment());
}

// Muestra el formulario correspondiente
function lanswitch_service_assignment() {
    const vlan_type = 0;
    form1.style.display   = 'none';
    form2.style.display   = 'none';
    form3.style.display   = 'none';
    form4.style.display   = 'none';

}

function selec_service_2(id, type){
    const service = $('#service_sele');
    const service_type = document.getElementById('serv_type_inp');
    const service_bw = document.getElementById('serv_bw_inp');
    const service_bw_label = document.getElementById('bw_service_label');
    const cerrar = document.getElementById('cerra_bus_servi_all');

    $.ajax({
        type: "POST",
        url: getBaseURL()+'asignar/servicio',
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                break;
                case "yes":
                    service_type.value = type;
                    service_bw.value = data['bw_service'];
                    service_bw_label.innerHTML = data['bw_service'];
                    service.find('option').remove();
                    service.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    cerrar.click();
}

function select_frontier_modal(id, name) {
    var select = $("#select_frontier");
    var close = $("#close_modal_frontier");
    select.find('option').remove();
    select.append(`<option disabled selected value="${id}">${name}</option>`).trigger('change.select2');
    close.trigger('click');
}

function ds_switch_1(){
    const checkbox = document.getElementById('ds_check_1');
    const ip_wan = document.getElementById('ip_wan_div_1');
    const subred = document.getElementById('subred_30_div_1');
    const ctag_div = document.getElementById('ctag_row_1');
    const ctag = $("#ctag_name_sel");
    const input = $('#ctag_arr');
    let vlan_id = $("#vlan_name_sel").find('option').val();

    if (checkbox.checked) {
        ip_wan.style.display = 'none';
        subred.style.display = 'block';
        ctag_div.style.display = 'block';
        ctag.find('option').remove();
        ctag.append('<option selected disabled value="0">0000</option>');
        if (!vlan_id) vlan_id = 0;
        console.log(vlan_id);
        $.ajax({
            type: "get",
            url: getBaseURL() + `ctag/obtener/${vlan_id}`,
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            cache: false,
            success: (data) => {
                input.val(JSON.stringify(data));
                next_vlan(7);
            },
            error: (resp) => ajaxErrorHandler(resp)
        });
    } else {
        subred.style.display = 'none';
        ctag_div.style.display = 'none';
        ip_wan.style.display = 'block';
        ctag.find('option').remove();
        ctag.append('<option selected disabled value="0">0000</option>');
    }
}

function ds_switch_2(){
    const checkbox = document.getElementById('ds_check_2');
    const ip_wan = document.getElementById('ip_wan_div_2');
    const subred = document.getElementById('subred_30_div_2');

    if (checkbox.checked) {
        ip_wan.style.display = 'none';
        subred.style.display = 'block';
    } else {
        subred.style.display = 'none';
        ip_wan.style.display = 'block';
    }
}

function ds_switch_3(){
    const checkbox = document.getElementById('ds_check_3');
    const ip_wan = document.getElementById('ip_wan_div_3');
    const subred = document.getElementById('subred_30_div_3');
    const ctag = document.getElementById('ctag_row_3');

    if (checkbox.checked) {
        ip_wan.style.display = 'none';
        subred.style.display = 'block';
        ctag.style.display = 'block';
    } else {
        subred.style.display = 'none';
        ctag.style.display = 'none';
        ip_wan.style.display = 'block';
    }
}

function ds_switch_4(){
    const checkbox = document.getElementById('ds_check_4');
    const ip_wan = document.getElementById('ip_wan_div_4');
    const subred = document.getElementById('subred_30_div_4');

    if (checkbox.checked) {
        ip_wan.style.display = 'none';
        subred.style.display = 'block';
    } else {
        subred.style.display = 'none';
        ip_wan.style.display = 'block';
    }
}

function mh_switch_1() {
    const checkbox = document.getElementById('mh_check_1');
    const frt = $('#frt_name_sel');
    const frt_cap = document.getElementById('frt_cap_inp');
    const frt_occ = document.getElementById('frt_occ_inp');
    const pei_h = document.getElementById('pei_h_div');
    const pei_mh = document.getElementById('pei_mh_div');
    const pei_h_int = document.getElementById('pei_h_int_div');
    const pei_mh_int = document.getElementById('pei_mh_int_div');
    const pei_h_subint = document.getElementById('pei_h_subint_div');
    const pei_mh_subint = document.getElementById('pei_mh_subint_div');
    const service = $('#service_sele');

    frt.find('option').remove();
    frt_cap.value = '';
    frt_occ.value = '';
    pei_h.value = '';
    pei_h_int.value = '';
    pei_h_subint.value = '';
    pei_mh.value = '';
    pei_mh_int.value = '';
    pei_mh_subint.value = '';

    if (checkbox.checked) {
        pei_h.style.display = 'none';
        pei_h_int.style.display = 'none';
        pei_h_subint.style.display = 'none';
        pei_mh.style.display = 'block';
        pei_mh_int.style.display = 'block';
        pei_mh_subint.style.display = 'block';
    } else {
        pei_mh.style.display = 'none';
        pei_mh_int.style.display = 'none';
        pei_mh_subint.style.display = 'none';
        pei_h.style.display = 'block';
        pei_h_int.style.display = 'block';
        pei_h_subint.style.display = 'block';
    }

    service.trigger('change.select2');
}

function mh_switch_3() {
    const checkbox = document.getElementById('mh_check_3');
    const pe_h = document.getElementById('pe_h_div');
    const pe_mh = document.getElementById('pe_mh_div');
    const pe_h_int = document.getElementById('pe_h_int_div');
    const pe_mh_int = document.getElementById('pe_mh_int_div');
    const pe_h_subint = document.getElementById('pe_h_subint_div');
    const pe_mh_subint = document.getElementById('pe_mh_subint_div');

    if (checkbox.checked) {
        pe_h.style.display = 'none';
        pe_h_int.style.display = 'none';
        pe_h_subint.style.display = 'none';
        pe_mh.style.display = 'block';
        pe_mh_int.style.display = 'block';
        pe_mh_subint.style.display = 'block';
    } else {
        pe_mh.style.display = 'none';
        pe_mh_int.style.display = 'none';
        pe_mh_subint.style.display = 'none';
        pe_h.style.display = 'block';
        pe_h_int.style.display = 'block';
        pe_h_subint.style.display = 'block';
    }

    service.trigger('change.select2');
}

function set_frt(frt, serv_type, multihome) {
    let frt_id    = document.getElementById('frt_id_inp');
    let frt_name  = $('#frt_name_sel');
    let frt_cap   = document.getElementById('frt_cap_inp');
    let frt_occ   = document.getElementById('frt_occ_inp');
    let frt_avail = document.getElementById('frt_avail_inp');
    let vlan_type = document.getElementById('vlan_type_inp');
    var assoc_eq; // Equipo asociado
    var assoc_eq_int; // Interfaz equipo asociado

    if (serv_type == Constants.SERVICE_TYPE_INTERNET_DEDICADO && multihome == false) {
        vlan_type.value    = 3;
        assoc_eq           = document.getElementById('pei_h_name_inp');
        assoc_eq_int       = document.getElementById('pei_h_int_inp');
        assoc_eq.value     = frt.acr_home_pei;
        assoc_eq_int.value = frt.interface_home_pei;
    }

    if (serv_type == Constants.SERVICE_TYPE_INTERNET_DEDICADO && multihome == true) {
        vlan_type.value    = 3;
        assoc_eq           = document.getElementById('pei_mh_name_inp');
        assoc_eq_int       = document.getElementById('pei_mh_int_inp');
        assoc_eq.value     = frt.acr_multihome_pei;
        assoc_eq_int.value = frt.interface_multihome_pei;
    }

    if(serv_type == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS && multihome == false){
        vlan_type.value    = 4;
        assoc_eq           = document.getElementById('pe_h_name_inp_rpv');
        assoc_eq_int       = document.getElementById('pe_h_int_inp_rpv');
        assoc_eq.value     = frt.acr_home_pe;
        assoc_eq_int.value = frt.interface_home_pe;
        frt_name           = $('#frt_name_sel_rpv');
        frt_id             = document.getElementById('frt_id_inp_rpv');
        frt_cap            = document.getElementById('frt_cap_inp_rpv')
        vlan_type          = document.getElementById('vlan_type_inp_rpv');
        frt_occ            = document.getElementById('frt_occ_inp_rpv');
    }

    if(serv_type == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS && multihome == true){
        vlan_type.value    = 4;
        assoc_eq           = document.getElementById('pe_mh_name_inp_rpv');
        assoc_eq_int       = document.getElementById('pe_mh_int_inp_rpv');
        assoc_eq.value     = frt.acr_multihome_pe;
        assoc_eq_int.value = frt.interface_multihome_pe;
        frt_name           = $('#frt_name_sel_rpv');
        frt_id             = document.getElementById('frt_id_inp_rpv');
        frt_cap            = document.getElementById('frt_cap_inp_rpv')
        vlan_type          = document.getElementById('vlan_type_inp_rpv');
        frt_occ            = document.getElementById('frt_occ_inp_rpv');
    }

    frt_id.value    = frt.id_frt;
    frt_name.find('option').remove();
    frt_name.append(`<option selected disabled value="${frt.id_frt}">${frt.frt} / ${frt.name_frt}</option>`).trigger('change.select2');
    frt_cap.value   = frt.bw_limit;
    frt_occ.value   = frt.bw_occu;
    frt_avail.value = frt.available_bw;
    $('#cerrar_frontier_list').trigger('click');
    return;
}

/**
 * Coloca el nro de vlan en el elemento select de la vista en formulario de asignación internet dedicado con agregador común
 * Y, si la vlan está registrada, guarda el id en un input hidden
 */
function set_vlan(vlan, serv_type, is_multihome) {
    let vlan_name  = '';
    let vlan_label = '';
    let select_ip  = '';
    var assoc_eq_int; // Interfaz equipo asociado
    var assoc_eq_subint; // Subinterfaz equipo asociado

    if (serv_type == Constants.SERVICE_TYPE_INTERNET_DEDICADO && is_multihome == false) {
        assoc_eq_int    = document.getElementById('pei_h_int_inp');
        assoc_eq_subint = document.getElementById('pei_h_sub_inp');
        vlan_name = $('#vlan_name_sel');
        vlan_label = document.getElementById('vlan_label');
        select_ip  = $('#select_ip_wan_btn');
    }

    if (serv_type == Constants.SERVICE_TYPE_INTERNET_DEDICADO && is_multihome == true) {
        assoc_eq_int    = document.getElementById('pei_mh_int_inp');
        assoc_eq_subint = document.getElementById('pei_mh_sub_inp');
        vlan_name = $('#vlan_name_sel');
        vlan_label = document.getElementById('vlan_label');
        select_ip  = $('#select_ip_wan_btn');
    }

    if (serv_type == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS && is_multihome == false){
        assoc_eq_int    = document.getElementById('pe_h_int_inp_rpv');
        assoc_eq_subint = document.getElementById('pe_h_sub_inp_rpv');
        vlan_name  = $('#vlan_name_sel_rpv');
        vlan_label = document.getElementById('vlan_label_rpv');
        select_ip  = $('#select_ip_wan_btn_rpv');
    }

    if (serv_type == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS && is_multihome == true){
        assoc_eq_int    = document.getElementById('pe_mh_int_inp_rpv');
        assoc_eq_subint = document.getElementById('pe_mh_sub_inp_rpv');
        vlan_name  = $('#vlan_name_sel_rpv');
        vlan_label = document.getElementById('vlan_label_rpv');
        select_ip  = $('#select_ip_wan_btn_rpv');
    }

    vlan_name.find('option').remove();
    if (typeof vlan === 'object') {
        vlan_name.append(`<option selected disabled value="${vlan.id}">${vlan.vlan}</option>`).trigger('change.select2');
        vlan_label.innerHTML = 'VLAN Metro-tag existente';
        assoc_eq_subint.value = `${assoc_eq_int.value}-${vlan.vlan}`;
        select_ip.attr('onClick', `ip_wan_by_vlan(${vlan.id},1)`);
        select_ip.attr('data-target', '#ip_admin_sele_lans');
    } else {
        vlan_name.append(`<option selected disabled value="">${vlan}</option>`).trigger('change.select2');
        vlan_label.innerHTML = 'VLAN Metro-tag nueva';
        assoc_eq_subint.value = `${assoc_eq_int.value}-${vlan}`;
        select_ip.attr('onClick', 'buscar_ip_admin_all_red(2,151)');
        select_ip.attr('data-target', '#ip_admin_sele');
    }

    $('#cerrar_vlan_list').trigger('click');
    return;
}

function ip_wan_by_vlan(vlan_id, interface) {
    switch (interface) {
        case 1: var id = document.getElementById("equip_id_inp").value; break;
        case 2: var id = document.getElementById("equip_sel").value; break;
        case 3: var id = document.getElementById("equip_id_inp").value; break;
        default: var id = document.getElementById("equip").value; break;
    }
    var new_tbody = document.createElement('tbody');
    $("#ip_lanswitch_table").html(new_tbody);
    if (id == '' || id.length == 0) {
        toastr.error("seleccione el equipo");
    } else {
        $.ajax({
            type: "get",
            url: getBaseURL() + `ip/wan/vlan/${vlan_id}`,
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                    break;
                    case 'nop':
                        console.log(data['datos']);
                        break;
                    case "yes":
                        $('#anilo_id').val(data['ring']);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i].ip +'</td>' +
                                '<td>'+ data['datos'][i].acronimo + '</td>' +
                                '<td>' + data['datos'][i].uso +' '+ data['datos'][i].vlan + '</td>';
                            if (data['datos'][i].type == 'DISPONIBLE' && data['datos'][i].id_status == 1) {
                                valor += '<td><a> <i class="fa fa-bullseye" onclick="selecion_ip_wan('+data['datos'][i].id+','+interface+');" title="Seleccionar IP"> </i></a></td>';
                            }else{
                                valor += '<td><a title="IP no disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a></td>';
                            }
                            valor +=  '</tr>';
                            $("#ip_lanswitch_table").append(valor)
                        });
                    break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function set_ip(ip, target_form) {
    let ip_id = null;
    let ip_number = null;
    switch (target_form) {
        case 1:
            ip_id = document.getElementById('ip_id');
            ip_number = document.getElementById('ip_number');
            break;
        case 2:
            ip_id = document.getElementById('ip_id_2');
            ip_number = document.getElementById('ip_number_2');
            break;
    }
    const close = $("#cerra_bus_ip_admin_lans");
    if (ip.hasOwnProperty('id')) ip_id.value = ip.id;
    ip_number.value = `${ip.ip}/${ip.prefixes}`;
    close.trigger('click');
}

/**
 * Registra asignación de servicio tipo internet dedicado, agregador común
 */
function register_internet_wan_assignment() {
    const equip_id = document.getElementById('equip_id_inp').value;
    const ring_id = document.getElementById('ring_id_inp').value;
    const service_id = $('#service_sele').find('option').val();
    const frt_id = $('#frt_name_sel').find('option').val();
    const available_bw = document.getElementById('frt_avail_inp').value;
    const vlan_id = $('#vlan_name_sel').find('option').val();
    const vlan_number = $('#vlan_name_sel').find('option').text();
    const ip_id = document.getElementById('ip_id').value;
    const wan_subnet_id = document.getElementById('wan_subnet_id').value;
    const public_subnet_id = document.getElementById('public_subnet_id').value;
    const pts = document.getElementsByClassName("puerto_sevicio_alta");
    const checkbox = document.getElementById('ds_check_1');
    const ctag = $('#ctag_name_sel').find('option').val();
    const ds_subnet_id = document.getElementById('ds_subnet_id').value;
    const close = $("#internet_wan_assign_close");
    let ports = [];

    for (var i = 0; i < pts.length; ++i) {
        if (typeof pts[i].value !== "undefined") {
            ports.push(pts[i].value);
        }
    }

    const data = {
        service_id: service_id,
        equip_id: equip_id,
        ring_id: ring_id,
        frontier_id: frt_id,
        frontier_avail: available_bw,
        use_vlan_id: vlan_id,
        vlan: vlan_number,
        public_subnet_id: public_subnet_id,
        ports: ports
    };

    if (checkbox.checked) {
        data.is_ds = 'true';
        data.ctag = ctag;
        data.ds_subnet_id = ds_subnet_id;
    } else {
        data.is_ds = 'false';
        data.ip_id = ip_id;
        data.wan_subnet_id = wan_subnet_id;
    }

    $.ajax({
        type: "post",
        url: getBaseURL()+`registrar/internet/equipo`,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: data,
        dataType: 'json',
        cache: false,
        success: (data) => {
            toastr.success('Operación exitosa');
            close.trigger('click');
        },
        error: (response) => ajaxErrorHandler(response)
    });
}

/**
 * Coloca el nro de vlan en el elemento select de la vista en formulario de asignación internet dedicado, agg BVI
 * Y, si la vlan está registrada, guarda el id en un input hidden
 */
function set_vlan_form_2(vlans) {
    const vlan_label = document.getElementById('vlan_label_2');
    const vlan_name = $('#vlan_name_sel_2');
    const vlans_input = $('#mtag_arr');

    vlans_input.val(JSON.stringify(vlans));
    vlan_name.find('option').remove();

    if (typeof vlans[0] === 'object') {
        vlan_label.innerHTML = 'VLAN Metro-tag existente';
        vlan_name.append(`<option disabled selected value="${vlans[0].id}">${vlans[0].vlan}</option>`).trigger('change.select2');
    } else {
        vlan_label.innerHTML = 'VLAN Metro-tag nueva';
        vlan_name.append(`<option disabled selected value="">${vlans[0]}</option>`).trigger('change.select2');
    }

    $('#cerrar_vlan_list').trigger('click');
    return;
}

/**
 * Toma la vlan seleccionada y la reemplaza por la siguiente según el array de vlans libres
 */
function next_vlan_form_2() {
    let free_vlans = JSON.parse($('#mtag_arr').val());
    let select = $("#vlan_name_sel_2");

    let index = free_vlans.indexOf(select.find('option').text());
    let next = (free_vlans[index+1] == undefined) ? 0 : index+1;

    select.find('option').remove();
    if (typeof free_vlans[next] === 'object') {
        select.append(`<option disabled selected value="${parseInt(free_vlans[next].id)}">${free_vlans[next].vlan}</option>`).trigger('change.select2');
    } else {
        select.append(`<option disabled selected value="">${free_vlans[next]}</option>`).trigger('change.select2');
    }

}

/**
 * Registra asignación de servicio tipo internet dedicado, agregador BVI
 */
 function register_internet_bv_assignment() {
    const equip_id = document.getElementById('equip_id_inp').value;
    const ring_id = document.getElementById('ring_id_inp').value;
    const agg_id = document.getElementById('agg_id_inp').value;
    const service_id = $('#service_sele').find('option').val();
    const vlan_id = $('#vlan_name_sel_2').find('option').val();
    const vlan_number = $('#vlan_name_sel_2').find('option').text();
    const ip_id = document.getElementById('ip_id_2').value;
    const wan_subnet_id = document.getElementById('wan_subnet_id_2').value;
    const public_subnet_id = document.getElementById('public_subnet_id_2').value;
    const pts = document.getElementsByClassName("puerto_sevicio_alta"); //
    const checkbox = document.getElementById('ds_check_2');
    const ds_subnet_id = document.getElementById('ds_subnet_id_2').value;
    const close = $("#internet_wan_assign_close");
    let ports = [];

    for (var i = 0; i < pts.length; ++i) {
        if (typeof pts[i].value !== "undefined") {
            ports.push(pts[i].value);
        }
    }

    const data = {
        service_id: service_id,
        equip_id: equip_id,
        ring_id: ring_id,
        agg_id: agg_id,
        use_vlan_id: vlan_id,
        vlan: vlan_number,
        public_subnet_id: public_subnet_id,
        ports: ports
    };

    if (checkbox.checked) {
        data.is_ds = 'true';
        data.ds_subnet_id = ds_subnet_id;
    } else {
        data.is_ds = 'false';
        data.ip_id = ip_id;
        data.wan_subnet_id = wan_subnet_id;
    }

    $.ajax({
        type: "post",
        url: getBaseURL()+`registrar/internet-bv/equipo`,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: data,
        dataType: 'json',
        cache: false,
        success: (data) => {
            toastr.success('Operación exitosa');
            close.trigger('click');
        },
        error: (response) => ajaxErrorHandler(response)
    });
}

/**
 * Funcion para mostrar info de asignación de servicio (No internet dedicado, ni RPV multiservicios)
 */
function lanswitch_service_assignment() {
    const vlan = document.getElementById('vlan_inp');
    const ports = document.getElementById('campos_port_4');

    vlan.value = '';
    while (ports.firstChild) ports.removeChild(ports.firstChild);

    // Ocultar form1, form2, form3 y mostrar form4
    form1.style.display = 'none';
    form2.style.display = 'none';
    form3.style.display = 'none';
    form4.style.display = 'block';

    save_btn.off().on('click', () => register_service_assignment());
}

/**
 * Registra asignación de servicios varios
 */
function register_service_assignment() {
    const equip_id = document.getElementById('equip_id_inp').value;
    const service_id = $('#service_sele').find('option').val();
    const vlan_number = document.getElementById('vlan_inp').value;
    const pts = document.getElementsByClassName("puerto_sevicio_alta");
    const close = $("#internet_wan_assign_close");
    let ports = [];

    for (var i = 0; i < pts.length; ++i) {
        if (typeof pts[i].value !== "undefined") {
            ports.push(pts[i].value);
        }
    }

    const data = {
        equip_id: equip_id,
        service_id: service_id,
        vlan: vlan_number,
        ports: ports
    };

    $.ajax({
        type: "post",
        url: getBaseURL()+`registrar/servicio/equipo`,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: data,
        dataType: 'json',
        cache: false,
        success: (data) => {
            toastr.success('Operación exitosa');
            close.trigger('click');
        },
        error: (response) => ajaxErrorHandler(response)
    });
}
