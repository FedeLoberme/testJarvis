
function service_type_rpv()
{
    const checkboxForVlanChange = document.getElementById('mh_check_3');
    let vlan_type = document.getElementById('vlan_type_inp_rpv');
    vlan_type.value = Constants.VLAN_TYPE_RPV;

    checkboxForVlanChange.addEventListener('change', function(){
       if (this.checked){
           vlan_type.value = Constants.VLAN_TYPE_RPV_MH;
       }

        if (!this.checked){
            vlan_type.value = Constants.VLAN_TYPE_RPV;
        }
    });



    class ServiceTypeRPVClass {
        constructor(equipment_id, service_type, service_bw, service_id, agg_type, agg_id, ring_id, frontier_id, frontier_capacity, frontier_occupation, vlan_type, vlan_id, vlan_number, ctag, is_multihome, pe, interface_pe, subinterface_pe, ports) {

            this.equipment_id           = equipment_id;
            this.service_type           = service_type;
            this.service_bw             = service_bw;
            this.service_id             = service_id;
            this.agg_type               = agg_type;
            this.agg_id                 = agg_id;
            this.ring_id                = ring_id;
            this.frontier_id            = frontier_id;
            this.frontier_capacity      = frontier_capacity;
            this.frontier_occupation    = frontier_occupation;
            this.vlan_type              = vlan_type;
            this.vlan_id                = vlan_id;
            this.vlan_number            = vlan_number;
            this.ctag                   = ctag;
            this.is_multihome           = is_multihome;
            this.pe                     = pe;
            this.interface_pe           = interface_pe;
            this.subinterface_pe        = subinterface_pe;
            this.ports                  = ports;
        }
    }

    /**
     * Array global en la funcion de ctags disponibles
     */
    let availableCtags = new Array();

    /**
     * Objeto del ctag
     */
    let ctag_service_type_rpv = {
        ctag     : '',
        ctagValue: 0,
        //ctagValue sirve para referenciar un indice en el array availableCtags
    }

    /**
     * Validador del proxy
     */
    let validator = {
        set: (target, property, value) => {
            target[property] = value;
            printCtag();
        }
    }

    let proxyCtagServiceRPV = new Proxy (ctag_service_type_rpv, validator);

    /**
     * Funcion que se llama en el setter del proxy y appendea el <option>
     */
    function printCtag(){
        let select = $("#ctag_name_sel_rpv");
        select.empty();
        select.append(proxyCtagServiceRPV.ctag);
    }

    let frt_name = $('#frt_name_sel_rpv');
    form1.style.display   = 'none';
    form2.style.display   = 'none';
    form3.style.display   = 'block';
    form4.style.display   = 'none';

    const checkbox = document.getElementById('mh_check_3');

    /**
     * Busca la frontera
     */
    $.ajax({
        type: "GET",
        url: getBaseURL() + `frontera/buscar/${service_type.value}/${service_bw.value}/${ring_id.value}/${agg_id.value}/${JSON.stringify(checkbox.checked)}`,
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

    /**
     * Busca el ctag
     */

    function searchCtag(id){
        const input = $('#ctag_arr_rpv');

        $.ajax({
            type: "get",
            url: getBaseURL() + `ctag/obtener/${id}`,
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            cache: false,
            success: (data) => {
                //limpio el array y guardo la data en el array
                availableCtags.pop()
                availableCtags = data;

                //defino que ctagValue sea 0 cada vez que se ejecute este ajax
                proxyCtagServiceRPV.ctagValue = 0;
                //defino proxy.ctag como el option a appendear
                proxyCtagServiceRPV.ctag = `<option disabled selected value="${availableCtags[0]}">${availableCtags[0]}</option>`;
            },
            error: (data) => {
                console.log({
                    message: data.responseJSON.message,
                    file   : data.responseJSON.file,
                    line   : data.responseJSON.line,
                });
                toastr.error("Error con el servidor");
            }
        });
    }

    /**
     * Busco la vlan y el ctag
     */

    frt_name.on('change.select2', function(){
        if (frt_name.find('option').val() != null && frt_name.find('option').val() != '') {
            const vlan_type = Constants.VLAN_TYPE_RPV;
            $.ajax({
                type: "get",
                url: getBaseURL() + `vlan/obtener/${vlan_type}/${equip_id.value}/${frt_name.find('option').val()}`,
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
                            toastr.error("Error con el servidor");
                            break;
                        case "yes":
                            set_vlan(data['datos'][0], service_type.value, checkbox.checked);
                            searchCtag(data['datos'][0]);
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    })

    /**
     * Busca el siguiente ctag disponible
     */
    $('#next_ctag_btn_rpv').on('click', function(){
        next_vlan_ctag();
        proxyCtagServiceRPV.ctagValue = proxyCtagServiceRPV.ctagValue + 1;
    })

    function next_vlan_ctag(){

        proxyCtagServiceRPV.ctag = `
            <option disabled selected
                value="${availableCtags[proxyCtagServiceRPV.ctagValue]}">${availableCtags[proxyCtagServiceRPV.ctagValue]}
            </option>
        `;
    }

    $('#int_serv_save_btn').off().on('click', function (){
        register_rpv_assignment();
    })


    /**
     * Guardar asignacion de servicio rpv
     */

    function register_rpv_assignment(){
        const ports               = document.querySelectorAll('.puerto_sevicio_alta');
        const equipment_id        = document.getElementById('equip_id_inp').value;
        const service_type        = document.getElementById('serv_type_inp').value;
        const service_id          = $('#service_sele').find('option').val();
        const service_bw          = document.getElementById('serv_bw_inp').value;
        const agg_type            = document.getElementById('agg_type_inp').value;
        const agg_id              = document.getElementById('agg_id_inp').value;
        const ring_id             = document.getElementById('ring_id_inp').value;
        const frontier_id         = document.getElementById('frt_id_inp_rpv').value;
        const frontier_capacity   = document.getElementById('frt_cap_inp').value;
        const frontier_occupation = document.getElementById('frt_occ_inp').value;
        const vlan_type           = document.getElementById('vlan_type_inp').value;
        const vlan_id             = $('#vlan_name_sel_rpv').find('option').val();
        const vlan_number         = $('#vlan_name_sel_rpv').find('option').text();
        const ctag                = $('#ctag_name_sel_rpv').find('option').text();
        const is_multihome        = checkbox.checked;
        let pe;
        let interface_pe;
        let subinterface_pe; /** en vlan **/

        if(service_type == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS && !is_multihome){
            pe              = document.getElementById('pe_h_name_inp_rpv').value;
            interface_pe    = document.getElementById('pe_h_int_inp_rpv').value;
            subinterface_pe = document.getElementById('pe_h_sub_inp_rpv').value;
        }

        if(service_type == Constants.SERVICE_TYPE_RPV_MULTISERVICIOS && is_multihome){
            pe              = document.getElementById('pe_mh_name_inp_rpv').value;
            interface_pe    = document.getElementById('pe_mh_int_inp_rpv').value;
            subinterface_pe = document.getElementById('pe_mh_sub_inp_rpv').value;
        }

        let portsArray = Object.entries(ports).map((el, index) => {
            if(el && index !== undefined){
                return parseInt(el[1].value);
            }
        });

        const serviceObject = new ServiceTypeRPVClass(equipment_id, service_type, service_bw, service_id, agg_type, agg_id, ring_id, frontier_id, frontier_capacity, frontier_occupation, vlan_type, vlan_id, vlan_number, ctag, is_multihome, pe, interface_pe, subinterface_pe, portsArray);

        $.ajax({
            type: "post",
            url: getBaseURL()+`registrar/internet-rpv/equipo`,
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            data: serviceObject,
            cache: false,
            success: (data) => {
                toastr.success('Operación exitosa');
                $('#internet_wan_assign_close').click();
            },
            error: (response) => console.log(response)
        });
    }

}
