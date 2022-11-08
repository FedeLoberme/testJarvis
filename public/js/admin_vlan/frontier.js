/** EDITAR FRONTERAS **/

/**BUSQUEDA **/
function search_frontier(id)
{
    //numero frontera
    let frontier_number = document.getElementById('frontier_number_edit');
    //tipo frontera
    //onst id_type_frontier = document.getElementById('id_zone');
    //tipo de servicio
    const id_type_service = $('#id_type_service')[0]
    //acronimo
    let acronimo_frontier = $('#acronimo_frontier_edit')[0];
    //bw
    const bw_total_frontier = $('#bw_total_frontier')[0];

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

    $.ajax({
        type: "GET",
        url: getBaseURL() + 'frontera/' + id,
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function(data){

            frontier_number.value = data.frontera;
            frontier_number.setAttribute('disabled', 'true');

            $('#id_zone_edit').append('<option selected value="'+data.zona.value+'">'+ data.zona.description +'</option>');

            //input hidden con el id de la frontera para agarrarla en otras funciones
            $('#id_zone_edit').append('<option value="'+id+'" id="frontier_id"></option>');

            $('#id_zone_edit').attr('disabled', 'true');

            $('#equip_A_edit').append('<option selected value="'+data.equipos.equipo_a.id+'">'+ data.equipos.equipo_a.acronimo +'</option>');
            $('#equip_B_edit').append('<option selected value="'+data.equipos.equipo_b.id+'">'+ data.equipos.equipo_b.acronimo +'</option>');
            acronimo_frontier.value = data.acronimo;


            //cambiar select en el tipo de frontera
            function changeFrontierType(reference)
            {
                //deshabilitar input
                $('#id_type_frontier_edit').attr('disabled', 'true');

                if(reference === 'metro'){
                    $('#id_type_frontier_edit').append('<option selected value="1">Metro</option>')
                }
                if(reference === 'AL'){
                    $('#id_type_frontier_edit').append('<option selected value="2">AL</option>')
                }
            }

            //cambiar select en el tipo de servicio
            function changeServiceType(reference)
            {
                //deshabilitar input
                $('#id_type_service_edit').attr('disabled', 'true');

                if(reference === 'internet'){
                    $('#id_type_service_edit').append('<option selected value="1">Internet</option>')
                }
                if(reference === 'RPV'){
                    $('#id_type_service_edit').append('<option selected value="2">RPV</option>')
                }
                if(reference === 'movil'){
                    $('#id_type_service_edit').append('<option selected value="3">Móvil</option>')
                }
            }


            //condicionales de los tipos de servicio y de frontera
            const equipo_a = data.equipos.equipo_a;
            const equipo_b = data.equipos.equipo_b;
            const modelo_a = data.equipos.modelo_a;
            const modelo_b = data.equipos.modelo_b;

            //append de los datos de los equipos
            $('#equipment_data').append(
                `<input type="hidden" value="${equipo_a.id}" id="equipo_a_data">`+
                `<input type="hidden" value="${equipo_b.id}" id="equipo_b_data">`
            );

            function changeEquipmentTypeHTML(type_of_equipment_a, type_of_equipment_b){
                document.querySelector('.equip_type_A_edit').textContent = type_of_equipment_a;
                document.querySelector('.equip_type_B_edit').textContent = type_of_equipment_b;
            }

            if(modelo_a == 'PEI' && modelo_b == 'DM'){
                changeFrontierType('metro');
                changeServiceType('internet');
                changeEquipmentTypeHTML(modelo_a, modelo_b);
            }

            if(modelo_a == 'PE' && modelo_b == 'DM'){
                changeFrontierType('metro');
                changeServiceType('RPV');
                changeEquipmentTypeHTML(modelo_a, modelo_b);
            }

            if(modelo_a == 'PEI' && modelo_b == 'SAR'){
                changeFrontierType('AL');
                changeServiceType('internet');
                changeEquipmentTypeHTML(modelo_a, modelo_b);
            }

            if(modelo_a == 'PE' && modelo_b == 'SAR'){
                changeFrontierType('metro');
                changeServiceType('RPV');
                changeEquipmentTypeHTML(modelo_a, modelo_b);
            }

            if(modelo_a == 'DM' && modelo_b == 'SAR'){
                changeFrontierType('AL');
                changeServiceType('movil');
                changeEquipmentTypeHTML(modelo_a, modelo_b);
            }

            //nombres de las interfaces
            $('#interfaz_a_edit').val(data.interfaz_a);
            $('#interfaz_a_edit').attr('disabled', 'true');

            $('#interfaz_b_edit').val(data.interfaz_b);
            $('#interfaz_b_edit').attr('disabled', 'true');

            //nombre de los bundles
            let bundle_a = data.interfaz_a;
            let bundle_b = data.interfaz_b;

            private_get_ports(bundle_a, bundle_b);
        }
    })
}

const private_get_ports = function(bundle_a, bundle_b){
    const id_a = $('#equip_A_edit').find('option:selected').val();
    const id_b = $('#equip_B_edit').find('option:selected').val();

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});

    $.ajax({
        type: "GET",
        url: getBaseURL()+'puerto/equipo/get_ports',
        data:{
            id_a: id_a,
            id_b: id_b
        },
        dataType: 'json',
        cache: false,
        success: function(lacp_data){

            //vacias los campos antes de arrancar la funcion
            $("#ports_frontier_A_edit").empty();
            $("#ports_frontier_B_edit").empty();

            //agarro el grupo (lacp) que esta seleccionado para cada equipo
            let bundle_a_selected,
                bundle_b_selected,
                bundle_a_selected_port,
                bundle_b_selected_port,
                bw_value_a,
                bw_value_b;

            //imprimo los bw calculados de los lacp
            const lacp_a_field = $('#ports_frontier_A_edit');
            const lacp_b_field = $('#ports_frontier_B_edit');

            //imprimir la suma de los bw calculados
            let bw_a_int,
                bw_b_int;

            for(const lacp of lacp_data.lacp_a){
                if (lacp.commentary === bundle_a){
                    bundle_a_selected_port = lacp.port.split(' ');
                    bundle_a_selected = lacp;

                    //declaro el bw como integer
                    bw_a_int = lacp.bw_lacp_group.split('.');

                    //imprimo los bw calculados de los lacp
                    bw_value_a = `<span><i>Total:<strong>${lacp.bw_lacp_group}</strong></i></span>`;
                }
            }

            for(const lacp of lacp_data.lacp_b){
                if (lacp.commentary === bundle_b){
                    bundle_b_selected_port = lacp.port.split(' ');
                    bundle_b_selected = lacp;

                    //declaro el bw como integer
                    bw_b_int = lacp.bw_lacp_group.split('.');

                    //imprimo los bw calculados de los lacp
                    bw_value_b = `<span><i>Total:<strong>${lacp.bw_lacp_group}</strong></i></span>`;
                }
            }

            //imprimo el total bw de la frontera
            let total_bw;

            if(parseInt(bw_a_int)[0] > parseInt(bw_b_int)[0]){
                total_bw = `${bw_b_int}`;
            }

            if(parseInt(bw_a_int)[0] < parseInt(bw_b_int)[0]){
                total_bw = `${bw_a_int}`;
            }

            if(parseInt(bw_a_int)[0] === parseInt(bw_b_int)[0]){
                total_bw = `${bw_b_int}`;
            }

            $('#bw_total_frontier_edit').attr('placeholder', total_bw);

            //imprimo los puertos de ese lacp
            bundle_a_selected_port.forEach(el => {
                if(el.length !== 0){
                    let valor = "<input type='text' class='form-control' placeholder='' readonly aria-label='port' aria-describedby='basic-addon1' value='"+ el +"'>"
                    $("#ports_frontier_A_edit").append(valor);
                }
            })

            bundle_b_selected_port.forEach(el => {
                if(el.length !== 0){
                    let valor = "<input type='text' class='form-control' placeholder='' readonly aria-label='port' aria-describedby='basic-addon1' value='"+ el +"'>"
                    $("#ports_frontier_B_edit").append(valor);
                }
            })

            //imprimo los bw calculados de los lacp
            lacp_a_field.append(bw_value_a);
            lacp_b_field.append(bw_value_b);

            if(bw_value_a !== bw_value_b){
                toastr.warning("LOS VALORES DE BW SON DISTINTOS, REVISAR GRUPO LACP SELECCIONADO");
            }

            //vaciar los campos de puertos
            $("#cerrar_frontera_pop_edit").on('click', function(){
                $("#ports_frontier_A_edit").empty();
                $("#ports_frontier_B_edit").empty();
            })
        }
    })
}

//traigo los lacp partiendo de un equipo
function load_lacp_frontier_from_equipment_id(equipment_id, lacp_in_use){

    //oculto boton de nuevo lacp
    $('#new_lacp_boton').attr('style', 'display: none;');

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'puerto/equipo',
        data: {id:equipment_id},
        dataType: 'json',
        cache: false,
        success: function(data) {

            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#equip').val(id);
                    mensaje.textContent  = data['acronimo'];

                    $(data['group']).each(function(i, v){
                        //si la funcion es llamada antes de editar un lacp
                        if(typeof lacp_in_use === 'string' && lacp_in_use === data['group'][i]['commentary']){
                            var valor = '<tr>' +
                                '<td>' + data['group'][i]['lacp_number'] +'</td>' +
                                '<td>' + data['group'][i]['port'] + '</td>' +
                                '<td>' + data['group'][i]['atributo'] + '</td>' +
                                '<td>' + data['group'][i]['commentary'] + '</td>' +
                                '<td >'+
                                `<a data-toggle="modal" data-target="#port_lacp_sevice_pop" title="Editar LACP" onclick="edit_lacp(${equipment_id}, ${data['group'][i]['id']})"> <i class="fa fa-edit"></i></a>` +
                                '</td>'+
                                '</tr>';
                        }

                        //si la funcion es llamada luego de editar un lacp
                        if(typeof lacp_in_use === 'number' && lacp_in_use == data['group'][i]['id']){
                            var valor = '<tr>' +
                                '<td>' + data['group'][i]['lacp_number'] +'</td>' +
                                '<td>' + data['group'][i]['port'] + '</td>' +
                                '<td>' + data['group'][i]['atributo'] + '</td>' +
                                '<td>' + data['group'][i]['commentary'] + '</td>' +
                                '<td >'+
                                `<a data-toggle="modal" data-target="#port_lacp_sevice_pop" title="Editar LACP" onclick="edit_lacp(${equipment_id}, ${data['group'][i]['id']})"> <i class="fa fa-edit"></i></a>` +
                                '</td>'+
                                '</tr>';
                        }

                        $("#list_all_lacp_equipmen").append(valor);
                    })
                    if (data['group'].length == 0) {
                        var valor = '<tr>' +
                            '<td colspan="5"> <center> No tiene grupo </center></td>'+
                            '</tr>';
                        $("#list_all_lacp_equipmen").append(valor);
                    }
                    break;
            }
        }
    });
}


//obtener los lacp disponibles
function load_lacp_frontier_edit(type){
    $("#list_all_lacp_equipmen").html("");
    let id;
    let lacp_in_use;

    if(type == 0){
        id = $('#equip_A_edit').find('option:selected').val();
        lacp_in_use = $('#interfaz_a_edit').val()
    } else {
        id = $('#equip_B_edit').find('option:selected').val();
        lacp_in_use = $('#interfaz_b_edit').val()
    }

    $("#equip_to_work").val(type);

    //declaro el id del equipo, tomo una referencia del lacp en uso con el nombre de la interfaz y llamo la funcion que me carga los lacp segun un equipo
    load_lacp_frontier_from_equipment_id(id, lacp_in_use);

    //pintar los puertos y bw del "nuevo" lacp al cerrar el modal
    $('#cerrar_lacp_frontier').on('click', function(){

       //obtener el bw de los lacp correspondientes de cada equipo
        const frontier_id = $('#frontier_id').val();

        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "GET",
            url: getBaseURL() + 'frontera/' + frontier_id,
            data: {id:frontier_id},
            dataType: 'json',
            cache: false,
            success: function(data){
                //nombre de los bundles
                let bundle_a = data.interfaz_a;
                let bundle_b = data.interfaz_b;

                private_get_ports(bundle_a, bundle_b);
            }
        })

    });

}

function edit_lacp(equipment_id, lacp_id){

    let modal = document.getElementById("exit_port_lacp_sevi");
    let mensaje = document.getElementById("title_port_lacp");

    mensaje.textContent = 'EDITAR LACP';

    let actual_port;

    $('#come_lacp_equi').val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/recurso',
        data: {id:equipment_id, lacp_id: lacp_id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor

                        //si el puerto existe dentro del grupo lacp
                        if(data['datos'][i]['status'] === "PUERTO DEL LACP"){
                            valor = '<tr>' +
                                '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                                '<td>' + data['datos'][i]['model'] + '</td>' +
                                '<td>' + data['datos'][i]['servicios'] + '</td>' +
                                '<td > <input type="checkbox" checked id="por_lacp" name="por_lacp_edit[]" value="'+ data['datos'][i]['id_po_bo'] +'"></td>'+
                                '</tr>';
                        } else{
                            valor = '<tr>' +
                                '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                                '<td>' + data['datos'][i]['model'] + '</td>' +
                                '<td>' + data['datos'][i]['servicios'] + '</td>' +
                                '<td > <input type="checkbox" id="por_lacp" name="por_lacp_edit[]" value="'+ data['datos'][i]['id_po_bo'] +'"></td>'+
                                '</tr>';
                        }

                        const edit_input = '<input type="hidden" value="edit" id="edit_input">';

                        $("#port_lacp_sevice").append(valor);
                        //input para chequear si es un edit de lacp
                        $("#port_lacp_sevice").append(edit_input);
                    })

                    const edit = document.getElementById('edit_input');
                    if(edit){
                        const submit = document.getElementById("lacp_aceptar");
                        submit.onclick = function(){
                            let ports = [];
                            $('[name="por_lacp_edit[]"]:checked').each(function(){
                                ports.push(this.value);
                            });

                            $.ajax({
                                type: "POST",
                                url: getBaseURL() +'editar/lacp',
                                data: {ports: ports, lacp: lacp_id},
                                dataType: 'json',
                                cache: false,
                                success: function(data){
                                    //cerrar el modal y limpiar el campo de los puertos
                                    $("#list_all_lacp_equipmen").empty();
                                    $('#exit_port_lacp_sevi').click();

                                    load_lacp_frontier_from_equipment_id(equipment_id, lacp_id);

                                    toastr.success("Modificación del LACP Exitosa");
                                },
                                error: function (err){
                                    toastr.error("Error con el servidor");
                                }
                            })


                        }
                    }
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    cancelar.click();
                    break;
            }

            let cancelar = document.getElementById("lacp_cancelar");
            let cerrar = document.getElementById('exit_port_lacp_sevi');

            cancelar.onclick = function() {
                $("#port_lacp_sevice").empty();
                modal.click();
            }

            cerrar.onclick = function() {
                $("#port_lacp_sevice").empty();
                modal.click();
            }

        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

//editar acronimo

//buscar acronimo segun id de frontera y printearlo
function search_frontier_to_edit_acronimo(id){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "GET",
        url: getBaseURL() + 'frontera/' + id,
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function (data){
            $('#edit_frontier_acronimo').val(data.acronimo);

            //paso el id de la frontera en un input
            const frontier_id = `<input type="hidden" value="${id}" id="frontier_id_input">`;
            $('#edit_frontier_acronimo_parent').append(frontier_id);
        }
    })
}

//guardar nuevo acronimo
function save_new_acronimo(){

    let formData = new FormData;
    formData.append('frontier_id', document.getElementById('frontier_id_input').value);
    formData.append('acronimo', document.getElementById('edit_frontier_acronimo').value);

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() + 'frontera/editar-acronimo',
        data: formData,
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType
        cache: false,
        success: function (data){
            toastr.success("Modificación Exitosa");
            $('#cancelar_edit_acronimo').click();

            //recargo la pagina para mostrar los cambios ya que la funcion en jarvis_ajax para hacer la tabla no es una funcion que pueda llamar
            setTimeout(function(){
                location.reload();
            }, 1000);
        },
        error: function(err){
            console.log(err);
        }
    })
}
