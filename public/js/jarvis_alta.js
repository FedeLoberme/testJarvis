var nextinput = 0;
var position= [];
var label_exis= [];
var por_in_fin= [];
var placa_position= [];
function Agregarplaca(){
    var equi_alta = document.getElementById("equi_alta").value;
    if (equi_alta == '') {
        toastr.error("La funsion y el equipo es obligatorio.");
    }else{
        var url = getBaseURL() +'agregar/puerto';
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: url,
            data: {equi_alta:equi_alta},
            dataType: 'json',
            cache: false,
            success: function(data) {
                var new_tbody = document.createElement('tbody');
                $("#jarvis_new_placa_alta").html(new_tbody);
                if (data[0]['contar'] > 0) {
                    for (  i = 0 ; i <= data[0]['contar'] - 1 ; i++){
                        var valor = '<tr>' +
                            '<td>' + data[i].board + '</td>' +
                            '<td>' + data[i].port + '</td>' +
                            '<td>' + data[i].quantity + '</td>' +
                            '<td>' + data[i].port_i + '</td>' +
                            '<td>' + data[i].port_f + '</td>' +
                            '<td>' + data[i].label + '</td>' +
                            '<td><a data-toggle="modal" data-target="#etiquetas" > <i class="fa fa-check-square-o" onclick="sele_port('+equi_alta+','+data[i].id+');" title="seleccionar placa"> </i></a></td>' +
                            '</tr>';
                        $("#jarvis_new_placa_alta").append(valor)
                    }
                    $('#id_equipment_new').val(equi_alta);
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function sele_port(equip, port){
    $('#id_placa').val(port);
    var elemen1 = $("#elemen1");
    var elemen2 = $("#elemen2");
    var elemen3 = $("#elemen3");
    var elemen4 = $("#elemen4");
    elemen1.val('');
    elemen2.val('');
    elemen3.val('');
    elemen4.val('');
    var elemen1_camp = document.getElementById('elemen1_camp');
    var elemen2_camp = document.getElementById('elemen2_camp');
    var elemen3_camp = document.getElementById('elemen3_camp');
    var elemen4_camp = document.getElementById('elemen4_camp');
    $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'etiqueta/relacion',
        data: {equip:equip, port:port},
        dataType: 'json',
        cache: false,
        success: function(data) {
            var title1 = document.getElementById("elemen1_title");
            var title2 = document.getElementById("elemen2_title");
            var title3 = document.getElementById("elemen3_title");
            var title4 = document.getElementById("elemen4_title");
            $('#nom_placa').val(data[0]['board']);
            $('#serapador_alta').val(data[0]['separado']);
            $('#port_ini').val(data[0]['port_f_i']);
            $('#port_fin').val(data[0]['port_f_f']);
            $('#t_label').val(data[0]['id_label']);
            switch (data[0]['con']) {
                case 1:
                    title1.textContent  = data[0]['letra'];
                    elemen2_camp.style.display = "none";
                    elemen3_camp.style.display = "none";
                    elemen4_camp.style.display = "none";
                    elemen1_camp.style.display = "block";
                    elemen1.find('option').remove();
                    $(data[0]['margen']).each(function(i, v){ // indice, valor
                        elemen1.append(
                            '<option value="'+ data[0]['margen'][i] + '">' +  data[0]['margen'][i] + '</option>'
                        );
                    })
                    break;
                case 2:
                    title1.textContent  = data[0]['letra'];
                    title2.textContent  = data[1]['letra'];
                    elemen3_camp.style.display = "none";
                    elemen4_camp.style.display = "none";
                    elemen1_camp.style.display = "block";
                    elemen2_camp.style.display = "block";
                    elemen1.find('option').remove();
                    $(data[0]['margen']).each(function(i, v){ // indice, valor
                        elemen1.append(
                            '<option value="'+ data[0]['margen'][i] + '">' +  data[0]['margen'][i] + '</option>'
                        );
                    })
                    elemen2.find('option').remove();
                    $(data[1]['margen']).each(function(i, v){ // indice, valor
                        elemen2.append(
                            '<option value="'+ data[1]['margen'][i] + '">' +  data[1]['margen'][i] + '</option>'
                        );
                    })
                    break;
                case 3:
                    title1.textContent  = data[0]['letra'];
                    title2.textContent  = data[1]['letra'];
                    title3.textContent  = data[2]['letra'];
                    elemen4_camp.style.display = "none";
                    elemen1_camp.style.display = "block";
                    elemen2_camp.style.display = "block";
                    elemen3_camp.style.display = "block";
                    elemen1.find('option').remove();
                    $(data[0]['margen']).each(function(i, v){ // indice, valor
                        elemen1.append(
                            '<option value="'+ data[0]['margen'][i] + '">' +  data[0]['margen'][i] + '</option>'
                        );
                    })
                    elemen2.find('option').remove();
                    $(data[1]['margen']).each(function(i, v){ // indice, valor
                        elemen2.append(
                            '<option value="'+ data[1]['margen'][i] + '">' +  data[1]['margen'][i] + '</option>'
                        );
                    })
                    elemen3.find('option').remove();
                    $(data[2]['margen']).each(function(i, v){ // indice, valor
                        elemen3.append(
                            '<option value="'+ data[2]['margen'][i] + '">' +  data[2]['margen'][i] + '</option>'
                        );
                    })
                    break;
                case 4:
                    title1.textContent  = data[0]['letra'];
                    title2.textContent  = data[1]['letra'];
                    title3.textContent  = data[2]['letra'];
                    title4.textContent  = data[3]['letra'];
                    elemen1_camp.style.display = "block";
                    elemen2_camp.style.display = "block";
                    elemen3_camp.style.display = "block";
                    elemen4_camp.style.display = "block";
                    $(data[0]['margen']).each(function(i, v){ // indice, valor
                        elemen1.append(
                            '<option value="'+ data[0]['margen'][i] + '">' +  data[0]['margen'][i] + '</option>'
                        );
                    })
                    elemen2.find('option').remove();
                    $(data[1]['margen']).each(function(i, v){ // indice, valor
                        elemen2.append(
                            '<option value="'+ data[1]['margen'][i] + '">' +  data[1]['margen'][i] + '</option>'
                        );
                    })
                    elemen3.find('option').remove();
                    $(data[2]['margen']).each(function(i, v){ // indice, valor
                        elemen3.append(
                            '<option value="'+ data[2]['margen'][i] + '">' +  data[2]['margen'][i] + '</option>'
                        );
                    })
                    elemen4.find('option').remove();
                    $(data[3]['margen']).each(function(i, v){ // indice, valor
                        elemen4.append(
                            '<option value="'+ data[3]['margen'][i] + '">' +  data[3]['margen'][i] + '</option>'
                        );
                    })
                    break;
                case 0:
                    elemen1_camp.style.display = "none";
                    elemen2_camp.style.display = "none";
                    elemen3_camp.style.display = "none";
                    elemen4_camp.style.display = "none";
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function AgregarCampos(){
    var modal = document.getElementById("exit_alta");
    var modal2 = document.getElementById("exit_alta_table");
    var serapador_alta = document.getElementById('serapador_alta').value;
    var nom_placa = document.getElementById('nom_placa').value;
    var id_placa = document.getElementById('id_placa').value;
    var elemen1 = document.getElementById('elemen1').value;
    var elemen2 = document.getElementById('elemen2').value;
    var elemen3 = document.getElementById('elemen3').value;
    var elemen4 = document.getElementById('elemen4').value;
    var port_ini = document.getElementById('port_ini').value;
    var port_fin = document.getElementById('port_fin').value;
    var t_label = document.getElementById('t_label').value;
    var resul = 'NO';
    var apro = 'yes';
    var placa_pose_all = document.getElementsByClassName("placa_alta_eliminar");
    var valores =[];
    for (var i = 0; i < placa_pose_all.length; ++i) {
        if (typeof placa_pose_all[i].value !== "undefined") {
            var all = placa_pose_all[i].value.split('~');
            valores.push({pose: all[0], placa: all[1], label: all[2], p_ini: all[3], p_fin: all[4]});
        }
    }
    if (elemen1 != '') {
        var etiqueta = elemen1;
        var mostrar = elemen1;
        var pos1 = elemen1.split(':');
        var position_all= pos1[1];
        if (elemen2 != '') {
            etiqueta = etiqueta +'|'+elemen2 ;
            var pos2 = elemen2.split(':');
            position_all = position_all +'?'+pos2[1];
            if (elemen3 != '') {
                etiqueta = etiqueta +'|'+elemen3 ;
                var pos3 = elemen3.split(':');
                position_all = position_all +'?'+pos3[1];
                if (elemen4 != '') {
                    etiqueta = etiqueta +'|'+elemen4 ;
                    var pos4 = elemen4.split(':');
                    position_all = position_all +'?'+pos4[1];
                }
            }
        }
        if (elemen2 != '') {
            mostrar = mostrar +' '+serapador_alta+' '+elemen2 ;
            if (elemen3 != '') {
                mostrar = mostrar+' '+serapador_alta+' '+elemen3 ;
                if (elemen4 != '') {
                    mostrar = mostrar+' '+serapador_alta+' '+elemen4 ;
                }
            }
        }
    }else{
        var position_all = 'na'
        var etiqueta = 0;
        var mostrar = 'default';
    }
    if (valores == '') {
        apro = 'yes'
    }else{
        $(valores).each(function(i, v){ // indice, valor
            if (valores[i].pose == etiqueta) {
                if (valores[i].placa == nom_placa) {
                    if (valores[i].p_ini > port_ini && valores[i].p_fin > port_ini) {
                        resul = 'SI';
                    }else{
                        if (valores[i].label != t_label) {
                            resul = 'SI';
                        }else{
                            if (valores[i].p_ini < port_ini && valores[i].p_ini < port_fin) {
                                resul = 'SI';
                            }else{
                                resul = 'NO';
                            }
                        }
                    }
                }else{
                    resul = 'NO';
                }
            }else{
                resul = 'SI';
            }
            if (resul == 'NO') {
                apro = 'not'
            }
        })
    }

    if (apro == 'yes') {
        valores.push({pose: etiqueta, placa: nom_placa, label: t_label, p_ini: port_ini, p_fin: port_fin});
        var eli = etiqueta+'~'+nom_placa+'~'+t_label+'~'+port_ini+'~'+port_fin;
        var data = id_placa+','+etiqueta+'|'+serapador_alta;
        var ver = mostrar+'  '+nom_placa+ ' P. inicial: '+port_ini +' P.final: '+port_fin;
        nextinput++;
        campo = '<div class="bw_all " id="input'+nextinput+'" > <input type="text" id="placa_m[' + nextinput + ']" name="placa_m[' + nextinput + ']" readonly="readonly" class="form-control" value="'+ver+'">     <a class="ico_input btn btn-info" onclick="quitar_placa('+nextinput+');"><i class="fa fa-trash" title="Quitar placa"> </i> Quitar</a>       <input type="hidden" class="placa_alta" id="placa_alta[' + nextinput + ']" name="placa_alta[' + nextinput + ']" value="'+data+'">          <input type="hidden" class="placa_alta_eliminar" id="placa_alta_eli[' + nextinput + ']" name="placa_alta_eli[' + nextinput + ']" value="'+eli+'">    </div>';
        $("#campos").append(campo);
        modal.click();
        modal2.click();
    }else{
        toastr.error("Esta posición ya esta ocupada");
    }
}

function quitar_placa(nextinput) {
    $('#input'+nextinput).remove();
}

function detal_client(){
    $('#alta_equipo #client_id').val('');
    $('#alta_equipo #client').val('');
}

function selec_client(id){
    $("#client").find('option').remove();
    $("#id_client_servi").find('option').remove();
    $("#atributo_ip_rese").find('option').remove();
    $("#edi_client").find('option').remove();
    $("#edic_client_sub_red").find('option').remove();
    if (id != null) {
        var cerrar = document.getElementById('cerra_bus_clien');
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/cliente',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#client").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#id_client_servi").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#client_sub_red").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#atributo_ip_rese").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#edi_client").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#edic_client_sub_red").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        break;
                    case "nop":
                        $("#client").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
                        $("#id_client_servi").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
                        $("#client_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
                        $("#atributo_ip_rese").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
                        $("#edi_client").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
                        $("#edic_client_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
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
    }else{
        selec.append('<option selected disabled value="">seleccionar</option>');
        servi.append('<option selected disabled value="">seleccionar</option>');
    }
}

function selec_client_lsw(id){
    $("#client_lsw").find('option').remove();
    if (id != null) {
        var cerrar = document.getElementById('cerra_bus_clien');
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/cliente',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#client_lsw").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        break;
                    case "nop":
                        $("#client_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
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
    }else{
        $("#client_lsw").append('<option selected disabled value="">seleccionar</option>');
    }
}

function mostrar_client() {
    var social = $("#client").val();
    if(social.length > 0 && social != "0") {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: "../buscar/cliente",
            data: {social:social},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'sip') {
                    $('#alta_equipo #Razon').text('');
                    $('#alta_equipo #client').text('');
                    $('#alta_equipo #client_id').text('');
                    $('#alta_equipo #Razon').text('Cliente Registrado');
                    $('#alta_equipo #client').text(data['name']);
                    $('#alta_equipo #client_id').text(data['name']);
                }else{
                    $('#alta_equipo #client_id').val('');
                    $('#alta_equipo #Razon').text('');
                    $('#alta_equipo #Razon').text('Cliente no Existe');
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#alta_equipo #client_id').text('');
        $('#alta_equipo #Razon').text('');
    }
}

function EquipmentBoard(){
    var equi_alta = document.getElementById("equi_alta").value;
    var agregador = document.getElementById("agregador");
    var all_board = document.getElementById("all_board");
    var img = document.getElementById("img_alta_equipo");
    var id_agg = document.getElementById("id_equipos").value;
    if (equi_alta != '' && id_agg == 0) {
        img.style.display = "block";
        all_board.style.display = "block";
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/puerto',
            data: {equi_alta:equi_alta},
            dataType: 'json',
            cache: false,
            success: function(data) {
                var capos_in = document.createElement('div');
                $("#campos").html(capos_in);
                if (data[0]['contar'] != 0) {
                    nextinput = 0;
                    position = [];
                    $(data).each(function(i, v){ // indice, valor
                        var datos = data[i]['id']+','+data[i]['label'];
                        var ver =  data[i]['board']+' P. inicial: '+data[i]['port_l_i']+' P. final: '+data[i]['port_l_f']+' Label: '+data[i]['label2'];
                        nextinput++;
                        campo = '<div class="bw_all" style="margin-bottom: 5px;" id="input'+nextinput+'" > <input type="text" id="placa_mos[' + nextinput + ']" name="placa_mos[' + nextinput + ']" readonly="readonly" class="form-control" value="'+ver+'">    <input type="hidden" class="placa_alta" id="placa_alta[' + nextinput + ']" name="placa_alta[' + nextinput + ']" value="'+datos+'"></div>';
                        $("#campos").append(campo);
                    })
                }
                if (data[0]['otras'] == 'yes') {
                    agregador.style.display = "block";
                }else{
                    agregador.style.display = "none";
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        all_board.style.display = "none";
        img.style.display = "none";
    }
}

function search_nodo(id){
    $('#pantalla').val('');
    var mensaje = document.getElementById("title_nodo");
    mensaje.textContent = 'MODIFICAR NODO';
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/nodo',
        headers: { 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        data: { id:id },
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'yes':
                    $('#id_nodo').val(id);
                    $('#cell_id').val(data['cell_id']);
                    $('#nodo').val(data['nodo']);
                    selec_address(data['address'],0);
                    $('#commenta').val(data['commentary']);
                    $('#propi').val(data['owner']);
                    $('#statu').val(data['status']);
                    $('#type').val(data['type']).trigger('change.select2');
                    $('#date').val(data['contract_date']);
                    break;
                case 'home':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.success("Cliente no encontrado");
                    break;
                default:
                    refresh();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_nodo(){
    var mensaje = document.getElementById("title_nodo");
    mensaje.textContent  = 'CREAR NODO';
    var id_nodo = document.getElementById("id_nodo").value;
    document.getElementById("nodo_new").reset();
    $('#id_nodo').val(0);
    $('#address').val('').trigger('change.select2');
}

function insert_update_nodo(){
    var id_nodo = document.getElementById("id_nodo").value;
    var functi = document.getElementById("id_function").value;
    var cell_id = document.getElementById("cell_id").value.toUpperCase().trim();
    var commen = document.getElementById("commenta").value;
    var nodo = document.getElementById("nodo").value.toUpperCase().trim();
    var address = document.getElementById("address").value.toUpperCase().trim();
    var date = document.getElementById("date").value;
    var type = document.getElementById("type").value;
    var propi = document.getElementById("propi").value;
    var status = document.getElementById("statu").value;
    var modal = document.getElementById("cerrar_nodo_all");
    address_new = address.replace(/\s{2,}/g, ' ');
    nodo_new = nodo.replace(/\s{2,}/g, ' ');
    cell_id_new = cell_id.replace(/\s{2,}/g, ' ');
    if (cell_id == "" || cell_id.length < 1) {
        toastr.error("El CELL ID es obligatorio.");
    } else if (nodo == "" || nodo.length < 1) {
        toastr.error("El Nodo es obligatorio.");
    } else if (type == 'ALQUILADO' && propi.length < 1) {
        toastr.error("El Propietario es obligatorio.");
    } else if (type == 'ALQUILADO' && date.length < 1) {
        toastr.error("La Fecha del contrato es obligatoria.");
    } else {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/nodo',
            data: { id_nodo:id_nodo, cell_id:cell_id, nodo:nodo, address:address, date:date, type:type, propi:propi, commen:commen, status:status },
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        console.log(data['datos']);
                        break;
                    case "exis":
                        toastr.error("El  CELL ID ya Existe.");
                        break;
                    case "yes":
                        if (id_nodo == 0) {
                            toastr.success("Registro Exitoso");
                            if (functi != 'Nodo') {
                                $("#nodo_al").find('option').remove();
                                $("#nodo_al").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
                                $(data['datos']).each(function(i, v){
                                    $("#nodo_al").append('<option value="'+ data['datos'][i]['id'] + '">' +  data['datos'][i]['node'] +' ' +  data['datos'][i]['cell_id']+'</option>');
                                })
                                $('#list_all_node').DataTable().ajax.reload();
                            }else{
                                $('#nodo_list').DataTable().ajax.reload();
                            }
                        }else{
                            toastr.success("Modificación Exitosa");
                            $('#nodo_list').DataTable().ajax.reload();
                        }
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function selec_lista(id, list){
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/lista',
        data: {id:id, list:list},
        dataType: 'json',
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
                    toastr.error("Error al buscar los datos");
                    break;
                case "ip_exi":
                    toastr.error("IP no disponible");
                    break;
                case "yes":
                    $('#name_lis').val(data['data']['name']);
                    $('#list_id').val(data['data']['id']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function alta_agg_crear(){
    var mensaje = document.getElementById("title_agg");
    var all_board = document.getElementById("all_board");
    var acro_input = document.getElementById("acro_input");
    var aceptar = document.getElementById("alta_agg_pop");
    var cancelar = document.getElementById("baja_agg_pop");
    var modal = document.getElementById("cerra_agg_pop");
    mensaje.textContent  = 'REGISTRAR AGREGADOR';
    document.getElementById("alta_agredador").reset();
    $("#equi_alta").find('option').remove();
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").find('option').remove();
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#nodo_al").find('option').remove();
    $("#nodo_al").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "block";
    all_board.style.display = "none";
    acro_input.style.display = "block";
    $('#id_equipos').val('0');
    aceptar.onclick = function() {
        var equi_alta = document.getElementById("equi_alta").value;
        var nodo_al = document.getElementById("nodo_al").value;
        var name = document.getElementById("name_agg").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var commen = document.getElementById("commen").value;
        var alta = document.getElementById("alta").value;
        var id_function = document.getElementById("id_function").value;
        var placa_alta = document.getElementsByClassName("placa_alta");
        var acronimo = document.getElementById("name_agg_anillo").value;
        var functi = document.getElementById("functi").value;
        var local = document.getElementById("local_equipmen").value;
        var port = [];
        for (var i = 0; i < placa_alta.length; ++i) {
            if (typeof placa_alta[i].value !== "undefined") {
                port.push(placa_alta[i].value);
            }
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/agregador',
            data: {equi_alta:equi_alta, nodo_al:nodo_al, name:name, ip_admin:ip_admin, commen:commen, alta:alta, port:port, id:0, acronimo:acronimo, local:local},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del agregador ya Existe");
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        if (functi == "anillo") {
                            nodo_agg_alta();
                        }else{
                            $('#claro_agregador').DataTable().ajax.reload();
                        }
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function alta_cpe_crear(){
    var boton = document.getElementById('boton_buscar_equipo_all');
    var aceptar = document.getElementById("alta_cpe_pop");
    var cancelar = document.getElementById("baja_cpe_pop");
    var modal = document.getElementById("cerra_cpe_pop");
    boton.style.display = "block";
    $('#title_cpe').text('REGISTRAR ROUTER');
    document.getElementById("alta_cpe").reset();
    $('#acro').removeAttr('disabled');
    $('#id_equipos').val('0');
    $('#rpv').val('').trigger('change.select2');
    $('#sitio').val('').trigger('change.select2');
    $("#equi_alta").find('option').remove();
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#client").find('option').remove();
    $("#client").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    aceptar.onclick = function() {
        var client = document.getElementById("client").value;
        var management = document.getElementById("management").value;
        var equi_alta = document.getElementById("equi_alta").value;
        var nodo_al = document.getElementById("nodo_al").value;
        var name = document.getElementById("acro").value;
        var rpv = document.getElementById("rpv").value;
        var sitio = document.getElementById("sitio").value;
        var ip_wan = document.getElementById("ip_wan").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var direc = document.getElementById("direc").value;
        var commen = document.getElementById("commentary").value;
        var alta = document.getElementById("ir_alta").value;
        var id_function = document.getElementById("id_function").value;
        var local = document.getElementById("local_equipmen").value;
        var enlace = document.getElementById("enlace").value;
        var placa_alta = document.getElementsByClassName("placa_alta");
        var port = [];
        for (var i = 0; i < placa_alta.length; ++i) {
            if (typeof placa_alta[i].value !== "undefined") {
                port.push(placa_alta[i].value);
            }
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/cpe',
            data: {client:client, name:name, rpv:rpv, sitio:sitio, ip_wan:ip_wan, ip_admin:ip_admin, nodo_al:nodo_al, direc:direc, equi_alta:equi_alta, port:port, id_function:id_function, id_cpe:0, alta:alta, commen:commen, management:management, local:local, enlace:enlace},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del agregador ya Existe");
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        $('#cpe_list').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_agg(id){
    var mensaje = document.getElementById("title_agg");
    mensaje.textContent = 'MODIFICAR AGREGADOR';
    var aceptar = document.getElementById("alta_agg_pop");
    var cancelar = document.getElementById("baja_agg_pop");
    var modal = document.getElementById("cerra_agg_pop");
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    var acro_input = document.getElementById("acro_input");
    acro_input.style.display = "none";
    $('#id_agg').val(id);
    $('#id_equipos').val(id);
    $("#nodo_al").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#equi_alta").find('option').remove();
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("Error al guardar los datos");
                    break;
                default:
                    $('#local_equipmen').val(data['datos']['location']);
                    $("#equi_alta").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    $('#name_agg').val(data['datos']['acronimo']);
                    $('#ip').val(data['datos']['id_ip']);
                    $('#commen').val(data['datos']['commentary']);
                    $('#alta').val(data['datos']['ir_os_up']);
                    $("#ip_admin").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var equi_alta = document.getElementById("equi_alta").value;
        var nodo_al = document.getElementById("nodo_al").value;
        var name = document.getElementById("name_agg").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var commen = document.getElementById("commen").value;
        var alta = document.getElementById("alta").value;
        var id_function = document.getElementById("id_function").value;
        var placa_alta = document.getElementsByClassName("placa_alta");
        var functi = document.getElementById("functi").value;
        var local = document.getElementById("local_equipmen").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/agregador',
            data: {equi_alta:equi_alta, nodo_al:nodo_al, name:name, ip_admin:ip_admin, commen:commen, alta:alta, port:0, id:id, acronimo:0, local:local},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del agregador ya Existe");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#claro_agregador').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function redireccionarPagina(fun) {
    var url = getBaseURL() +'ver/'+fun;
    window.location = url;
}

function lugar_nodo(){
    var type = document.getElementById('type').value;
    var propi2 = document.getElementById('propi2');
    var fecha = document.getElementById('fecha');
    switch (type) {
        case "PROPIO":
            propi2.style.display = "none";
            fecha.style.display = "none";
            $('#propi').val('');
            $('#date').val('');
            break;
        case "ALQUILADO":
            propi2.style.display = "block";
            fecha.style.display = "block";
            break;
        case "COUBICACION":
            propi2.style.display = "block";
            fecha.style.display = "block";
            $('#date').val('');
            break;
    }
}

function search_cpe(id){
    var modal = document.getElementById("cerra_cpe_pop");
    var mensaje = document.getElementById("title_cpe");
    var aceptar = document.getElementById("alta_cpe_pop");
    var cancelar = document.getElementById("baja_cpe_pop");
    mensaje.textContent = 'MODIFICAR ROUTER';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    $('#id_equipos').val(id);
    var ip_rpv_all = document.getElementById('ip_rpv_all');
    var ip_all = document.getElementById('ip_all');
    var direc_all = document.getElementById('direc_all');
    var nodo_all = document.getElementById('nodo_all');
    $("#client").find('option').remove();
    $("#direc").find('option').remove();
    $("#nodo_al").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#equi_alta").find('option').remove();
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("Error. Equipo no encontrado");
                    break;
                default:
                    $("#equi_alta").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $("#client").append('<option selected disabled value="'+data['datos']['id_client']+'">'+data['datos']['client']+' '+data['datos']['cuit']+' '+data['datos']['business_name']+'</option>').trigger('change.select2');
                    $('#acro').val(data['datos']['acronimo']);
                    //$('#acro').attr('disabled', '');
                    if (data['datos']['ip_wan_rpv'] == null) {
                        $('#rpv').val('No');
                        ip_rpv_all.style.display = "none";
                        ip_all.style.display = "block";
                    }else{
                        ip_rpv_all.style.display = "block";
                        ip_all.style.display = "none";
                        $('#rpv').val('Si');
                    }
                    if (data['datos']['id_nodo'] == null) {
                        $('#sitio').val('Si');
                        direc_all.style.display = "block";
                        nodo_all.style.display = "none";
                        $("#direc").append('<option selected disabled value="'+data['datos']['address']+'">'+data['datos']['direcc']+'</option>').trigger('change.select2');
                    }else{
                        $('#sitio').val('No');
                        direc_all.style.display = "none";
                        nodo_all.style.display = "block";
                        $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    }
                    $('#ip_wan').val(data['datos']['ip_wan_rpv']);
                    $('#ir_alta').val(data['datos']['ir_os_up']);
                    $('#commentary').val(data['datos']['commentary']);
                    $('#management').val(data['datos']['client_management']);
                    $('#local_equipmen').val(data['datos']['location']);
                    $('#enlace').val(data['datos']['service']);
                    $("#ip_admin").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var client = document.getElementById("client").value;
        var management = document.getElementById("management").value;
        var equi_alta = document.getElementById("equi_alta").value;
        var nodo_al = document.getElementById("nodo_al").value;
        var name = document.getElementById("acro").value;
        console.log(name);
        var rpv = document.getElementById("rpv").value;
        var sitio = document.getElementById("sitio").value;
        var ip_wan = document.getElementById("ip_wan").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var direc = document.getElementById("direc").value;
        var commen = document.getElementById("commentary").value;
        var alta = document.getElementById("ir_alta").value;
        var id_function = document.getElementById("id_function").value;
        var local = document.getElementById("local_equipmen").value;
        var enlace = document.getElementById("enlace").value;
        var placa_alta = document.getElementsByClassName("placa_alta");
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/cpe',
            data: {client:client, name:name, rpv:rpv, sitio:sitio, ip_wan:ip_wan, ip_admin:ip_admin, nodo_al:nodo_al, direc:direc, equi_alta:equi_alta, port:0, id_function:id_function, id_cpe:id, alta:alta, commen:commen, management:management, local:local, enlace:enlace},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del agregador ya Existe");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#cpe_list').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_acronimo_agg(id){
    $('#id_agg_pop').val(id);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'lista/acronimo';
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    var new_tbody = document.createElement('tbody');
                    $("#lis_acro_agg").html(new_tbody);
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay acronimo disponible en este agregador");
                    }else{
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i].name + '</td>' +
                                '<td> <center><a data-toggle="modal" data-target="#lis_acronimo_agg" > <i class="fa fa-edit" onclick="search_acronimo_agg_edic('+data['datos'][i].id+');" title="Editar acronimo"> </i></a></center></td>' +
                                '</tr>';
                            $("#lis_acro_agg").append(valor)
                        });
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function agg_crear_acronimo(){
    var mensaje = document.getElementById("msj_list_agg");
    mensaje.textContent  = 'REGISTRAR ACRONIMO';
    var id_agg_pop = document.getElementById('id_agg_pop').value;
    $('#id_agg_acro').val(id_agg_pop);
    $('#acroni_agg').val('');
    $('#id_agg_edic').val('0');
    $('#id_rela').val('0');
}

function new_acron_agg (){
    var id_agg_acro = document.getElementById('id_agg_acro').value;
    var acroni_agg = document.getElementById('acroni_agg').value;
    var id_agg_edic = document.getElementById('id_agg_edic').value;
    var acro_pop_cer = document.getElementById('acro_pop_cer');
    var id_rela = document.getElementById('id_rela').value;
    acroni_agg = acroni_agg.toUpperCase();
    acroni_agg = acroni_agg.trim();
    acroni_new = acroni_agg.replace(/\s{2,}/g, ' ');
    if (acroni_new == '' ){
        toastr.error("El Acronimo es obligatorio.");
    }else{
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        var url = getBaseURL() +'registar/acronimo';
        $.ajax({
            type: "POST",
            url: url,
            data: {id_agg_acro:id_agg_acro, acroni_new:acroni_new, id_agg_edic:id_agg_edic, id_rela:id_rela},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'login') {
                    refresh();
                }else{
                    if (data['resul'] == 'autori') {
                        toastr.error("Usuario no autorizado");
                    }else{
                        if (data['resul'] == 'nop') {
                            toastr.error("Error al guardar los datos");
                        }else{
                            if (data['resul'] == 'exis') {
                                toastr.error("Existe este acronimo en el agregador");
                            }else{
                                search_acronimo_agg(id_agg_acro);
                                if (id_agg_edic == 0) {
                                    toastr.success("Registro Exitoso");
                                }else{
                                    toastr.success("Modificación Exitosa");
                                }
                                acro_pop_cer.click();
                            }
                        }
                    }
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });

    }
}

function search_acronimo_agg_edic(id_relati){
    var mensaje = document.getElementById("msj_list_agg");
    var msj_list = 'MODIFICAR ACRONIMO';
    mensaje.textContent  = msj_list;
    var id_agg_pop = document.getElementById('id_agg_pop').value;
    $('#id_agg_acro').val(id_agg_pop);
    $('#id_rela').val(id_relati);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'buscar/relacion';
    $.ajax({
        type: "POST",
        url: url,
        data: {id_relati:id_relati},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("Error al guardar los datos");
                    }else{
                        $('#id_agg_edic').val(data['datos'][0]['id_agg_acronimo']);
                        $('#acroni_agg').val(data['datos'][0]['name']);
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function inf_equip_agg(id){
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/placa',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("Error al guardar los datos");
                    }else{
                        var new_tbody = document.createElement('tbody');
                        $("#placa_asignada_body").html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i].slot + '</td>' +
                                '<td>' + data['datos'][i].board + '</td>' +
                                '<td>' + data['datos'][i].port + '</td>' +
                                '<td>' + data['datos'][i].quantity + '</td>' +
                                '</tr>';
                            $("#placa_asignada_body").append(valor)
                        });
                        $('#equip_title').text(data['datos'][0]['acronimo']);
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function validation_rama(){
    var modal = document.getElementById("cerrar_pop_rama");
    var rama = document.getElementById("rama").value;
    rama = rama.toUpperCase();
    rama = rama.trim();
    rama_new = rama.replace(/\s{2,}/g, ' ');
    var rango = document.getElementById("rango").value;
    var descrit = document.getElementById("descrit").value;
    descrit = descrit.toUpperCase();
    descrit = descrit.trim();
    descrit_new = descrit.replace(/\s{2,}/g, ' ');
    var id_rama = document.getElementById("id_rama").value;
    var padre = document.getElementById("padre").value;
    var type = document.getElementById("type").value;
    var ip_rama = document.getElementById("ip_rama").value;
    var pre = document.getElementById("pre").value;
    if (rama_new == '' || rama_new.length == 0 ) {
        toastr.error("El Nombre es obligatorio.");
    }else if (rango == '' || rango.length == 0 ) {
        toastr.error("El Rango es obligatorio.");
    }else if ((type == '' || type.length == 0 ) && rango =='Si') {
        toastr.error("El Tipo de IP es obligatorio.");
    }else if ((ip_rama == '' || ip_rama.length == 0 ) && rango =='Si') {
        toastr.error("La IP es obligatorio.");
    }else if ((pre == '' || pre.length == 0 ) && rango =='Si') {
        toastr.error("El Prefijo es obligatorio.");
    }else if (descrit_new == '' || descrit_new.length == 0) {
        toastr.error("La Descripción es obligatorio.");
    }else{
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registar/rama',
            data: {rama_new:rama_new, rango:rango, descrit_new:descrit_new, id_rama:id_rama, padre:padre, type:type, ip_rama:ip_rama, pre:pre},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'nop':
                        toastr.error("Error al guardar los datos");
                        break;
                    case 'impo':
                        toastr.error("Inconsistencia en los datos");
                        break;
                    case 'exis':
                        toastr.error("El rango ya existe en esta rama");
                        break;
                    default:
                        if (id_rama == 0) {
                            toastr.success("Registro Exitoso");
                        }else{
                            toastr.success("Modificación Exitosa");
                        }
                        if (padre == 0) {
                            var int=self.setInterval('refresh()',700);
                        }else{
                            eliminar_mas_rama(padre);
                            limpiar_rama(padre);
                            ver_mas_rama(padre);
                            modal.click();
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function modificar_rama(id){
    var mensaje = document.getElementById("rama_title");
    var msj_list = 'MODIFICAR RAMA';
    mensaje.textContent  = msj_list;
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'buscar/rama';
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("Error al guardar los datos");
                    }else{
                        $('#id_rama').val(id);
                        $('#rama').val(data['name']);
                        $('#padre').val(data['id_padre']);
                        $('#rango').val(data['rank']).trigger('change.select2');
                        $('#descrit').val(data['description']);
                        $('#rango').attr('disabled', '');
                        if (data['rank'] == 'Si') {
                            $('#type').val(data['type']);
                            $('#ip_rama').val(data['ip']);
                            $('#id_ip_edi').val(data['edi_ip']);
                            $('#pre').val(data['prefixes']);
                            if (data['ip_hijo'] != null) {
                                $('#type').attr('disabled', '');
                                $('#ip_rama').attr('disabled', '');
                                $('#pre').attr('disabled', '');
                            }else{
                                $('#type').removeAttr('disabled');
                                $('#ip_rama').removeAttr('disabled');
                                $('#pre').removeAttr('disabled');
                            }
                        }else{
                            $('#type').val('');
                            $('#ip_rama').val('');
                            $('#pre').val('');
                        }
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function ver_mas_rama(id){
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'mas/rama',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("No hay datos para este grupo");
                    break;
                default:
                    var aler = 0;
                    $('#id_rango_old').val(data['es_rango']);
                    $('#id_rama_old').val(id);
                    if (positivo != null) {
                        positivo.style.display = "none";
                        negativo.style.display = "block";
                    }
                    $(data['datos']).each(function(i, v){
                        if (data['datos'][i].permi != 0) {
                            var valor = '<ul>';
                            if (data['datos'][i].rank != 'Si') {
                                valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="ver_mas_rama('+data['datos'][i].id+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_mas_rama('+data['datos'][i].id+');"></i></li>' +
                                    '<li>-<i class="fa fa-database"></i></li> ';
                            }else{
                                valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="rango_rama_list('+data['datos'][i].id+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_rango_rama_list('+data['datos'][i].id+');"></i></li>' +
                                    '<li>-<i class="fa fa-file-archive-o"></i></li> ';
                            }
                            valor +=    '<li>  ' + data['datos'][i].name + ' ' + data['datos'][i].ip_rank +'' + data['datos'][i].barra+ '</li>';
                            if (data['datos'][i].permi >= 10) {
                                valor += '<li title="Modificar Rama"> <i class="fa fa-edit" data-toggle="modal" data-target="#popcrear_rama"onclick="modificar_rama('+data['datos'][i].id+');"></i></li>';
                            }
                            if (data['datos'][i].rank == 'Si'){
                                if (data['datos'][i].permi >= 10) {
                                    valor += '<span class=' + data['datos'][i].color +'></span>';
                                    valor += '<li title="Crear Toda La SubRed"> <i class="fa fa-code-fork" data-toggle="modal" data-target="#pop_sub_red_all" onclick="crear_sub_red_all('+data['datos'][i].id+');"></i></li>';
                                }
                                valor += '<li title="Crear SubRed"> <i class="fa fa-sitemap" data-toggle="modal" data-target="#popcrear_red"onclick="crear_sub_red('+data['datos'][i].id+');"></i></li>' +
                                    '<li title="Eliminar SubRed"> <i class="fa fa-window-close" data-toggle="modal" data-target="#popeliminar"onclick="eliminar_sub_red('+data['datos'][i].id+');"></i></li>';
                                if (data['permi'] == 1) {
                                    valor += '<li title="Eliminar Rama"> <i class="fa fa-trash" onclick="eliminar_rama('+data['datos'][i].id+');"></i></li>';
                                }
                                valor +='</ul>';
                            }else{
                                if(data['datos'][i].padre == 0) {
                                    if (data['datos'][i].permi >= 10) {
                                        valor += '<li title="Crear Rama Hijo">  <i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_multi('+data['datos'][i].id+');"></i></li>';
                                    }
                                    valor += '</ul>';
                                }else{
                                    if (data['datos'][i].hijo == 1) {
                                        if (data['datos'][i].permi >= 10) {
                                            valor += '<li title="Crear Rama Hijo">  <i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_rank('+data['datos'][i].id+');"></i></li>';
                                        }
                                        valor += '</ul>';
                                    }else{
                                        if (data['datos'][i].permi >= 10) {
                                            valor += '<li title="Crear Rama Hijo">  <i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_sin_rank('+data['datos'][i].id+');"></i></li>';
                                        }
                                        valor += '</ul>';
                                    }
                                }
                            }
                            $("#contenedor"+id).append(valor)
                            var table = '<div><table class="table_ramas hijos" style="margin-left: 20px;" id="contenedor'+data['datos'][i].id+'"></table></div>';
                            $("#contenedor"+id+"").append(table)
                            aler = 1;
                        }else{
                            if (data['canti']==[i] && aler == 0) {
                                toastr.error("Usuario no autorizado");
                                positivo.style.display = "block";
                                negativo.style.display = "none";
                            }
                        }
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function eliminar_sub_red(id){
    $('#id_red').val(id);
    var rango = $("#rango_exis");
    rango.find('option').remove();
    rango.append('<option selected disabled value="">seleccionar</option>');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'subred/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case 'yes':
                    $(data['datos']).each(function(i, v){ // indice, valor
                        rango.append(
                            '<option value="'+ data['datos'][i]['id'] + '">' +  data['datos'][i]['ip'] +'/'+  data['datos'][i]['prefixes']+'</option>'
                        );
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function eliminar_rango_listo(){
    var id_red = document.getElementById("id_red").value;
    var id = document.getElementById("rango_exis").value;
    var modal = document.getElementById("cerrar_eliminar");
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'liberar/rango',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "No":
                    toastr.error("Rango no Existe");
                    break;
                case "relation":
                    toastr.error("Almeno uno IP esta siendo utilizada");
                    break;
                case 'yes':
                    eliminar_rango_rama_list(id_red);
                    modal.click();
                    toastr.success("Rango liberado Exitosamente");
                    $('#id_red').val('0');
                    $('#rango_exis').val('').trigger('change.select2');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_sub_red(id){
    var id_red = document.getElementById("id_red").value;
    if (id != id_red) {
        vaciar_sub_red();
    }
    $('#id_red').val(id);
}

function vaciar_sub_red(){
    $('#ip_mascara1').val('');
    $('#ip_mascara2').val('');
    $('#ip_mascara3').val('');
    $('#ip_mascara4').val('');
    $('#mask').val('');
    $('#status_rango').val('');
    $('#atribu').val('').trigger('change.select2');
    $('#id_red').val('0');
}

function validation_seb_red(){
    var ip_mascara1 = document.getElementById("ip_mascara1").value;
    var ip_mascara2 = document.getElementById("ip_mascara2").value;
    var ip_mascara3 = document.getElementById("ip_mascara3").value;
    var ip_mascara4 = document.getElementById("ip_mascara4").value;
    var mask = document.getElementById("mask").value;
    var status_rango = document.getElementById("status_rango").value;
    var functi = document.getElementById("functi").value;
    var id_red = document.getElementById("id_red").value;
    var modal = document.getElementById("cerrar_pop_rango_fin");
    if (ip_mascara1=='' || ip_mascara2 == '' || ip_mascara3=='' || ip_mascara4 == '' || mask == '') {
        toastr.error("Complete la IP de red es obligatorio.");
    }else if (status_rango == '' || status_rango.length == 0 ) {
        toastr.error("El Estado es obligatorio.");
    }else{
        var ip = ip_mascara1+'.'+ip_mascara2+'.'+ip_mascara3+'.'+ip_mascara4;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/subred',
            data: {ip:ip, mask:mask, id_red:id_red, status:status_rango},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "mal_rango":
                        toastr.error("Alguna IP de ese Rango estan siendo usada");
                        break;
                    case 'regla':
                        toastr.error("No respeta la regla de subneteo");
                        break;
                    case 'incorrecto':
                        toastr.error("IP incorrecto");
                        break;
                    case 'yes':
                        switch (functi) {
                            case 'admin_ip':
                                rango_rama_list(id_red);
                                break;
                            case 'CPE':
                                eliminar_mas_rama(id_red);
                                break;
                            case 'AGG':
                                rango_rama_lis_cpe(id_red, 4);
                                break;
                            case 'LANSWITCH':
                                eliminar_mas_rama(id_red);
                                break;
                            case 'anillo':
                                rango_rama_lis_cpe(id_red, 3);
                                break;
                            case 'SERVICIO':
                                eliminar_rango_rama_list(id_red);
                                break;
                        }
                        modal.click();
                        toastr.success("Registro Exitoso");
                        vaciar_sub_red();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function rango_rama_list(id){
    var id_rama_old = document.getElementById("id_rama_old").value;
    var id_rango_old = document.getElementById("id_rango_old").value;
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    if (id != id_rama_old && id_rama_old!= 0 && id_rango_old == 'Si'){
        var positivo_old = document.getElementById('positivo'+id_rama_old+'');
        var negativo_old = document.getElementById('negativo'+id_rama_old+'');
        negativo_old.style.display = "none";
        positivo_old.style.display = "block";
    }
    var new_tbody = document.createElement('div');
    $("#multi_table_ip").html(new_tbody);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'ver/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay datos para este grupo");
                    }else{
                        positivo.style.display = "none";
                        negativo.style.display = "block";
                        var titulo = '<h4><i class="fa fa-file-archive-o"></i>  Rango: '+data['nombre']+' :'+data['inicio']+'/'+data['barra']+'</h4>';
                        titulo += '<h4> Detalle de las Ip del Rango</h4>';
                        $("#multi_table_ip").append(titulo);
                        if (data['permiso'] >= 5) {
                            var boton ='<a class="btn btn-success" data-toggle="modal" data-target="#liberar_ip_pop" title="Liberar IP" onclick="libera_ip();"><i class=""></i>Libera IP</a> '+
                                ' <a class="btn btn-success" data-toggle="modal" data-target="#asignar_ip_pop" title="Asignar IP" onclick="asignar_ip_grupo();"><i class=""></i>Asignar IP</a>';
                            $("#multi_table_ip").append(boton);
                        }
                        var table = '<div><table class="table table-striped table-bordered table-hover dataTables-example">';
                        table +='<thead> <tr><th><input type="checkbox" onclick="checkAll(this)"></th> <th>Estado</th> <th>Dirección</th> <th>Atributos</th> <th>SUBNET</th> <th></th> </tr> </thead>';
                        table +='<tbody id="tbodyramas"> </tbody>';
                        table +='</table></div>';
                        $("#multi_table_ip").append(table);
                        $(data['datas']).each(function(i, v){ // indice, valor
                            var valor = '<tr>';
                            if (data['datas'][i]['status'] != 'SIN ASIGNAR') {
                                valor +='<td><input type="checkbox" name="del['+[i]+']" value="' + data['datas'][i]['id_rango'] + '"></td>';
                            }else{
                                valor +='<td></td>';
                            }
                            if (data['datas'][i]['ip'] == data['fin']) {
                                valor += '<td><center><i class="fa fa-globe"></i></center></td>';
                            }else{
                                switch (data['datas'][i]['type']) {
                                    case "RED":
                                        valor += '<td><center><i class="fa fa-sitemap"></i></center></td>';
                                        break;
                                    case "GATEWAY":
                                        valor += '<td><center><i class="fa fa-laptop"></i></center></td>';
                                        break;
                                    case "BROADCAST":
                                        valor += '<td><center><i class="fa fa-globe"></i></center></td>';
                                        break;
                                    default :
                                        valor += '<td>' + data['datas'][i]['status'] + '</td>';
                                        break;
                                }
                            }
                            valor += '<td>' + data['datas'][i]['ip'] + '</td>' +
                                '<td>' + data['datas'][i]['atributo'] + '</td>' +
                                '<td>' + data['datas'][i]['subnet'] + '</td>' +
                                '<td>';
                            if (data['datas'][i]['status'] != 'SIN ASIGNAR') {
                                valor += '<a data-toggle="modal" data-target="#asignar_ip_pop" title="Asignar IP" onclick="asignar_ip(' + data['datas'][i]['id_rango'] + ');"><i class="fa fa-dot-circle-o"></i></a> ';
                            }
                            if (data['datas'][i]['status_id'] == '1' && data['datas'][i]['type'] == "RED") {
                                valor += '<a data-toggle="modal" data-target="#popasignar_red_ip" onclick="asignar_red_ip_admin('+data['datas'][i]['id_rango']+',0);" title="seleccionar SubRed"> <i class="fa fa-sitemap"> </i></a>';
                            }
                            if (data['datas'][i]['status_id'] != 2 && data['datas'][i]['status'] != 'SIN ASIGNAR') {
                                valor += ' <a data-toggle="modal" data-target="#estado_ip_pop" title="Cambiar estado" onclick="status_ip(' + data['datas'][i]['id_rango'] + ');"><i class="fa fa-circle"></i></a>';
                            }
                            valor += '<a data-toggle="modal" data-target="#popdetal_ip" onclick="detalle_ip_rango('+data['datas'][i]['id_rango']+');" title="Detalle IP"> <i class="fa fa-search" ></i></a></td>'+
                                '</tr>';
                            $("#tbodyramas").append(valor)

                        });
                        $('#id_rama_old').val(id);
                        $('#id_rango_old').val('Si');
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function detalle_ip_rango(id){
    var content = $("#detalles_ip");
    var new_tbody = document.createElement('tbody');
    content.html(new_tbody);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'detalle/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay Nodo disponible");
                    }else{
                        content.html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            content.append('<tr>' +
                                '<td>' + data['datos'][i]['ip']+'/'+data['datos'][i]['prefixes'] + '</td>' +
                                '<td>' + data['datos'][i]['attribute'] + '</td>' +
                                '<td>' + data['datos'][i]['fecha'] + '</td>' +
                                '<td>' + data['datos'][i]['name'] +' '+data['datos'][i]['last_name']+ '</td>' +
                                '</tr>'
                            );
                        })
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function eliminar_rango_rama_list(id){
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    positivo.style.display = "block";
    negativo.style.display = "none";
    var new_tbody = document.createElement('div');
    $("#multi_table_ip").html(new_tbody);
    $('#id_rama_old').val('0');
    $('#id_rango_old').val('Si');
}

function new_rama_rank(id){
    var mensaje = document.getElementById("rama_title");
    var msj_list = 'CREAR RAMA';
    mensaje.textContent  = msj_list;
    var id_rama = document.getElementById("id_rama").value;
    var padre = document.getElementById("padre").value;
    limpiar_rama(id);
    $('#rango').val('Si').trigger('change.select2');
    $('#rango').attr('disabled', '');
}

function new_rama_sin_rank(id){
    var mensaje = document.getElementById("rama_title");
    var msj_list = 'CREAR RAMA';
    mensaje.textContent  = msj_list;
    var id_rama = document.getElementById("id_rama").value;
    var padre = document.getElementById("padre").value;
    $('#rango').val('No').trigger('change.select2');
    $('#rango').attr('disabled', '');
    if (id_rama != 0 || padre != id) {
        limpiar_rama(id);
    }
}

function new_rama_multi(id){
    var mensaje = document.getElementById("rama_title");
    var msj_list = 'CREAR RAMA';
    mensaje.textContent  = msj_list;
    $('#rango').removeAttr('disabled');
    var id_rama = document.getElementById("id_rama").value;
    var padre = document.getElementById("padre").value;
    if (id_rama != 0 || padre != id) {
        limpiar_rama(id);
        $('#rango').val('').trigger('change.select2');
    }
}

function crear_rama(){
    var mensaje = document.getElementById("rama_title");
    var msj_list = 'CREAR RAMA';
    mensaje.textContent  = msj_list;
    var id_rama = document.getElementById("id_rama").value;
    var padre = document.getElementById("padre").value;
    $('#rango').val('No').trigger('change.select2');
    $('#rango').attr('disabled', '');
    if (id_rama != 0 || id_rama == '' ) {
        var id = 0;
        limpiar_rama(id);
    }
}

function limpiar_rama(id){
    $('#padre').val(id);
    $('#rama').val('');
    $('#id_rama').val(0);
    $('#descrit').val('');
    $('#id_rama_old').val(0);
    $('#id_rango_old').val('Si');
    $('#type').val('');
    $('#ip_rama').val('');
    $('#pre').val('');
    pre_view_ip();
}

function eliminar_mas_rama(id){
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    var new_tbody = document.createElement('table');
    $("#contenedor"+id+"").html(new_tbody);
    positivo.style.display = "block";
    negativo.style.display = "none";
    var new_tbody = document.createElement('div');
    $("#multi_table_ip").html(new_tbody);
    $('#id_rama_old').val(0);
}

function RPV_web(){
    var rpv = document.getElementById("rpv").value;
    var ip_rpv_all = document.getElementById('ip_rpv_all');
    var ip_all = document.getElementById('ip_all');
    $("#ip_admin").find('option').remove();
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#ip_wan').val('');
    switch (rpv) {
        case "Si":
            ip_rpv_all.style.display = "block";
            ip_all.style.display = "none";
            break;
        case "No":
            ip_rpv_all.style.display = "none";
            ip_all.style.display = "block";
            break;
        case '':
            ip_rpv_all.style.display = "none";
            ip_all.style.display = "none";
            break;
    }
}

function sitio_web(){
    var sitio = document.getElementById("sitio").value;
    var direc_all = document.getElementById('direc_all');
    var nodo_all = document.getElementById('nodo_all');
    $("#nodo_al").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#direc').append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    switch (sitio) {
        case "Si":
            direc_all.style.display = "block";
            nodo_all.style.display = "none";
            break;
        case "No":
            direc_all.style.display = "none";
            nodo_all.style.display = "block";
            break;
        case '':
            direc_all.style.display = "none";
            nodo_all.style.display = "none";
            break;
    }
}

function aconimo_cpe(){
    var id = document.getElementById("client").value;
    var id_cpe = document.getElementById("id_equipos").value;
    if (id_cpe == 0 && id != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'cpe/acronimo',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'nop':
                        toastr.error("No hay datos para este grupo");
                        break;
                    case 'yes':
                        $('#acro').val(data['acronimo']);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

$("#acro").on("keyup", function() {
    var acro = document.getElementById("acro").value;
    if (acro.length > 9) {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        var url = getBaseURL() +'consultar/acronimo';
        $.ajax({
            type: "POST",
            url: url,
            data: {acro:acro},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'login') {
                    refresh();
                }else{
                    if (data['resul'] == 'autori') {
                        toastr.error("Usuario no autorizado");
                    }else{
                        if (data['resul'] == 'nop') {
                            $('#aconimo_cpe_msj').text('Nueva acronimo');
                        }else{
                            $('#aconimo_cpe_msj').text('Exite el acronimo');
                        }
                    }
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#aconimo_cpe_msj').text('');
    }
});

function comen_nodo(id){
    $('#comentarios').val('');
    $('#title_nodo_comen').text('');
    var modal = document.getElementById("cerrar_comenta");
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'consultar/comentario';
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'yes') {
                        $('#comentarios').text(data['commen']);
                        $('#title_nodo_comen').text(data['name']);
                    }else{
                        toastr.error("No tiene comentario");
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function nodo_agg_alta(agg_id = ""){
    var id = document.getElementById("nodo_al_anillo").value;
    var agg = $("#agg");
    agg.find('option').remove();
    agg.append('<option selected disabled value="">seleccionar</option>');
    //agg.val(agg_id).trigger('change.select2');
    var new_tbody = document.createElement('tbody');
    $("#list_all_agg_equip").html(new_tbody);
    if (id != '' && id.length != 0) {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        var url = getBaseURL() +'AGG/anillo';
        $.ajax({
            type: "POST",
            url: url,
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'nop':
                        toastr.error("No tiene agregador este Nodo");
                        break;
                    case 'yes':
                        $(data['datos']).each(function(i, v){ // indice, valor
                            agg.append(
                                '<option value="'+ data['datos'][i]['id'] + '">' +  data['datos'][i]['acronimo'] + '</option>'
                            );
                        });
                        $("#list_all_agg_equip").html(new_tbody);
                        $(data['datos']).each(function(l, k){ // indice, valor
                            if (data['datos'][l].ip != null) {
                                var ip = data['datos'][l].ip+'/'+data['datos'][l].prefixes;
                            }else{
                                var ip = '';
                            }
                            var valor='<tr>' +
                                '<td>' + data['datos'][l].acronimo + '</td>' +
                                '<td>' + ip + '</td>' +
                                '<td>' + data['datos'][l].commentary + '</td>' +
                                '<td>' + data['datos'][l].status + '</td>' +
                                '<td><a title="Seleccionar" onclick="sele_agg_alta('+data['datos'][l].id+');"> <i class="fa fa-bullseye"> </i></a></td>' +
                                '</tr>';
                            $("#list_all_agg_equip").append(valor);
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

function acronimo_agg_anillo_alta(){
    var id = document.getElementById("agg").value;
    var acro_selec = $("#acro_selec");
    if (id != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        var url = getBaseURL() +'lista/acronimo';
        $.ajax({
            type: "POST",
            url: url,
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'login') {
                    refresh();
                }else{
                    if (data['resul'] == 'autori') {
                        toastr.error("Usuario no autorizado");
                    }else{
                        $("#bw_max").val("");
                        var new_tbody_table = document.createElement('tbody');
                        $("#jarvis_new_por_alta_anillo").html(new_tbody_table)
                        var new_tbody = document.createElement('div');
                        $("#campos_port").html(new_tbody);
                        $("#num_acro").val("");
                        acro_selec.find('option').remove();
                        acro_selec.append('<option selected disabled value="">seleccionar</option>');
                        acro_selec.val("").trigger('change.select2');
                        if (data['resul'] == 'nop') {
                            toastr.error("No tiene acronimo este agregador");
                        }else{
                            $(data['datos']).each(function(i, v){ // indice, valor
                                acro_selec.append(
                                    '<option value="'+ data['datos'][i]['name'] + '">' +  data['datos'][i]['name'] + '</option>'
                                );
                            });
                        }
                        $("#me_vlan_ls").find('option').remove();
                        $("#me_vlan_ls").append('<option selected disabled value="0">0000</option>');
                        $("#me_vlan_radio").find('option').remove();
                        $("#me_vlan_radio").append('<option selected disabled value="0">0000</option>');
                        get_free_vlans(5);
                        get_free_vlans(6);
                        $('#me_vlan_ls_arr').off().on('change', function() {
                            next_vlan(5);
                        });
                    }
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        var new_tbody_table = document.createElement('div');
        $("#campos_port").html(new_tbody_table);
        $("#bw_max").val("");
        $("#num_acro").val("");
        acro_selec.find('option').remove();
        acro_selec.append('<option selected disabled value="">seleccionar</option>');
        acro_selec.val("").trigger('change.select2');
        var new_tbody = document.createElement('tbody');
        $("#jarvis_new_por_alta_anillo").html(new_tbody)
    }
}

function pre_view_anillo(){
    var id_anillo = document.getElementById("id_anillo").value;
    if (id_anillo != 0) {
        var acro_selec = document.getElementById("acro_selec_edi").value;
        var num_acro = document.getElementById("num_acro_edi").value;
    }else{
        var acro_selec = document.getElementById("acro_selec").value;
        var num_acro = document.getElementById("num_acro").value;
    }
    if (acro_selec != '' && num_acro!= '') {
        switch (num_acro.length) {
            case 1:
                var numero = '000'+num_acro;
                break;
            case 2:
                var numero = '00'+num_acro;
                break;
            case 3:
                var numero = '0'+num_acro;
                break;
            default:
                var numero = num_acro;
                break;
        }
        var mostrar = 'ME-'+acro_selec+'_'+numero;
        if (id_anillo == 0) {$('#acro_anillo').val(mostrar); }else{ $('#acro_anillo_edi').val(mostrar);}
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'anillo/acronimo',
            data: {acronimo:mostrar,id:id_anillo,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#acro_anillo_msj').text(data['datos']);
                $('#acro_anillo_msj_edic').text(data['datos']);
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#acro_anillo').val('');
    }
}

$("#num_acro").on("keyup", function() {
    pre_view_anillo();
});

$("#num_acro_edi").on("keyup", function() {
    pre_view_anillo();
});

function acronimo_anillo_alta(){
    pre_view_anillo();
}

function bw_anillo(){
    var id = document.getElementById("equi_id").value;
    var id_anillo = document.getElementById("id_anillo").value;
    var bw = document.getElementById("bw_max").value;
    var new_tbody = document.createElement('tbody');
    $("#jarvis_new_por_alta_anillo").html(new_tbody)
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/anillo',
        data: {id:id, bw:bw , id_anillo:id_anillo},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("No tiene puerto disponible este agregador");
                    break;
                default:
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var label = '';
                        if (data['datos'][i]['f_s_p'] != '@@') {
                            var label = data['datos'][i]['f_s_p'];
                        }
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['label'] + label + data['datos'][i]['por_selec'] + '</td>' +
                            '<td>' + data['datos'][i]['type'] + '</td>' +
                            '<td>' + data['datos'][i]['status'] + '</td>' +
                            '<td>' + data['datos'][i]['commentary'] + '</td>';
                        if (data['datos'][i]['status'] == 'RESERVADO PARA ANILLO') {
                            valor += '<td><input type="checkbox" onclick="checkbo();" name="por'+data['datos'][i]['id']+'" value="'+data['datos'][i]['por_selec']+'@'+data['datos'][i]['id']+'">'+
                                ' <a title = "Detalle de puerto" data-toggle="modal" data-target="#detalle_agg_puerto" onclick="detal_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['por_selec']+');"> <i class="fa fa-twitch"> </i></a></td>';
                        } else {
                            valor += '<td></td>';
                        }
                        valor += '</tr>';
                        $("#jarvis_new_por_alta_anillo").append(valor)
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

var port_asig = "";
function checkbo(){
    let valoresCheck = [];
    $("input[type=checkbox]:checked").each(function(){
        if (valoresCheck.length > 3) {
            this.checked=false;
        }else{
            valoresCheck.push(this.value);
        }
    });
    port_asig = valoresCheck
}

function port_anillo_selec(){
    var id = document.getElementById("agg").value;
    $("#equi_id").val(id);
    var modal = document.getElementById("exit_alta_port");
    if (id == '' || id == null) {
        toastr.error("Debe seleccionar el Nodo y Agregador");
        $("#new_placa_anillo_alta").modal("toggle");
    }
}

function port_anillo_selec_pantalla(){
    var id = port_asig ;
    var id_anillo = document.getElementById("id_anillo").value;
    var modal = document.getElementById("exit_alta_port");
    if (port_asig != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'mostrar/puertos',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'login') {
                    refresh();
                }else{
                    var new_tbody = document.createElement('div');
                    $("#campos_port_ani").html(new_tbody);
                    if (data['resul'] == 'autori') {
                        toastr.error("Usuario no autorizado");
                    }else{
                        $(data).each(function(i, v){
                            campo = '<input type="text" id="placa_mos['+[i]+']" name="placa_m['+[i]+']" readonly="readonly" class="form-control" value="'+data[i]['slot']+data[i]['port']+'">     <input type="hidden" class="placa_alta" id="placa_alta['+[i]+']" name="placa_alta['+[i]+']" value="'+data[i]['port']+'@'+data[i]['board']+'">';
                            if (id_anillo == 0) {
                                $("#campos_port_ani").append(campo);
                            }else{
                                $("#campos_port_edi").append(campo);
                            }


                        })
                    }
                    modal.click();
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function register_port_anillo_selec(){
    var functi = document.getElementById("functi").value;
    var id_anillo = document.getElementById("id_anillo").value;
    var nodo_al = document.getElementById("nodo_al_anillo").value;
    var agg = $("#agg");
    var dedica = document.getElementById("dedica").value;
    var commen = document.getElementById("commen_anillo").value;
    var type = document.getElementById("type_anillo").value;
    var acro_selec = document.getElementById("acro_selec").value;
    var num_acro = document.getElementById("num_acro").value;
    var placa_alta = document.getElementsByClassName("placa_alta");
    var modal = document.getElementById("cerrar_anillo_register");
    var vlan_ls = document.getElementById('me_vlan_ls').value;
    var vlan_radio = document.getElementById('me_vlan_radio').value;
    var ip_ls = document.getElementById('me_ip_ls_id').value;
    var ip_radio = document.getElementById('me_ip_radio_id').value;

    agg.off();
    agg.on('change.select2', function() {
        next_free_vlan(5);
        next_free_vlan(6);
    });

    if (nodo_al == '' || nodo_al.length == 0) {
        toastr.error("El Nodo es obligatorio.");
        return;
    }else if (agg == '' || agg.length == 0 ) {
        toastr.error("El Agregador es obligatorio.");
        return;
    }else if (acro_selec == '' || acro_selec.length == 0 ) {
        toastr.error("El Acronimo del Agregador es obligatorio.");
        return;
    }else if (num_acro == '' || num_acro.length == 0 ) {
        toastr.error("El Numero del Acronimo es obligatorio.");
        return;
    }else if (dedica == '' || dedica.length == 0 ) {
        toastr.error("La respuesta si y/o no es Dedicado es obligatorio.");
        return;
    }else if (type == '' || type.length == 0 ) {
        toastr.error("El tipo de Anillo es obligatorio.");
        return;
    }else if (placa_alta.length == 0 ) {
        toastr.error("Tiene que tener minimo un puerto asignado.");
        return;
    }else if (empty(vlan_ls) || vlan_ls == '0') {
        toastr.error("la Vlan de Gestión lanswitch es obligatoria.");
        return;
    }else if (empty(ip_ls) || ip_ls == '0') {
        toastr.error("la Ip de Gestión lanswitch es obligatoria.");
        return;
    }else if (ip_ls == ip_radio) {
        toastr.error("La Ip de Gestión LS y Radio deben ser distintas.");
        return;
    }

    var vlan_all = [];
    vlan_all[0] = `1_${vlan_ls}_${ip_ls}`;
    if (!empty(vlan_radio) && vlan_radio != '0') {
        if (!empty(ip_radio) && ip_radio != '0') {
            vlan_all[1] = `2_${vlan_radio}_${ip_radio}`;
        } else {
            toastr.error("Debe especificar una IP de Gestión Radio.");
            return;
        }
    }

    var valor_placa = [];
    for (var i = 0; i < placa_alta.length; ++i) {
        if (typeof placa_alta[i].value !== "undefined") {
            valor_placa.push(placa_alta[i].value);
        }
    }

    switch (num_acro.length) {
        case 1:
            var numero = '000'+num_acro;
            break;
        case 2:
            var numero = '00'+num_acro;
            break;
        case 3:
            var numero = '0'+num_acro;
            break;
        default:
            var numero = num_acro;
            break;
    }
    var acro_lis = 'ME-'+acro_selec+'_'+numero;
    if (valor_placa.length == 3) {
        toastr.error("Tiene que ser 1, 2 o 4 del Agregador para el anillo");
        return;
    }

    var equip = agg.val();
    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: getBaseURL() +'registrar/anillo',
        data: {nodo_al:nodo_al, agg:equip, dedica:dedica, commen:commen, type:type, acro_lis:acro_lis, valor_placa:valor_placa, id_anillo:id_anillo, all_vlan_ip:vlan_all},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'vlan':
                    toastr.error("La Vlan tiene que ser menor a 4045.");
                    break;
                case 'exis':
                    toastr.error("El Acronimo ya Existe");
                    break;
                case 'vlan_exis':
                    toastr.error("Una de las Vlans ya está siendo utilizada por el equipo");
                    break;
                case 'port_n_mal':
                    toastr.error("Tiene que ser 1, 2 o 4 del Agregador para el anillo");
                    break;
                case 'yes':
                    toastr.success("Registro Exitoso");
                    $('#anillo_list').DataTable().ajax.reload();
                    $('#list_all_ring').DataTable().ajax.reload();
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function search_anillo (id){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/anillo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'yes') {
                $('#id_anillo').val(id);
                $("#equi_id").val(data['id_agg']);
                $('#nodo_motrar').val(data['node']);
                $('#agg_motrar').val(data['agg']);
                $("#acro_selec_edi").find('option').remove();
                $(data['acronimo']).each(function(i, v){
                    $("#acro_selec_edi").append(
                        '<option value="'+ data['acronimo'][i]['name'] + '">' +  data['acronimo'][i]['name'] + '</option>'
                    );
                })
                var new_tbody = document.createElement('div');
                $("#campos_port_edi").html(new_tbody);
                $(data['port']).each(function(i, v){
                    campo = '<input type="text" id="placa_m['+[i]+']" name="placa_m['+[i]+']" readonly="readonly" class="form-control" value="'+data['port'][i]['mostrar']+'">     <input type="hidden" class="placa_alta" id="placa_alta['+[i]+']" name="placa_alta['+[i]+']" value="'+data['port'][i]['data']+'">';
                    $("#campos_port_edi").append(campo);
                })
                $('#acro_selec_edi').val(data['acro_select']);
                $('#num_acro_edi').val(data['acro_number']);
                $('#dedica_edi').val(data['dedicated']);
                $('#type_edi').val(data['type']);
                $('#commen_edi').val(data['commentary']);
                $('#acro_anillo_edi').val('ME-'+data['acro_select']+'_'+data['acro_number']);
                $('#max_edi').val(data['logo']).trigger('change.select2');
                $('#n_max_edi').val(data['bw_all']);
            }else{
                if (data['resul'] == 'home') {
                    toastr.error("Usuario no autorizado");
                    var int=self.setInterval('refresh()',700);
                }
            }
            $('#acro_anillo_msj_edic').text('');
        }
    });
}

function crear_new_anillo(){
    var functi = document.getElementById("functi").value;
    $("#nodo_al_anillo").find('option').remove();
    $("#nodo_al_anillo").append('<option selected disabled value="">seleccionar</option>');
    $('#id_anillo').val('0');
    $('#agg').find('option').remove();
    $('#agg').append('<option selected disabled value="">seleccionar</option>');
    $('#acro_selec').val('');
    $('#num_acro').val('');
    $('#acro_anillo').val('');
    $('#dedica').val('');
    $('#type').val('');
    $('#commen_anillo').val('');
    var new_tbody = document.createElement('div');
    $("#campos_port_ani").html(new_tbody);
    $("#campos_vlan_plus").html(new_tbody);
    $('#acro_anillo_msj').text('');
    $("#me_vlan_ls").find('option').remove();
    $("#me_vlan_ls").append('<option selected disabled value="0">0000</option>');
    $("#me_vlan_radio").find('option').remove();
    $("#me_vlan_radio").append('<option selected disabled value="0">0000</option>');
}

function edi_port_anillo_selec(){
    var id_anillo = document.getElementById("id_anillo").value;
    var equi_id = document.getElementById("equi_id").value;
    var acro_selec = document.getElementById("acro_selec_edi").value;
    var num_acro = document.getElementById("num_acro_edi").value;
    var dedica = document.getElementById("dedica_edi").value;
    var type = document.getElementById("type_edi").value;
    var commen = document.getElementById("commen_edi").value;
    var n_max = document.getElementById("max_edi").value;
    var max = document.getElementById("n_max_edi").value;
    var placa_alta = document.getElementsByClassName("placa_alta");
    if (acro_selec == '' || acro_selec.length == 0 ) {
        toastr.error("El Acronimo del Agregador es obligatorio.");
    }else if (num_acro == '' || num_acro.length == 0 ) {
        toastr.error("El Numero del Acronimo es obligatorio.");
    }else if (dedica == '' || dedica.length == 0 ) {
        toastr.error("La respuesta si y/o no es Dedicado es obligatorio.");
    }else if (type == '' || type.length == 0 ) {
        toastr.error("El tipo de Anillo es obligatorio.");
    }else if (placa_alta.length == 0 ) {
        toastr.error("Tiene que tener minimo una placa asignada.");
    }else{
        var valor_placa = [];
        for (var i = 0; i < placa_alta.length; ++i) {
            if (typeof placa_alta[i].value !== "undefined") {
                valor_placa.push(placa_alta[i].value);
            }
        }
        switch (num_acro.length) {
            case 1:
                var numero = '000'+num_acro;
                break;
            case 2:
                var numero = '00'+num_acro;
                break;
            case 3:
                var numero = '0'+num_acro;
                break;
            default:
                var numero = num_acro;
                break;
        }
        var acro_lis = 'ME-'+acro_selec+'_'+numero;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/anillo',
            data: {nodo_al:0, agg:equi_id, dedica:dedica, commen:commen, type:type, acro_lis:acro_lis, valor_placa:valor_placa, id_anillo:id_anillo, n_max:n_max, max:max},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'exis':
                        toastr.error("El Acronimo ya Existe");
                        console.log(data['datos']);
                        break;
                    case 'vlan_exis':
                        toastr.error("Una de las Vlans ya está siendo utilizada por el equipo");
                        break;
                    case 'port_n_mal':
                        toastr.error("Tiene que ser 1, 2 o 4 del Agregador para el anillo");
                        break;
                    case 'yes':
                        toastr.success("Modificación Exitosa");
                        setTimeout("redireccionarPagina('anillo')", 700);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function rango_anillo(){
    var rango = document.getElementById("rango").value;
    var ran_positivo = document.getElementById('ran_positivo');
    if (rango == 'Si') {
        ran_positivo.style.display = "block";
    }else{
        ran_positivo.style.display = "none";
    }
}

function pre_view_ip(){
    var ip = document.getElementById("ip_rama").value;
    var pre = document.getElementById("pre").value;
    var pre_vi = document.getElementById("pre_vi");
    if (ip != '' && pre != '') {
        var mostrar = ip+'/'+pre;
    }else{
        var mostrar = "";
    }
    pre_vi.textContent  = mostrar;
}

$("#ip_rama").on("keyup", function() {
    pre_view_ip();
});

$("#pre").on("keyup", function() {
    pre_view_ip();
});

function buscar_ip_admin(id, ip_servi=null){
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    var new_all = document.createElement('div');
    $("#multi_table_ip").html(new_all);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'mas/rama';
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("No hay datos para este grupo");
                    break;
                default:
                    var conte = $('#contenedor'+id);
                    $('#id_rango_old').val(data['es_rango']);
                    $('#id_rama_old').val(id);
                    if (conte.length == 0 || id == 1) {
                        $("#contenedor").html(new_all);
                        conte = $('#contenedor');
                        var valor_ini = '<ul><li><i class="fa fa-file-archive-o"></i></li> '+
                            '<li>  ' + data['actual']['name'] + '</li>'+
                            '</ul>';
                        $('#contenedor').append(valor_ini)
                        var table = '<div><table class="table_ramas hijos" style="margin-left: 30px;" id="contenedor'+id+'"></table></div>';
                        $('#contenedor').append(table)
                    }else{
                        if (positivo != null) {
                            positivo.style.display = "none";
                            negativo.style.display = "block";
                        }
                    }
                    $('#contenedor'+id+'').html(new_all);
                    $(data['datos']).each(function(i, v){
                        var valor = '<ul>';
                        if (data['datos'][i].rank != 'Si') {
                            valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="buscar_ip_admin('+data['datos'][i].id+','+ip_servi+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_mas_rama('+data['datos'][i].id+');"></i></li>' +
                                '<li>- <i class="fa fa-database"></i></li> ';
                        }else{
                            valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="rango_rama_lis_cpe('+data['datos'][i].id+','+ip_servi+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_rango_rama_list('+data['datos'][i].id+');"></i></li>' +
                                '<li>--- <i class="fa fa-file-archive-o"></i></li> ';
                        }
                        valor += '<li>  ' + data['datos'][i].name + ' ' + data['datos'][i].ip_rank +'' + data['datos'][i].barra + '</li>';
                        if (data['datos'][i].rank == 'Si') {
                            if (data['datos'][i].permi >= 5) {
                                valor += '<li title="Crear SubRed"> <i class="fa fa-sitemap" data-toggle="modal" data-target="#popcrear_red"onclick="crear_sub_red('+data['datos'][i].id+');"></i></li>' +
                                    '<li title="Eliminar SubRed"> <i class="fa fa-window-close" data-toggle="modal" data-target="#popeliminar"onclick="eliminar_sub_red('+data['datos'][i].id+');"></i></li>';
                            }
                            valor += '</ul>';
                        }else{
                            if (data['datos'][i].padre != 0 && data['datos'][i].hijo == 0) {
                                if (data['datos'][i].permi >= 5) {
                                    valor += '<li title="Crear Rama Hijo">  <i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_sin_rank('+data['datos'][i].id+');"></i></li>';
                                }
                            }
                            valor += '</ul>';
                        }
                        $('#contenedor'+id).append(valor)
                        var table = '<div><table class="table_ramas hijos" style="margin-left: 30px;" id="contenedor'+data['datos'][i].id+'"></table></div>';
                        $('#contenedor'+id).append(table)
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function rango_rama_lis_cpe(id, ip_servi=null){
    var id_rama_old = document.getElementById("id_rama_old").value;
    var id_rango_old = document.getElementById("id_rango_old").value;
    var id_function = document.getElementById("functi").value;
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    if (id != id_rama_old && id_rama_old!= 0 && id_rango_old == 'Si'){
        var positivo_old = document.getElementById('positivo'+id_rama_old+'');
        var negativo_old = document.getElementById('negativo'+id_rama_old+'');
        negativo_old.style.display = "none";
        positivo_old.style.display = "block";
    }
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                var new_tbody = document.createElement('div');
                $("#multi_table_ip").html(new_tbody);
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay datos para este grupo");
                    }else{
                        positivo.style.display = "none";
                        negativo.style.display = "block";
                        var titulo = '<h4><i class="fa fa-file-archive-o"></i>  Rango: '+data['nombre']+' :'+data['inicio']+'/'+data['barra']+'</h4>';
                        titulo += '<h4> Detalle de las Ip del Rango</h4>';
                        $("#multi_table_ip").append(titulo)
                        var table = '<div><table class="table table-striped table-bordered table-hover dataTables-example">';
                        table +='<thead> <tr> <th>Estado</th> <th>Dirección</th> <th>SUBNET</th> <th></th> </tr> </thead>';
                        table +='<tbody id="tbodyramas"> </tbody>';
                        table +='</table></div>';
                        $("#multi_table_ip").append(table)
                        $(data['datas']).each(function(i, v){ // indice, valor
                            var valor = '<tr>';

                            if (data['datas'][i]['ip'] == data['fin']) {
                                valor += '<td><center><i class="fa fa-globe"></i></center></td>';
                            }else{

                                switch (data['datas'][i]['type']) {
                                    case "RED":
                                        valor += '<td><center><i class="fa fa-sitemap"></i> RED</center></td>';
                                        break;
                                    case "GATEWAY":
                                        valor += '<td><center><i class="fa fa-laptop"></i> GATEWAY</center></td>';
                                        break;
                                    case "BROADCAST":
                                        valor += '<td><center><i class="fa fa-globe"></i> BROADCAST</center></td>';
                                        break;
                                    default :
                                        valor += '<td><center>' + data['datas'][i]['status'] + '</center></td>';
                                        break;
                                }

                            }
                            valor += '<td> ' + data['datas'][i]['ip'] + '</td>' +
                                '<td>' + data['datas'][i]['subnet'] + '</td>';
                            if ((data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == 'DISPONIBLE' && ip_servi != 3 && (ip_servi == null || ip_servi == 0 || ip_servi == 4 || ip_servi == 5 || ip_servi == 6 || ip_servi == 7 || ip_servi == 8 || ip_servi == 9)) || (data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == "GATEWAY" && (ip_servi != 1 && (ip_servi == 4 || id_function == 1) || ip_servi == 5 || ip_servi == 6)) || (((id_function == 'anillo' || ip_servi == 1) && ip_servi != 4) && (data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == 'RED'))) {
                                valor +='<td> <i class="fa fa-dot-circle-o" onclick="selecion_ip_rango('+data['datas'][i]['id_rango']+','+ip_servi+');"></i></td>' +
                                    '</tr>';
                            }else{
                                if (data['datas'][i]['status'] == 'SIN ASIGNAR') {
                                    valor +='<td></td>' +
                                        '</tr>';
                                }else{
                                    valor +='<td> <i class="fa fa-warning" style="color: coral;"></i></td>' +
                                        '</tr>';
                                }
                            }
                            $("#tbodyramas").append(valor)
                        });
                        $('#id_rama_old').val(id);
                        $('#id_rango_old').val('Si');
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

}

function selecion_ip_rango(id, ip_servi=null){
    switch (ip_servi) {
        case 2:
            var modal = document.getElementById("cerra_bus_ip_admin_lans");
            break;
        case 10:
            var modal = document.getElementById("cerra_vlan_ring_ipran");
            break;
        default:
            var modal = document.getElementById("cerra_bus_ip_admin");
            break;
    }
    if (id != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        var url = getBaseURL() +'buscar/ip';
        $.ajax({
            type: "POST",
            url: url,
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'login') {
                    refresh();
                }else{
                    if (data['resul'] == 'autori') {
                        toastr.error("Usuario no autorizado");
                    }else{
                        if (data['resul'] == 'exis') {
                            toastr.error("La IP es Invalidad");
                        }else{
                            switch (ip_servi) {
                                case 1:
                                    $('#ip_rank_servi_id').val(id);
                                    $('#ip_admin_rank').val(data['ip']+'/'+data['barra']);
                                    $("#ip_admin").find('option').remove();
                                    $("#ip_admin").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 0:
                                    $('#ip_admin_servi_id').val(id);
                                    $('#ip_admin_servi').val(data['ip']+'/'+data['barra']);
                                    break;
                                case 3:
                                    $('#ip_admin_id_anillo').val(id);
                                    $('#ip_admin_anillo').val(data['ip']+'/'+data['barra']);
                                    break;
                                case 5:
                                    $("#ip_admin_loopback").find('option').remove();
                                    $("#ip_admin_loopback").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 6:
                                    $("#loopback_ip_admin").find('option').remove();
                                    $("#loopback_ip_admin").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 7:
                                    $("#edi_loopback").find('option').remove();
                                    $("#edi_loopback").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 8:
                                    $("#edi_ip_loopback").find('option').remove();
                                    $("#edi_ip_loopback").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 9:
                                    $("#edi_ip_gestion").find('option').remove();
                                    $("#edi_ip_gestion").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 10:
                                    $("#ip_admin_lsw").find('option').remove();
                                    $("#ip_admin_lsw").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                                case 11:
                                    $('#ipran_ip_ls_id').val(id);
                                    $('#ipran_ip_ls').val(data['ip']+'/'+data['barra']);
                                    break;
                                case 12:
                                    $('#ipran_ip_radio_id').val(id);
                                    $('#ipran_ip_radio').val(data['ip']+'/'+data['barra']);
                                    break;
                                case 13:
                                    $('#me_ip_ls_id').val(id);
                                    $('#me_ip_ls').val(data['ip']+'/'+data['barra']);
                                    break;
                                case 14:
                                    $('#me_ip_radio_id').val(id);
                                    $('#me_ip_radio').val(data['ip']+'/'+data['barra']);
                                    break;
                                case 151:
                                    // Internet dedicado. Agg común. IP WAN Internet
                                    $("#wan_subnet_id").val(id);
                                    $("#ip_admin_sele_lans").modal();
                                    ip_by_subnet(data['ip'], data['barra'], data['branch_id'], 1);
                                break;
                                case 152:
                                    // Internet dedicado. Agg común. Rango IP Público
                                    $("#public_subnet_id").val(id);
                                    $("#public_subnet_number").val(data['ip']+'/'+data['barra']);
                                    break;
                                case 153:
                                    // Internet dedicado. Agg común. Subred /30
                                    $("#ds_subnet_id").val(id);
                                    $("#ds_subnet_number").val(data['ip']+'/'+data['barra']);
                                break;
                                case 154:
                                    // Internet dedicado. Agg BVI. IP WAN Internet
                                    $("#wan_subnet_id_2").val(id);
                                    $("#ip_admin_sele_lans").modal();
                                    ip_by_subnet(data['ip'], data['barra'], data['branch_id'], 2);
                                break;
                                case 155:
                                    // Internet dedicado. Agg BVI. Rango IP Público
                                    $("#public_subnet_id_2").val(id);
                                    $("#public_subnet_number_2").val(data['ip']+'/'+data['barra']);
                                break;
                                case 156:
                                    // Internet dedicado. Agg BVI. Subred /30
                                    $("#ds_subnet_id_2").val(id);
                                    $("#ds_subnet_number_2").val(data['ip']+'/'+data['barra']);
                                break;
                                default :
                                    $("#ip_admin").find('option').remove();
                                    $("#ip_admin").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                                    break;
                            }
                            modal.click();
                            var new_all = document.createElement('div');
                            $("#contenedor").html(new_all);
                        }
                    }
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#ip_admin_id').val(0);
    }
}

function grupo_ip_validacion(){
    var name = document.getElementById("name").value;
    var id = document.getElementById("id_group").value;
    name = name.toUpperCase();
    name = name.trim();
    name_new = name.replace(/\s{2,}/g, ' ');
    if (name_new == '') {
        toastr.error("El nombre es obligatorio.");
    }else{
        var url = getBaseURL() +'registar/grupo';
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: url,
            data: {name:name_new, id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'yes':
                        if (id==0) {
                            toastr.success("Registrado Exitoso");
                        }else{
                            toastr.success("Modificación Exitosa");
                        }
                        var int=self.setInterval('refresh()',700);
                        break;
                    case 'login':
                        refresh();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function search_group(id){
    var mensaje = document.getElementById("title_group");
    var msj_list = 'MODIFICAR GRUPO';
    mensaje.textContent  = msj_list;
    var url = getBaseURL() +'buscar/grupo';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            $('#id_group').val(id);
            $('#name').val(data['name']);
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_group(){
    var id = document.getElementById("id_group").value;
    var mensaje = document.getElementById("title_group");
    var msj_list = 'REGISTRAR GRUPO';
    mensaje.textContent  = msj_list;
    if (id != 0){
        $('#id_group').val('0');
        $('#name').val('');
    }
}

function search_user_agre_qui(id){
    var mensaje = document.getElementById("name_group");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/usuarios',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            mensaje.textContent  = data['group'];
            var new_tbody = document.createElement('tbody');
            $("#user_grupo_listo").html(new_tbody);
            $("#user_grupo_falta").html(new_tbody);
            if (data['derecha'] != '') {
                $(data['derecha']).each(function(i, v){ // indice, valor
                    var valor1 = '<tr>' +
                        '<td>'+data['derecha'][i].name+' '+data['derecha'][i].last_name+'</td>' +
                        '<td><center> <i class="fa fa-dot-circle-o" title="Agregarpor Usuario" onclick="asig_group('+data['derecha'][i]['id']+', '+id+');"></i><center></td>' +
                        '</tr>';
                    $("#user_grupo_falta").append(valor1)
                })
            }else{
                var valor1 = '<tr>' +
                    '<td colspan="2"><center>Sin Registro</center></td>' +
                    '</tr>';
                $("#user_grupo_falta").append(valor1)
            }
            if (data['izquierda']!= '') {
                $(data['izquierda']).each(function(i, v){ // indice, valor
                    var valor = '<tr>' +
                        '<td>'+data['izquierda'][i].name+' '+data['izquierda'][i].last_name+'</td>' +
                        '<td><center> <i class="fa fa-times-rectangle-o" title="Quitar Usuario" onclick="delete_asig_group('+data['izquierda'][i]['id']+');"></i><center></td>' +
                        '</tr>';
                    $("#user_grupo_listo").append(valor)
                })
            }else{
                var valor = '<tr>' +
                    '<td colspan="2"><center>Sin Registro</center></td>' +
                    '</tr>';
                $("#user_grupo_listo").append(valor)
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function search_per_agre_qui(id){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/permisos',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            $('#id_group_new').val(id);
            var new_tbody = document.createElement('tbody');
            $("#permi_grupo").html(new_tbody);
            $(data['datos']).each(function(i, v){ // indice, valor
                var valor = '<tr>' +
                    '<td>' + data['datos'][i].name + '</td>' +
                    '<td><center><input type="radio" id="'+[i]+'_0" value="'+ data['datos'][i].id +'_0" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                    '<td><center><input type="radio" id="'+[i]+'_3" value="'+ data['datos'][i].id +'_3" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                    '<td><center><input type="radio" id="'+[i]+'_5" value="'+ data['datos'][i].id +'_5" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                    '<td><center><input type="radio" id="'+[i]+'_10" value="'+ data['datos'][i].id +'_10" class="permi_new" name="permission['+ [i] +']"> </center></td>' +
                    '</tr>';
                $("#permi_grupo").append(valor)
                $("#"+[i]+"_"+ data['datos'][i].permi +"").prop("checked", true);
            })
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function asig_group(user, group){
    var url = getBaseURL() +'agregar/usuarios';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: url,
        data: {user:user,group:group},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(data['resul'] == 'yes'){
                toastr.success("Registrado Exitoso");
                search_user_agre_qui(group);
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delete_asig_group(id){
    var url = getBaseURL() +'quitar/usuarios';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(data['resul'] == 'yes'){
                toastr.success("Modificación Exitosa");
                search_user_agre_qui(data['id']);
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function new_permi_group(){
    var modal = document.getElementById("cerrar_permisos_ip");
    var id = document.getElementById("id_group_new").value;
    var permission = document.getElementsByClassName("permi_new");
    var contar = permission.length/4;
    var permi_value = [];
    for (var i = 0; i < contar; ++i) {
        var memo=document.getElementsByName('permission['+[i]+']');
        for (var g = 0; g < 4; ++g) {
            if(memo[g].checked){
                permi_value.push(memo[g].value);
            }
        }
    }
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'registrar/permisos',
        data: {id:id, permi:permi_value},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(data['resul'] == 'yes'){
                toastr.success("Registrado Exitoso");
                modal.click();
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_new_permi_espe(){
    var mensaje = document.getElementById("title_group_espe");
    mensaje.textContent  = 'CREAR PREMISO ESPECIAL';
    var id = document.getElementById("id_especial").value;
    $('#user').removeAttr('disabled');
    $('#rama').removeAttr('disabled');
    if (id != 0) {
        $('#id_especial').val(0);
        $('#user').val('').trigger('change.select2');
        $('#rama').val('').trigger('change.select2');
        $('#permi_new').val('');
    }
}

function permis_ip_validacion(){
    var id = document.getElementById("id_especial").value;
    var user = document.getElementById("user").value;
    var rama = document.getElementById("rama").value;
    var permi_new = document.getElementById("permi_new").value;
    if (user == '' || user.length == 0) {
        toastr.error("El Usuario es obligatorio.");
    }else if (rama == '' || rama.length == 0 ) {
        toastr.error("La Rama es obligatorio.");
    }else if (permi_new == '' || permi_new.length == 0 ) {
        toastr.error("El Permiso es obligatorio.");
    }else{
        var url = getBaseURL() +'registro/especial';
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: url,
            data: {id:id, user:user, rama:rama, permi_new:permi_new},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if(data['resul'] == 'yes'){
                    toastr.success("Registrado Exitoso");
                    var int=self.setInterval('refresh()',700);
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function search_permiss(id){
    var mensaje = document.getElementById("title_group_espe");
    mensaje.textContent  = 'MODIFICAR PREMISO ESPECIAL';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/permiso',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(data['resul'] == 'yes'){
                $('#id_especial').val(id);
                $('#user').val(data['datos']['id_user']).trigger('change.select2');
                $('#rama').val(data['datos']['id_branch']).trigger('change.select2');
                $('#permi_new').val(data['datos']['permissions']);
                $('#user').attr('disabled', '');
                $('#rama').attr('disabled', '');
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_uplink(){
    var mensaje = document.getElementById("title_uplink");
    mensaje.textContent  = 'CREAR UPLINK';
    var id = document.getElementById("id_uplink").value;
    if (id != 0) {
        $('#id_uplink').val(0);
        $('#nodo_al').val('').trigger('change.select2');
        $('#uplink').val('');
        $('#n_max').val('');
        $('#max').val(1);
        $('#equipment_sat').val('');
        $('#ip_gestion').val('');
        $('#por_sar').val('');
        $('#mtr_tag').val('');
        $('#cus_tag').val('');
        $('#vlan').val('');
    }
}

function validation_uplink(){
    var id = document.getElementById("id_uplink").value;
    var nodo_al = document.getElementById("nodo_al").value;
    var uplink = document.getElementById("uplink").value;
    var n_max = document.getElementById("n_max").value;
    var max = document.getElementById("max").value;
    var equipment_sat = document.getElementById("equipment_sat").value;
    var ip_gestion = document.getElementById("ip_gestion").value;
    var por_sar = document.getElementById("por_sar").value;
    var mtr_tag = document.getElementById("mtr_tag").value;
    var cus_tag = document.getElementById("cus_tag").value;
    var vlan = document.getElementById("vlan").value;
    var bw = n_max * max;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'registrar/uplink',
        data: {id:id, nodo_al:nodo_al, uplink:uplink, equipment_sat:equipment_sat, ip_gestion:ip_gestion, por_sar:por_sar, mtr_tag:mtr_tag, cus_tag:cus_tag, vlan:vlan, bw:bw},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(data['resul'] == 'yes'){

            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function search_uplink(id){
    var mensaje = document.getElementById("title_uplink");
    mensaje.textContent  = 'MODIFICAR UPLINK';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/uplink',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if(data['resul'] == 'yes'){
                $('#id_uplink').val(id);
                $('#nodo_al').val('').trigger('change.select2');
                $('#uplink').val(data['datos']['name']);
                $('#n_max').val(data['datos']['bw_maximum']);
                $('#max').val(1);
                $('#equipment_sat').val(data['datos']['sar_equipment']);
                $('#ip_gestion').val(data['datos']['sar_ip']);
                $('#por_sar').val(data['datos']['sar_port']);
                $('#mtr_tag').val(data['datos']['mt']);
                $('#cus_tag').val(data['datos']['ct']);
                $('#vlan').val(data['datos']['vlan']);
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_perfil(){
    var mensaje = document.getElementById("title_profil");
    mensaje.textContent  = 'CREAR PERFIL';
    $('#id_profil').val(0);
    $('#name').val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'crear/perfil',
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    var new_tbody = document.createElement('tbody');
                    $("#profil_new_table").html(new_tbody);
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i].name + '</td>' +
                            '<td><center><input type="radio" checked="checked" id="'+[i]+'_0" value="0_'+ data['datos'][i].id +'" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                            '<td><center><input type="radio" id="'+[i]+'_3" value="3_'+ data['datos'][i].id +'" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                            '<td><center><input type="radio" id="'+[i]+'_5" value="5_'+ data['datos'][i].id +'" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                            '<td><center><input type="radio" id="'+[i]+'_10" value="10_'+ data['datos'][i].id +'" class="permi_new" name="permission['+ [i] +']"> </center></td>' +
                            '</tr>';
                        $("#profil_new_table").append(valor);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function profil_validacion(){
    var id = document.getElementById("id_profil").value;
    var name = document.getElementById("name").value;
    name = name.toUpperCase();
    name = name.trim();
    name_new = name.replace(/\s{2,}/g, ' ');
    var permission = document.getElementsByClassName("permi_new");
    var contar = permission.length/4;
    var permi_value = [];
    for (var i = 0; i < contar; ++i) {
        var memo=document.getElementsByName('permission['+[i]+']');
        for (var g = 0; g < 4; ++g) {
            if(memo[g].checked){
                permi_value.push(memo[g].value);
            }
        }
    }
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'registrar/perfil',
        data: {id:id, name_new:name_new, permi_value:permi_value},
        dataType: 'json',
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
                    toastr.error("Error al guardar los datos");
                    break;
                case "yes":
                    if (id == 0) {
                        toastr.success("Registro Exitoso");
                    }else{
                        toastr.success("Modificación Exitosa");
                    }
                    var int=self.setInterval('refresh()',700);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function search_perfil(id){
    var mensaje = document.getElementById("title_profil");
    mensaje.textContent  = 'CREAR PERFIL';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/perfil',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $('#id_profil').val(id);
                    $('#name').val(data['name']);
                    var new_tbody = document.createElement('tbody');
                    $("#profil_new_table").html(new_tbody);
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i].appli + '</td>' +
                            '<td><center><input type="radio" id="'+[i]+'_0" value="0_'+ data['datos'][i].appli_id +'" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                            '<td><center><input type="radio" id="'+[i]+'_3" value="3_'+ data['datos'][i].appli_id +'" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                            '<td><center><input type="radio" id="'+[i]+'_5" value="5_'+ data['datos'][i].appli_id +'" class="permi_new" name="permission['+ [i] +']" > </center></td>' +
                            '<td><center><input type="radio" id="'+[i]+'_10" value="10_'+ data['datos'][i].appli_id +'" class="permi_new" name="permission['+ [i] +']"> </center></td>' +
                            '</tr>';
                        $("#profil_new_table").append(valor)
                        $("#"+[i]+"_"+ data['datos'][i].permi +"").prop("checked", true);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function clear_alta_lanswitch(){
    document.getElementById("alta_lanswitch").reset();
    var campo_por = document.createElement('div');
    $("#campos_port_all").html(campo_por);
    $("#equi_con_1").find('option').remove();
    $("#equi_con_1").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#equi_con_2").find('option').remove();
    $("#equi_con_2").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#client").find('option').remove();
    $("#client").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#equi_alta").find('option').remove();
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#direc").find('option').remove();
    $("#direc").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").find('option').remove();
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#sitio").val('').trigger('change.select2');
}

function alta_lanswitch_crear(){
    clear_alta_lanswitch();
    var aceptar = document.getElementById("alta_ls_pop");
    var cancelar = document.getElementById("baja_ls_pop");
    var modal = document.getElementById("cerra_ls_pop");
    var mensaje = document.getElementById("title_lanswitch");
    mensaje.textContent  = 'REGISTRAR LANSWITCH';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "block";
    var boton_crear = document.getElementById('mas_anillo');
    boton_crear.style.display = "block";
    var boton_client = document.getElementById('bus_client');
    boton_client.style.display = "block";
    var port = document.getElementById('port_lanswitch_list');
    port.style.display = "block";
// var equipm = document.getElementById('equi_all_lanswitch');
//     equipm.style.display = "block";
    var bus_anillo = document.getElementById('bus_anillo');
    bus_anillo.style.display = "block";
    var bus_client = document.getElementById('bus_client');
    bus_client.style.display = "block";
    var new_clit = document.getElementById('new_clit');
    new_clit.style.display = "block";
    aceptar.onclick = function() {
        var equi_alta = document.getElementById("equi_alta").value;
        var client = document.getElementById("client").value;
        var direc = document.getElementById("direc").value;
        var anilo = document.getElementById("anilo_id").value;
        var name = document.getElementById("acro").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var orden = document.getElementById("orden").value;
        var enlace = document.getElementById("enlace").value;
        var id_function = document.getElementById("id_function").value;
        var local = document.getElementById("local_equipmen").value;
        var nodo_al = document.getElementById("nodo_al").value;
        var sitio = document.getElementById("sitio").value;
        var commen = document.getElementById("commentary").value;
        var placa_alta = document.getElementsByClassName("placa_alta");
        var port_lanswitch = document.getElementsByClassName("port_lanswitch");
        var valor = [];
        var port = [];
        for (var i = 0; i < placa_alta.length; ++i) {
            if(typeof placa_alta[i].value !== "undefined"){valor.push(placa_alta[i].value); }
        }
        for (var i = 0; i < port_lanswitch.length; ++i) {
            if(typeof port_lanswitch[i].value !== "undefined"){port.push(port_lanswitch[i].value);}
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/lanswitch',
            data: {valor:valor, anilo:anilo, ip_admin:ip_admin, enlace:enlace, orden:orden, client:client, name:name, direc:direc, equi_alta:equi_alta, id:0, port:port, local:local, nodo_al:nodo_al, sitio:sitio, commen:commen},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del agregador ya Existe");
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        $('#lanswitch_list').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_lanswitch(id){
    clear_alta_lanswitch();
    var aceptar = document.getElementById("alta_ls_pop");
    var cancelar = document.getElementById("baja_ls_pop");
    var modal = document.getElementById("cerra_ls_pop");
    var mensaje = document.getElementById("title_lanswitch");
    mensaje.textContent  = 'MODIFICAR LANSWITCH';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    var boton_crear = document.getElementById('mas_anillo');
    boton_crear.style.display = "none";
    var boton_client = document.getElementById('bus_client');
    boton_client.style.display = "none";
    var port = document.getElementById('port_lanswitch_list');
    port.style.display = "none";
// var equipm = document.getElementById('equi_all_lanswitch');
//     equipm.style.display = "none";
    var bus_anillo = document.getElementById('bus_anillo');
    bus_anillo.style.display = "none";
    var bus_client = document.getElementById('bus_client');
    bus_client.style.display = "none";
    var new_clit = document.getElementById('new_clit');
    new_clit.style.display = "none";
    $('#id_equipos').val(id);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/equipo',
        data: {id:id,},
        dataType: 'json',
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
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case "yes":
                    $('#anilo_name').val(data['anillo']['name']+' '+data['anillo']['acronimo']);
                    $('#anilo_id').val(data['anillo']['id']);
                    $('#ip_admin_id_lans').val(data['id']);
                    $('#ip_admin_lans').val(data['ip']);
                    $('#enlace').val(data['datos']['service']);
                    $('#local_equipmen').val(data['datos']['location']);
                    $('#commentary').val(data['datos']['commentary']);
                    $('#orden').val(data['datos']['ir_os_up']);
                    $('#ip_admin').append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $('#equi_alta').append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $('#client').append('<option selected disabled value="'+data['datos']['id_client']+'">'+data['datos']['client']+' '+data['datos']['cuit']+' '+data['datos']['business_name']+'</option>').trigger('change.select2');
                    if (data['datos']['node'] == null) {
                        $('#sitio').val('Si').trigger('change.select2');
                        $("#direc").append('<option selected disabled value="'+data['datos']['address']+'">'+data['datos']['direcc']+'</option>').trigger('change.select2');
                    }else{
                        $('#sitio').val('No').trigger('change.select2');
                        $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    }
                    $('#acro').val(data['datos']['acronimo']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var equi_alta = document.getElementById("equi_alta").value;
        var client = document.getElementById("client").value;
        var direc = document.getElementById("direc").value;
        var anilo = document.getElementById("anilo_id").value;
        var name = document.getElementById("acro").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var orden = document.getElementById("orden").value;
        var enlace = document.getElementById("enlace").value;
        var id_function = document.getElementById("id_function").value;
        var local = document.getElementById("local_equipmen").value;
        var nodo_al = document.getElementById("nodo_al").value;
        var sitio = document.getElementById("sitio").value;
        var commen = document.getElementById("commentary").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/lanswitch',
            data: {valor:0, anilo:anilo, ip_admin:ip_admin, enlace:enlace, orden:orden, client:client, name:name, direc:direc, equi_alta:equi_alta, id:id, port:0, local:local, nodo_al:nodo_al, sitio:sitio, commen:commen},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del agregador ya Existe");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#lanswitch_list').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function acronimo_lanswitch(){
    var id = document.getElementById("id_equipos").value;
    var anillo = document.getElementById("anilo_id").value;
    var client = document.getElementById("client").value;
    if (anillo != '' && client.length > 0 && client != '' && anillo.length > 0 && id == 0) {
        $('#acro').val('');
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'acronimo/lanswitch',
            data: {anillo:anillo, client:client, id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        toastr.error("Error. el Cliente no tiene acronimo");
                        break;
                    case "yes":
                        $('#acro').val(data['acronimo']);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function selec_anillo_lan(id){
    var modal = document.getElementById("cerra_bus_anillo");
    // var equipm = document.getElementById('equip_2_mostar');
    // var equi = $("#equi_con_1");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'seleccionar/anillo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $('#anilo_id').val(id);
                    $('#anilo_name').val(data['name']+' '+data['type']+', Agregador:'+data['acronimo']);
                    $('#anilo_name').attr('disabled', '');
                    acronimo_lanswitch();
                    // if (data['coun'] > 1) {
                    //     equipm.style.display = "block";
                    // }else{
                    //     equipm.style.display = "none";
                    // }
                    // equi.find('option').remove();
                    // equi.append('<option selected disabled value="">seleccionar</option>');
                    // equi.val('');
                    // $(data['equip']).each(function(i, v){ // indice, valor
                    //     equi.append(
                    //         '<option value="'+ data['equip'][i]['id'] + '">' +  data['equip'][i]['acronimo'] + '</option>'
                    //     );
                    // })
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

id_ip_cargada = [];
var contar = 0;
function vlan_anillo_selec(fun = null){
    if (fun == 2) {
        var id = document.getElementById("id_equip_vlan").value;
    } else if (fun == 1) {
        var id = document.getElementById("id_lsw").value;
    } else {
        var id = document.getElementById("agg").value;
    }
    if (id == '' || id == null) {
        toastr.error("Debe seleccionar el Nodo y Agregador");
        $("#new_vlan_anillo_alta").modal("toggle");
        return;
    }
    $("#use_vlan").attr('onChange', 'use_vlan_new('+fun+')');
    $("#button_frontier").attr('onClick', 'list_frontier('+id+')');
    $("#next_free_vlan").attr('onClick', 'next_free_vlan('+fun+')');
    document.getElementById("vla_all_new").reset();
    var aceptar = document.getElementById("vlan_aceptar");
    var cancelar = document.getElementById("vlan_cancelar");
    var modal = document.getElementById("exit_alta_vlan");
    var admin_ip_vlan = document.getElementById('admin_ip_vlan');
    var div_frontier = document.getElementById('div_frontier');
    var div_vlan = document.getElementById('div_vlan');
    admin_ip_vlan.style.display = 'none';
    div_vlan.style.display = 'none';
    div_frontier.style.display = 'none';
    aceptar.onclick = function() {
        var ip_admin_id = document.getElementById("ip_admin_id_anillo").value;
        var rango_ip = document.getElementById("rango_ip").value;
        var ip_admin = document.getElementById("ip_admin_anillo").value;
        var use_vlan = document.getElementById("use_vlan");
        var vlan = $("#free_vlans").find("option").val();
        use_vlan_value = use_vlan.value,
            use_vlan_text = use_vlan.options[use_vlan.selectedIndex].innerText;
        if (use_vlan_value == '' || use_vlan_value.length == 0) {
            toastr.error("El uso de la vlan es obligatorio.");
        }else if (vlan == '' || vlan.length == 0 ) {
            toastr.error("La Vlan es obligatorio.");
        }else if (vlan >  4045) {
            toastr.error("La Vlan tiene que ser menor a 4045.");
        }else if ((ip_admin == '' || ip_admin.length == 0) && rango_ip == 'SI') {
            toastr.error("La IP es obligatorio.");
        }else{
            var compare_ip = id_ip_cargada.includes( ip_admin_id );
            if (compare_ip == false) {
                id_ip_cargada.push(ip_admin_id);
                contar++;
                var ver = use_vlan_text +': '+vlan+', '+ip_admin;
                var datos = use_vlan_value+'_'+vlan+'_'+ip_admin_id;
                if (fun == null) {
                    input = '<div class="bw_all " id="input'+contar+'" > <input type="text" id="ip_vlan_mostar[' + contar + ']" name="ip_vlan_mostar[' + contar + ']" readonly="readonly" class="form-control" value="'+ver+'">            <a class="ico_input btn btn-info" onclick="quitar_vlan('+contar+', '+ip_admin_id+');"><i class="fa fa-trash" title="Quitar Vlan"> </i> Quitar</a>         <input type="hidden" class="vlan_ip_new" id="vlan_ip_new[' + contar + ']" name="vlan_ip_new[' + contar + ']" value="'+datos+'">            <input type="hidden" class="vlan_use_new" id="vlan_use_new[' + contar + ']" name="vlan_use_new[' + contar + ']" value="'+use_vlan_value+'"></div>';
                    $("#campos_vlan_plus").append(input);
                }else{
                    input = '<div class="bw_all " id="input'+contar+'" > <input type="text" id="ip_vlan_mostar[' + contar + ']" name="ip_vlan_mostar[' + contar + ']" readonly="readonly" class="form-control" value="'+ver+'">            <a class="ico_input btn btn-info" onclick="quitar_vlan('+contar+', '+ip_admin_id+');"><i class="fa fa-trash" title="Quitar Vlan"> </i> Quitar</a>         <input type="hidden" class="vlan_ip_ring_ipran" id="vlan_ip_ring_ipran[' + contar + ']" name="vlan_ip_ring_ipran[' + contar + ']" value="'+datos+'">            <input type="hidden" class="vlan_use_ring_ipran" id="vlan_use_ring_ipran[' + contar + ']" name="vlan_use_ring_ipran[' + contar + ']" value="'+use_vlan_value+'"></div>';
                    $("#campos_vlan_ring_ipran").append(input);
                }
                modal.click();
                $('#use_vlan').val('');
                $('#vlan').val('');
                $('#ip_admin_id').val('');
                $('#ip_admin').val('');
            }else{
                toastr.error("La IP ya esta seleccionada");
            }
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function quitar_vlan(campo, ip){
    var index = id_ip_cargada.indexOf(ip);
    if (index == -1) {
        id_ip_cargada.splice(index, 1);
    }
    $('#input'+campo).remove();
}

function rango_rama_lis_anillo(id){
    var id_rama_old = document.getElementById("id_rama_old").value;
    var id_rango_old = document.getElementById("id_rango_old").value;
    var id_function = document.getElementById("id_function").value;
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    if (id != id_rama_old && id_rama_old!= 0 && id_rango_old == 'Si'){
        var positivo_old = document.getElementById('positivo'+id_rama_old+'');
        var negativo_old = document.getElementById('negativo'+id_rama_old+'');
        negativo_old.style.display = "none";
        positivo_old.style.display = "block";
    }
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                var new_tbody = document.createElement('div');
                $("#multi_table_ip").html(new_tbody);
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay datos para este grupo");
                    }else{
                        positivo.style.display = "none";
                        negativo.style.display = "block";
                        var titulo = '<h4><i class="fa fa-file-archive-o"></i>  Rango: '+data['nombre']+' :'+data['inicio']+'/'+data['barra']+'</h4>';
                        titulo += '<h4> Detalle de las Ip del Rango</h4>';
                        $("#multi_table_ip").append(titulo)
                        var table = '<div><table class="table table-striped table-bordered table-hover dataTables-example">';
                        table +='<thead> <tr> <th>Estado</th> <th>Dirección</th> <th>SUBNET</th> <th></th> </tr> </thead>';
                        table +='<tbody id="tbodyramas"> </tbody>';
                        table +='</table></div>';
                        $("#multi_table_ip").append(table)
                        $(data['datas']).each(function(i, v){ // indice, valor
                            var valor = '<tr>';

                            if (data['datas'][i]['ip'] == data['fin']) {
                                valor += '<td><center><i class="fa fa-globe"></i></center></td>';
                            }else{
                                if (id_function != 1) {
                                    switch (data['datas'][i]['type']) {
                                        case "RED":
                                            valor += '<td><center><i class="fa fa-desktop"></i> RED</center></td>';
                                            break;
                                        case "GATEWAY":
                                            valor += '<td><center><i class="fa fa-laptop"></i> GATEWAY</center></td>';
                                            break;
                                        case "BROADCAST":
                                            valor += '<td><center><i class="fa fa-globe"></i> BROADCAST</center></td>';
                                            break;
                                        default :
                                            valor += '<td><center>' + data['datas'][i]['status'] + '</center></td>';
                                            break;
                                    }
                                }else{
                                    switch (data['datas'][i]['type']) {
                                        case "RED":
                                            valor += '<td><center><i class="fa fa-desktop"></i> RED</center></td>';
                                            break;
                                        case "GATEWAY":
                                            valor += '<td><center>GATEWAY</center></td>';
                                            break;
                                        case "BROADCAST":
                                            valor += '<td><center><i class="fa fa-globe"></i> BROADCAST</center></td>';
                                            break;
                                        default :
                                            valor += '<td><center>' + data['datas'][i]['status'] + '</center></td>';
                                            break;
                                    }
                                }
                            }
                            valor += '<td> ' + data['datas'][i]['ip'] + '</td>' +
                                '<td>' + data['datas'][i]['subnet'] + '</td>';
                            if ((data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == 'DISPONIBLE') || (data['datas'][i]['type'] == "GATEWAY" && id_function == 1)) {
                                valor +='<td> <i class="fa fa-dot-circle-o" onclick="selecion_ip_rango('+data['datas'][i]['id_rango']+');"></i></td>' +
                                    '</tr>';
                            }else{
                                valor +='<td> <i class="fa fa-warning"></i></td>' +
                                    '</tr>';
                            }
                            $("#tbodyramas").append(valor)

                        });
                        $('#id_rama_old').val(id);
                        $('#id_rango_old').val('Si');
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function search_vlan_ip(id, id_equip){
    var new_tbody = document.createElement('tbody');
    $("#list_ip_vlan_mostrar").html(new_tbody);
    $('#id_equip_vlan').val(id_equip);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/vlan',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $('#id_anillo_vlan').val(id);
                    $("#list_ip_vlan_mostrar").html(new_tbody);
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr id="linea' + data['datos'][i].id + '" >';
                        valor += '<td>' + data['datos'][i].name + '</td>';
                        valor += '<td>' + data['datos'][i].vlan + '</td>';
                        if (data['datos'][i].sufijo_vcid != null) { valor += '<td>' + data['datos'][i].sufijo_vcid + '</td>';
                        } else { valor += '<td> - </td>'; }
                        valor += '<td>' + data['datos'][i].ip + '/' + data['datos'][i].prefixes + '</td>';
                        valor += '<td><a> <i class="fa fa-trash" title="Eliminar Vlan" onclick="delete_vlan_ip(' + data['datos'][i].id + ');"> </i></a></td>';
                        valor += '</tr>';
                        $("#list_ip_vlan_mostrar").append(valor);
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delete_vlan_ip(id){
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    modal0.style.display = "block";
    mensaje.textContent  = "Esta seguro que desea eliminar el registro?";
    aceptar.onclick = function() {
        modal0.style.display = "none";
        modal.click();
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'eliminar/vlan',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "Exist":
                        toastr.error("Alguna IP de este Rango esta siendo usada");
                        break;
                    case "yes":
                        var new_tbody = document.createElement('tr');
                        $("#linea"+id+"").html(new_tbody);
                        toastr.success("Modificación Exitosa");
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal0.style.display = "none";
    }
}

function crear_vlan_rango_ip(funti = null){
    if (funti == 2) {
        var id_equip = document.getElementById("id_equip_vlan").value;
    } else if (funti == 1) {
        var id_equip = document.getElementById("id_lsw").value;
    } else {
        var id_equip = document.getElementById("agg").value;
    }
    $("#use_vlan").off();
    $("#next_free_vlan").off();
    $("#use_vlan").on('change', function() {
        $("#button_frontier").off();
        $("#free_vlans_arr").off();
        use_vlan_new(funti);
        $("#free_vlans_arr").on('change', () => next_vlan(2));
        $("#button_frontier").attr('onClick', 'list_frontier('+id_equip+')');
        $("#next_free_vlan").attr('onClick', 'next_vlan('+funti+')');
    });

    document.getElementById("vla_all_new").reset();
    var aceptar = document.getElementById("vlan_aceptar");
    var cancelar = document.getElementById("vlan_cancelar");
    var modal = document.getElementById("exit_alta_vlan");
    var admin_ip_vlan = document.getElementById('admin_ip_vlan');
    var div_frontier = document.getElementById('div_frontier');
    var div_vlan = document.getElementById('div_vlan');
    admin_ip_vlan.style.display = 'none';
    div_vlan.style.display = 'none';
    div_frontier.style.display = 'none';
    aceptar.onclick = function() {
        if (funti == null) {
            var anilo_id = document.getElementById("anilo_id");
            if (anilo_id != null) {
                var id_anillo_vlan = anilo_id.value;
            }else{
                var id_anillo_vlan = document.getElementById("id_anillo_vlan").value;
            }
        }else if (funti == 2){
            var id_anillo_vlan = document.getElementById("id_anillo_vlan").value;
        }else{
            var id_anillo_vlan = document.getElementById("id_ring_new").value;
        }
        var use_vlan = document.getElementById("use_vlan").value;
        var vlan = document.getElementById("free_vlans").value;
        var ip_admin_id = document.getElementById("ip_admin_id_anillo").value;
        var id_frontier = document.getElementById("select_frontier").value;
        if (use_vlan == '' || use_vlan.length == 0) {
            toastr.error("El uso de la vlan es obligatorio");
        } else if (id_frontier == '') {
            toastr.error("La frontera es obligatoria");
        } else if (vlan == '' || vlan == 0 ) {
            toastr.error("La Vlan es obligatoria");
        } else if (ip_admin_id == '' || ip_admin_id.length == 0 ) {
            toastr.error("La IP es obligatoria");
        } else {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/vlan',
                data: { id:id_anillo_vlan, uso:use_vlan, vlan:vlan, ip:ip_admin_id, id_equipment:id_equip, id_frontier:id_frontier },
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            break;
                        case "exit":
                            toastr.error("Alguna IP de este Rango esta siendo usada");
                            break;
                        case "yes":
                            toastr.success("Registro Exitoso");
                            modal.click();
                            if (anilo_id != null) {
                                buscar_ip_admin_lanswitch(2);
                            }else{
                                search_vlan_ip(data['datos'], id_equip);
                            }
                            if (funti == 10) {
                                buscar_ip_lanswitch(funti);
                            }
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function use_vlan_new(fun = null){
    var id_list_use_vlan = document.getElementById("use_vlan").value;
    var admin_ip_vlan = document.getElementById('admin_ip_vlan');
    var ip_admin = document.getElementById('ip_admin_anillo');
    var id_anillo = document.getElementById('ip_admin_id_anillo');
    var div_vlan = document.getElementById('div_vlan');
    var vlans = $('#free_vlans');
    var frontier = $('#select_frontier');
    var div_frontier = document.getElementById('div_frontier');
    vlans.find('option').remove();
    vlans.append('<option selected disabled value="0">0000</option>');
    frontier.find('option').remove();
    frontier.append('<option selected disabled value="0">000</option>');

    $.ajax({
        type: "get",
        url: getBaseURL()+'vlan/frontera/'+id_list_use_vlan,
        cache: false,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            switch (data['resul']) {
                case "yes":
                    div_vlan.style.display = 'none';
                    div_frontier.style.display = 'block';
                    frontier.on('change.select2', function (){
                        vlans.find('option').remove();
                        vlans.append('<option selected disabled value="0">0000</option>');
                        get_free_vlans(fun);
                        div_vlan.style.display = 'block';
                    });
                    break;
                case "nop":
                    div_frontier.style.display = 'none';
                    get_free_vlans(fun);
                    div_vlan.style.display = 'block';
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

    $.ajax({
        type: "POST",
        url: getBaseURL() +'vlan/rango',
        data: {id:id_list_use_vlan},
        dataType: 'json',
        cache: false,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    ip_admin.value = '';
                    id_anillo.value = '' ;
                    if (data['datos'] == 'SI') {
                        admin_ip_vlan.style.display = "block";
                    }else{
                        admin_ip_vlan.style.display = "none";
                        // si es solo cuando desaparece el campo; ponerlo aca el '';
                    }
                    $('#rango_ip').val(data['datos']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function address_general(){
    var mensaje = document.getElementById("title_address_general");
    mensaje.textContent  = 'REGISTRAR DIRECCIÓN';
    $('#id_address_edic').val(0);
    $('#pais').val('').trigger('change.select2');
    $('#provin').val('').trigger('change.select2');
    $('#local').val('');
    $('#calle').val('');
    $('#altura').val('');
    $('#piso').val('');
    $('#apartamento').val('');
    $('#postal').val('');
}

function register_address(func = null){
    var id = document.getElementById("id_address_edic").value;
    var pais = document.getElementById("pais").value;
    var provin = document.getElementById("provin").value;
    var local = document.getElementById("local").value.toUpperCase();
    var calle = document.getElementById("calle").value.toUpperCase();
    var altura = document.getElementById("altura").value;
    var piso = document.getElementById("piso").value.toUpperCase();
    var apartamento = document.getElementById("apartamento").value;
    var postal = document.getElementById("postal").value;
    var modal = document.getElementById("address_exit");
    if (pais == '' || pais.length == 0) {
        toastr.error("El Pais es obligatorio.");
    }else if (provin == '' || provin.length == 0 ) {
        toastr.error("La Provincia es obligatorio.");
    }else if (local == '' || local.length == 0 ) {
        toastr.error("La Localidad es obligatorio.");
    }else if (calle == '' || calle.length == 0 ) {
        toastr.error("La Calle es obligatorio.");
    }else if (altura == '' || altura.length == 0 ) {
        toastr.error("La Altura es obligatorio.");
    }else{
        var dire = $("#address");
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/direccion',
            data: {id:id, pais:pais, provin:provin, local:local, calle:calle, altura:altura, piso:piso, apartamento:apartamento, postal:postal,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "no":
                        toastr.error("La dirección ya existe");
                        break;
                    case "yes":
                        modal.click();
                        if (id == 0) {
                            detal_addres(3);
                            detal_addres(1);
                            $('#list_address').DataTable().ajax.reload();
                            toastr.success("Registro Exitoso");
                        }else{
                            toastr.success("Modificación Exitosa");
                            $('#list_address').DataTable().ajax.reload();
                        }
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
}

function search_address(id){
    var mensaje = document.getElementById("title_address_general");
    mensaje.textContent  = 'MODIFICAR DIRECCIÓN';
    $('#id_address_edic').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/direccion',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $('#pais').val(data['datos']['id_countries']).trigger('change.select2');
                    $('#local').val(data['datos']['location']);
                    $('#calle').val(data['datos']['street']);
                    $('#altura').val(data['datos']['height']);
                    $('#piso').val(data['datos']['floor']);
                    $('#apartamento').val(data['datos']['department']);
                    $('#postal').val(data['datos']['postal_code']);
                    provincia_all(data['datos']['provinces']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function buscar_ip_lanswitch(fun = null){
    if (fun == 10) {
        var id = document.getElementById("id_ring_new").value;
    }else{
        var id = document.getElementById("anilo_id").value;
    }
    var new_tbody = document.createElement('tbody');
    $("#ip_lanswitch_table").html(new_tbody);
    $("#ip_lsw_ring_ipran").html(new_tbody);
    if (id == '' || id.length == 0) {
        toastr.error("seleccione el Anillo Primero");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'buscar/ip/lanswitch',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#ip_lanswitch_table").html(new_tbody);
                        $("#ip_lsw_ring_ipran").html(new_tbody);
                        if (data['datos'].length == 0) {
                            toastr.error("El Anillo no tiene Vlan de Gestión LS");
                        }
                        if (fun == 10) {
                            $(data['datos']).each(function(i, v){
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i].ip +'</td>' +
                                    '<td>'+ data['datos'][i].acronimo + '</td>' +
                                    '<td>' + data['datos'][i].uso +' '+ data['datos'][i].vlan + '</td>';
                                if (data['datos'][i].type == 'DISPONIBLE' && data['datos'][i].id_status == 1) {
                                    valor += '<td><a> <i class="fa fa-bullseye" onclick="selecion_ip_rango('+data['datos'][i].id+','+fun+');" title="Seleccionar IP"> </i></a></td>' +
                                        '</tr>';
                                }else{
                                    valor += '<td><a title="IP no disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a></td>' +
                                        '</tr>';
                                }
                                $("#ip_lsw_ring_ipran").append(valor);
                            });
                        }else{
                            $(data['datos']).each(function(i, v){
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i].ip +'</td>' +
                                    '<td>'+ data['datos'][i].acronimo + '</td>' +
                                    '<td>' + data['datos'][i].uso +' '+ data['datos'][i].vlan + '</td>';
                                if (data['datos'][i].type == 'DISPONIBLE' && data['datos'][i].id_status == 1) {
                                    valor += '<td><a> <i class="fa fa-bullseye" onclick="selecion_ip_rango('+data['datos'][i].id+','+fun+');" title="Seleccionar IP"> </i></a></td>' +
                                        '</tr>';
                                }else{
                                    valor += '<td><a title="IP no disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a></td>' +
                                        '</tr>';
                                }
                                $("#ip_lanswitch_table").append(valor);
                            });
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function port_lanswitch_selec(){
    // var equi_con_1 = document.getElementById("equi_con_1").value;
    // var equi_con_2 = document.getElementById("equi_con_2").value;
    var anilo = document.getElementById("anilo_id").value;
    var table_por_2 = document.getElementById('table_por_2');
    var placa_alta = document.getElementsByClassName("placa_alta");
    var mensaje = document.getElementById("title_por_1");
    var title_equi_1 = document.getElementById("title_equi_1");
    var mensaje2 = document.getElementById("title_por_2");
    var title_equi_2 = document.getElementById("title_equi_2");
    var placa = [];
    for (var i = 0; i < placa_alta.length; ++i) {
        if (typeof placa_alta[i].value !== "undefined"){ placa.push(placa_alta[i].value);}
    }
    var p1 = $("#por1");
    var p2 = $("#por2");
    p1.find('option').remove();
    p2.find('option').remove();
    mensaje.textContent = '';
    mensaje2.textContent = '';
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/lanswitch',
        data: {anilo:anilo, placa:placa,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "nop":
                    toastr.error(data['datos']);
                    break;
                case "yes":
                    $('#count_port').val(data['coun']);
                    mensaje.textContent = data['ring'].name;
                    title_equi_1.textContent  = '';
                    p1.append('<option selected disabled value="">seleccionar</option>');
                    $(data['datos']).each(function(i, v){ // indice, valor
                        p1.append(
                            '<option value="'+data['datos'][i]['port']+'|'+data['datos'][i]['id']+'">'+data['datos'][i].label+data['datos'][i].slot+data['datos'][i].port+' '+data['datos'][i].type+'</option>'
                        );
                    });

                    table_por_2.style.display = "block";
                    mensaje2.textContent = data['ring'].name;
                    title_equi_2.textContent = '';
                    p2.append('<option selected disabled value="">seleccionar</option>');
                    $(data['datos']).each(function(i, v){ // indice, valor
                        p2.append(
                            '<option value="'+data['datos'][i]['port']+'|'+data['datos'][i]['id']+'">'+data['datos'][i].label+data['datos'][i].slot+data['datos'][i].port+' '+data['datos'][i].type+'</option>'
                        );
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

var numero = 0;
function port_lanswitch_all(){
    var modal = document.getElementById("cerra_puerto_all");
    var count_port = document.getElementById("count_port").value;
    var select = document.getElementById("por1"),
        por1 = select.value,
        por1_text = select.options[select.selectedIndex].innerText;
    var select2 = document.getElementById("por2"),
        por2 = select2.value,
        por2_text = select2.options[select2.selectedIndex].innerText;
    var port1 = por1.split('@');
    var port2 = por2.split('@');
    if (por1 == '' || por1.length == 0) {
        toastr.error("El puerto es obligatorio.");
    }else{
        var campos = $("#campos_port_all");
        var new_tbody = document.createElement('div');
        campos.html(new_tbody);
        numero++;
        input = '<input type="text" readonly="readonly" class="form-control" value="'+por1_text+'">                <input type="hidden" class="port_lanswitch" name="port_lanswitch[' + numero + ']" value="'+por1+'">';
        campos.append(input);
        numero++;
        input = '<input type="text" readonly="readonly" class="form-control" value="'+por2_text+'">                <input type="hidden" class="port_lanswitch" name="port_lanswitch[' + numero + ']" value="'+por2+'">';
        campos.append(input);
        modal.click();
    }
}

function equipment_lanswitch(){
    var anillo = document.getElementById("anilo_id").value;
    var equip = document.getElementById("equi_con_1").value;
    var equi_2 = $("#equi_con_2");
    equi_2.find('option').remove();
    if (anillo != 0 && anillo != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'equipo/lanswitch',
            data: {anillo:anillo, equip:equip},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        equi_2.append('<option selected disabled value="">seleccionar</option>');
                        $(data['datos']).each(function(i, v){
                            equi_2.append(
                                '<option value="'+data['datos'][i]['id']+'">'+data['datos'][i].name+'</option>'
                            );
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

function alta_servicio_crear(id=null){
    var mensaje = document.getElementById("title_service");
    mensaje.textContent  = 'CREAR SERVICIO';
    var boton_client = document.getElementById('bus_client');
    boton_client.style.display = "block";
    var boton_client_create = document.getElementById('new_clit');
    boton_client_create.style.display = "block";
    document.getElementById("alta_serv").reset();
    $("#id_client_servi").find('option').remove();
    $("#direc_a").find('option').remove();
    $("#direc_b").find('option').remove();
    $("#id_client_servi").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#direc_a").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#direc_b").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#type_servi').val('').trigger('change.select2');
    $('#max').val(1);
    $('#id_service').val('0');
}

function alta_service(){
    var id = document.getElementById("id_service").value;
    var service = document.getElementById("service").value;
    var type = document.getElementById("type_servi").value;
    var n_max = document.getElementById("n_max").value;
    var max = document.getElementById("max").value;
    var id_client = document.getElementById("id_client_servi").value;
    var ord = document.getElementById("ord").value;
    var direc_a = document.getElementById("direc_a").value;
    var direc_b = document.getElementById("direc_b").value;
    var come = document.getElementById("come").value;
    var functi = document.getElementById("functi").value;
    var servi_relation = document.getElementById("servi_relation").value;
    var relation = document.getElementById("option_relation_service").value;
    var option_bw = document.getElementById("option_bw_service").value;
    if (service == '' || service.length == 0) {
        toastr.error("El Numero de Servicio es obligatorio.");
    }else if (type == '' || type.length == 0) {
        toastr.error("El Tipo es obligatorio.");
    }else if ((max == '' || max == 0) && option_bw == 'SI') {
        toastr.error("El ancho de banda es obligatorio.");
    }else if ((n_max == '' || n_max.length == 0) && option_bw == 'SI') {
        toastr.error("El ancho de banda es obligatorio.");
    }else if (id_client == '' || id_client.length == 0) {
        toastr.error("El Cliente es obligatorio.");
    }else if (ord == '' || ord.length == 0) {
        toastr.error("La Orden es obligatorio.");
    }else if (direc_a == '' || direc_a.length == 0) {
        toastr.error("La Dirección 'A' es obligatorio.");
    }else{
        if (n_max == null) {
            n_max = 2;
        }
        var bw = n_max * max;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/servicio',
            data: {id:id, service:service, type:type, id_client:id_client, ord:ord, direc_a:direc_a, direc_b:direc_b, bw:bw, come:come, servi_relation:servi_relation},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "exis":
                        toastr.error("El service ya existe");
                        break;
                    case "yes":
                        var modal = document.getElementById("cerra_crear_ser");
                        toastr.success("Registrado Exitoso");
                        var ref = $('#servicios_list').DataTable();
                        ref.ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function search_service(id){
    var mensaje = document.getElementById("title_service");
    mensaje.textContent  = 'MODIFICAR SERVICIO';
    $('#id_service').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/servicio',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#type_servi').val(data['datos']['id_type']).trigger('change.select2');
                    selec_client(data['datos']['id_client']);
                    selec_address(data['datos']['id_address_a'], 2)
                    selec_address(data['datos']['id_address_b'], 3)
                    $('#service').val(data['datos']['number']);
                    $('#ord').val(data['datos']['order_high']);
                    $('#come').val(data['datos']['commentary']);
                    $('#n_max').val(~~data['bw']['data']);
                    $('#max').val(data['bw']['logo']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function port_selec_servi(interface = null, form = null){
    var servivio = document.getElementById('id_servicio_recurso').value;
    var target_form = document.getElementById("target_form");
    target_form.value = form;
    switch (interface) {
        case 1:
            var equip = document.getElementById("equip_id_inp").value;
            break;
        case 2:
            var equip = document.getElementById("equip_sel").value;
            break;
        case 3:
            var equip = document.getElementById("equip_id_inp").value;
            break;
        case 4:
            var equip = document.getElementById("equip_id_inp").value;
            break;
        case 5:
            var equip = document.getElementById("equip_id_inp").value;
            break;
        default:
            var equip = document.getElementById('equip').value;
            break;
    }

    let por_sel = [];
    $("input[type=checkbox]:checked").each(function(){
        por_sel.push(this.value);
    });

    var new_tbody = document.createElement('tbody');
    $("#por_alta_servicio").html(new_tbody)

    if (equip == '' || equip.length == 0) {
        toastr.error("Seleccione el Equipo");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'puerto/servicio',
            data: {id:equip, servivio:servivio},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        console.log(data['datos']);
                        break;
                    case "yes":
                        if (data['resul'] == 'nop') {
                            toastr.error("No tiene puerto disponible este agregador");
                        }else{
                            $(data['grupo']).each(function(i, v){ // indice, valor
                                var valor = '<tr>' +
                                    '<td>' + data['grupo'][i]['name'] +'</td>' +
                                    '<td>' + data['grupo'][i]['atributo'] + '</td>' +
                                    '<td>'+data['grupo'][i]['number']+'</td>' +
                                    '<td>'+data['grupo'][i]['commentary']+'</td>' +
                                    '<td> <input type="checkbox" id="" name="por[]" value="'+ data['grupo'][i]['port'] +'">'+
                                    ' <a data-toggle="modal" data-target="#port_recurso_sevicio_pop" title="Agregar puerto" onclick="sum_port_group('+data['grupo'][i]['id_group']+');"> <i class="fa fa-plus-square"> </i> </a> '+
                                    '<a data-toggle="modal" data-target="#port_recurso_sevicio_pop" title="Quitar puerto" onclick="res_port_group('+data['grupo'][i]['id_group']+');"> <i class="fa fa-minus-square"> </i> </a> </td>' +
                                    '</tr>';
                                $("#por_alta_servicio").append(valor)
                            })

                            $(data['datos']).each(function(i, v){ // indice, valor
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i]['label'] + data['datos'][i]['f_s_p'] + data['datos'][i]['por_selec'] + '</td>';
                                valor += '<td>' + data['datos'][i]['type_port'] + '</td>';
                                if (data['datos'][i]['type'] != "ANILLO" && data['datos'][i]['type'] != "LINK" && data['datos'][i]['type'] != "UPLINK") {
                                    valor += '<td>' + data['datos'][i]['atributo'] + '</td>';
                                }else{
                                    valor += '<td>' + data['datos'][i]['type'] + '</td>';
                                }
                                valor += '<td>' + data['datos'][i]['service'] + '</td>';
                                valor += '<td>' + data['datos'][i]['commentary'] + '</td>';
                                if (data['datos'][i]['group'] == '' && data['datos'][i]['type'] != "ANILLO" && data['datos'][i]['type'] != "LINK" && data['datos'][i]['type'] != "UPLINK") {
                                    valor += '<td><input type="checkbox" id='+data['datos'][i]['id']+' name="por[]" value="'+data['datos'][i]['id']+'">';
                                }else{
                                    if (data['datos'][i]['type'] != "ANILLO" && data['datos'][i]['type'] != "LINK" && data['datos'][i]['type'] != "Uplink") {
                                        valor +='<td> <i class="fa fa-unlock-alt" style="color: coral;" title="Esta en un grupo"></i>';
                                    }else if(data['datos'][i]['type'] == "ANILLO"){
                                        valor +='<td> <i class="fa fa-circle-o-notch" style="color: coral;" title="Puerto del anillo"></i>';
                                    } else{
                                        valor +='<td> <i class="fa fa-unlink" style="color: coral;" title="Puerto del Uplink"></i>';
                                    }
                                }
                                valor +=' <a data-toggle="modal" data-target="#popcomen_port" title="Comentario del puerto" onclick="commen_port_servi('+data['datos'][i]['board']+','+data['datos'][i]['por_selec']+');"> <i class="fa fa-twitch"> </i> </a> </td></td>';
                                valor += '</tr>';
                                $("#por_alta_servicio").append(valor)
                            })
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function port_servi_pantalla(form = null){
    switch (form) {
        case '1':
            var port_list = $("#campos_port_1");
            var servic = document.getElementById('service_sele');
            break;
        case '2':
            var port_list = $("#campos_port_2");
            var servic = document.getElementById('service_sele');
            break;
        case '3':
            var port_list = $("#campos_port_3");
            var servic = document.getElementById('service_sele');
            break;
        case '4':
            var port_list = $("#campos_port_4");
            var servic = document.getElementById('service_sele');
            break;
        case '5':
            var port_list = $("#campos_port_5");
            var servic = document.getElementById('service_sele');
            break;
        default:
            var port_list = $("#campos_port");
            var servic = document.getElementById('service_sele');
            break;
    }
    if (servic == null || servic.value == '') var servicio = document.getElementById('id_servicio_recurso').value;
    else var servicio = servic.value;
    var modal = document.getElementById("exit_port_servi");
    var mensaje = document.getElementById("myMensaje");
    let port = [];
    let checks = $("#por_alta_servicio").find("input[type=checkbox]:checked");

    checks.each((i) => port.push(checks[i].value));
    if (port.length == 0) {
        toastr.error("Seleccione puerto.");
    } else {
        $.ajax({
            type: "POST",
            url: getBaseURL() +'agregar/puerto/servicio',
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            data: {id:port, servicio:servicio},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        if (data['msj'] == 0 || data['msj_max'] == 0 || data['msj_anillo'] == 0) {
                            var modal0 = document.getElementById('confirmacion');
                            var aceptar = document.getElementById("myBtnSi");
                            var cancelar = document.getElementById("myBtnNo");
                            modal0.style.display = "block";
                            if (data['msj_anillo'] == 0) {
                                mensaje.textContent = "La suma del ancho de banda de los servicios supera la capacidad del anillo. ¿Desea continuar?";
                            } else {
                                if (data['msj'] == 0) {
                                    mensaje.textContent = "El ancho de banda del servicio es mayor al del puerto. ¿Desea continuar?";
                                } else {
                                    mensaje.textContent = "El ancho de banda de los servicios es mayor al del puerto. ¿Desea continuar?";
                                }
                            }
                            aceptar.onclick = function() {
                                modal0.style.display = "none";
                                modal.click();
                                var new_tbody = document.createElement('div');
                                port_list.html(new_tbody);
                                $(data['datos']).each(function(i, v){ // indice, valor
                                    campo = '<div class="bw_all" id="input_servi'+i+'" > <input type="text" readonly="readonly" class="form-control" value="'+data['datos'][i]['port']+'">    <input type="hidden" class="puerto_sevicio_alta" id="puerto_sevicio_alta['+i+']" name="puerto_sevicio_alta['+i+']" value="'+data['datos'][i]['id']+'"></div>';
                                    port_list.append(campo);
                                })
                                $("#campos_port_all_full").html(new_tbody)
                                $(data['datos']).each(function(i, v){ // indice, valor
                                    campo = '<div class="bw_all" id="input_servi_edic'+i+'" > <input type="text" readonly="readonly" class="form-control" value="'+data['datos'][i]['port']+'">    <input type="hidden" class="puerto_sevicio_alta_edic" id="puerto_sevicio_alta_edic['+i+']" name="puerto_sevicio_alta_edic['+i+']" value="'+data['datos'][i]['id']+'"></div>';
                                    $("#campos_port_all_full").append(campo);
                                })
                            }
                            cancelar.onclick = function() {
                                var new_tbody = document.createElement('div');
                                port_list.html(new_tbody);
                                modal0.style.display = "none";
                            }
                        } else {
                            modal.click();
                            var new_tbody = document.createElement('div');
                            port_list.html(new_tbody);
                            $(data['datos']).each(function(i, v){ // indice, valor
                                campo = '<div class="bw_all" id="input_servi'+i+'" > <input type="text" readonly="readonly" class="form-control" value="'+data['datos'][i]['port']+'">    <input type="hidden" class="puerto_sevicio_alta" id="puerto_sevicio_alta['+i+']" name="puerto_sevicio_alta['+i+']" value="'+data['datos'][i]['id']+'"></div>';
                                port_list.append(campo);
                            })
                            $("#campos_port_all_full").html(new_tbody)
                            $(data['datos']).each(function(i, v){ // indice, valor
                                campo = '<div class="bw_all" id="input_servi_edic'+i+'" > <input type="text" readonly="readonly" class="form-control" value="'+data['datos'][i]['port']+'">    <input type="hidden" class="puerto_sevicio_alta_edic" id="puerto_sevicio_alta_edic['+i+']" name="puerto_sevicio_alta_edic['+i+']" value="'+data['datos'][i]['id']+'"></div>';
                                $("#campos_port_all_full").append(campo);
                            })
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function alta_servicio_recurso(service_type){
    var mensaje = document.getElementById("title_recurso");
    mensaje.textContent  = 'AGREGAR RECURSO';
    var ip_campo = document.getElementById('ip_servicio');
    var rango_ip = document.getElementById('rango_servicio');
    var servicio = document.getElementById('id_servicio_recurso').value;
    const serv_type = document.getElementById('srv_type_inp');
    $('#equip').val('').trigger('change.select2');
    $('#type_equip').val('').trigger('change.select2');
    $('#ip_admin_servi_id').val('');
    $('#ip_admin_servi').val('');
    var div = document.createElement('div');
    $("#campos_port").html(div);
    serv_type.value = service_type;

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ip/rango/recurso',
        data: {id:servicio},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                break;
                case "yes":
                    $('#reques_ip').val(data['datos']['require_ip']);
                    $('#reques_rank').val(data['datos']['require_rank']);
                    if (data['datos']['require_ip'] == 'SI'){
                        ip_campo.style.display = "block"; 
                    }else{
                        ip_campo.style.display = "none";
                    }
                    if (data['datos']['require_rank'] == 'SI'){
                        rango_ip.style.display = "block"; 
                    }else{
                        rango_ip.style.display = "none";
                    }
                break;        
            }
        },
        error: function() { 
            toastr.error("Error con el servidor");
        }
    });                              
}

function por_equipm(){
    var equip = document.getElementById('equip').value;
    var port = document.getElementById('port_lanswitch_list');
    var vlan = document.getElementById('input_vlan');
    if (equip != '') {
        port.style.display = "block"; 
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'ip/wan',
            data: {id:equip,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                    break;
                    case "yes":
                        if (data['datos'].length != 0) {
                            $('#ip_admin_servi_id').val(data['datos']['id']);
                            $('#ip_admin_servi').val(data['datos']['ip']+'/'+data['datos']['prefixes']);
                        }else{
                            $('#ip_admin_servi_id').val('');
                            $('#ip_admin_servi').val('');
                        }
                        if (data['equi_ip']['ip_wan_rpv'] != '' && data['equi_ip']['ip_wan_rpv'] != null) {
                            vlan.style.display = "none";
                        }else{
                            vlan.style.display = "block";
                        }
                    break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                    break;        
                }
            }
            /*error: function() { 
                toastr.error("Error con el servidor");
            }*/
        });
    }else{
        port.style.display = "none";
    }
}

function list_equipment(){
    var type= document.getElementById('type_equip').value;
    var fun = $("#type_equip").find('option:selected').text();
    var label = document.getElementById("name_vlan");
    let serv_type = document.getElementById('srv_type_inp').value;
    if (type != '') {
        if ((serv_type == 15 || serv_type == 20) && type == 4) {
            redirect_service_assignment();
        }
        list_equipmen_servi(fun);
        switch (type) {
            case '4':
                label.textContent = 'VLAN Metro-tag';
            break;
            case '2':
                label.textContent = 'VLAN Local';
            break;
            default:
                label.textContent = 'VLAN';
            break;
        }
    }else{
        label.textContent = 'VLAN';
    }
}

function sele_equi_servi(id){
    var modal = document.getElementById("cerra_buscar_equipo_all");
    var selec = $("#equip");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                break;
                case "yes":
                    selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>');
                    selec.val(id).trigger('change.select2');
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
    modal.click();
}

function alta_service_recurso(){
    let reserva_flag = false;
    var id_servicio = document.getElementById('id_servicio_recurso').value;
    var equip = document.getElementById('equip').value;
    var ip_admin = document.getElementById('ip_admin_servi_id').value;
    var ip_rank = document.getElementById('ip_rank_servi_id').value;
    var vlan = document.getElementById('vlan_recurso').value;
    var puerto_sevicio_alta = document.getElementsByClassName("puerto_sevicio_alta");
    var modal = document.getElementById("cerra_recurso_ser");
    var port = [];
    if(document.getElementById('reserve_option') == null || document.getElementById('select_option_reserve') == null){
        var reserve = '';
        var reserve_si_no = '';
    } else {
        var reserve = document.getElementById('reserve_option').value;
        var reserve_si_no = document.getElementById('select_option_reserve').value;
    }
    let ipran = $("#ipran").val();

    for (var i = 0; i < puerto_sevicio_alta.length; ++i) {
        if (typeof puerto_sevicio_alta[i].value !== "undefined") {
            port.push(puerto_sevicio_alta[i].value);
        }
    }
    if (ipran == 'si') {
        if (reserve_si_no == 2) {
            if (reserve == '' || reserve.length == 0){
                toastr.error("La reserva es obligatoria");
            } else {
                reserva_flag = true;
            }
        } else if(reserve_si_no == 1) {
            //El usuario elige NO usar alguna reserva
            reserve = '';
            reserva_flag = true;
        } else if(reserve_si_no == 0) {
            reserva_flag = false;
        }
    } else {
        reserve = '';
        reserva_flag = true;
    }
    if (equip == '' || equip.length == 0) {
        toastr.error("El Equipo es obligatorio.");
    } else if (port == '' || puerto_sevicio_alta.length == 0) {
        toastr.error("El Puerto es obligatorio.");
    } else if(!reserva_flag) {
        toastr.error("La seleccion de reserva es obligatoria");
    } else {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/recurso',
            data: {id_servicio:id_servicio, ip_admin:ip_admin, port:port, ip_rank:ip_rank, vlan:vlan, equip:equip, reserve:reserve,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                    break;
                    case "ip_exi":
                        toastr.error("La IP ya esta ocupada");
                    break;
                    case "ip_ring":
                        toastr.error("La IP WAN no esta asociada a un anillo");
                    break;
                    case "bw_bajo":
                        toastr.error("El ancho de banda del servicio es mayor al del puerto");
                    break;
                    case "rank_exi":
                        toastr.error("Al meno una IP del rango esta ocupada");
                    break;
                    case "yes":
                        if (data['datos'] == 1) {
                            toastr.info('El ancho de banda del servicio es mayor al del puerto')
                        }
                        toastr.success("Registrado Exitoso");
                        delete_recur();
                        modal.click();
                        ver_recurso_servicio(id_servicio);
                        $('#respu').val('SI');
                        $('#cometari').val('');
                    break;    
                }
            },
            error: function() { 
                toastr.error("Error con el servidor");
            }
        });
    }
}

function delete_recur(){
    var new_tbody = document.createElement('div');
    $("#campos_port").html(new_tbody)
    $('#id_recurso').val('');
    $('#equip').val('');
    $('#ip_admin_servi_id').val('');
    $('#reques_ip').val('');
    $('#ip_admin_servi').val('');
    $('#ip_rank_servi_id').val('');
    $('#ip_admin_rank').val('');
    $('#grupo_puerto').val('NO');
    $('#vlan_recurso').val('');
    $('#reques_rank').val('');
}

function ver_recurso_servicio(id, type = null){
    $('#id_servicio_recurso').val(id);
    $('#id_servicio_tipo').val(type);
    var new_tbody = document.createElement('tbody');
    $("#por_alta_recursos").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/recurso',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['slot'] +''+ data['datos'][i]['n_port'] +'</td>' +
                            '<td>' + data['datos'][i]['acronimo'] + '</td>' +
                            '<td>' + data['datos'][i]['group'] + '</td>' +
                            '<td>' + data['datos'][i]['vlan'] + '</td>' +
                            '<td>' + data['datos'][i]['commentary'] + '</td>' +
                            '<td><a data-toggle="modal" data-target="#vlan_pop_new" > <i class="fa fa-edit" onclick="vlan_servi_recurso('+data['datos'][i]['port']+','+ data['datos'][i]['vlan']+');" title="Modificar Vlan"> </i></a>';
                        if (data['datos'][i]['group'] != '' && data['datos'][i]['group'] != null) {
                            valor += ' <a data-toggle="modal" data-target="#port_recurso_sevicio_pop"><i class="fa fa-plus-square-o" onclick="list_port_new('+data['datos'][i]['equipo']+','+ data['datos'][i]['id_group'] +');" title="Agregar puerto LACP"> </i></a>'+
                                ' <a data-toggle="modal" data-target="#port_recurso_sevicio_pop"><i class="fa fa-minus-square-o" onclick="list_port_all('+data['datos'][i]['id_group']+');" title="Quitar puerto"> </i></a>';
                        }
                        valor +=  ' <a><i class="fa fa-trash-o" onclick="delete_port('+ data['datos'][i]['id_group'] +');" title="Eliminar"></i></a>'+
                            '</td>'+
                            '</tr>';
                        $("#por_alta_recursos").append(valor)
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delete_port(port){
    var id_servicio = document.getElementById('id_servicio_recurso').value;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'eliminar/recurso',
        data: {port:port, id:id_servicio,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Registrado Exitoso");
                    ver_recurso_servicio(id_servicio);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function list_port_new(id, port){
    var mensaje = document.getElementById("title_port_mas_meno");
    mensaje.textContent  = 'AGREGAR PUERTO';
    var new_tbody = document.createElement('tbody');
    $("#port_recurso_sevicio").html(new_tbody)
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/recurso',
        data: {id:id, port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        if (data['datos'][i]['id_port'] != port) {
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                                '<td>' + data['datos'][i]['model'] + '</td>' +
                                '<td>' + data['datos'][i]['servicios'] + '</td>' +
                                '<td > <a onclick="insert_port_new('+data['datos'][i]['id']+','+port+');" title="Modificar"><i class="fa fa-dot-circle-o" > </i></a></td>'+
                                '</tr>';
                            $("#port_recurso_sevicio").append(valor);
                        }
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function insert_port_new(port, board, group){
    var modal = document.getElementById("exit_port_recu_sevi");
    var id_servicio = document.getElementById('id_servicio_recurso').value;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'nuevo/recurso',
        data: {id:group, port:port, board:board},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Registrado Exitoso");
                    modal.click();
                    ver_recurso_servicio(id_servicio);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function list_port_all(port){
    var mensaje = document.getElementById("title_port_mas_meno");
    mensaje.textContent  = 'QUITAR PUERTO';
    var new_tbody = document.createElement('tbody');
    $("#port_recurso_sevicio").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'grupo/puerto',
        data: {port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    if (data['datos'][0] != '') {
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i]['slot'] + data['datos'][i]['n_port']+'</td>' +
                                '<td>' + data['datos'][i]['model'] + '</td>' +
                                '<td>' + data['datos'][i]['service'] + '</td>' +
                                '<td > <i class="fa fa-trash-o" onclick="delate_port_new('+data['datos'][i]['id']+');" title="Quitar"> </i></a></td>'+
                                '</tr>';
                            $("#port_recurso_sevicio").append(valor)
                        })
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delate_port_new(id){
    var modal = document.getElementById("exit_port_recu_sevi");
    var id_servicio = document.getElementById('id_servicio_recurso').value;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'eliminar/puerto/grupo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "nop":
                    toastr.error("Hay servicio que requiere el ancho de bando del puerto en el grupo");
                    break;
                case "yes":
                    toastr.success("Modificación Exitosa");
                    modal.click();
                    ver_recurso_servicio(id_servicio);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function ver_ip_servicio(id){
    var new_tbody = document.createElement('tbody');
    $("#ip_recurso_sevicio").html(new_tbody)
    $('#id_servicio_recurso').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ip/recurso',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    if (data['datos'][0] != '') {
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>'+data['datos'][i]['ip']+'</td>' +
                                '<td>'+data['datos'][i]['type']+'</td>' +
                                '<td> <i class="fa fa-trash-o" data-toggle="modal" data-target="#confimacion_full" onclick="delate_ip_new('+data['datos'][i]['id']+');" title="Quitar"> </i></a></td>'+
                                '</tr>';
                            $("#ip_recurso_sevicio").append(valor)
                        })
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delate_ip_new(id){
    var mensaje = document.getElementById("mytitle");
    var modal = document.getElementById('cerra_confimacion_full');
    var aceptar = document.getElementById("Aceptar");
    var cancelar = document.getElementById("Cancelar");
    mensaje.textContent = '¿Esta seguro de que quieres liberar la ip?';
    aceptar.onclick = function() {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'eliminar/ip',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        toastr.error("IP WAN esta utilizada por al meno un servicio");
                        modal.click();
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        ver_ip_servicio(data['datos']);
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }

}

function ip_rank_new_ser_recur(){
    $('#ip_admin').find('option').remove();
    $('#ip_admin').append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
}

function ip_rank_new_servi(){
    var id_ser = document.getElementById('id_servicio_recurso').value;
    var modal = document.getElementById("cerra_recurso_servi_ip_rank");
    var ip = document.getElementById('ip_admin').value;
    if (ip == '' || ip.length == 0) {
        toastr.error("La IP es obligatorio.");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'agregar/ip',
            data: {id:ip, servicio:id_ser,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "exis":
                        toastr.error("Almeno una IP del rango esta ocupada.");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        ver_ip_servicio(id_ser);
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function vlan_servi_recurso(port, vlan){
    $('#vlan_ser_rec').val(vlan);
    var cancelar = document.getElementById("vlan_service_new_cerra");
    var aceptar = document.getElementById("vlan_service_new");
    var modal = document.getElementById("cerra_recurso_servi_vlan");
    aceptar.onclick = function(){
        var vlan = document.getElementById('vlan_ser_rec').value;
        if (vlan == '' || vlan.length == 0) {
            toastr.error("La Vlan es obligatorio.");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'modificar/vlan',
                data: {vlan:vlan, port:port,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "exis":
                            toastr.error("La Vlan esta ocupada.");
                            break;
                        case "yes":
                            toastr.success("Modificación Exitosa");
                            ver_recurso_servicio(data['datos']);
                            modal.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }

}

function delecte_lista(id, table){
    var modal = document.getElementById("cerrar_pop_list_provincia");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'eliminar/lista',
        data: {id:id, table:table,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Eliminación Exitosa");
                    $("#elimi"+id).closest('tr').remove();
                    if (modal != null) {
                        modal.click();
                    }
                    break;
                case "exis":
                    toastr.error("El valor de esta lista esta siendo utilizado");
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
}

function selec_address(id, fun){
    switch (fun){
        case 0:
            var selec = $("#address");
            selec.find('option').remove();
            break;
        case 1:
            var selec = $("#direc");
            selec.find('option').remove();
            break;
        case 2:
            var selec = $("#direc_a");
            selec.find('option').remove();
            break;
        case 3:
            var selec = $("#direc_b");
            selec.find('option').remove();
            break;
    }
    if (id != '' && id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/direccion',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        if (fun == 3) {
                            var modal = document.getElementById("cerra_bus_direc_servi");
                        }else{
                            var modal = document.getElementById("cerra_bus_direc");
                        }
                        modal.click();
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
    }
}
function selec_address_radio(id){
    $("#edi_address").find('option').remove();
    $("#id_address").find('option').remove();
    var modal = document.getElementById("cerra_bus_direc");
    if (id != '' && id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/direccion',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#edi_address").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#id_address").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        modal.click();
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
    }
}

function selec_address_lsw_new(id){
    var modal = document.getElementById("cerra_bus_direc");
    var selec = $("#direc_lsw");
    selec.find('option').remove();
    if (id != '' && id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'asignar/direccion',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        modal.click();
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
    }
}

function selec_equipmen(id){
    var selec = $("#equi_alta"); selec.find('option').remove();
    var radio = $("#id_modelo_radio"); radio.find('option').remove();
    var lsw = $("#equi_alta_lsw"); lsw.find('equi_alta_lsw').remove();

    var id_equipos = document.getElementById('id_equipos').value;
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    var mensaje = document.getElementById("myMensaje");
    var cerrar = document.getElementById('cerra_bus_equipo_servi_all');
    if (id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/modelo',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        if ((data['stock'] == 0 || data['stock'] == null) && id_equipos == 0) {
                            modal0.style.display = "block";
                            mensaje.textContent  = "No hay stock actualmente. ¿Desea continuar?";
                            aceptar.onclick = function() {
                                selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                                radio.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                                lsw.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                                cerrar.click();
                                modal0.style.display = "none";
                            }
                            cancelar.onclick = function() {
                                modal0.style.display = "none";
                            }
                        }else{
                            selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                            lsw.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                            radio.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                            cerrar.click();
                        }
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
    }else{
        selec.append('<option selected disabled value="">seleccionar</option>');
    }
}

function selec_equipmen_lsw(id){
    var selec = $("#equi_alta_lsw");
    selec.find('option').remove();
    var id_equipos = document.getElementById('id_equipos').value;
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    var mensaje = document.getElementById("myMensaje");
    var cerrar = document.getElementById('cerra_bus_equipo_servi_all');
    if (id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/modelo',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        if ((data['stock'] == 0 || data['stock'] == null) && id_equipos == 0) {
                            modal0.style.display = "block";
                            mensaje.textContent  = "No hay stock actualmente. ¿Desea continuar?";
                            aceptar.onclick = function() {
                                selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                                cerrar.click();
                                modal0.style.display = "none";
                            }
                            cancelar.onclick = function() {
                                modal0.style.display = "none";
                            }
                        }else{
                            selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                            cerrar.click();
                        }
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
    }else{
        selec.append('<option selected disabled value="">seleccionar</option>');
    }
}

function selec_node(id){
    var cerrar = document.getElementById('cerra_bus_nodo');
    var selec = $("#nodo_al");
    selec.find('option').remove();
    if (id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/nodo',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        $("#showFormValues #nodo").text(data['datos']);
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
    }else{
        selec.append('<option selected disabled value=""> Seleccione</option>').trigger('change.select2');
    }
    cerrar.click();
}

function selec_node_lsw_new(id){
    var cerrar = document.getElementById('cerra_bus_nodo');
    var selec = $("#nodo_al_lsw");
    $("#id_link").find('option').remove();
    $("#id_link").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');

    selec.find('option').remove();
    if (id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/nodo',
            data: {id:id,},
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
                    case "nop":
                        selec.append('<option selected disabled value="">seleccionar</option>');
                        toastr.error("El nodo seleccionado no est&aacute; operativo");
                        return;
                        break;
                    case "yes":
                        selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        break;

                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        selec.append('<option selected disabled value="">seleccionar</option>');
    }
    cerrar.click();
}

function selec_node_anillo(id, input){
    var cerrar = document.getElementById('cerra_bus_nodo');
    if (input == 0) {
        var selec_anillo = $("#nodo_al_anillo");
    }else{
        var selec_anillo = $("#nodo_all");
    }
    selec_anillo.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/nodo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#acro_ring_ipran_sele').val(data['cell_id']);
                    selec_anillo.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
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

function down_servi(id){
    var modal = document.getElementById("cerra_recurso_servi_dow");
    var cancelar = document.getElementById("cancelar_recurso_servi_dow");
    var aceptar = document.getElementById("aceptar_recurso_servi_dow");
    $('#down').val('');
    aceptar.onclick = function() {
        var down = document.getElementById('down').value;
        if (down == '' || down.length == 0) {
            toastr.error("La orden de baja es obligatorio.");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'baja/servicio',
                data: {id:id, down:down,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Baja Exitosa");
                            var ref = $('#servicios_list').DataTable();
                            ref.ajax.reload();
                            modal.click();
                            break;
                        case "nop":
                            toastr.error("No se puede dar de baja");
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
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function cancelar_servicio(id){
    var aceptar = document.getElementById("cancelar_sevi_aceptar");
    var cancelar = document.getElementById("cancelar_sevi_cerrar");
    var modal = document.getElementById("cerra_recurso_servi_can");
    aceptar.onclick = function() {
        var mot = document.getElementById('mot_can').value;
        if (mot == '' || mot.length == 0) {
            toastr.error("El motivo es obligatorio.");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'cancelar/servicio',
                data: {id:id, mot:mot,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Cancelación Exitosa");
                            $('#servicios_list').DataTable().ajax.reload();
                            modal.click();
                            break;
                        case "nop":
                            toastr.error("No se puede Cancelar");
                            modal.click();
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
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function down_equipmen_id(id){
    $('#id_equi').val(id);
    $('#down').val('');
}

function down_equipmen(){
    var id = document.getElementById('id_equi').value;
    var down = document.getElementById('down').value;
    var modal = document.getElementById("cerra_recurso_equipo_dow");
    if (down == '' || down.length == 0 ) {
        toastr.error("La oreden de baja es obligatorio.");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'baja/equipo',
            data: {id:id, down:down},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Cancelación Exitosa");
                        $('#claro_agregador').DataTable().ajax.reload();
                        $('#cpe_list').DataTable().ajax.reload();
                        $('#lanswitch_list').DataTable().ajax.reload();
                        $('#jarvis_dm').DataTable().ajax.reload();
                        $('#jarvis_pe').DataTable().ajax.reload();
                        $('#jarvis_pei').DataTable().ajax.reload();
                        $('#jarvis_radio').DataTable().ajax.reload();
                        $('#jarvis_sar').DataTable().ajax.reload();
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("Tiene servicio activo");
                        modal.click();
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
    }
}

function service_equipmen(id){
    var new_tbody = document.createElement('tbody');
    $("#servi_equipo").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'servicio/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    if (data['datos'][0] != '') {
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>'+data['datos'][i]['label']+data['datos'][i]['slot']+data['datos'][i]['n_port']+'</td>' +
                                '<td>'+data['datos'][i]['vlan']+'</td>' +
                                '<td>'+data['datos'][i]['number']+'</td>' +
                                '<td>'+data['datos'][i]['bw_service']+'</td>' +
                                '<td>'+data['datos'][i]['business_name']+'</td>' +
                                '<td><a data-toggle="modal" data-target="#editar_recurso_servicio_pop" onclick="resource_service_edit('+data['datos'][i]['id']+', '+data['datos'][i]['service']+');" title="Modificar recurso"><i class="fa fa-edit"></i></a>'+
                                '<a title="Ingeneria" href="http://coronel2.claro.amx:8010/WebIngenieria/pages/buscarIngenieria.xhtml?email=true&servicio='+data['datos'][i]['number']+'" target="_blank"> <i class="fa fa-clipboard"> </i> </a>'+
                                '</td>' +
                                '</tr>';
                            $("#servi_equipo").append(valor);
                        })
                    }
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
}

function new_recur_equipmen(id){
    var modal = document.getElementById("cerra_recurso_ser");
    var mensaje = document.getElementById("title_recurso");
    mensaje.textContent  = 'ASIGNAR RECURSO';
    $('#bw_equipment_info').hide();
    $("#bw_equipment").val('');
    $('#div_aplicar_reserva').hide();
    $('#ipran').val('no');
    $('#id_servicio_recurso').val('').trigger('change.select2');
    $('#ip_admin_servi_id').val('');
    $('#ip_admin_servi').val('');
    $('#ip_rank_servi_id').val('');
    $('#ip_admin_rank').val('');
    $('#vlan_recurso').val('');
    $("#select_option_reserve").val($("#select_option_reserve option:first").val()).change();
    $("#reserve_option").find('option').remove();
    $('#reserve_option').append('<option selected disabled> Seleccionar </option>').trigger('change.select2');
    $('.bw_reserve').text('');
    $('.bw_service').text('');
    var new_tbody = document.createElement('div');
    $("#campos_port").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'acronimo/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#equip_name').val(data['datos']);
                    $('#equip').val(id);
                    $('#ip_admin_servi_id').val(data['id']);
                    $('#ip_admin_servi').val(data['ip']);
                    if(data['type'] == 'Ipran'){
                        $('#div_aplicar_reserva').show();
                        $('#ipran').val('si')
                    }
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
}

function validar_servi(){
    var servicio = document.getElementById('id_servicio_recurso').value;
    var por_all = document.getElementById('por_all_recuso_servi');
    var ip_campo = document.getElementById('ip_servicio');
    var rango_ip = document.getElementById('rango_servicio');
    if (servicio == '') {
        por_all.style.display = "none";
    }else{
        por_all.style.display = "block";
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'ip/rango/recurso',
            data: {id:servicio},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#reques_ip').val(data['datos']['require_ip']);
                        $('#reques_rank').val(data['datos']['require_rank']);
                        if (data['datos']['require_ip'] == 'SI'){
                            ip_campo.style.display = "block";
                        }else{
                            ip_campo.style.display = "none";
                        }
                        if (data['datos']['require_rank'] == 'SI'){
                            rango_ip.style.display = "block";
                        }else{
                            rango_ip.style.display = "none";
                        }
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
    }
}

function selec_service(id){
    var cerrar = document.getElementById('cerra_bus_servi_all');
    let bw_service = $(".bw_service").text();
    let bw_reserve = $(".bw_reserve").text();
    let bw_equipment = $("#bw_equipment").val();
    $(".bw_service").html('');
    $("#id_servicio_recurso").find('option').remove();
    $("#id_servicio_sub_red").find('option').remove();
    $("#atributo_ip_rese").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/servicio',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#id_servicio_recurso").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    $("#atributo_ip_rese").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    $("#id_servicio_sub_red").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    $(".bw_service").html(data['bw_service']/1024)
                    if((bw_equipment > 0 && data['bw_service']/1024 > 0) && (data['bw_service']/1024 > bw_equipment)){
                        swal("CUIDADO!", "El bw de servicio es mayor al de el uplink (equipo)", "error");
                        //toastr.warning("CUIDADO! el bw de servicio es mayor al de el uplink (equipo)")
                    }
                    if((data['bw_service']/1024 > 0 && bw_reserve > 0) && data['bw_service']/1024 > bw_reserve){
                        swal("CUIDADO!", "El bw de servicio es mayor al de la reserva", "error");
                        //toastr.warning("CUIDADO! el bw de servicio es mayor al de reserva")
                    }
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

function selec_service_radio(id){
    var cerrar = document.getElementById('cerra_bus_servi_all');
    $("#servicio_radio").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/servicio',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#servicio_radio").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    cerrar.click();
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

}

function clip_new_list_servi(){
    var mensaje = document.getElementById("title_type_ser");
    mensaje.textContent  = 'AGREGAR TIPO DE SERVICIO ';
    $('#id_type_ser').val(0);
    $('#lis_name').val('');
    $('#servi_ip').val('').trigger('change.select2');
    $('#servi_rango_ip').val('').trigger('change.select2');

}

function type_service_bw(){
    var id = document.getElementById('type_servi').value;
    var input = document.getElementById('bw_service_input');
    var address = document.getElementById('input_dire_b_all');
    var relation = document.getElementById('service_input_relation');
    var nmax = document.getElementById('n_max');
    var service_rel = document.getElementById('servi_relation');
    var max = document.getElementById('max');
    let input_service = document.getElementById('service');

    if ( id != "" || id.length > 0 ){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'bw/servicio',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'yes':
                        input_service.setAttribute('onkeypress', 'return esNumero(event);');
                        if($("#type_servi option:selected").text() == 'IR (INGENERIA RED)'){

                            if (input_service.value.substr(0,2) != 'IR') {
                                input_service.value = 'IR';   }

                            input_service.setAttribute('onkeypress', 'return Number_letra(event);');
                        } else
                        { if (input_service.value.substr(0,2) == 'IR') {
                            input_service.value = '';}
                        }
                        $('#option_bw_service').val(data['datos']['require_bw']);
                        $('#option_relation_service').val(data['datos']['require_related']);
                        if (data['datos']['require_bw'] == 'SI') {
                            input.style.display = "block";
                        }else{
                            input.style.display = "none";
                        }
                        if (data['datos']['require_related'] == 'SI') {
                            relation.style.display = "block";
                        }else{
                            relation.style.display = "none";
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        input.style.display = "block";
        relation.style.display = "block";
    }
    if (id == 18 || id == 9) {
        address.style.display = "block";
    }else{
        address.style.display = "none";
    }
}

function new_list_servi(){
    var id = document.getElementById('id_type_ser').value;
    var name = document.getElementById('lis_name').value.toUpperCase().trim().replace(/\s{2,}/g, ' ');
    var ip = document.getElementById('servi_ip').value;
    var rango = document.getElementById('servi_rango_ip').value;
    var bw = document.getElementById('servi_bw').value;
    var relation = document.getElementById('servi_rela').value;
    var modal = document.getElementById("exit_pop_cerra_tipo_servi");
    if ( name == "" || name.length < 1 ){
        toastr.error("La nombre es obligatorio");
    }else if ( ip == "" || ip.length < 1 ){
        toastr.error("La IP es obligatoria");
    }else if ( rango == "" || rango.length < 1 ){
        toastr.error("El rango IP es obligatorio");
    }else if ( bw == "" || bw.length < 1 ){
        toastr.error("El ancho de banda es obligatorio");
    }else if ( relation == "" || relation.length < 1 ){
        toastr.error("La relación es obligatorio");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'lista/servicio',
            data: {id:id, name:name, ip:ip, rango:rango, bw:bw, relation:relation,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'exist':
                        toastr.error("El dato ya existe");
                        break;
                    case 'utilizando':
                        toastr.error("No se puede modificar se esta utilizando");
                        break;
                    default:
                        if (id == 0) {
                            toastr.success("Registro Exitoso");
                        }else{
                            toastr.success("Modificación Exitosa");
                        }
                        window.location = getBaseURL() +'lista/tipo/servicio';
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function selec_lista_service(id){
    var mensaje = document.getElementById("title_type_ser");
    mensaje.textContent  = 'MODIFICAR TIPO DE SERVICIO';
    $('#id_type_ser').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/tipo/servicio',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'yes':
                    $('#lis_name').val(data['datos']['name']);
                    $('#servi_ip').val(data['datos']['require_ip']);
                    $('#servi_rango_ip').val(data['datos']['require_rank']);
                    $('#servi_bw').val(data['datos']['require_bw']);
                    $('#servi_rela').val(data['datos']['require_related']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delecte_lista_type_service(id){
    var mensaje = document.getElementById("mytitle");
    var modal = document.getElementById('cerra_confimacion_full');
    var aceptar = document.getElementById("Aceptar");
    var cancelar = document.getElementById("Cancelar");
    mensaje.textContent = 'Esta seguro de eliminar el tipo de servicio';
    aceptar.onclick = function(){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'eliminar/tipo/servicio',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        modal.click();
                        break;
                    case 'exis':
                        toastr.error("No se puede eliminar tiene servicio asociado");
                        modal.click();
                        break;
                    case 'yes':
                        toastr.success("Eliminación Exitosa");
                        window.location = getBaseURL() +'lista/tipo/servicio';
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function(){
        modal.click();
    }

}

function sele_agg_alta(id){
    var cerrar = document.getElementById('cerra_bus_equipo_agg');
    $('#agg').val(id).trigger('change.select2');
    cerrar.click();
    /*
    var cerrar = document.getElementById('cerra_bus_equipo_agg');
    $('#agg').find('option').remove();
    if (id != '' && id !=  null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'asignar/equipo',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                    break;
                    case "yes":
                        $("#agg").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        cerrar.click();
                    break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        cerrar.click();
                    break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    */
}

function inf_equip_port(id){
    var boton = document.getElementById('new_lacp_boton');
    var mensaje = document.getElementById("acro_equi_por");
    var new_tbody = document.createElement('tbody');
    $("#list_all_port_equipmen").html(new_tbody);
    var new_tbody = document.createElement('tbody');
    $("#list_all_lacp_equipmen").html(new_tbody)
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'puerto/equipo',
        data: {id:id},
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
                        var valor = '<tr>' +
                            '<td>' + data['group'][i]['lacp_number'] +'</td>' +
                            '<td>' + data['group'][i]['port'] + '</td>' +
                            '<td>' + data['group'][i]['atributo'] + '</td>' +
                            '<td>' + data['group'][i]['commentary'] + '</td>' +
                            '<td >';
                        if (data['permi'] > 3) {
                            valor +='<a data-toggle="modal" data-target="#port_recurso_sevicio_pop" onclick="port_new_lacp_search('+id+','+data['group'][i]['id']+');" title="Agregar Puerto LACP"> <i class="fa fa-plus-square-o"> </i></a> '+
                                '<a data-toggle="modal" data-target="#port_recurso_sevicio_pop" onclick="port_delecte_lacp_search('+id+','+data['group'][i]['id']+');" title="Quitar Puerto LACP"> <i class="fa fa-minus-square-o"> </i></a> ';
                            valor += '<a title = "Comentario puerto" data-toggle="modal" data-target="#popcomen_port" onclick="commen_group_update('+id+','+data['group'][i]['id']+');"> <i class="fa fa-twitch"> </i></a>';
                        }
                        '<a onclick="delecte_lacp('+data['group'][i]['id']+');" title="Eliminar LACP"> <i class="fa fa-trash-o"> </i></a> '+
                        '</td>'+
                        '</tr>';
                        $("#list_all_lacp_equipmen").append(valor);
                    })
                    if (data['group'].length == 0) {
                        var valor = '<tr>' +
                            '<td colspan="5"> <center> No tiene grupo </center></td>'+
                            '</tr>';
                        $("#list_all_lacp_equipmen").append(valor);
                    }
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>'+data['datos'][i]['slot']+data['datos'][i]['port']+'</td>' +
                            '<td>'+data['datos'][i]['type']+'</td>' +
                            '<td>'+data['datos'][i]['status']+'</td>' +
                            '<td>'+data['datos'][i]['bw']+'</td>' +
                            '<td>'+data['datos'][i]['atributo']+'</td>' +
                            '<td>'+data['datos'][i]['agg_status']+'</td>' +
                            '<td>'+data['datos'][i]['commentary']+'</td>'+
                            '<td>';
                        if (data['datos'][i]['service'] != 'NO') {
                            valor +=' <a onclick="info_detal_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['port']+');" data-toggle="modal" data-target="#popdetalle_puerto_servicio" title="Detalle de servicio"> <i class="fa fa-search"> </i> <a> ';
                        }
                        if (data['permi'] >= 3) {
                            boton.style.display = "block";
                            if (data['datos'][i]['status'] == 'VACANTE' && data['datos'][i]['atributo'] == '' &&  data['status'] != 'BAJA') {
                                valor += '<a title="Reservar" data-toggle="modal" data-target="#popreser_port" onclick="reser_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['port']+');"> <i class="fa fa-unlock"> </i></a>';
                            }else{
                                if (data['datos'][i]['id_status'] > 2 ) {
                                    valor += '<a title = "Liberar puerto" data-toggle="modal" data-target="#confimacion_full" onclick="free_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['port']+');"> <i class="fa fa-unlock-alt"> </i></a>';
                                }else{
                                    valor += '<a title = "No disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a>';
                                }
                            }
                        }else{
                            boton.style.display = "none";
                        }
                        if (data['datos'][i]['type'] != 'IF' && data['datos'][i]['type'] != 'ODU') {
                            if (data['datos'][i]['eq_status'] == 'ALTA') {
                                if (data['datos'][i]['connected_to'] == '' || data['datos'][i]['connected_to'] == null) {
                                    valor += '<a title="Relacionar puerto otro equipo" data-toggle="modal" data-target="#poprel_port_eq" ';
                                    valor += 'onclick="relate_equip_ports('+data['datos'][i]['id']+','+data['datos'][i]['port']+',\''+data['datos'][i]['type']+'\',\''+data['datos'][i]['bw']+'\');"> <i class="fa fa-compress"> </i> </a>';
                                } else {
                                    valor += '<a title="Desconectar puerto otro equipo" data-toggle="modal" data-target="#popdesc_port_eq" ';
                                    valor += 'onclick="disconnect_port('+data['datos'][i]['id']+','+data['datos'][i]['port']+');"> <i class="fa fa-expand"> </i> </a>';
                                }
                            }
                        }
                        if (data['datos'][i]['function'] != '4' && data['datos'][i]['function'] != '2' && data['datos'][i]['function'] != '7'){
                            valor += '<a title = "Detalle de puerto" data-toggle="modal" data-target="#detalle_agg_puerto" onclick="detal_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['port']+');"> <i class="fa fa-info-circle"> </i></a>';
                        }
                        if (data['datos'][i]['type'] == 'IF') {
                            valor += '<a title = "Detalle de puerto" data-toggle="modal" data-target="#PopDetalPortIF" onclick="detal_port_radio_antena_odu('+data['datos'][i]['id']+','+data['datos'][i]['port']+');"> <i class="fa fa-info-circle"> </i></a>';
                        }
                        valor += '<a title = "Comentario puerto" data-toggle="modal" data-target="#popcomen_port" onclick="commen_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['port']+');"> <i class="fa fa-twitch"> </i></a>';
                        valor += '</td></tr>';
                        $("#list_all_port_equipmen").append(valor)
                    });
                    break;
                case "nop":
                    toastr.error("No tiene placa");
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
}

function detal_port_equipmen(board, port){
    var title = document.getElementById("port_title_name");
    var new_tbody = document.createElement('tbody');
    $("#list_all_detalle_agg_puerto").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/puerto/agg',
        data: {board:board, port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    title.textContent  = data['port'];
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['adminstatus']+ '</td>' +
                            '<td>' + data['datos'][i]['operstatus']+ '</td>' +
                            '<td>' + data['datos'][i]['anillo']+ '</td>' +
                            '<td>' + data['datos'][i]['nombremodulo']+ '</td>' +
                            '<td>' + data['datos'][i]['tipomodulo']+ '</td>' +
                            '<td>' + data['datos'][i]['distancia']+ '</td>' +
                            '<td>' + data['datos'][i]['descripcion']+ '</td>' +
                            '<td>' + data['datos'][i]['date']+ '</td>' +
                            '</tr>';
                        $("#list_all_detalle_agg_puerto").append(valor)
                    });
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
}

function reser_port_equipmen (placa, port){
    var modal = document.getElementById("cerra_reser_port");
    var aceptar = document.getElementById("acep_reser");
    var cancelar = document.getElementById("cance_reser");
    aceptar.onclick = function() {
        var mot = document.getElementById('mot_reser').value;
        var commen = document.getElementById('commen_reser').value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'reservar/puerto',
            data: {placa:placa, port:port, mot:mot, commen:commen},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Operaci&oacute;n exitosa");
                        inf_equip_port(data['datos']);
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("El puerto esta ocupado");
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
    }
    cancelar.onclick = function() {
        modal.click();
    }
    $('#mot_reser').val('');
    $('#commen_reser').val('');
}



function quitar_ip_admin(interface = null){
    if (interface == 1 || interface == null) {
        $('#ip_admin_servi_id').val('');
        $('#ip_admin_servi').val('');
    } else {
        $('#ip_rank_servi_id').val('');
        $('#ip_admin_rank').val('');
    }
}

function inf_anillo(id){
    var mensaje = document.getElementById("name_anilla_equip");
    var new_tbody = document.createElement('tbody');
    $("#lis_equi_anillo").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'equipo/anillo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    mensaje.textContent = data['acronimo'];
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i].acronimo + '</td>' +
                            '<td>' + data['datos'][i].ip + '</td>' +
                            '<td>' + data['datos'][i].model + '</td>' +
                            '<td>' + data['datos'][i].mark + '</td>' +
                            '<td>' + data['datos'][i].direc + '</td>' +
                            '<td><a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+data['datos'][i].id+');"> <i class="fa fa-keyboard-o"> </i></a></td>' +
                            '</tr>';
                        $("#lis_equi_anillo").append(valor)
                    });
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
}

function img_equip_alta(){
    var id = document.getElementById('equi_alta').value;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'imagen/modelo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            var image = getBaseURL() +'public/img/equipo/'+data['img'];
            $('#imagenes').html("<img class='img_equi_mos' src=" + image + ">");
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function libera_ip(){
    var mensaje = document.getElementById("myMensaje");
    mensaje.textContent  = 'ESTA SEGURO DE LIBERAR LA IP';
    var modal = document.getElementById("cerrar_libre_ip_pop");
    $('#type_libre').val('').trigger('change.select2');
    let valores = [];
    $("input[type=checkbox]:checked").each(function(){
        valores.push(this.value);
    });
    if (valores.length > 0) {
        var aceptar = document.getElementById("liberar_seguir");
        var cancelar = document.getElementById("liberar_cerra");
        aceptar.onclick = function() {
            var atributo = document.getElementById('type_libre').value;
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'liberar/ip',
                data: {id:valores, atributo:atributo},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Liberación IP Exitosa");
                            rango_rama_list(data['datos']);
                            modal.click();
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
        }
        cancelar.onclick = function() {
            modal.click();
        }
    }else{
        toastr.error("Selecione la IP");
    }
}

function asignar_ip(id){
    $('#type_reser').val('').trigger('change.select2');
    var cancelar = document.getElementById("asignar_cerra");
    var aceptar = document.getElementById("asignar_seguir");
    var modal = document.getElementById("cerrar_asignar_ip_pop");
    aceptar.onclick = function() {
        var type = document.getElementById('type_reser').value;
        var atributo = document.getElementById('atributo_ip_rese').value;
        if (atributo == '' || atributo.length == 0) {
            toastr.error("El atributo es obligatorio.");
        }else{
            if (type == "1") {
                var type_ip = document.getElementById('type_ip_rese').value;
            }else{
                var type_ip = null;
            }
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'asignar/ip',
                data: {id:id, atributo:atributo, type:type, type_ip},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Asignacion de IP Exitosa");
                            rango_rama_list(data['datos']);
                            modal.click();
                            break;
                        case "nop":
                            toastr.error("La IP a tiene atributo");
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
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function buscar_placa(id){
    var tbody = document.createElement('tbody');
    $("#list_all_equipmen_board").html(tbody);
    var title = document.getElementById("title_board");
    var title2 = document.getElementById("title_board_new");
    var new_tbody = document.createElement('tbody');
    $("#list_all_equipmen_board").html(new_tbody);
    $("#list_all_board_new").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/placa/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    title.textContent = data['acronimo'];
                    title2.textContent = data['acronimo'];
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i].slot + '</td>' +
                            '<td>' + data['datos'][i].board + '</td>' +
                            '<td>' + data['datos'][i].type_board + '</td>' +
                            '<td>' + data['datos'][i].quantity + '</td>' +
                            '<td>' + data['datos'][i].port_f_i + '</td>' +
                            '<td>' + data['datos'][i].port_f_f + '</td>' +
                            '<td>' + data['datos'][i].port + '</td>' +
                            '<td>' + data['datos'][i].connector + '</td>' +
                            '<td>' + data['datos'][i].bw + '</td>' +
                            '<td>' + data['datos'][i].label + '</td>' +
                            '<td>' + data['datos'][i].port_l_i + '</td>' +
                            '<td>' + data['datos'][i].port_l_f + '</td>' +
                            '<td>';
                        if (data['datos'][i].type_board != 'ONBOARD') {
                            valor +='<a data-toggle="modal" data-target="#posicion_placa" onclick="sele_pose_board('+data['datos'][i].id+');" title="Modificar posición"> <i class="fa fa-edit"> </i></a>'+
                                '<a data-toggle="modal" data-target="#confimacion_full" onclick="delecte_board('+data['datos'][i].id+');" title="Quitar Placa"> <i class="fa fa-window-close"> </i></a>';
                        }
                        valor +='</td>' +
                            '</tr>';
                        $("#list_all_equipmen_board").append(valor)
                    });
                    if (data['datos'].length == 0) {
                        toastr.error("No tiene placa");
                    }
                    $(data['datos_full']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>' + data['datos_full'][i].board + '</td>' +
                            '<td>' + data['datos_full'][i].quantity + '</td>' +
                            '<td>' + data['datos_full'][i].port_f_i + '</td>' +
                            '<td>' + data['datos_full'][i].port_f_f + '</td>' +
                            '<td>' + data['datos_full'][i].port + '</td>' +
                            '<td>' + data['datos_full'][i].connector + '</td>' +
                            '<td>' + data['datos_full'][i].bw_max_port + '</td>' +
                            '<td>' + data['datos_full'][i].label + '</td>' +
                            '<td>' + data['datos_full'][i].slot + '</td>' +
                            '<td>' + data['datos_full'][i].port_l_i + '</td>' +
                            '<td>' + data['datos_full'][i].port_l_f + '</td>' +
                            '<td><a data-toggle="modal" data-target="#posicion_placa" onclick="sele_board_new('+id+','+data['datos_full'][i].id+','+data['datos_full'][i].relation+');" title="seleccionar placa"> <i class="fa fa-dot-circle-o"> </i></a></td>' +
                            '</tr>';
                        $("#list_all_board_new").append(valor)
                    });
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
}

function asignar_ip_grupo(){
    $('#type_reser').val('').trigger('change.select2');
    var cancelar = document.getElementById("asignar_cerra");
    var aceptar = document.getElementById("asignar_seguir");
    var modal = document.getElementById("cerrar_asignar_ip_pop");
    let valores = [];
    $("input[type=checkbox]:checked").each(function(){
        valores.push(this.value);
    });
    if (valores.length > 0) {
        aceptar.onclick = function() {
            var type = document.getElementById('type_reser').value;
            var atributo = document.getElementById('atributo_ip_rese').value;
            if (atributo == '' || atributo.length == 0) {
                toastr.error("El atributo es obligatorio.");
            }else{
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "POST",
                    url: getBaseURL() +'asignar/grupo/ip',
                    data: {id:valores, atributo:atributo, type:type},
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        switch (data['resul']){
                            case "login":
                                refresh();
                                break;
                            case "yes":
                                toastr.success("Asignacion de IP Exitosa");
                                rango_rama_list(data['datos']);
                                modal.click();
                                break;
                            case "nop":
                                toastr.error("Una IP ya tiene ese atributo");
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
            }
        }
        cancelar.onclick = function() {
            modal.click();
        }
    }else{
        toastr.error("Selecione la IP");
        aceptar.onclick = function() {
            modal.click();
        }
        cancelar.onclick = function() {
            modal.click();
        }
    }
}

function status_ip(id){
    $('#status_ip_individual').val('')
    var cancelar = document.getElementById("estado_cerra");
    var aceptar = document.getElementById("estado_seguir");
    var modal = document.getElementById("cerrar_estado_ip_pop");
    aceptar.onclick = function() {
        var status = document.getElementById('status_ip_individual').value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'estado/ip',
            data: {id:id, status:status,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Modificación de IP Exitosa");
                        rango_rama_list(data['datos']);
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("IP Ocupada");
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
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function free_port_equipmen(placa, port){
    var mensaje = document.getElementById("mytitle");
    mensaje.textContent  = 'ESTA SEGURO DE LIBERAR PUERTO';
    var cancelar = document.getElementById("Cancelar");
    var aceptar = document.getElementById("Aceptar");
    var modal = document.getElementById("cerra_confimacion_full");
    aceptar.onclick = function() {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'liberar/puerto',
            data: {placa:placa, port:port,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        inf_equip_port(data['datos']);
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("Puerto Ocupado");
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
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function sele_board_new(equi, board, relation){
    var cancelar = document.getElementById("exit_alta_placa");
    var aceptar = document.getElementById("alta_placa");
    var modal = document.getElementById("cerra_bus_placa_nueva");
    var neuvo = document.createElement('div');
    $("#all_select_board").html(neuvo);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/posicion/placa',
        data: {board:board, relation:relation,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#separar_pose_alta').val(data['datos'][0]['sep']);
                    $(data['datos']).each(function(i, v){
                        campo = '<div class="form-group">'+
                            '<label>'+data['datos'][i]['let']+'</label>'+
                            '<select class="form-control pose_elemen" id="pose_elemen'+[i]+'" name="pose_elemen['+[i]+']">'+
                            '<option selected disabled value="">seleccionar</option>';
                        for (p = data['datos'][i]['min'] ; p <= data['datos'][i]['max']; p++){
                            campo += '<option value="'+p+'">'+p+'</option>';
                        }
                        campo += '</select>'+
                            '</div>';
                        $("#all_select_board").append(campo);
                    });
                    break;
                case "nop":
                    toastr.error("Error en el puerto");
                    modal.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    var modal2 = document.getElementById("cerra_posicion_placa");
    aceptar.onclick = function() {
        var separar = document.getElementById('separar_pose_alta').value;
        var pose = document.getElementsByClassName("pose_elemen");
        var valor = [];
        for (var i = 0; i < pose.length; ++i) {
            if (typeof pose[i].value !== "undefined") {
                valor.push(pose[i].value);
            }
        }
        var validar = valor.indexOf('');
        if (valor.length > 0 && validar == -1) {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/placa',
                data: {valor:valor, separar:separar, equi:equi, board:board},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            buscar_placa(equi);
                            modal2.click();
                            modal.click();
                            break;
                        case "nop":
                            toastr.error("Posición ocupada");
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            modal2.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }else{
            toastr.error("Posición obligatoria");
        }
    }
    cancelar.onclick = function() {
        modal2.click();
    }
}

function sele_pose_board(id){
    var cancelar = document.getElementById("exit_alta_placa");
    var aceptar = document.getElementById("alta_placa");
    var modal = document.getElementById("cerra_posicion_placa");
    var neuvo = document.createElement('div');
    $("#all_select_board").html(neuvo);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/posicion',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#separar_pose_alta').val(data['datos'][0]['sep']);
                    $(data['datos']).each(function(i, v){
                        campo = '<div class="form-group">'+
                            '<label>'+data['datos'][i]['let']+'</label>'+
                            '<select class="form-control pose_elemen" id="pose_elemen'+[i]+'" name="pose_elemen['+[i]+']">'+
                            '<option selected disabled value="">seleccionar</option>';
                        for (p = data['datos'][i]['min'] ; p <= data['datos'][i]['max']; p++){
                            campo += '<option value="'+p+'">'+p+'</option>';
                        }
                        campo += '</select>'+
                            '</div>';
                        $("#all_select_board").append(campo);
                        $('#pose_elemen'+[i]+'').val(data['pose'][i]['valor']);
                    });
                    break;
                case "nop":
                    toastr.error("Placa no encontrada");
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
    aceptar.onclick = function() {
        var separar = document.getElementById('separar_pose_alta').value;
        var pose = document.getElementsByClassName("pose_elemen");
        var valor = [];
        for (var i = 0; i < pose.length; ++i) {
            if (typeof pose[i].value !== "undefined") {
                valor.push(pose[i].value);
            }
        }
        var validar = valor.indexOf('');
        if (valor.length > 0 && validar == -1){
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'modificar/posicion',
                data: {valor:valor, separar:separar, id:id,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            buscar_placa(data['datos']);
                            modal.click();
                            break;
                        case "nop":
                            toastr.error("Posición ocupada");
                            break;
                        case "exist":
                            toastr.error("Esta placa ya tiene esta posición");
                            modal.click();
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
        }else{
            toastr.error("Posición obligatoria");
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function delecte_board(id){
    var mensaje = document.getElementById("mytitle");
    mensaje.textContent  = '¿ESTA SEGURO DE QUITAR PLACA?';
    var cancelar = document.getElementById("Cancelar");
    var aceptar = document.getElementById("Aceptar");
    var modal = document.getElementById("cerra_confimacion_full");
    aceptar.onclick = function() {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'quitar/placa',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        buscar_placa(data['datos']);
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("Se esta utilizando puerto de esta placa");
                        modal.click();
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
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function delete_ring(id){
    var mensaje = document.getElementById("mytitle");
    mensaje.textContent  = '¿ESTA SEGURO DE DAR BAJA AL ANILLO?';
    var cancelar = document.getElementById("Cancelar");
    var aceptar = document.getElementById("Aceptar");
    var modal = document.getElementById("cerra_confimacion_full");
    aceptar.onclick = () => {
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            url: getBaseURL() +'eliminar/anillo',
            data: {id:id},
            dataType: 'JSON',
            cache: false,
            success: () => {
                toastr.success("Baja Exitosa");
                modal.click();
            },
            error: (resp) => ajaxErrorHandler(resp)
        });
    }
    cancelar.onclick = () => modal.click();
}

function search_attribute(){
    var attribute= document.getElementById('type_reser').value;
    var input_all = document.createElement('div');
    $("#input_atributo").html(input_all);
    if (attribute != '') {
        switch (attribute){
            case "1":
                campo = '<label>Equipo*</label>'+
                    '<div class="bw_all" id="bw_all" >'+
                    '<select disabled="true" class="form-control hide-arrow-select" id="atributo_ip_rese" name="atributo_ip_rese">'+
                    '<option selected disabled value="">seleccionar</option>'+
                    '</select>'+
                    '<a onclick="equipo_table_select_ip();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_all_equipo_ip" title="Buscar Equipo"><i class="fa fa-search"> </i></a>'+
                    '</div>';
                campo += '<label>Tipo IP*</label>'+
                    '<select class="form-control " id="type_ip_rese" name="type_ip_rese">'+
                    '<option value="WAN">IP WAN</option>'+
                    '<option value="Gestion">IP Gestión</option>'+
                    '</select>';
                break;
            case "2":
                campo = '<label>Cliente*</label>'+
                    '<div class="bw_all" id="bw_all" >'+
                    '<select disabled="true" class="form-control hide-arrow-select" id="atributo_ip_rese" name="atributo_ip_rese">'+
                    '<option selected disabled value="">seleccionar</option>'+
                    '</select>'+
                    '<a class="ico_input btn btn-info" id="bus_client" title="Buscar Cliente" onclick="client_table_select();" data-toggle="modal" data-target="#buscar_client"><i class="fa fa-search"></i></a>'+
                    '</div>';
                break;
            case "3":
                campo = '<label>Servicio*</label>'+
                    '<div class="bw_all" id="bw_all" >'+
                    '<select disabled="true" class="form-control hide-arrow-select" id="atributo_ip_rese" name="atributo_ip_rese">'+
                    '<option selected disabled value="">seleccionar</option>'+
                    '</select>'+
                    '<a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_servicio_all" title="Buscar Servicio" onclick="service_table_select();"><i class="fa fa-search"></i></a>'+
                    '</div>';
                break;
            case "4":
                campo = '<label>Asignación*</label>'+
                    '<input type="text" placeholder="Comentario" maxlength="50" autocomplete="off" id="atributo_ip_rese" name="atributo_ip_rese"class="form-control">';
                break;
        }
        $("#input_atributo").append(campo);
    }
}

function update_ring_port(id){
    var cancelar = document.getElementById("exit_alta_puerto");
    var aceptar = document.getElementById("alta_puerto");
    var modal = document.getElementById("cerra_puerto_anillo");
    var new_tbody = document.createElement('div');
    $("#all_puerto_anillo_new").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'anillo/puerto',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    modal.click();
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        campo = '<div class="form-group">'+
                            '<label>'+data['datos'][i]['acronimo']+' '+data['datos'][i]['slot']+'</label>'+
                            '<select class="form-control port_new_rign" id="port_new_rign'+[i]+'" name="port_new_rign['+[i]+']">'+
                            '<option selected disabled value="">seleccionar</option>';
                        $(data['option']).each(function(p, h){
                            if (data['option'][p]['status'] == 2 || data['option'][p]['status'] == 3) {
                                campo += '<option value="'+data['datos'][i]['id']+'~'+data['datos'][i]['connected']+'~'+data['option'][p]['data']+'">'+data['option'][p]['port']+'</option>';
                            }else{
                                campo += '<option style="color:red;" value="'+data['datos'][i]['id']+'~'+data['datos'][i]['connected']+'~'+data['option'][p]['data']+'">'+data['option'][p]['port']+'</option>';
                            }
                        })
                        campo += '</select> </div>';
                        $("#all_puerto_anillo_new").append(campo);
                    })
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var pose = document.getElementsByClassName("port_new_rign");
        var valor = [];
        for (var i = 0; i < pose.length; ++i) {
            if (typeof pose[i].value !== "undefined"){ valor.push(pose[i].value); }
        }
        var validar = valor.indexOf('');
        if (valor.length == 0 && validar != -1) {
            toastr.error("Puerto obligatorio");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'modificar/puerto/anillo',
                data: {id:id, valor:valor,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Modificación Exitosa");
                            modal.click();
                            break;
                        case "exist":
                            toastr.error("Los puerto no pueden ser lo mismo");
                            break;
                        case "nop":
                            toastr.error("El puerto esta ocupado");
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            modal.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function sum_port_group(group){
    var mensaje = document.getElementById("title_port_mas_meno");
    mensaje.textContent  = 'AGREGAR PUERTO LACP';
    var new_tbody = document.createElement('tbody');
    $("#port_recurso_sevicio").html(new_tbody)
    var id = document.getElementById('equip').value;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/recurso',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                            '<td>' + data['datos'][i]['model'] + '</td>' +
                            '<td>' + data['datos'][i]['servicios'] + '</td>' +
                            '<td> <a onclick="insert_port_lacp('+data['datos'][i]['por_selec']+', '+data['datos'][i]['board']+', '+group+');" title="Modificar"> <i class="fa fa-dot-circle-o" > </i></a></td>'+
                            '</tr>';
                        $("#port_recurso_sevicio").append(valor);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function res_port_group(group){
    var mensaje = document.getElementById("title_port_mas_meno");
    mensaje.textContent  = 'QUITAR PUERTO LACP';
    var new_tbody = document.createElement('tbody');
    $("#port_recurso_sevicio").html(new_tbody)
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'eliminar/lacp',
        data: {id:group,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['slot']+ data['datos'][i]['n_port'] +'</td>' +
                            '<td>' + data['datos'][i]['model'] + '</td>' +
                            '<td>' + data['datos'][i]['service'] + '</td>' +
                            '<td> <a onclick="delecte_port_lacp('+data['datos'][i]['id']+');" title="Quitar puerto lacp"> <i class="fa fa-trash-o"> </i></a></td>'+
                            '</tr>';
                        $("#port_recurso_sevicio").append(valor);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function insert_port_lacp(port, board, group){
    var modal = document.getElementById("exit_port_recu_sevi");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/lacp',
        data: {port:port, board:board, group:group,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Modificación Exitosa");
                    port_selec_servi();
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delecte_port_lacp(id){
    var modal = document.getElementById("exit_port_recu_sevi");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'eliminar/puerto/lacp',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "nop":
                    toastr.error("Ancho de banda supera los puertos");
                    break;
                case "yes":
                    toastr.success("Modificación Exitosa");
                    port_selec_servi();
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function new_lacp(){
    var modal = document.getElementById("exit_port_lacp_sevi");
    var mensaje = document.getElementById("title_port_lacp");
    mensaje.textContent  = 'CREAR LACP';
    var new_tbody = document.createElement('tbody');
    $("#port_lacp_sevice").html(new_tbody)
    var id = document.getElementById('equip').value;
    var cancelar = document.getElementById("lacp_cancelar");
    var aceptar = document.getElementById("lacp_aceptar");
    $('#come_lacp_equi').val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/recurso',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                            '<td>' + data['datos'][i]['model'] + '</td>' +
                            '<td>' + data['datos'][i]['servicios'] + '</td>' +
                            '<td > <input type="checkbox" id="por_lacp" name="por_lacp[]" value="'+ data['datos'][i]['id_po_bo'] +'"></td>'+
                            '</tr>';
                        $("#port_lacp_sevice").append(valor);
                    })
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    cancelar.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var come = document.getElementById('come_lacp_equi').value;
        let lacp = [];
        $('[name="por_lacp[]"]:checked').each(function(){
            lacp.push(this.value);
        });
        if (lacp.length > 0) {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/lacp',
                data: {id:lacp, come:come},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            var new_tbody = document.createElement('tbody');
                            $("#port_lacp_sevice").html(new_tbody)
                            modal.click();
                            if (functi != 'SERVICIO') {
                                inf_equip_port(id);
                            }
                            port_selec_servi();
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            cancelar.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }else{
            toastr.error("Seleccione puertos");
        }
    }
    cancelar.onclick = function() {
        var new_tbody = document.createElement('tbody');
        $("#port_lacp_sevice").html(new_tbody)
        modal.click();
    }
}

function localizacion(){
    var modal = document.getElementById("cerra_local");
    var cancelar = document.getElementById("localtion_exit");
    var aceptar = document.getElementById("localtion_success");
    var input = document.getElementById("elemen_local");
    var new_div = document.createElement('div');
    $("#elemento_localizacion").html(new_div)
    $('#elemen_local').val('');
    input.onchange = function() {
        var cantidad= document.getElementById('elemen_local').value;
        var new_div = document.createElement('div');
        $("#elemento_localizacion").html(new_div)
        if (cantidad != '' && cantidad > 0) {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL()+'equipo/localizacion',
                data: {},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            for ( i = 0 ; i <= cantidad - 1 ; i++){
                                can_new = '<div class="form-group">'+
                                    '<div class="bw_all" id="bw_all" >'+
                                    '<select class="form-control name_val" id="name_val['+i+']" name="name_val[]">';
                                $(data['datos']).each(function(i, v){
                                    can_new += '<option value="'+ data['datos'][i]['name'] + '">'+ data['datos'][i]['name'] + '</option>';
                                });
                                can_new += '</select>'+
                                    ' <input type="text" id="local_val['+i+']"maxlength="20" placeholder="lugar" name="local_val[]" class="form-control local_val">'+
                                    '</div>'+
                                    '</div>';
                                $("#elemento_localizacion").append(can_new);
                            }
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            modal.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    aceptar.onclick = function() {
        var local = document.getElementsByClassName("local_val");
        var name = document.getElementsByClassName("name_val");
        var valor_name = [];
        var valor_local = [];
        var mostrar = '';
        for (var i = 0; i < name.length; ++i) {
            if (typeof name[i].value !== "undefined") {
                valor_name.push(name[i].value);
            }
            if (typeof local[i].value !== "undefined") {
                valor_local.push(local[i].value);
            }
            if (mostrar == '') {
                mostrar = name[i].value+': '+local[i].value;
            }else{
                mostrar = mostrar+' | '+name[i].value+': '+local[i].value;
            }
        }
        var validar1 = valor_name.indexOf('');
        var validar2 = valor_local.indexOf('');
        if (validar1 != -1 || validar2 != -1) {
            toastr.error("Todos los campos son obligatorio");
        }else if (valor_name.length == 0) {
            toastr.error("El numero de elemento obligatorio");
        }else{
            $('#local_equipmen').val(mostrar);
            $('#local_equipmen_lsw').val(mostrar);
            modal.click();
        }

    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function users_sesion(id){
    var mensaje = document.getElementById("mytitle");
    mensaje.textContent  = 'Confirme si desea expulsar el usuario';
    var modal = document.getElementById("cerra_confimacion_full");
    var cancelar = document.getElementById("Cancelar");
    var aceptar = document.getElementById("Aceptar");
    aceptar.onclick = function() {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'cerrar/usuario',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Se expulso el usuario Exitosamente");
                        $('#user_lis_all').DataTable().ajax.reload();
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("No puede expulsar su mismo usuario");
                        modal.click();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function users_desactivar(id){
    var mensaje = document.getElementById("mytitle");
    mensaje.textContent  = 'Confirme desactivación de usuario';
    var modal = document.getElementById("cerra_confimacion_full");
    var cancelar = document.getElementById("Cancelar");
    var aceptar = document.getElementById("Aceptar");
    aceptar.onclick = function() {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'desactivar/usuario',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        toastr.success("Desactivación Exitosa");
                        $('#user_lis_all').DataTable().ajax.reload();
                        modal.click();
                        break;
                    case "nop":
                        toastr.error("No puede desactivar su mismo usuario");
                        modal.click();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function users_activar(id){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'activar/usuario',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Activación Exitosa");
                    $('#user_lis_all').DataTable().ajax.reload();
                    modal.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function port_new_lacp_search(id, group){
    var mensaje = document.getElementById("title_port_mas_meno");
    mensaje.textContent  = 'AGREGAR PUERTO LACP';
    var new_tbody = document.createElement('tbody');
    $("#port_recurso_sevicio").html(new_tbody)
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/recurso',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                            '<td>' + data['datos'][i]['model'] + '</td>' +
                            '<td>' + data['datos'][i]['servicios'] + '</td>' +
                            '<td> <a onclick="insert_port_lacp_new('+data['datos'][i]['por_selec']+', '+data['datos'][i]['board']+', '+group+', '+id+');" title="Modificar"> <i class="fa fa-dot-circle-o" > </i></a></td>'+
                            '</tr>';
                        $("#port_recurso_sevicio").append(valor);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function insert_port_lacp_new(port, board, group, equip){
    var modal = document.getElementById("exit_port_recu_sevi");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/lacp',
        data: {port:port, board:board, group:group,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Modificación Exitosa");
                    inf_equip_port(equip);
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function port_delecte_lacp_search(id, group){
    var mensaje = document.getElementById("title_port_mas_meno");
    mensaje.textContent  = 'QUITAR PUERTO';
    var new_tbody = document.createElement('tbody');
    $("#port_recurso_sevicio").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'eliminar/puerto/lacp/equipo',
        data: {id:id, group:group,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['slot'] + data['datos'][i]['n_port']+'</td>' +
                            '<td>' + data['datos'][i]['model'] + '</td>' +
                            '<td>' + data['datos'][i]['service'] + '</td>' +
                            '<td > <i class="fa fa-trash-o" onclick="delate_port_lacp('+data['datos'][i]['id']+','+id+');" title="Quitar"> </i></a></td>'+
                            '</tr>';
                        $("#port_recurso_sevicio").append(valor)
                    })
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delate_port_lacp(id, equip){
    var modal = document.getElementById("exit_port_recu_sevi");
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'eliminar/puerto/grupo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "nop":
                    toastr.error("Hay servicio que requiere el ancho de bando del puerto en el grupo");
                    break;
                case "yes":
                    toastr.success("Modificación Exitosa");
                    modal.click();
                    inf_equip_port(equip);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delecte_lacp(id){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'eliminar/lacp/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Eliminación Exitosa");
                    inf_equip_port(data['datos']);
                    break;
                case "exis":
                    toastr.error("LACP esta ciendo utilizado");
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function provincia_all(provincia = null){
    var sele = $("#provin");
    sele.find('option').remove();
    sele.append('<option selected disabled value="">seleccionar</option>');
    $('#provin').val('').trigger('change.select2');
    var id = document.getElementById('pais').value;
    if (id != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'mostrar/provincia',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $(data['datos']).each(function(i, v){ // indice, valor
                            sele.append(
                                '<option value="'+ data['datos'][i]['id'] + '">' +  data['datos'][i]['name'] + '</option>'
                            );
                        })
                        var opt = $("#provin option").sort(function (a,b) { return a.textContent.toUpperCase().localeCompare(b.textContent.toUpperCase()) });
                        $("#provin").append(opt);
                        //$("#provin").find('option:first').attr('selected','selected');
                        if (provincia != null) {
                            $('#provin').val(provincia).trigger('change.select2');
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function provincia_lista(id){
    var list = 12;
    $('#list_id_pais').val(id);
    var new_tbody = document.createElement('tbody');
    $("#all_province_pais").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'mostrar/provincia',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i].name + '</td>' +
                            '<td>'+
                            '<a data-toggle="modal" data-target="#lis_edict_province" onclick="list_province_selec('+data['datos'][i].id+', '+list+');" title="Editar"> <i class="fa fa-edit" > </i></a>' +
                            '<a onclick="delecte_lista('+data['datos'][i].id+', '+list+');" title="Eliminar"> <i class="fa fa-trash-o" > </i></a></td>' +
                            '</tr>';
                        $("#all_province_pais").append(valor)
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function content_direc(id){
    $('#list_all_conten_address').DataTable( {
        stateSave: true,
        destroy: true,
        "processing": true,
        resposive: true,
        dom: 'lfrtip',
        "ajax": getBaseURL() +'buscar/contenido/direccion/'+id,
        "columns": [
            { data: 'equipment' },
            { data: 'number' },
            { data: 'business_name' },
            { data: 'name' },
            { data: 'bw' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a data-toggle="modal" data-target="#recurso_servicio_pop" onclick="new_recur_equipmen('+id+');" title="Asignar recurso a un servicio"> <i class="fa fa-exchange"></i></a>';
                }
            },
        ]
    });
}

function list_province_new(){
    var mensaje = document.getElementById("title_provinse");
    mensaje.textContent  = 'REGISTRAR PROVINCIA';
    var pais = document.getElementById("list_id_pais").value;
    $('#list_id_pais').val(pais);
    $('#name_lis_povince').val('');
    $('#list_id_provice').val(0);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/lista',
        data: {id:pais, list:11},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#name_pais').val(data['data']['name']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function list_province_selec(id, list){
    var mensaje = document.getElementById("title_provinse");
    mensaje.textContent  = 'MODIFICACIÓN PROVINCIA';
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/lista',
        data: {id:id, list:list},
        dataType: 'json',
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
                    toastr.error("Error al buscar los datos");
                    break;
                case "ip_exi":
                    toastr.error("IP no disponible");
                    break;
                case "yes":
                    $('#list_id_pais').val(data['data']['id_countries']);
                    $('#name_pais').val(data['data']['countries']);
                    $('#name_lis_povince').val(data['data']['name']);
                    $('#list_id_provice').val(data['data']['id']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});

function crear_sub_red_all(id){
    var modal = document.getElementById('cerrar_sub_red_all');
    var cancelar = document.getElementById("sub_red_all_cerra");
    var aceptar = document.getElementById("sub_red_all_seguir");
    $('#mask_all').val('');
    aceptar.onclick = function() {
        var mask = document.getElementById("mask_all").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'ip/subred/rango',
            data: {id:id, mask:mask},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function buscar_ip_wan(interface = null){
    switch (interface) {
        case 1: var id = document.getElementById("equip_id_inp").value; break;
        case 2: var id = document.getElementById("equip_sel").value; break;
        default: var id = document.getElementById("equip").value; break;
    }
    var new_tbody = document.createElement('tbody');
    $("#ip_lanswitch_table").html(new_tbody);
    if (id == '' || id.length == 0) {
        toastr.error("seleccione el equipo");
    } else {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'ip/wan/lanswitch',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
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

function selecion_ip_wan(id, interface = null){
    switch (interface) {
        case 1:
            var ip_id = $('#ip_id');
            var ip_number = $('#ip_number');
            break;
        case 3:
            var ip_id = $('#ip_id_2');
            var ip_number = $('#ip_number_2');
            break;
        default:
            var ip_id = $('#ip_admin_servi_id');
            var ip_number = $('#ip_admin_servi');
            break;
    }
    var modal = document.getElementById("cerra_bus_ip_admin_lans");
    if (id != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'buscar/ip',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "yes":
                        ip_id.val(id);
                        ip_number.val(data['ip']+'/'+data['barra']);
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        ip_id.val(0);
        ip_number.val('');
    }
}

function commen_port_equipmen(board, port){
    var cancelar = document.getElementById("button_cancelar");
    var aceptar = document.getElementById("button_aceptar");
    var modal = document.getElementById("cerrar_comen_puerto");
    var title_msj = document.getElementById("title_port_commen");
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/comentario',
        data: {board:board, port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#commen_port_all').val(data['datos']['commen']);
                    title_msj.textContent  = data['acronimo'];
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen_port_all").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/comentario/puerto',
            data: {board:board, port:port, commen:commen,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        inf_equip_port(data['datos']);
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function FilterIP(){
    var modal = document.getElementById("cerrar_pop_filter");
    var filter = document.getElementById('boton_filter');
    var cerrar = document.getElementById('boton_filter_cerrar');
    var aceptar = document.getElementById("aceptar_filtro");
    var cancelar = document.getElementById("cancelar_filtro");
    $('#atributo_ip').val('').trigger('change.select2');
    aceptar.onclick = function() {
        var ip = document.getElementById("ip_filter").value;
        var anillo = document.getElementById("anilo_id").value;
        var client = document.getElementById("client").value;
        var equip = document.getElementById("equip").value;
        var servicio = document.getElementById("id_servicio_recurso").value;
        var atributo = document.getElementById("atributo_ip").value;
        if ((ip == "" || ip.length < 1) && atributo == 4) {
            toastr.error("La IP es obligatorio.");
        }else if ((anillo == "" || anillo.length < 1) && atributo == 1){
            toastr.error("El Anillo es obligatorio.");
        }else if ((client == "" || client.length < 1) && atributo == 2){
            toastr.error("El Cliente es obligatorio.");
        }else if ((equip == "" || equip.length < 1) && atributo == 3){
            toastr.error("El Equipo es obligatorio.");
        }else if ((servicio == "" || servicio.length < 1) && atributo == 5){
            toastr.error("El Servicio es obligatorio.");
        }else{
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL()+'filtrar/ip',
                data: {ip:ip, anillo:anillo, client:client, equip:equip, servicio:servicio, atributo:atributo,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            if (data['datos'].length > 0) {
                                filter.style.display = "none";
                                cerrar.style.display = "block";
                                var new_tbody = document.createElement('div');
                                $("#multi_table_ip").html(new_tbody);
                                var new_table = document.createElement('div');
                                $("#conten1").html(new_table);
                                modal.click();
                                var table = '<div><table class="table_ramas hijos" id="contenedor1"></table></div>';
                                $("#conten1").append(table)
                                $(data['datos']).each(function(i, v){
                                    valor ='<ul><li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i]['id']+'" onclick="rango_rama_list('+data['datos'][i]['id']+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i]['id']+'" onclick="eliminar_mas_rama('+data['datos'][i]['id']+');"></i></li>' +
                                        '<li>-<i class="fa fa-database"></i></li> ';
                                    valor +=    '<li>  ' + data['datos'][i]['name'] + ' ' + data['datos'][i]['ip_rank'] +'' + data['datos'][i]['barra']+ '</li>';
                                    if (data['datos'][i].permi >= 10) {
                                        valor += '<li title="Modificar Rama"> <i class="fa fa-edit" data-toggle="modal" data-target="#popcrear_rama"onclick="modificar_rama('+data['datos'][i]['id']+');"></i></li>';
                                    }
                                    if (data['datos'][i].permi >= 10) {
                                        valor += '<li title="Crear Toda La SubRed"> <i class="fa fa-code-fork" data-toggle="modal" data-target="#pop_sub_red_all" onclick="crear_sub_red_all('+data['datos'][i]['id']+');"></i></li>';
                                    }
                                    if (data['datos'][i].permi >= 5) {
                                        valor += '<li title="Crear SubRed"> <i class="fa fa-sitemap" data-toggle="modal" data-target="#popcrear_red"onclick="crear_sub_red('+data['datos'][i]['id']+');"></i></li>' +
                                            '<li title="Eliminar SubRed"> <i class="fa fa-window-close" data-toggle="modal" data-target="#popeliminar"onclick="eliminar_sub_red('+data['datos'][i]['id']+');"></i></li>';
                                    }
                                    valor += '<li title="Detalle"> <i class="fa fa-search" data-toggle="modal" data-target="#popfilter_local"onclick="detal_sub_red('+data['datos'][i]['id']+');"></i></li>';
                                    valor += '</ul>';
                                    $("#contenedor1").append(valor);
                                });
                            }else{
                                toastr.error("La IP no existe");
                            }
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function DelecteFilter(){
    var filter = document.getElementById('boton_filter');
    var cerrar = document.getElementById('boton_filter_cerrar');
    filter.style.display = "block";
    cerrar.style.display = "none";
    var new_tbody = document.createElement('div');
    $("#multi_table_ip").html(new_tbody);
    var new_table = document.createElement('div');
    $("#conten1").html(new_table);
    var table = '<div id="contenedor1" class="table_ramas hijos"></div>';
    $("#conten1").append(table);
    ver_mas_rama(1);
}

function FiltroAtributo(){
    var atributo = document.getElementById("atributo_ip").value;
    var anillo = document.getElementById('anillo_input');
    var equipo = document.getElementById('equipo_input');
    var ip = document.getElementById('ip_input');
    var servicio = document.getElementById('servicio_input');
    var cliente = document.getElementById('cliente_input');
    $("#ip_filter").val('');
    $("#anilo_name").val('seleccionar');
    $("#anilo_id").val('');
    $("#client").find('option').remove();
    $("#equip").find('option').remove();
    $("#id_servicio_recurso").find('option').remove();
    $("#client").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#equip").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_servicio_recurso").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    switch (atributo) {
        case "1":
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "block";
            break;
        case "2":
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "block";
            anillo.style.display = "none";
            break;
        case "3":
            equipo.style.display = "block";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
        case "4":
            equipo.style.display = "none";
            ip.style.display = "block";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
        case "5":
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "block";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
        default:
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
    }
}

function selec_anillo_service(id){
    var modal = document.getElementById("cerra_bus_anillo");
    var equipm = document.getElementById('equip_2_mostar');
    var equi = $("#equi_con_1");
    var selec = $("#anilo_id_sub_red");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'seleccionar/anillo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $('#anilo_id').val(id);
                    $('#anilo_name').val(data['name']+' '+data['type']+', Agregador:'+data['acronimo']);
                    $('#anilo_name').attr('disabled', '');
                    selec.append('<option selected disabled value="'+id+'">'+data['name']+' '+data['type']+'</option>');
                    selec.val(id).trigger('change.select2');
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function sele_equi_admin_ip(id){
    var modal = document.getElementById("cerra_all_equipo_ip");
    var selec = $("#equip");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>');
                    selec.val(id).trigger('change.select2');
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
    modal.click();
}

function FiltroAtributoLista(){
    var atributo = document.getElementById("atributo_ip_lista").value;
    var anillo = document.getElementById('anillo_input_list');
    var equipo = document.getElementById('equipo_input_list');
    var ip = document.getElementById('ip_input_list');
    var servicio = document.getElementById('servicio_input_list');
    var cliente = document.getElementById('cliente_input_list');
    $("#ip_filter_list").val('');
    $("#anillo_id_list").find('option').remove();
    $("#client_list").find('option').remove();
    $("#equip_list").find('option').remove();
    $("#id_servicio_list").find('option').remove();
    $("#anillo_id_list").append('<option selected disabled value="">seleccionar</option>');
    $("#client_list").append('<option selected disabled value="">seleccionar</option>');
    $("#equip_list").append('<option selected disabled value="">seleccionar</option>');
    $("#id_servicio_list").append('<option selected disabled value="">seleccionar</option>');
    switch (atributo) {
        case "1":
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "block";
            break;
        case "2":
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "block";
            anillo.style.display = "none";
            break;
        case "3":
            equipo.style.display = "block";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
        case "4":
            equipo.style.display = "none";
            ip.style.display = "block";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
        case "5":
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "block";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
        default:
            equipo.style.display = "none";
            ip.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            break;
    }
}

function FilterBuscar(){
    var atributo = document.getElementById("atributo_ip_lista").value;
    var anillo = document.getElementById("anillo_id_list").value;
    var client = document.getElementById("client_list").value;
    var equip = document.getElementById("equip_list").value;
    var ip_filter = document.getElementById("ip_filter_list").value;
    var id_servicio = document.getElementById("id_servicio_list").value;
    $url = "";
    switch (atributo) {
        case "1":
            if (anillo == "" || anillo.length < 1){
                toastr.error("El Anillo es obligatorio.");
            }else{
                $url = "filtro/ip/anillo/"+anillo;
            }
            break;
        case "2":
            if (client == "" || client.length < 1){
                toastr.error("El Cliente es obligatorio.");
            }else{
                $url = "filtro/ip/cliente/"+client;
            }
            break;
        case "3":
            if (equip == "" || equip.length < 1){
                toastr.error("El Equipo es obligatorio.");
            }else{
                $url = "filtro/ip/equipo/"+equip;
            }
            break;
        case "4":
            if (ip_filter == "" || ip_filter.length < 1){
                toastr.error("La IP es obligatorio.");
            }else{
                $url = "filtro/ip/"+ip_filter;
            }
            break;
        case "5":
            if (id_servicio == "" || id_servicio.length < 1){
                toastr.error("El Servicio es obligatorio.");
            }else{
                $url = "filtro/ip/servicio/"+id_servicio;
            }
            break;
    }
    if ($url != "") {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_all_info_ip').DataTable({
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL()+$url,
            "columns": [
                { data: 'ip' },
                { data: 'status' },
                { data: 'atributo' },
            ]
        });
    }
}

function ClearSubRed(){
    $("#status_sub_red").val('').trigger('change.select2');
    $("#rama_sub_red").val('').trigger('change.select2');
    $('#list_all_sub_red').DataTable().clear().draw();
}

function ClearFilterIP(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_info_ip').DataTable().clear().draw();
    $("#atributo_ip_lista").val('').trigger('change.select2');
    $("#ip_filter_list").val('');
    $("#anillo_id_list").find('option').remove();
    $("#client_list").find('option').remove();
    $("#equip_list").find('option').remove();
    $("#id_servicio_list").find('option').remove();
    $("#anillo_id_list").append('<option selected disabled value="">seleccionar</option>');
    $("#client_list").append('<option selected disabled value="">seleccionar</option>');
    $("#equip_list").append('<option selected disabled value="">seleccionar</option>');
    $("#id_servicio_list").append('<option selected disabled value="">seleccionar</option>');
}

function selec_anillo_ip(id){
    var modal = document.getElementById("cerra_bus_anillo");
    var selec = $("#anillo_id_list");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'seleccionar/anillo/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    selec.append('<option selected disabled value="'+id+'">'+data['datos']['name']+'</option>');
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function selec_client_ip(id){
    $("#client_list").find('option').remove();
    if (id != null) {
        var cerrar = document.getElementById('cerra_bus_clien');
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/cliente',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#client_list").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        break;
                    case "nop":
                        $("#client_list").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
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
    }else{
        selec.append('<option selected disabled value="">seleccionar</option>');
    }
}

function selec_service_ip(id){
    var cerrar = document.getElementById('cerra_bus_servi_all');
    var selec = $("#id_servicio_list");
    var selec_upgr = $("#service_sel");
    var bw_service = $("#bw_input");
    selec.find('option').remove();
    selec_upgr.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/servicio',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    selec_upgr.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    bw_service.val(data['bw_service']);
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

function sele_equi_admin_ip_list(id){
    var modal = document.getElementById("cerra_all_equipo_ip");
    $("#equip_list").find('option').remove();
    $("#atributo_ip_rese").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#equip_list").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    $("#atributo_ip_rese").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
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
    modal.click();
}

function FilterBuscarSebRed(){
    var status = document.getElementById("status_sub_red").value;
    var rama = document.getElementById("rama_sub_red").value;
    if ( status != "" && rama != "") {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_all_sub_red').DataTable({
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL()+'filtro/sub/red/'+status+'/'+rama,
            "columns": [
                { data: 'ip' },
                { data: 'status' },
                { data: 'atributo' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var branch = full.branch;
                        var boton = '';
                        switch (status) {
                            case '1':
                                boton += '<a data-toggle="modal" data-target="#popasignar_red_ip" onclick="asignar_red_ip_admin('+id+',1);" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                                break;
                            case '2':
                                boton += '<a title="Ocupado"> <i class="fa fa-warning" style="color: coral;"></i></a></td>';
                                break;
                            default:
                                boton += '<a data-toggle="modal" data-target="#confimacion_full" onclick="liberar_red_ip_admin('+id+');" title="Liberar"> <i class="fa fa-circle"></i></a></td>';
                                break;
                        }
                        boton += '<a data-toggle="modal" data-target="#popfilter_local" onclick="detal_sub_red('+branch+');" title="Detalle"> <i class="fa fa-search"></i></a></td>';
                        return boton;
                    }
                },
            ]
        });
    }else{
        $('#list_all_sub_red').DataTable().clear().draw();
    }
}

function AsignarAtributo(){
    var atributo = document.getElementById("atributo_red_ip").value;
    var anillo = document.getElementById('anillo_input_red');
    var equipo = document.getElementById('equipo_input_red');
    var comen = document.getElementById('comen_input_red');
    var servicio = document.getElementById('servicio_input_red');
    var cliente = document.getElementById('cliente_input_red');
    var anillo_input = document.getElementById('anillo_input_red_id');
    var node = document.getElementById('node_input_red_id');
    $("#type_vlan_red_ip").val('').trigger('change.select2');
    $("#vlan_sub_red").val('');
    $("#asignar_sub_red").val('');
    $("#anilo_id_sub_red").find('option').remove();
    $("#client_sub_red").find('option').remove();
    $("#id_servicio_sub_red").find('option').remove();
    $("#nodo_al").find('option').remove();
    $("#client_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_servicio_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#anilo_id_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#nodo_al").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    switch (atributo) {
        case "1":
            comen.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            node.style.display = "none";
            anillo.style.display = "block";
            anillo_input.style.display = "block";
            break;
        case "2":
            comen.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "block";
            anillo.style.display = "none";
            node.style.display = "none";
            anillo_input.style.display = "none";
            break;
        case "4":
            comen.style.display = "block";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            node.style.display = "none";
            anillo_input.style.display = "none";
            break;
        case "5":
            comen.style.display = "none";
            servicio.style.display = "block";
            cliente.style.display = "none";
            anillo.style.display = "none";
            node.style.display = "none";
            anillo_input.style.display = "none";
            break;
        case "6":
            comen.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            node.style.display = "block";
            anillo.style.display = "block";
            anillo_input.style.display = "none";
            break;
        default:
            comen.style.display = "none";
            servicio.style.display = "none";
            cliente.style.display = "none";
            anillo.style.display = "none";
            node.style.display = "none";
            anillo_input.style.display = "none";
            break;
    }
}

function asignar_red_ip_admin(id, location = null){
    var modal = document.getElementById("cerrar_pop_asignar_red_ip");
    var cerrar = document.getElementById('cancelar_asignar_red_ip');
    var aceptar = document.getElementById("aceptar_asignar_red_ip");
    $("#atributo_red_ip").val('').trigger('change.select2');
    aceptar.onclick = function() {
        var atributo = document.getElementById("atributo_red_ip").value;
        var type_vlan = document.getElementById("type_vlan_red_ip").value;
        var vlan = document.getElementById("vlan_sub_red").value;
        var anilo_id = document.getElementById("anilo_id_sub_red").value;
        var client = document.getElementById("client_sub_red").value;
        var asignar = document.getElementById("asignar_sub_red").value;
        var servicio = document.getElementById("id_servicio_sub_red").value;
        var node = document.getElementById("nodo_al").value;
        if (atributo == '' || atributo.length == 0) {
            toastr.error("El Atributo es obligatorio.");
        }else if (type_vlan == '' && (atributo == '1' || atributo == '6')) {
            toastr.error("El Tipo de Vlan es obligatorio.");
        }else if (vlan == '' && (atributo == '1' || atributo == '6')) {
            toastr.error("La Vlan es obligatorio.");
        }else if (anilo_id == '' && atributo == '1' ) {
            toastr.error("El Anillo es obligatorio.");
        }else if (client == '' && atributo == '2' ) {
            toastr.error("El Cliente es obligatorio.");
        }else if (asignar == '' && atributo == '4' ) {
            toastr.error("El comentario es obligatorio.");
        }else if (servicio == '' && atributo == '5' ) {
            toastr.error("El Servicio es obligatorio.");
        }else if (node == '' && atributo == '6' ) {
            toastr.error("El Nodo es obligatorio.");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'asignar/subred',
                data: {id:id, atributo:atributo, type_vlan:type_vlan, vlan:vlan, anilo_id:anilo_id, client:client, asignar:asignar, servicio:servicio, node:node},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Registro Exitoso");
                            $("#atributo_red_ip").val('').trigger('change.select2');
                            modal.click();
                            if (location == '1') {
                                FilterBuscarSebRed();
                            }else{
                                rango_rama_list(data['datos']);
                            }
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            break;
                        case "nop":
                            toastr.error("La SubRed tiene IP ocupada");
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    cerrar.onclick = function() {
        modal.click();
    }
}

function buscar_ip_admin_all_red(id, ip_servi=null){
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    var new_tbody = document.createElement('div');
    $("#multi_table_ip").html(new_tbody);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'mas/rama';
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay datos para este grupo");
                    }else{
                        $('#id_rango_old').val(data['es_rango']);
                        var conte = $('#contenedor'+id);
                        if (conte.length == 0 || id == 1) {
                            var new_all = document.createElement('div');
                            $("#contenedor").html(new_all);
                            conte = $('#contenedor');
                            var valor_ini = '<ul>'+
                                '<li><i class="fa fa-file-archive-o"></i></li> '+
                                '<li>  ' + data['actual']['name'] + '</li>'+
                                '</ul>';
                            $('#contenedor').append(valor_ini)
                            var table = '<div><table class="table_ramas hijos" style="margin-left: 30px;" id="contenedor'+id+'"></table></div>';
                            $('#contenedor').append(table)
                        }else{
                            positivo.style.display = "none";
                            negativo.style.display = "block";
                        }
                        var new_tbody = document.createElement('div');
                        $('#contenedor'+id+'').html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<ul>';
                            if (data['datos'][i].rank != 'Si') {
                                valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="buscar_ip_admin_all_red('+data['datos'][i].id+','+ip_servi+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_mas_rama('+data['datos'][i].id+');"></i></li>' +
                                    '<li>- <i class="fa fa-database"></i></li> ';
                            }else{
                                valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="rango_rama_lis_all_red('+data['datos'][i].id+','+ip_servi+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_rango_rama_list('+data['datos'][i].id+');"></i></li>' +
                                    '<li>--- <i class="fa fa-file-archive-o"></i></li> ';
                            }
                            valor +=    '<li>  ' + data['datos'][i].name + ' ' + data['datos'][i].ip_rank +'' + data['datos'][i].barra + '</li>';
                            if (data['datos'][i].rank == 'Si') {
                                if (data['datos'][i].permi >= 5) {
                                    valor += '<li title="Crear SubRed"> <i class="fa fa-sitemap" data-toggle="modal" data-target="#popcrear_red"onclick="crear_sub_red('+data['datos'][i].id+');"></i></li>' +
                                        '<li title="Eliminar SubRed"> <i class="fa fa-window-close" data-toggle="modal" data-target="#popeliminar"onclick="eliminar_sub_red('+data['datos'][i].id+');"></i></li>' +
                                        '</ul>';
                                }else{
                                    valor += '</ul>';
                                }
                            }else{
                                if (data['datos'][i].rank == 'No' && data['datos'][i].padre == 0) {
                                    valor += '</ul>';
                                }else{
                                    if (data['datos'][i].rank == 'No' && data['datos'][i].hijo == 0) {
                                        if (data['datos'][i].permi >= 5) {
                                            valor += '<li title="Crear Rama Hijo">  <i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_sin_rank('+data['datos'][i].id+');"></i></li>' +
                                                '</ul>';
                                        }else{
                                            valor += '</ul>';
                                        }
                                    }
                                }
                            }
                            $('#contenedor'+id).append(valor)
                            var table = '<div><table class="table_ramas hijos" style="margin-left: 30px;" id="contenedor'+data['datos'][i].id+'"></table></div>';
                            $('#contenedor'+id).append(table)
                        });
                        $('#id_rama_old').val(id);
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function rango_rama_lis_all_red(id, ip_servi=null){
    var id_rama_old = document.getElementById("id_rama_old").value;
    var id_rango_old = document.getElementById("id_rango_old").value;
    var id_function = document.getElementById("functi").value;
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    if (id != id_rama_old && id_rama_old!= 0 && id_rango_old == 'Si'){
        var positivo_old = document.getElementById('positivo'+id_rama_old+'');
        var negativo_old = document.getElementById('negativo'+id_rama_old+'');
        negativo_old.style.display = "none";
        positivo_old.style.display = "block";
    }
    var new_tbody = document.createElement('div');
    $("#multi_table_ip").html(new_tbody);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("No hay datos para este grupo");
                    break;
                default:
                    positivo.style.display = "none";
                    negativo.style.display = "block";
                    var titulo = '<h4><i class="fa fa-file-archive-o"></i>  Rango: '+data['nombre']+' :'+data['inicio']+'/'+data['barra']+'</h4>';
                    titulo += '<h4> Detalle de las Ip del Rango</h4>';
                    $("#multi_table_ip").append(titulo)
                    var table = '<div><table class="table table-striped table-bordered table-hover dataTables-example">';
                    table +='<thead> <tr> <th>Estado</th> <th>Dirección</th> <th>Atributo</th> <th></th> </tr> </thead>';
                    table +='<tbody id="tbodyramas"> </tbody>';
                    table +='</table></div>';
                    $("#multi_table_ip").append(table)
                    $(data['datas']).each(function(i, v){
                        if (data['datas'][i]['type'] == "RED" || data['datas'][i]['status_id'] == 4 || data['datas'][i]['status_id'] == 0) {
                            var valor = '<tr>';
                            if (data['datas'][i]['ip'] == data['fin']) {
                                valor += '<td><center><i class="fa fa-globe"></i></center></td>';
                            }else{
                                switch (data['datas'][i]['type']) {
                                    case "RED":
                                        valor += '<td><center><i class="fa fa-sitemap"></i> RED</center></td>';
                                        break;
                                    default :
                                        valor += '<td><center>' + data['datas'][i]['status'] + '</center></td>';
                                        break;
                                }
                            }
                            if (data['datas'][i]['subnet'] != null && data['datas'][i]['subnet'] != '') {
                                valor += '<td> ' + data['datas'][i]['ip']+'/'+data['datas'][i]['subnet']+'</td>';
                            }else{
                                valor += '<td> ' + data['datas'][i]['ip']+'</td>';
                            }
                            valor += '<td>' + data['datas'][i]['atributo'] + '</td>';
                            if (data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == 'RED' && data['datas'][i]['info_red'] == 'SI') {
                                valor +='<td> <i class="fa fa-dot-circle-o" onclick="selecion_ip_rango('+data['datas'][i]['id_rango']+','+ip_servi+');"></i></td>';
                            }else{
                                if (data['datas'][i]['status'] == 'SIN ASIGNAR') {
                                    valor +='<td></td>';
                                }else{
                                    valor +='<td> <i class="fa fa-warning" style="color: coral;"></i></td>';
                                }
                            }
                            valor += '</tr>';
                            $("#tbodyramas").append(valor)
                        }
                    });
                    $('#id_rama_old').val(id);
                    $('#id_rango_old').val('Si');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function liberar_red_ip_admin(id){
    var aceptar = document.getElementById("Aceptar");
    var cancelar = document.getElementById("Cancelar");
    var mensaje = document.getElementById("mytitle");
    var modal = document.getElementById('cerra_confimacion_full');
    mensaje.textContent = '¿Esta seguro de que quieres liberar la SubRed?';
    aceptar.onclick = function() {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'liberar/subred',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'nop':
                        toastr.error("La SubRed tiene IP ocupada");
                        break;
                    case 'yes':
                        FilterBuscarSebRed();
                        toastr.success("Liberación Exitosa");
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function alta_dm_crear(){
    var mensaje = document.getElementById("title_dm");
    mensaje.textContent  = 'REGISTRAR DM';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "block";
    var aceptar = document.getElementById("alta_dm_pop");
    var cancelar = document.getElementById("baja_dm_pop");
    var modal = document.getElementById('cerra_dm_pop');
    var selec = $("#equi_alta");
    selec.find('option').remove();
    selec.append('<option selected disabled value="">seleccionar</option>');
    document.getElementById("alta_dm").reset();
    $('#id_equipos').val('0');
    $("#equi_alta").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#nodo_al").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#nodo_al').append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    aceptar.onclick = function() {
        var placa = document.getElementsByClassName("placa_alta");
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var equipo = document.getElementById("equi_alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        var port = [];
        for (var i = 0; i < placa.length; ++i) {
            if (typeof placa[i].value !== "undefined") { port.push(placa[i].value); }
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/DM',
            data: {id:0, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:equipo, nodo:nodo, port:port, id_zone:id_zona},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'yes':
                        $('#jarvis_dm').DataTable().ajax.reload();
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_dm(id){
    
    var mensaje = document.getElementById("title_dm");
    mensaje.textContent  = 'MODIFICAR DM';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    var aceptar = document.getElementById("alta_dm_pop");
    var cancelar = document.getElementById("baja_dm_pop");
    var modal = document.getElementById('cerra_dm_pop');
    document.getElementById("alta_dm").reset();
    $('#id_equipos').val(id);
    $("#nodo_al").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#equi_alta").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case 'yes':
                    $('#local_equipmen').val(data['datos']['location']);
                    $("#equi_alta").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $('#name').val(data['datos']['acronimo']);
                    $('#ip').val(data['datos']['id_ip']);
                    $('#commen').val(data['datos']['commentary']);
                    $('#alta').val(data['datos']['ir_os_up']);
                    $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    $("#ip_admin").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $(`#zone_sel option[value="${data['datos']['id_zone']}"]`).attr('selected', 'selected');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        if (alta == '' || alta.length == 0 ) {
            toastr.error("El IR Alta es obligatorio.")
        }else if (name == '' || name.length == 0 ) {
            toastr.error("El Acronimo es obligatorio.");
        }else if (ip_admin == '' || ip_admin.length == 0) {
            toastr.error("La ip de Gestión es obligatorio.");
        }else if (id_zona == '' || id_zona.length == 0) {
            toastr.error("La zona es obligatoria.");
        }else{
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/DM',
                data: {id:id, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:0, port:0, nodo:nodo, id_zone:id_zona},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case 'login':
                            refresh();
                            break;
                        case 'autori':
                            toastr.error("Usuario no autorizado");
                            break;
                        case 'yes':
                            $('#jarvis_dm').DataTable().ajax.reload();
                            toastr.success("Modificación Exitosa");
                            modal.click();
                            break;
                    }
                },
                error: function(data) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors['errors'], function (ind, elem) {
                        toastr.error(elem);
                    });
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function alta_pei_crear(){
    var mensaje = document.getElementById("title_pei");
    mensaje.textContent  = 'REGISTRAR PEI';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "block";
    var aceptar = document.getElementById("alta_pei_pop");
    var cancelar = document.getElementById("baja_pei_pop");
    var modal = document.getElementById('cerra_pei_pop');
    document.getElementById("alta_pei").reset();
    $('#id_equipos').val('0');
    $("#equi_alta").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#nodo_al").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#nodo_al').append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    aceptar.onclick = function() {
        var placa = document.getElementsByClassName("placa_alta");
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var equipo = document.getElementById("equi_alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        var port = [];
        for (var i = 0; i < placa.length; ++i) {
            if (typeof placa[i].value !== "undefined") { port.push(placa[i].value); }
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/PEI',
            data: {id:0, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:equipo, port:port, nodo:nodo, id_zone:id_zona},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'yes':
                        $('#jarvis_pei').DataTable().ajax.reload();
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_pei(id){
    var mensaje = document.getElementById("title_pei");
    mensaje.textContent  = 'MODIFICAR PEI';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    var aceptar = document.getElementById("alta_pei_pop");
    var cancelar = document.getElementById("baja_pei_pop");
    var modal = document.getElementById('cerra_pei_pop');
    document.getElementById("alta_pei").reset();
    $('#id_equipos').val(id);
    $("#nodo_al").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#equi_alta").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case 'yes':
                    $('#local_equipmen').val(data['datos']['location']);
                    $("#equi_alta").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $('#name').val(data['datos']['acronimo']);
                    $('#ip').val(data['datos']['id_ip']);
                    $('#commen').val(data['datos']['commentary']);
                    $('#alta').val(data['datos']['ir_os_up']);
                    $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    $("#ip_admin").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $(`#zone_sel option[value="${data['datos']['id_zone']}"]`).attr('selected', 'selected');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        if (alta == '' || alta.length == 0 ) {
            toastr.error("El IR Alta es obligatorio.")
        }else if (name == '' || name.length == 0 ) {
            toastr.error("El Acronimo es obligatorio.");
        }else if (ip_admin == '' || ip_admin.length == 0) {
            toastr.error("La ip de Gestión es obligatorio.");
        }else if (id_zona == '' || id_zona.length == 0) {
            toastr.error("La zona es obligatoria.");
        }else{
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/PEI',
                data: {id:id, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:0, port:0, nodo:nodo, id_zone:id_zona},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case 'login':
                            refresh();
                            break;
                        case 'autori':
                            toastr.error("Usuario no autorizado");
                            break;
                        case 'yes':
                            $('#jarvis_pei').DataTable().ajax.reload();
                            toastr.success("Modificación Exitosa");
                            modal.click();
                            break;
                    }
                },
                error: function(data) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors['errors'], function (ind, elem) {
                        toastr.error(elem);
                    });
                }
            });

        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function alta_pe_crear(){
    var mensaje = document.getElementById("title_pe");
    mensaje.textContent  = 'REGISTRAR PE';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "block";
    var aceptar = document.getElementById("alta_pe_pop");
    var cancelar = document.getElementById("baja_pe_pop");
    var modal = document.getElementById('cerra_pe_pop');
    document.getElementById("alta_pe").reset();
    $('#id_equipos').val('0');
    $("#equi_alta").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#nodo_al").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#nodo_al').append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    aceptar.onclick = function() {
        var placa = document.getElementsByClassName("placa_alta");
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var equipo = document.getElementById("equi_alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        var port = [];
        for (var i = 0; i < placa.length; ++i) {
            if (typeof placa[i].value !== "undefined") { port.push(placa[i].value); }
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/PE',
            data: {id:0, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:equipo, port:port, nodo:nodo, id_zone:id_zona},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'yes':
                        $('#jarvis_pe').DataTable().ajax.reload();
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_pe(id){
    document.getElementById("title_pe").textContent  = 'MODIFICAR PE';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    var aceptar = document.getElementById("alta_pe_pop");
    var cancelar = document.getElementById("baja_pe_pop");
    var modal = document.getElementById('cerra_pe_pop');
    document.getElementById("alta_pe").reset();
    $('#id_equipos').val(id);
    $("#nodo_al").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#equi_alta").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case 'yes':
                    $('#local_equipmen').val(data['datos']['location']);
                    $('#name').val(data['datos']['acronimo']);
                    $('#ip').val(data['datos']['id_ip']);
                    $('#commen').val(data['datos']['commentary']);
                    $('#alta').val(data['datos']['ir_os_up']);
                    $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    $("#ip_admin").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $("#equi_alta").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $(`#zone_sel option[value="${data['datos']['id_zone']}"]`).attr('selected', 'selected');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        if (alta == '' || alta.length == 0 ) {
            toastr.error("El IR Alta es obligatorio.")
        }else if (name == '' || name.length == 0 ) {
            toastr.error("El Acronimo es obligatorio.");
        }else if (ip_admin == '' || ip_admin.length == 0) {
            toastr.error("La ip de Gestión es obligatorio.");
        }else if (id_zona == '' || id_zona.length == 0) {
            toastr.error("La zona es obligatoria.");
        }else{
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/PE',
                data: {id:id, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:0, port:0, nodo:nodo, id_zone:id_zona},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case 'login':
                            refresh();
                            break;
                        case 'autori':
                            toastr.error("Usuario no autorizado");
                            break;
                        case 'yes':
                            $('#jarvis_pe').DataTable().ajax.reload();
                            toastr.success("Modificación Exitosa");
                            modal.click();
                            break;
                    }
                },
                error: function(data) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors['errors'], function (ind, elem) {
                        toastr.error(elem);
                    });
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function detal_sub_red(id){
    var div = document.createElement('div');
    $("#detal_0").html(div);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'detalle/subred',
        data: {id:id},
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
                    $("#detal_0").html(div);
                    $(data['datos']).each(function(i, v){
                        var valor = '<p> <i class="fa fa-database"></i>'+'_ '+data['datos'][i]['rama']+'</p>';
                        $("#detal_0").append(valor);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function rank_ip_new_all(){
    var mensaje = document.getElementById("title_stock_ip");
    mensaje.textContent  = 'REGISTRO IP EN EL STOCK';
    var aceptar = document.getElementById("stock_ip_seguir");
    var cancelar = document.getElementById("stock_ip_cerra");
    var modal = document.getElementById('cerra_stock_ip_pop');
    document.getElementById("new_stock_ip_all").reset();
    aceptar.onclick = function() {
        var status = document.getElementById("status_stock").value;
        var ip = document.getElementById("ip_stock").value;
        var use = document.getElementById("use_ip_stock").value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'registar/stock/IP',
            data: {id:0, status, ip, use},
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
                    case "error":
                        toastr.error("Error en el rango");
                        break;
                    case "exist":
                        toastr.error("El Rango ya existe");
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        $('#list_stock_all_ip').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_stock_ip(id){
    var mensaje = document.getElementById("title_stock_ip");
    mensaje.textContent  = 'MODIFICAR IP EN EL STOCK';
    var aceptar = document.getElementById("stock_ip_seguir");
    var cancelar = document.getElementById("stock_ip_cerra");
    var modal = document.getElementById('cerra_stock_ip_pop');
    document.getElementById("new_stock_ip_all").reset();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'buscar/stock/IP',
        data: {id:id},
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
                    $('#status_stock').val(data['datos']['status']).trigger('change.select2');
                    $('#ip_stock').val(data['datos']['rank']);
                    $('#use_ip_stock').val(data['datos']['use']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var status = document.getElementById("status_stock").value;
        var ip = document.getElementById("ip_stock").value;
        var use = document.getElementById("use_ip_stock").value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'registar/stock/IP',
            data: {id:id, status, ip, use},
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
                    case "nop":
                        toastr.error("Rango Ocupada");
                        break;
                    case "exist":
                        toastr.error("El Rango ya existe");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#list_stock_all_ip').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function sele_stock_ip_list(id){
    var modal = document.getElementById('cerrar_ip_stock_all');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'buscar/stock/IP',
        data: {id:id},
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
                    $('#ip_rama').val(data['datos']['rank']);
                    $('#pre').val('24');
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function popadd_module_clean(){
    var mensaje = document.getElementById("title_add_module");
    mensaje.textContent  = 'REGISTRAR MODULO';
//$('#id_address_edic').val(0);
    $('#pais').val('').trigger('change.select2');
    $('#provin').val('').trigger('change.select2');
    $('#local').val('');
    $('#calle').val('');
    $('#altura').val('');
}

function register_module(func = null){
    var nombre_modulo = document.getElementById("nombre_modulo").value;
    var tipo_modulo = document.getElementById("tipo_modulo").value;
    var distancia = document.getElementById("distancia").value;
    var km = document.getElementById("km").value;
    var fibra = document.getElementById("fibra").value;
    var corta_larga = document.getElementById("corta_larga").value;
    if (nombre_modulo == '' || nombre_modulo.length == 0) {
        toastr.error("El nombre del modulo es obligatorio.");
    }else if (tipo_modulo == '' || tipo_modulo.length == 0 ) {
        toastr.error("El tipo de modulo es obligatorio.");
    }else if (distancia == '' || distancia.length == 0 ) {
        toastr.error("La distancia es obligatoria.");
    }else if (fibra == '' || fibra.length == 0 ) {
        toastr.error("El tipo de fibra es obligatorio.");
    }else if (corta_larga == '' || corta_larga.length == 0 ) {
        toastr.error("Determinar si es corta o larga.");
    }else{
        //var dire = $("#address");
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/module',
            data: {nombre_modulo:nombre_modulo ,tipo_modulo:tipo_modulo, distancia:distancia, km:km, fibra:fibra, corta_larga,corta_larga},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "no":
                        toastr.error("La dirección ya existe");
                        break;
                    case "yes":
                        modal.click();
                        if (id == 0) {
                            //detal_addres(3);
                            //detal_addres(1);
                            $('#impor_list_module').DataTable().ajax.reload();
                            toastr.success("Registro Exitoso");
                        }else{
                            toastr.success("Modificación Exitosa");
                            $('#impor_list_module').DataTable().ajax.reload();
                        }
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
}

function search_lanswitch_port_ring(id){
    var aceptar = document.getElementById("alta_port_lsw");
    var cancelar = document.getElementById("exit_alta_port_lsw");
    var modal = document.getElementById("cerra_puerto_lsw_anillo");
    var tbody = document.createElement('div');
    $("#all_puerto_anillo_lsw").html(tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/ls/anillo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $(data['datos_port']).each(function(i, v){
                        campo = '<div class="form-group">'+
                            '<label>'+data['datos_port'][i]['port']+'</label>'+
                            '<select class="form-control pose_ring_lsw" id="pose_ring_lsw'+[i]+'" name="pose_ring_lsw['+[i]+']">';
                        $(data['datos']).each(function(h, p){
                            if (data['datos'][i]['selec'] == 1) {
                                campo += '<option selected value="'+data['datos_port'][i]['id']+'|'+data['datos'][h]['port']+'">'+data['datos'][h]['all']+'</option>';
                            }else{
                                campo += '<option value="'+data['datos_port'][i]['id']+'|'+data['datos'][h]['port']+'">'+data['datos'][h]['all']+'</option>';
                            }
                        });
                        campo += '</select>'+
                            '</div>';
                        $("#all_puerto_anillo_lsw").append(campo);
                    });
                    break;
            }
        },
        error: function(data) {
            var errors = $.parseJSON(data.responseText);
            $.each(errors['errors'], function (ind, elem) {
                toastr.error(elem);
            });
        }
    });
    aceptar.onclick = function() {
        var port =[];
        var port_ring = document.getElementsByClassName("pose_ring_lsw");
        for (var i = 0; i < port_ring.length; ++i) {
            if (typeof port_ring[i].value !== "undefined") {
                port.push(port_ring[i].value);
            }
        }
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'modificar/puerto/ls',
            data: {port:port},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "duplica":
                        toastr.error("Error. Puertos repetidos");
                        break;
                    case "ocupado":
                        toastr.error("Error. Puertos Ocupado");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function resource_service_edit(id, servi){
    $("#id_service_recur").find('option').remove();
    $("#id_equip").find('option').remove();
    var new_tbody = document.createElement('div');
    $("#campos_port_all_full").html(new_tbody)
    var ip_wan = document.getElementById('ip_servicio_wan_edic');
    $('#ip_admin_servi_id_edic').val('');
    $('#ip_admin_servi_edic').val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'modificar/recurso/mostrar',
        data: {id:id, servi:servi},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $(data['service']).each(function(i, v){
                        $("#id_service_recur").append('<option selected disabled value="'+data['service'][i]['service']+'">'+data['service'][i]['number']+'</option>').trigger('change.select2');
                        $("#id_equip").append('<option selected disabled value="'+data['service'][i]['id']+'">'+data['service'][i]['acronimo']+'</option>').trigger('change.select2');
                        $('#vlan_recurso_edict').val(data['service'][i]['vlan']);
                        $('#lacp_id').val(id);
                        if (data['service'][i]['require_ip'] != 'NO') {
                            ip_wan.style.display = "block";
                        }else{
                            ip_wan.style.display = "none";
                        }
                    });
                    if (data['ip'] != null && data['ip'] != '') {
                        $('#ip_admin_servi_id_edic').val(data['ip']['id']);
                        $('#ip_admin_servi_edic').val(data['ip']['ip']);
                    }
                    $(data['port_exist']).each(function(l, h){ // indice, valor
                        campo = '<div class="bw_all" id="input_servi_edic'+l+'" > <input type="text" readonly="readonly" class="form-control" value="'+data['port_exist'][l]['port']+'">    <input type="hidden" class="puerto_sevicio_alta_edic" id="puerto_sevicio_alta_edic['+l+']" name="puerto_sevicio_alta_edic['+l+']" value="'+data['port_exist'][l]['id']+'"></div>';
                        $("#campos_port_all_full").append(campo);
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}


function commen_port_servi(board, port){
    var cancelar = document.getElementById("button_cancelar");
    var aceptar = document.getElementById("button_aceptar");
    var modal = document.getElementById("cerrar_comen_puerto");
    var title_msj = document.getElementById("title_port_commen");
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/comentario',
        data: {board:board, port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#commen_port_all').val(data['datos']['commen']);
                    title_msj.textContent  = data['acronimo'];
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen_port_all").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/comentario/puerto',
            data: {board:board, port:port, commen:commen,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        port_selec_servi();
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function port_selec_servi_edict(){
    var equip = document.getElementById('id_equip').value;
    var servivio = document.getElementById('id_servicio_recurso').value;
    let por_sel = [];
    $("input[type=checkbox]:checked").each(function(){
        por_sel.push(this.value);
    });
    var new_tbody = document.createElement('tbody');
    $("#por_alta_servicio").html(new_tbody)
    if (equip == '' || equip.length == 0) {
        toastr.error("Seleccione el Equipo");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'puerto/servicio',
            data: {id:equip, servivio:servivio},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        if (data['resul'] == 'nop') {
                            toastr.error("No tiene puerto disponible este agregador");
                        }else{
                            $(data['grupo']).each(function(i, v){ // indice, valor
                                var valor = '<tr>' +
                                    '<td>' + data['grupo'][i]['name'] +'</td>' +
                                    '<td>' + data['grupo'][i]['atributo'] + '</td>' +
                                    '<td>'+data['grupo'][i]['number']+'</td>' +
                                    '<td> <input type="checkbox" id="" name="por[]" value="'+ data['grupo'][i]['port'] +'">'+
                                    ' <a data-toggle="modal" data-target="#port_recurso_sevicio_pop" title="Agregar puerto" onclick="sum_port_group('+data['grupo'][i]['id_group']+');"> <i class="fa fa-plus-square"> </i> </a> '+
                                    '<a data-toggle="modal" data-target="#port_recurso_sevicio_pop" title="Quitar puerto" onclick="res_port_group('+data['grupo'][i]['id_group']+');"> <i class="fa fa-minus-square"> </i> </a> </td>' +
                                    '</tr>';
                                $("#por_alta_servicio").append(valor)
                            })

                            $(data['datos']).each(function(i, v){ // indice, valor
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i]['label'] + data['datos'][i]['f_s_p'] + data['datos'][i]['por_selec'] + '</td>';
                                if (data['datos'][i]['type'] != "ANILLO") {
                                    valor += '<td>' + data['datos'][i]['atributo'] + '</td>';
                                }else{
                                    valor += '<td>' + data['datos'][i]['type'] + '</td>';
                                }
                                valor += '<td>' + data['datos'][i]['service'] + '</td>';
                                valor += '<td>' + data['datos'][i]['commentary'] + '</td>';
                                if (data['datos'][i]['group'] == '' && data['datos'][i]['type'] != "ANILLO") {
                                    valor += '<td><input type="checkbox" id='+data['datos'][i]['id']+' name="por[]" value="'+data['datos'][i]['id']+'">';
                                }else{
                                    if (data['datos'][i]['type'] != "ANILLO") {
                                        valor +='<td> <i class="fa fa-unlock-alt" style="color: coral;" title="Esta en un grupo"></i>';
                                    }else{
                                        valor +='<td> <i class="fa fa-circle-o-notch" style="color: coral;" title="Puerto del anillo"></i>';
                                    }
                                }
                                valor +=' <a data-toggle="modal" data-target="#popcomen_port" title="Comentario del puerto" onclick="commen_port_servi('+data['datos'][i]['board']+','+data['datos'][i]['por_selec']+');"> <i class="fa fa-twitch"> </i> </a> </td></td>';
                                valor += '</tr>';
                                $("#por_alta_servicio").append(valor)
                            })
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function editar_service_recurso(){
    var id_servicio = document.getElementById('id_service_recur').value;
    var equip = document.getElementById('id_equip').value;
    var ip_admin = document.getElementById('ip_admin_servi_id_edic').value;
    var vlan = document.getElementById('vlan_recurso_edict').value;
    var lacp = document.getElementById('lacp_id').value;
    var puerto_sevicio_alta = document.getElementsByClassName("puerto_sevicio_alta_edic");
    var modal = document.getElementById("cerra_recurso_editar");
    var port = [];
    for (var i = 0; i < puerto_sevicio_alta.length; ++i) {
        if (typeof puerto_sevicio_alta[i].value !== "undefined") {
            port.push(puerto_sevicio_alta[i].value);
        }
    }
    if (equip == '' || equip.length == 0) {
        toastr.error("El Equipo es obligatorio.");
    }else if (port == '' || puerto_sevicio_alta.length == 0) {
        toastr.error("El Puerto es obligatorio.");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'modificar/recurso',
            data: {id_servicio:id_servicio, lacp:lacp, ip_admin:ip_admin, port:port, vlan:vlan, equip:equip,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "ip_exi":
                        toastr.error("La IP ya esta ocupada");
                        break;
                    case "ip_ring":
                        toastr.error("La IP WAM no esta asociada a un anillo");
                        break;
                    case "rank_exi":
                        toastr.error("Al meno una IP del rango esta ocupada");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        service_equipmen(equip);
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function buscar_ip_admin_lanswitch(){
    var id = document.getElementById("id_equip").value;
    var new_tbody = document.createElement('tbody');
    $("#ip_wan_lanswitch_table").html(new_tbody);
    if (id == '' || id.length == 0) {
        toastr.error("seleccione el Anillo Primero");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'buscar/ip/wan/lanswitch',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        toastr.error("El equipo no tiene anillo");
                        break;
                    case "yes":
                        $("#ip_wan_lanswitch_table").html(new_tbody);
                        if (data['datos'].length == 0) {
                            toastr.error("El anillo no tiene Vlan Wan de internet asociada");
                        }
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i].ip +'</td>' +
                                '<td>'+ data['datos'][i].acronimo + '</td>' +
                                '<td>' + data['datos'][i].uso +' '+ data['datos'][i].vlan + '</td>';
                            if (data['datos'][i].type == 'DISPONIBLE' && data['datos'][i].id_status == 1) {
                                valor += '<td><a> <i class="fa fa-bullseye" onclick="ip_wan_selecion('+data['datos'][i].id+');" title="Seleccionar IP"> </i></a></td>' +
                                    '</tr>';
                            }else{
                                valor += '<td><a title="IP no disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a></td>' +
                                    '</tr>';
                            }
                            $("#ip_wan_lanswitch_table").append(valor)
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

function ip_wan_selecion(id){
    var modal = document.getElementById("cerra_bus_ip_admin_cpe");
    if (modal == null) {
        var modal = document.getElementById("cerra_bus_ip_wan_lans");
    }
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'exis':
                    toastr.error("La IP es Invalidad");
                    break;
                default :
                    $('#ip_admin_servi_id').val(id);
                    $('#ip_admin_servi').val(data['ip']+'/'+data['barra']);
                    $('#ip_admin_servi_id_edic').val(id);
                    $('#ip_admin_servi_edic').val(data['ip']+'/'+data['barra']);
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function crear_vlan_rango_ip_wan(){
    document.getElementById("vla_all_new").reset();
    var aceptar = document.getElementById("vlan_aceptar");
    var cancelar = document.getElementById("vlan_cancelar");
    var modal = document.getElementById("exit_alta_vlan");
    aceptar.onclick = function() {
        var equip = document.getElementById("id_equip").value;
        var use_vlan = document.getElementById("use_vlan").value;
        var vlan = document.getElementById("vlan").value;
        var ip_admin_id = document.getElementById("ip_admin_id_anillo").value;
        if (use_vlan == '' || use_vlan.length == 0) {
            toastr.error("El uso de la vlan es obligatorio.");
        }else if (vlan == '' || vlan.length == 0 ) {
            toastr.error("La Vlan es obligatorio.");
        }else if (ip_admin_id == '' || ip_admin_id.length == 0 ) {
            toastr.error("La IP es obligatorio.");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url:getBaseURL()+'agregar/vlan/wan/anillo',
                data: {id:equip, uso:use_vlan, vlan:vlan, ip:ip_admin_id },
                dataType: 'json',
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
                            toastr.error("El equipo no tiene anillo");
                            break;
                        case "exit":
                            toastr.error("Alguna IP de este Rango esta siendo usada");
                            break;
                        case "yes":
                            buscar_ip_admin_lanswitch();
                            toastr.success("Registro Exitoso");
                            modal.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function ip_wan_anillo_sele_cpe(){
    var id = document.getElementById("anillo_id_ip_wan").value;
    var new_tbody = document.createElement('tbody');
    $("#ip_cpe_table").html(new_tbody);
    if (id != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'buscar/ip/wan/cpe',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#ip_cpe_table").html(new_tbody);
                        if (data['datos'].length == 0) {
                            toastr.error("El Anillo no tiene Internet WAN asociado");
                        }
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i].ip +'</td>' +
                                '<td>'+ data['datos'][i].acronimo + '</td>' +
                                '<td>' + data['datos'][i].uso +' '+ data['datos'][i].vlan + '</td>';
                            if (data['datos'][i].type == 'DISPONIBLE' && data['datos'][i].id_status == 1) {
                                valor += '<td><a> <i class="fa fa-bullseye" onclick="ip_wan_selecion('+data['datos'][i].id+');" title="Seleccionar IP"> </i></a></td>' +
                                    '</tr>';
                            }else{
                                valor += '<td><a title="IP no disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a></td>' +
                                    '</tr>';
                            }
                            $("#ip_cpe_table").append(valor)
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

function selec_anillo_ip_wan(id){
    var modal = document.getElementById("cerra_bus_anillo");
    var opcion = $("#anillo_id_ip_wan");
    opcion.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'seleccionar/anillo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $("#anillo_id_ip_wan").append(
                        '<option value="'+id+'">'+data['name']+' '+data['type']+'</option>'
                    ).trigger('change.select2');
                    modal.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function detal_port_excel_ring(id){
    var new_tbody = document.createElement('tbody');
    $("#excel_port_all").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'lista/importar/puerto',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $("#excel_port_all").html(new_tbody);
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i].num +'</td>' +
                            '<td>'+ data['datos'][i].port + '</td>' +
                            '<td>' + data['datos'][i].bw + '</td>';
                        $("#excel_port_all").append(valor)
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function dupli_table(){
    var placa_pose_all = document.getElementsByClassName("number_table");
    var number = placa_pose_all.length;
    var table ='<tr class="number_table" id="number_table'+number+'">'+
        '<td>'+
        '<div class="form-group">'+
        '<select class="form-control" name="asigna[]">'+
        '<option selected disabled value="">*</option>'+
        '</select>'+
        '</div>'+
        '</td>'+
        '<td>'+
        '<div class="form-group">'+
        '<input name="torcuato[]" type="text" class="form-control">'+
        '</div>'+
        '</td>'+
        '<td>'+
        '<div class="form-group">'+
        '<input name="Garay[]" type="text" class="form-control">'+
        '</div>'+
        '</td>'+
        '<td>'+
        '<div class="form-group">'+
        '<select class="form-control" name="mascara">'+
        '<option selected disabled value="">*</option>'+
        '</select>'+
        '</div>'+
        '</td>'+
        '<td>'+
        '<div class="form-group">'+
        '<input name="reducida" type="text" class="form-control ">'+
        '</div>'+
        '</td>'+
        '<td>'+
        '<a class="ico_input btn btn-info" onclick="dele_table('+number+');"> <i class="fa fa-trash-o"> </i></a>'+
        '</td>'+
        '</tr>';
    $("#max_input").append(table);
}

function dele_table(data){
    var tr = document.createElement('tr');
    $("#number_table"+data+"").html(tr);
}

function up_service(id){
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'alta/servicio',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Alta Exitosa");
                    $('#servicios_list').DataTable().ajax.reload();
                    break;
                case "nop":
                    toastr.error("Servicio no encontrado");
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
}

function create_chain(){
    $("#select2-agg-container").empty();
    $("#select2-agg-container").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#campos_chain_port").empty();
    document.getElementById("title_cadena").textContent  = 'REGISTRAR CADENA AGG';
    document.getElementById("alta_cadena").reset();
    var aceptar = document.getElementById("alta_chain");
    var cancelar = document.getElementById("baja_chain");
    var modal = document.getElementById("cerra_cadena_pop");
    aceptar.onclick = function() {
        var name = document.getElementById("name_chain").value;
        var extrem_1 = document.getElementById("extrem_1").value;
        var extrem_2 = document.getElementById("extrem_2").value;
        var BW = document.getElementById("BW_chain").value;
        var max = document.getElementById("max_chain").value;
        var commentary = document.getElementById("commentary_chain").value;
        var port_all = document.getElementsByClassName("input_chain_alta_edic");
        var port =[];
        for (var i = 0; i < port_all.length; ++i) {
            if (typeof port_all[i].value !== "undefined") { port.push(port_all[i].value); }
        }
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/cadena',
            data: {name:name,extrem_1:extrem_1,extrem_2:extrem_2,BW:BW,max:max,commentary:commentary,port:port,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#list_cadena').DataTable().ajax.reload();
                        toastr.success("Alta Exitosa");
                        modal.click();
                        break;
                    case "port":
                        toastr.error("Seleccionar Equipo y Puerto");
                        break;
                    case "nop":
                        toastr.error("Puerto Ocupado");
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function edic_chain(id){
    document.getElementById("edic_alta_cadena").reset();
    var aceptar = document.getElementById("edic_alta_chain");
    var cancelar = document.getElementById("edic_baja_chain");
    var modal = document.getElementById("edic_cerra_cadena_pop");
    $('#id_chain').val(id);
    $('#edic_id_chain').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/cadena',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#edic_name_chain').val(data['data']['name']);
                    $('#edic_extrem_1').val(data['data']['extreme_1']);
                    $('#edic_extrem_2').val(data['data']['extreme_2']);
                    $('#edic_commentary_chain').val(data['data']['commentary']);
                    $('#edic_BW_chain').val(data['data']['bw']);
                    $('#edic_max_chain').val(data['data']['max']);
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var id_chain = document.getElementById("edic_id_chain").value;
        var name = document.getElementById("edic_name_chain").value;
        var extrem_1 = document.getElementById("edic_extrem_1").value;
        var extrem_2 = document.getElementById("edic_extrem_2").value;
        var BW = document.getElementById("edic_BW_chain").value;
        var max = document.getElementById("edic_max_chain").value;
        var commentary = document.getElementById("edic_commentary_chain").value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'modificar/cadena',
            data: {id_chain:id_chain,name:name,extrem_1:extrem_1,extrem_2:extrem_2,BW:BW,max:max,commentary:commentary,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#list_cadena').DataTable().ajax.reload();
                        toastr.success("Modificación Exitosa");
                        modal.click();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function chain_equipment_agg(id){
    var tbody = document.createElement('tbody');
    $("#list_agg_chain").html(tbody);
    $('#chain_id').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'listar/equipo/agregador',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#list_agg_chain").html(tbody);
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>'+ data['datos'][i].acronimo + '</td>' +
                            '<td>' + data['datos'][i].port +'</td>' +
                            '<td>' + data['datos'][i].node +'</td>' +
                            '<td>'+ data['datos'][i].ip + '</td>' +
                            '<td><a onclick="port_chain_free('+data['datos'][i].id+');" title="Liberar recurso"> <i class="fa fa-trash-o"> </i></a> <a onclick="agregar_puertos_agg_cadena('+data['datos'][i].id+');" data-toggle="modal" data-target="#new_puerto_servicio_alta" title="Agregar puerto"><i class="fa fa-plus"> </i></a> <a onclick="quitar_puertos_agg_cadena('+data['datos'][i].id+');" data-toggle="modal" data-target="#new_puerto_servicio_alta" title="Quitar puerto"><i class="fa fa-minus"> </i></a> </td></tr>';
                        $("#list_agg_chain").append(valor)
                    });
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}


function new_agg_chain(){
    var aceptar = document.getElementById("asignar_chain");
    var cancelar = document.getElementById("cancelar_chain");
    var modal = document.getElementById("cerra_asignar_agg");
    var id = document.getElementById('chain_id').value;
    $("#old_agg1").find('option').remove();
    $("#new_agg_B").find('option').remove();
    document.getElementById("campos_chain_port_B").innerHTML='';
    var tbody = document.createElement('div');
    $("#input_old_agg2").html(tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'agregador/cadena/asignada',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    let nombre_cadena = ((data['data']['name'])).toUpperCase();
                    $('#cadena_nameB_h4').html(nombre_cadena);

                    $("#input_old_agg2").html(tbody);
                    $(data['datos']).each(function(i, v){
                        $("#old_agg1").append('<option value="'+data['datos'][i].id+'">'+data['datos'][i].acronimo+'</option>');
                    });
                    if (data['datos'].length > 1) {
                        var sele = '<div class="form-group">'+
                            '<label>Equipo 2*</label> '+
                            '<select class="form-control old_agg" id="old_agg2" name="old_agg2">'+
                            '</select>'+
                            '</div>';
                        $("#input_old_agg2").append(sele);
                        $(data['datos']).each(function(h, v){
                            $("#old_agg2").append('<option value="'+data['datos'][h].id+'">'+data['datos'][h].acronimo+'</option>');
                        });
                    }
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });



    aceptar.onclick = function() {
        var port_all = document.getElementsByClassName("input_chain_alta_edic");
        var port =[];
        for (var i = 0; i < port_all.length; ++i) {
            if (typeof port_all[i].value !== "undefined") { port.push(port_all[i].value); }
        }
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/recurso/agregador',
            data: {id:id, port:port},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        chain_equipment_agg(id);
                        modal.click();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "nop":
                        toastr.error("Puerto Ocupado");
                        break;
                }
            },
            error: function(data) {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}
function relate_ports_agg(){
    var id = document.getElementById('chain_id').value;
    $("#puertos_relate").empty();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'relacionar/puerto/agregador',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    let puertos = '';
                    let puertos_a = '';
                    $(data['datos']).each(function(h,v){
                        puertos += (data['datos'][h].port)
                    });
                    var splitted = puertos.split('<br>')
                    for (let index = 0; index < splitted.length; index++) {
                        const element = splitted[index];
                        if(element.length>1){
                            puertos_a += '<input type="checkbox" id="'+ index +'" value="'+ element+'">'+ '<label for="'+ index +'"> '+ element +'</label>'+'<br>'
                        }
                    }

                    $("#puertos_relate").append('<div class="form-group">'+
                        '<label>Puertos Disponibles de la cadena </label>'+ '<br>' +puertos_a + '</div>');
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}
function list_agg_chain_all(element_id = null){
    $('#list_all_agg_equip_chain').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'agregar/equipo/agregador',
        "columns": [
            { data: 'acronimo' },
            { data: 'ip' },
            { data: 'commentary' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var opc = '';
                    if (element_id != null) {
                        if (full.status == 'ALTA') {
                            opc += '<a onclick="select_eq_modal('+full.id+',\''+full.acronimo+'\',\''+element_id+'\');" title="Seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                        }
                    } else {
                        opc += '<a title="Selecionar" onclick="sele_agg_chain('+id+');"> <i class="fa fa-bullseye"> </i></a>';
                    }
                    return opc;
                }
            },
        ]
    });
}

function list_agg_chain_all_new(){
    $('#list_all_agg_equip_chain').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'agregar/equipo/agregador',
        "columns": [
            { data: 'acronimo' },
            { data: 'ip' },
            { data: 'commentary' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Selecionar" onclick="sele_agg_chain_new('+id+');"> <i class="fa fa-bullseye"> </i></a>';
                }
            },
        ]
    });
}

function sele_agg_chain(id){
    var cerrar = document.getElementById('cerra_bus_equipo_agg');
    var agg = $("#agg");
    let agg_B = $("#new_agg_B");
    agg.find('option').remove();
    agg_B.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'acronimo/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    agg.append(
                        '<option value="'+id+'">'+ data['datos']+'</option>'
                    ).trigger('change.select2');
                    agg_B.append(
                        '<option value="'+id+'">'+ data['datos']+'</option>'
                    ).trigger('change.select2');
                    cerrar.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function sele_agg_chain_new(id){
    var cerrar = document.getElementById('cerra_bus_equipo_agg');
    $("#new_agg").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'acronimo/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#new_agg").append('<option value="'+id+'">'+ data['datos']+'</option>').trigger('change.select2');
                    cerrar.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function inf_equip_port_chain(){
    var id = document.getElementById('agg').value;
    var new_tbody = document.createElement('tbody');
    $("#buton_save").attr("onclick","asig_port_chain()");


    $("#por_alta_servicio").html(new_tbody)
    if (id == '' || id.length == 0) {
        toastr.error("Seleccione el Equipo");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'buscar/puerto/agregador',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        if (data['resul'] == 'nop') {
                            toastr.error("No tiene puerto disponible este agregador");
                        }else{
                            $(data['datos']).each(function(i, v){ // indice, valor
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i]['label'] + data['datos'][i]['f_s_p'] + data['datos'][i]['por_selec'] + '</td>';
                                valor += '<td>' + data['datos'][i]['atributo'] + '</td>';
                                valor += '<td>' + data['datos'][i]['service'] + '</td>';
                                if(data['datos'][i]['type'] != null){
                                    valor += '<td>' + data['datos'][i]['type'] + '</td>';
                                }else{
                                    valor += '<td> </td>';
                                }

                                valor += '<td>' + data['datos'][i]['commentary'] + '</td>';
                                if (data['datos'][i]['atributo'] == 'VACANTE') {
                                    valor += '<td><input type="checkbox" id='+[i]+' name="port_chain[]" value="'+data['datos'][i]['id']+'">';
                                }else{
                                    if (data['datos'][i]['type'] != "ANILLO") {
                                        valor +='<td> <i class="fa fa-unlock-alt" style="color: coral;" title="Esta ocupado"></i>';
                                    }else{
                                        valor +='<td> <i class="fa fa-circle-o-notch" style="color: coral;" title="Puerto del anillo"></i>';
                                    }
                                }
                                valor += '</tr>';
                                $("#por_alta_servicio").append(valor)
                            })
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function asig_port_chain(){
    let port = [];
    $("input[type=checkbox]:checked").each(function(){ port.push(this.value); });
    var id = document.getElementById('chain_id').value;
    var modal = document.getElementById('exit_port_chain');
    var new_tbody = document.createElement('tbody');
    $("#campos_chain_port").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'recurso/cadena/agregador',
        data: {id:id, port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#campos_chain_port").html(new_tbody);
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var campo = '<div class="input_chain" id="input_chain'+i+'" > <input type="text" readonly="readonly" class="form-control" value="'+data['datos'][i]['port']+'">    <input type="hidden" class="input_chain_alta_edic" id="input_chain_alta_edic['+i+']" name="input_chain_alta_edic['+i+']" value="'+data['datos'][i]['id']+'"></div>';
                        $("#campos_chain_port").append(campo);
                        $("#campos_chain_port_B").append(campo);
                    });
                    modal.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    modal.click();
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function port_chain_free(id){

    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    modal0.style.display = "block";
    mensaje.textContent  = "Esta seguro que desea borrar este equipo de la cadena?";

    var chain_id = $("#chain_id").val();

    aceptar.onclick = function() {
        modal0.style.display = "none";
        modal.click();
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'borrar/puertos/agregador/todos',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "Exist":
                        toastr.error("Algun puerto del equipo esta conectado a otro");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        modal.click();
                        chain_equipment_agg(chain_id);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal0.style.display = "none";
    }
}

function port_chain_all_show(){
    var agg = document.getElementById('agg').value;
    var input = document.getElementById('port_input_chain');
    if (agg == null) {
        input.style.display = "none";
    }else{
        input.style.display = "block";
    }
}

function clear_lsw_new(){
    document.getElementById("alta_lsw").reset();
    var campo_p = document.createElement('div');
    $("#campos_lsw").html(campo_p);
    $("#client_lsw").find('option').remove();
    $("#client_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#equi_alta_lsw").find('option').remove();
    $("#equi_alta_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin_lsw").find('option').remove();
    $("#ip_admin_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#link_all_lsw").find('option').remove();
    $("#link_all_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_ring_new").find('option').remove();
    $("#id_ring_new").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#client_lsw").find('option').remove();
    $("#client_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
}

function create_lsw_new(){
    clear_lsw_new();
    $("#campos_port_link_all").empty();
    $("#campos_lsw").empty();
    $('#id_lsw_new').val(0);
    $('#sitio_lsw').removeAttr('disabled');
    $('#port_sar').removeAttr('disabled');
    $('#equi_sar').removeAttr('disabled');
    var aceptar = document.getElementById("alta_lsw_pop");
    var cancelar = document.getElementById("baja_lsw_pop");
    var modal = document.getElementById("cerra_lsw_pop");
    document.getElementById("title_lsw").textContent  = 'REGISTRAR LANSWITCH IPRAN';
    document.getElementById('boton_buscar_equipo_all_lsw').style.display = "block";
    document.getElementById('node_button').style.display = "block";
    document.getElementById('img_alta_equipo_lsw').style.display = "none";
    document.getElementById('all_board_lsw').style.display = "none";
    document.getElementById('nodo_all_lsw').style.display = "none";
    document.getElementById('direc_all_lsw').style.display = "none";
    document.getElementById('input_id_ring').style.display = "none";
    document.getElementById('port_ring_list_lsw').style.display = "none";
    document.getElementById('client_all_lsw').style.display = "none";
    document.getElementById('link_button').style.display = "block";
    document.getElementById('bus_ring').style.display = "block";
    aceptar.onclick = function() {
        var board = [];
        var port = [];
        var ip_admin = document.getElementById("ip_admin_lsw").value;
        var enlace = document.getElementById("enlace_lsw").value;
        var orden = document.getElementById("orden_lsw").value;
        var sitio = document.getElementById("sitio_lsw").value;
        var name = document.getElementById("acro_lsw").value;
        var nodo_al = document.getElementById("nodo_al_lsw").value;
        var direc = document.getElementById("direc_lsw").value;
        var equi_alta = document.getElementById("equi_alta_lsw").value;
        var commen = document.getElementById("commentary_lsw").value;
        var local = document.getElementById("local_equipmen_lsw").value;
        var board_all = document.getElementsByClassName("placa_alta_lsw");
        var link = document.getElementById("link_all_lsw").value;
        var port_all = document.getElementsByClassName("port_link_id");
        var port_sar = document.getElementById("port_sar").value;
        var equi_sar = document.getElementById("equi_sar").value;
        var client = document.getElementById("client_lsw").value;
        var ring = document.getElementById("id_ring_new").value;
        for (var i = 0; i < board_all.length; ++i) {
            if(typeof board_all[i].value !== "undefined"){board.push(board_all[i].value); }
        }
        for (var i = 0; i < port_all.length; ++i) {
            if(typeof port_all[i].value !== "undefined"){port.push(port_all[i].value); }
        }
        if (port.length == 3) {
            toastr.error("El anillo no puede ser de tres '3' puertos");
        }else{
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL()+'registrar/lanswitch/ipran',
                data: {id:0,board:board,ip_admin:ip_admin,enlace:enlace,orden:orden,sitio:sitio,port_sar:port_sar,name:name,nodo_al:nodo_al,direc:direc,equi_alta:equi_alta,commen:commen,local:local,link:link,port:port,equi_sar:equi_sar,ring:ring,client:client},
                dataType: 'json',
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
                            toastr.error("Error al guardar los datos");
                            break;
                        case "ip_exi":
                            toastr.error("IP no disponible");
                            break;
                        case "acronimo_exi":
                            toastr.error("El Nombre del LSW ya Existe");
                            break;
                        case "yes":
                            toastr.success("Registro Exitoso");
                            $('#lanswitch_list').DataTable().ajax.reload();
                            modal.click();
                            break;
                    }
                },
                error: function(data) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors['errors'], function (ind, elem) {
                        toastr.error(elem);
                    });
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function sitio_web_lsw(){
    var sitio = document.getElementById("sitio_lsw").value;
    var equip = document.getElementById("equi_alta_lsw").value;
    var direc_all = document.getElementById('direc_all_lsw');
    var nodo_all = document.getElementById('nodo_all_lsw');
    var link = document.getElementById('link_all_node');
    var ring = document.getElementById('input_id_ring');
    var ip_admin = document.getElementById('boton_ip_admin');
    var ip_ring = document.getElementById('boton_ip_ring');
    var port_link = document.getElementById("port_link_list_lsw");
    var port_ring = document.getElementById("port_ring_list_lsw");
    var client = document.getElementById("client_all_lsw");
    var sar = document.getElementById("sar");
    $("#nodo_al_lsw").find('option').remove();
    $("#nodo_al_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#direc_lsw").find('option').remove();
    $("#direc_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#link_all_lsw").find('option').remove();
    $("#link_all_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_ring_new").find('option').remove();
    $("#id_ring_new").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#client_lsw").find('option').remove();
    $("#client_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    switch (sitio) {
        case "Si":
            direc_all.style.display = "block";
            nodo_all.style.display = "none";
            ring.style.display = "block";
            ip_ring.style.display = "block";
            client.style.display = "block";
            ip_admin.style.display = "none";
            sar.style.display = "none";
            if (equip != null && equip != '') {
                port_ring.style.display = "block";
                port_link.style.display = "none";
            }else{
                port_ring.style.display = "none";
                port_link.style.display = "none";
            }
            break;
        case "No":
            sar.style.display = "block";
            direc_all.style.display = "none";
            nodo_all.style.display = "block";
            ring.style.display = "none";
            client.style.display = "none";
            ip_ring.style.display = "none";
            ip_admin.style.display = "block";
            if (equip != null && equip != '') {
                port_ring.style.display = "none";
                port_link.style.display = "block";
            }else{
                port_ring.style.display = "none";
                port_link.style.display = "none";
            }
            break;
        case '':
            sar.style.display = "none";
            ring.style.display = "none";
            direc_all.style.display = "none";
            nodo_all.style.display = "none";
            ip_ring.style.display = "none";
            ip_admin.style.display = "none";
            port_ring.style.display = "none";
            port_link.style.display = "none";
            break;
    }
    var capos_in = document.createElement('div');
    $("#campos_port_link_all").html(capos_in);
    link.style.display = "none";
}

function EquipmentBoardLSW(){
    var equi_alta = document.getElementById("equi_alta_lsw").value;
    var sitio = document.getElementById("sitio_lsw").value;
    var id = document.getElementById("id_lsw_new").value;
    var port_link = document.getElementById("port_link_list_lsw");
    var port_ring = document.getElementById("port_ring_list_lsw");
    var board = document.getElementById("new_board_lsw");
    var all_board = document.getElementById("all_board_lsw");
    var img = document.getElementById("img_alta_equipo_lsw");
    var capos_in = document.createElement('div');
    $("#campos_lsw").html(capos_in);
    if (equi_alta != '' && id == 0) {
        img.style.display = "block";
        all_board.style.display = "block";
        switch (sitio) {
            case 'Si':
                port_link.style.display = "none";
                port_ring.style.display = "block";
                break;
            case 'No':
                port_link.style.display = "block";
                port_ring.style.display = "none";
                break;
            default:
                port_link.style.display = "none";
                port_ring.style.display = "none";
                break;
        }
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/puerto',
            data: { equi_alta:equi_alta},
            dataType: 'json',
            cache: false,
            success: function(data) {
                $("#campos_lsw").html(capos_in);
                if (data[0]['contar'] != 0) {
                    nextinput = 0;
                    position = [];
                    $(data).each(function(i, v){ // indice, valor
                        var datos = data[i]['id']+','+data[i]['label'];
                        var ver =  data[i]['board']+' P. inicial: '+data[i]['port_l_i']+' P. final: '+data[i]['port_l_f']+' Label: '+data[i]['label2'];
                        nextinput++;
                        campo = '<div class="bw_all" style="margin-bottom: 5px;" id="input_lsw'+nextinput+'" > <input type="text" id="placa_mos_lsw[' + nextinput + ']" name="placa_mos_lsw[' + nextinput + ']" readonly="readonly" class="form-control" value="'+ver+'">    <input type="hidden" class="placa_alta_lsw" id="placa_alta_lsw[' + nextinput + ']" name="placa_alta_lsw[' + nextinput + ']" value="'+datos+'"></div>';
                        $("#campos_lsw").append(campo);
                    })
                }
                if (data[0]['otras']=='yes'){board.style.display = "block";}else{board.style.display="none";}
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        all_board.style.display = "none";
        img.style.display = "none";
        port_link.style.display = "none";
    }
}

function buscar_ip_admin_lsw_new(id, ip_servi=null){
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    var new_all = document.createElement('div');
    $("#multi_table_ip").html(new_all);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    var url = getBaseURL() +'mas/rama';
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("No hay datos para este grupo");
                    break;
                default:
                    var conte = $('#contenedor'+id);
                    $('#id_rango_old').val(data['es_rango']);
                    $('#id_rama_old').val(id);
                    if (conte.length == 0 || id == 1) {
                        $("#contenedor").html(new_all);
                        conte = $('#contenedor');
                        var valor_ini = '<ul><li><i class="fa fa-file-archive-o"></i></li> '+
                            '<li>  ' + data['actual']['name'] + '</li>'+
                            '</ul>';
                        $('#contenedor').append(valor_ini)
                        var table = '<div><table class="table_ramas hijos" style="margin-left: 30px;" id="contenedor'+id+'"></table></div>';
                        $('#contenedor').append(table)
                    }else{
                        if (positivo != null) {
                            positivo.style.display = "none";
                            negativo.style.display = "block";
                        }
                    }
                    $('#contenedor'+id+'').html(new_all);
                    $(data['datos']).each(function(i, v){
                        var valor = '<ul>';
                        if (data['datos'][i].rank != 'Si') {
                            valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="buscar_ip_admin_lsw_new('+data['datos'][i].id+','+ip_servi+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_mas_rama('+data['datos'][i].id+');"></i></li>' +
                                '<li>- <i class="fa fa-database"></i></li> ';
                        }else{
                            valor +='<li><i class="fa fa-plus-square-o" id="positivo'+data['datos'][i].id+'" onclick="rango_rama_lis_lsw_new('+data['datos'][i].id+','+ip_servi+');"></i>  <i class="fa fa-minus-square-o" style="display: none;" id="negativo'+data['datos'][i].id+'" onclick="eliminar_rango_rama_list('+data['datos'][i].id+');"></i></li>' +
                                '<li>--- <i class="fa fa-file-archive-o"></i></li> ';
                        }
                        valor += '<li>  ' + data['datos'][i].name + ' ' + data['datos'][i].ip_rank +'' + data['datos'][i].barra + '</li>';
                        if (data['datos'][i].rank == 'Si') {
                            if (data['datos'][i].permi >= 5) {
                                valor += '<li title="Crear SubRed"> <i class="fa fa-sitemap" data-toggle="modal" data-target="#popcrear_red"onclick="crear_sub_red('+data['datos'][i].id+');"></i></li>' +
                                    '<li title="Eliminar SubRed"> <i class="fa fa-window-close" data-toggle="modal" data-target="#popeliminar"onclick="eliminar_sub_red('+data['datos'][i].id+');"></i></li>';
                            }
                            valor += '</ul>';
                        }else{
                            if (data['datos'][i].padre != 0 && data['datos'][i].hijo == 0) {
                                if (data['datos'][i].permi >= 5) {
                                    valor += '<li title="Crear Rama Hijo">  <i class="fa fa-pagelines" data-toggle="modal" data-target="#popcrear_rama" onclick="new_rama_sin_rank('+data['datos'][i].id+');"></i></li>';
                                }
                            }
                            valor += '</ul>';
                        }
                        $('#contenedor'+id).append(valor)
                        var table = '<div><table class="table_ramas hijos" style="margin-left: 30px;" id="contenedor'+data['datos'][i].id+'"></table></div>';
                        $('#contenedor'+id).append(table)
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function rango_rama_lis_lsw_new(id, ip_servi=null){
    var id_rama_old = document.getElementById("id_rama_old").value;
    var id_rango_old = document.getElementById("id_rango_old").value;
    var id_function = document.getElementById("functi").value;
    var positivo = document.getElementById('positivo'+id+'');
    var negativo = document.getElementById('negativo'+id+'');
    if (id != id_rama_old && id_rama_old!= 0 && id_rango_old == 'Si'){
        var positivo_old = document.getElementById('positivo'+id_rama_old+'');
        var negativo_old = document.getElementById('negativo'+id_rama_old+'');
        negativo_old.style.display = "none";
        positivo_old.style.display = "block";
    }
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ver/ip',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            if (data['resul'] == 'login') {
                refresh();
            }else{
                var new_tbody = document.createElement('div');
                $("#multi_table_ip").html(new_tbody);
                if (data['resul'] == 'autori') {
                    toastr.error("Usuario no autorizado");
                }else{
                    if (data['resul'] == 'nop') {
                        toastr.error("No hay datos para este grupo");
                    }else{
                        positivo.style.display = "none";
                        negativo.style.display = "block";
                        var titulo = '<h4><i class="fa fa-file-archive-o"></i>  Rango: '+data['nombre']+' :'+data['inicio']+'/'+data['barra']+'</h4>';
                        titulo += '<h4> Detalle de las Ip del Rango</h4>';
                        $("#multi_table_ip").append(titulo)
                        var table = '<div><table class="table table-striped table-bordered table-hover dataTables-example">';
                        table +='<thead> <tr> <th>Estado</th> <th>Dirección</th> <th>SUBNET</th> <th></th> </tr> </thead>';
                        table +='<tbody id="tbodyramas"> </tbody>';
                        table +='</table></div>';
                        $("#multi_table_ip").append(table)
                        $(data['datas']).each(function(i, v){ // indice, valor
                            var valor = '<tr>';

                            if (data['datas'][i]['ip'] == data['fin']) {
                                valor += '<td><center><i class="fa fa-globe"></i></center></td>';
                            }else{

                                switch (data['datas'][i]['type']) {
                                    case "RED":
                                        valor += '<td><center><i class="fa fa-sitemap"></i> RED</center></td>';
                                        break;
                                    case "GATEWAY":
                                        valor += '<td><center><i class="fa fa-laptop"></i> GATEWAY</center></td>';
                                        break;
                                    case "BROADCAST":
                                        valor += '<td><center><i class="fa fa-globe"></i> BROADCAST</center></td>';
                                        break;
                                    default :
                                        valor += '<td><center>' + data['datas'][i]['status'] + '</center></td>';
                                        break;
                                }

                            }
                            valor += '<td> ' + data['datas'][i]['ip'] + '</td>' +
                                '<td>' + data['datas'][i]['subnet'] + '</td>';
                            if ((data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == 'DISPONIBLE') || (data['datas'][i]['status_id'] == 1 && data['datas'][i]['type'] == "GATEWAY")) {
                                valor +='<td> <i class="fa fa-dot-circle-o" onclick="selecion_ip_rango_lsw_new('+data['datas'][i]['id_rango']+');"></i></td>' +
                                    '</tr>';
                            }else{
                                if (data['datas'][i]['status'] == 'SIN ASIGNAR') {
                                    valor +='<td></td>' +
                                        '</tr>';
                                }else{
                                    valor +='<td> <i class="fa fa-warning" style="color: coral;"></i></td>' +
                                        '</tr>';
                                }
                            }
                            $("#tbodyramas").append(valor)
                        });
                        $('#id_rama_old').val(id);
                        $('#id_rango_old').val('Si');
                    }
                }
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function selecion_ip_rango_lsw_new(id){
    var modal = document.getElementById("cerra_bus_ip_admin");
    if (id != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'buscar/ip',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'login') {
                    refresh();
                }else{
                    if (data['resul'] == 'autori') {
                        toastr.error("Usuario no autorizado");
                    }else{
                        if (data['resul'] == 'exis') {
                            toastr.error("La IP es Invalidad");
                        }else{
                            $("#ip_admin_lsw").find('option').remove();
                            $("#ip_admin_lsw").append('<option selected disabled value="'+id+'">'+data['ip']+'/'+data['barra']+'</option>').trigger('change.select2');
                            modal.click();
                            var new_all = document.createElement('div');
                            $("#contenedor").html(new_all);
                        }
                    }
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#ip_admin_id').val(0);
    }
}

function update_search_lsw(id){
    clear_lsw_new();
    var aceptar = document.getElementById("alta_lsw_pop");
    var cancelar = document.getElementById("baja_lsw_pop");
    var modal = document.getElementById("cerra_lsw_pop");
    document.getElementById("title_lsw").textContent  = 'MODIFICAR LANSWITCH';
    document.getElementById('boton_buscar_equipo_all_lsw').style.display = "none";
    document.getElementById('link_button').style.display = "none";
    document.getElementById('img_alta_equipo_lsw').style.display = "none";
    document.getElementById('all_board_lsw').style.display = "none";
    document.getElementById('boton_buscar_equipo_all_lsw').style.display = "none";
    document.getElementById('node_button').style.display = "none";
    document.getElementById('port_ring_list_lsw').style.display = "none";
    document.getElementById('bus_ring').style.display = "none";
    $('#id_lsw_new').val(id);
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/equipo',
        data: {id:id,},
        dataType: 'json',
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
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case "yes":
                    $('#sitio_lsw').val(data['datos']['client_management']);
                    $('#enlace_lsw').val(data['datos']['service']);
                    $('#local_equipmen_lsw').val(data['datos']['location']);
                    $('#commentary_lsw').val(data['datos']['commentary']);
                    $('#orden_lsw').val(data['datos']['ir_os_up']);
                    $('#ip_admin_lsw').append('<option selected value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $('#equi_alta_lsw').append('<option selected value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    if (data['datos']['client_management'] == 'Si') {
                        $("#direc_lsw").append('<option selected value="'+data['datos']['address']+'">'+data['datos']['direcc']+'</option>').trigger('change.select2');
                        $("#id_ring_new").append('<option selected value="'+data['anillo']['id']+'">'+data['anillo']['name']+'</option>').trigger('change.select2');
                        $('#client_lsw').append('<option selected value="'+data['datos']['id_client']+'">'+data['datos']['client']+' '+data['datos']['cuit']+' '+data['datos']['business_name']+'</option>').trigger('change.select2');
                        document.getElementById('nodo_all_lsw').style.display = "none";
                        document.getElementById('link_all_node').style.display = "none";
                        document.getElementById('sar').style.display = "none";
                        document.getElementById('input_id_ring').style.display = "block"
                        document.getElementById('direc_all_lsw').style.display = "block"
                        document.getElementById('client_all_lsw').style.display = "block"
                    }else{
                        $("#nodo_al_lsw").append('<option selected value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                        document.getElementById('nodo_all_lsw').style.display = "block";
                        document.getElementById('link_all_node').style.display = "block";
                        document.getElementById('sar').style.display = "block";
                        document.getElementById('input_id_ring').style.display = "none"
                        document.getElementById('direc_all_lsw').style.display = "none"
                        document.getElementById('client_all_lsw').style.display = "none"
                        $("#link_all_lsw").append('<option selected value="'+data['datos']['id_link']+'">'+data['datos']['link']+'</option>').trigger('change.select2');
                        $('#equi_sar').val(data['datos']['Equi_sap']);
                        $('#port_sar').val(data['datos']['port_sar']);
                    }
                    $('#acro_lsw').val(data['datos']['acronimo']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    $('#sitio_lsw').attr('disabled', '');
    $('#port_sar').attr('disabled', '');
    $('#equi_sar').attr('disabled', '');
    aceptar.onclick = function() {
        var ip_admin = document.getElementById("ip_admin_lsw").value;
        var enlace = document.getElementById("enlace_lsw").value;
        var orden = document.getElementById("orden_lsw").value;
        var sitio = document.getElementById("sitio_lsw").value;
        var client = document.getElementById("client_lsw").value;
        var ring = document.getElementById("id_ring_new").value;
        var name = document.getElementById("acro_lsw").value;
        var nodo_al = document.getElementById("nodo_al_lsw").value;
        var direc = document.getElementById("direc_lsw").value;
        var equi_alta = document.getElementById("equi_alta_lsw").value;
        var commen = document.getElementById("commentary_lsw").value;
        var local = document.getElementById("local_equipmen_lsw").value;
        var port_sar = document.getElementById("port_sar").value;
        var equi_sar = document.getElementById("equi_sar").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/lanswitch/ipran',
            data: {id:id,board:0,ip_admin:ip_admin,enlace:enlace,orden:orden,sitio:sitio,port_sar:port_sar,name:name,nodo_al:nodo_al,direc:direc,equi_alta:equi_alta,commen:commen,local:local,link:0,port:0,equi_sar:equi_sar,client:client,ring:ring},
            dataType: 'json',
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
                        toastr.error("Error al guardar los datos");
                        break;
                    case "ip_exi":
                        toastr.error("IP no disponible");
                        break;
                    case "acronimo_exi":
                        toastr.error("El Nombre del LSW ya Existe");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#lanswitch_list').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}
function alta_link_crear(){
    if(location.href == getBaseURL()+'ver/link/celda'){
        let select = $("#type_link");
        select.addClass("hide-arrow-select");
        select.attr("disabled",true);
        select.find('option').get(0).remove();
        $('#type_link option[value=3]').attr('selected','selected');
    }
    var aceptar = document.getElementById("alta_link_pop");
    var cancelar = document.getElementById("baja_link_pop");
    var modal = document.getElementById("cerra_link_pop");
    document.getElementById("title_link").textContent  = 'REGISTRAR LINK';
    document.getElementById("alta_link").reset();
    $("#nodo_al").find('option').remove();
    $("#nodo_al").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    aceptar.onclick = function() {
        var type = document.getElementById("type_link").value;
        var nodo = document.getElementById("nodo_al").value;
        var n_max = document.getElementById("n_max_link").value;
        var max_link = document.getElementById("max_link").value;
        var name = document.getElementById("name_link").value;
        var commentary = document.getElementById("commentary_link").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/link',
            data: {id:0,type:type,nodo:nodo,n_max:n_max,max_link:max_link,name:name,commentary:commentary},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "yes":
                        toastr.success("Creación Exitosa");
                        $('#list_link').DataTable().ajax.reload();
                        $('#list_link_ipran').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function update_search_link(id){
    $('#id_link_modify').val(id);
    $("#nodo_al").find('option').remove();
    var aceptar = document.getElementById("modify_link_pop_save");
    var cancelar = document.getElementById("close_modify_link_pop");
    var modal = document.getElementById("close_modify_link_pop");
    if(location.href == getBaseURL()+'ver/link/celda'){
        let select = $("#type_link_modify");
        select.addClass("hide-arrow-select");
        select.attr("disabled",true);
        select.find('option').get(0).remove();
    }
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/link',
        data: {id:id,},
        dataType: 'json',
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
                    toastr.error("Error. link no encontrado");
                    break;
                case "yes":
                    $("#type_link_modify").val(data['datos'][0]['type']);
                    $("#name_link_modify").val(data['datos'][0]['name']);
                    $("#nodo_al_modify").append('<option selected disabled value="'+data['datos'][0]['id_node']+'">'+ data['datos'][0]['node'] +'</option>').trigger('change.select2');
                    $("#n_max_link_modify").val(data['datos'][0]['bw_limit']);
                    $("#max_link_modify option:contains("+data['datos'][0]['bw_limit_logo']+")").attr('selected', 'selected');
                    $("#commentary_link_modify").val(data['datos'][0]['commentary']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var type = document.getElementById("type_link_modify").value;
        var nodo = document.getElementById("nodo_al_modify").value;
        var n_max = document.getElementById("n_max_link_modify").value;
        var max_link = document.getElementById("max_link_modify").value;
        var name = document.getElementById("name_link_modify").value;
        var commentary = document.getElementById("commentary_link_modify").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/link',
            data: {id:id,type:type,nodo:nodo,n_max:n_max,max_link:max_link,name:name,commentary:commentary},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#list_link_ipran').DataTable().ajax.reload();
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function info_detal_port_equipmen(board, port){
    var title = document.getElementById("port_title_detal");
    $("#detal_port_equipment_all").empty();
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'detalle/puerto/servicio',
        data: {board:board, port:port},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    title.textContent = data['port'];
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['Service'] +'</td>' +
                            '<td>' + data['datos'][i]['vlan'] + '</td>' +
                            '<td>' + data['datos'][i]['bw'] + '</td>' +
                            '<td>' + data['datos'][i]['client'] + '</td>' +
                            '</tr>';
                        $("#detal_port_equipment_all").append(valor);
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function selec_link_lsw_new(id){
    $("#link_all_lsw").find('option').remove();
    var cerrar = document.getElementById('cerra_bus_link');
    if (id != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/link',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#link_all_lsw").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        break;
                    case "nop":
                        $("#link_all_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
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
    }else{
        selec.append('<option selected disabled value="">seleccionar</option>');
        cerrar.click();
    }
}

function port_lsw_selec_link(){
    var placa_alta = document.getElementsByClassName("placa_alta_lsw");
    var placa = [];
    $("#list_all_port_link").empty();
    $("#campos_port_link_all").empty();
    for (var i = 0; i < placa_alta.length; ++i) {
        if (typeof placa_alta[i].value !== "undefined"){ placa.push(placa_alta[i].value);}
    }
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'puerto/lsw/link',
        data: {placa:placa,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "nop":
                    toastr.error("El equipo no tiene puerto");
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                            '<td>'+data['datos'][i]['label']+data['datos'][i]['pose']+'</td>' +
                            '<td>'+data['datos'][i]['type']+ '</td>' +
                            '<td>'+data['datos'][i]['bw_port']+'</td>' +
                            '<td><a title="Seleccionar" onclick="selec_new_port_link_lsw('+data['datos'][i]['id']+','+data['datos'][i]['port']+','+[i]+');"> <i class="fa fa-bullseye"> </i></a></td>' +
                            '</tr>';
                        valor += '<input type="hidden" id="'+[i]+'" value="'+data['datos'][i]['label']+data['datos'][i]['pose']+' '+data['datos'][i]['bw_port']+'">';
                        $("#list_all_port_link").append(valor);
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function selec_new_port_link_lsw(board, port, id){
    var name = document.getElementById(id).value;
    var modal = document.getElementById('cerra_port_link_all');
    $("#list_all_port_link").empty();
    $("#campos_port_link_all").empty();
    var valor = '<input type="text" class="form-control" readonly="readonly" value="'+name+'">';
    valor += '<input type="hidden" name="port_link_id[]" class="port_link_id" value="'+board+','+port+'">';
    $("#campos_port_link_all").append(valor);
    modal.click();
}

function search_lsw_port_link(id){
    var aceptar = document.getElementById("alta_port_lsw_link");
    var cancelar = document.getElementById("exit_alta_port_lsw_link");
    var cerrar = document.getElementById("cerra_puerto_lsw_link");
    var titulo = $("#title_link_port");
    var vinculado = false;
    var ejecutar_fun = function(){}
    $("#all_puerto_link_lsw").empty();
    titulo.empty();
    aceptar.removeAttribute('data-toggle');
    aceptar.removeAttribute('data-target');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'puerto/link/lanswitch',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            var campo = '';
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "nop":
                    titulo.textContent = '';
                    if ('exception' in data) {
                        campo += '<div class="form-group">'+
                            '<h4>Este equipo no tiene Uplink vinculado, '+
                            'deber&aacute; seleccionar uno</h4>'+
                            '</div>';
                        aceptar.dataset.toggle = "modal";
                        aceptar.dataset.target = "#attach_uplink_equipment";
                        ejecutar_fun = function(param1){ set_equipment_uplink(param1); }
                    } else {
                        toastr.error("Error de servidor");
                    }
                    break;
                case "yes":
                    titulo.textContent = data['port_old']['name'];
                    if (Array.isArray(data['port_old'])) {
                        campo += '<div class="form-group">'+
                            '<label>'+'Selecciona el puerto a utilizar</label>'+
                            '<select class="form-control" id="port_new_link" name="port_new_link">';
                    } else {
                        campo += '<div class="form-group">'+
                            '<label>'+data['port_old']['port']+' '+data['port_old']['bw']+'</label>'+
                            '<select class="form-control" id="port_new_link" name="port_new_link">';
                    }
                    $(data['datos']).each(function(i, v){
                        if (data['datos'][i]['status'] == 2) {
                            campo += '<option value="'+data['datos'][i]['id']+','+data['datos'][i]['n_port']+'">'+data['datos'][i]['port']+' '+data['datos'][i]['bw_port']+'</option>';
                        } else {
                            campo += '<option disabled style="color:red;" value="">'+data['datos'][i]['port']+' '+data['datos'][i]['bw_port']+'</option>';
                        }
                    });
                    campo += '</select>'+
                        '</div>';
                    vinculado = true;
                    ejecutar_fun = function(param1, param2){ port_new_link_lsw(param1, param2); }
                    break;
            }
            $("#all_puerto_link_lsw").append(campo);
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

    aceptar.onclick = function() {
        if (vinculado === true) {
            var port = document.getElementById('port_new_link').value;
            ejecutar_fun(id, port); // port_new_link_lsw(id, port);
        } else {
            ejecutar_fun(id); // set_equipment_uplink(id);
        }
        cerrar.click();
    }

    cancelar.onclick = function() {
        cerrar.click();
    }
}

function select_uplink_item(link_id, link_acr) {
    $('#port_div').show();
    document.getElementById("close_uplink_list").click();
    var uplink_field = $("#uplink_field");
    uplink_field.find('option').remove();
    uplink_field.append('<option selected disabled value="'+link_id+'">'+link_acr+'</option>');
    uplink_field.val(link_id).trigger('change.select2');
}

function port_new_link_lsw(id, port) {
    if (port != '' && port != null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'puerto/nuevo/lanswitch',
            data: {id:id, port:port,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        toastr.error("El equipo no tiene puerto");
                        break;
                    case "yes":
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function set_equipment_uplink(eq_id) {
    $('#port_div').hide();
    $("#uplink_field").empty().trigger("change");
    $("#uplink_field").find('option').remove()
    $("#port_field").empty().trigger("change");
    $("#port_field").find('option').remove()
    $("#attach_board_id").val('').trigger('change');
    $("#attach_port_n").val('').trigger('change');
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    } else {
        str = 0;
    }
    if (str >= 3) {
        document.getElementById('uplink_search_anchor').setAttribute('onclick', 'uplink_by_equipment('+eq_id+')');
        document.getElementById('port_search_anchor').setAttribute('onclick', 'port_list_by_equipment('+eq_id+')');
    }
}

function acronimo_lsw_new(id){
    $('#acro_lsw').val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'acrinimo/lsw/link',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#acro_lsw').val(data['datos']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function link_sar_new(){
    var camp_sar = document.getElementById('sar');
    var link = document.getElementById('link_all_lsw').value;
    if (link != '' && link != null) {
        camp_sar.style.display = "block";
    }else{
        camp_sar.style.display = "none";
    }
}

function acro_link(){
    var nodo = document.getElementById('nodo_al').value;
    if (nodo != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'acronimo/link',
            data: {id:nodo,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#name_link').val(data['datos']);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#name_link').val('');
    }
}

function selec_equipmen_all_lsw(id){
    var modal = document.getElementById("cerra_buscar_equipo_all_lsw");
    var selec = $("#id_lsw");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    modal.click();
                    selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    $('#id_ip_lsw').val(data['ip']);
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
    modal.click();
}

function equip_port_dato(){
    var id = document.getElementById('id_lsw').value;
    var boton = document.getElementById('cerra_equipmen_radio');
    var mensaje = document.getElementById("acro_equipmen_radio");
    var new_tbody = document.createElement('tbody');
    $("#list_port_equipmen_radio").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'puerto/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    mensaje.textContent  ='Puerto LSW dato del equipo: '+data['acronimo'];
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>'+data['datos'][i]['slot']+data['datos'][i]['port']+'</td>' +
                            '<td>'+data['datos'][i]['type']+'</td>' +
                            '<td>'+data['datos'][i]['status']+'</td>' +
                            '<td>'+data['datos'][i]['bw']+'</td>' +
                            '<td>'+data['datos'][i]['atributo']+'</td>' +
                            '<td>'+data['datos'][i]['agg_status']+'</td>' +
                            '<td>'+data['datos'][i]['commentary']+'</td>'+
                            '<td>';
                        if (data['datos'][i]['status'] == 'VACANTE') {
                            valor +=' <a onclick="selec_port_lsw_radio('+data['datos'][i]['id']+','+data['datos'][i]['port']+');" title="Selecionar"> <i class="fa fa-bullseye"> </i> <a> ';
                        }else{
                            valor +=' <i class="fa fa-warning" style="color: coral;"> </i>';
                        }
                        valor += '</td></tr>';
                        $("#list_all_port_equipmen_lsw_radio").append(valor)
                    });
                    break;
                case "nop":
                    toastr.error("No tiene placa");
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
            mensaje.textContent  = '';
        }
    });
}

function equip_port_gestion(){
    var id = document.getElementById('id_lsw').value;
    var boton = document.getElementById('cerra_equipmen_radio');
    var mensaje = document.getElementById("acro_equipmen_radio");
    var new_tbody = document.createElement('tbody');
    $("#list_all_port_equipmen_lsw_radio").html(new_tbody);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'puerto/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    mensaje.textContent  ='Puerto LSW Gestion del equipo: '+data['acronimo'];
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>'+data['datos'][i]['slot']+data['datos'][i]['port']+'</td>' +
                            '<td>'+data['datos'][i]['type']+'</td>' +
                            '<td>'+data['datos'][i]['status']+'</td>' +
                            '<td>'+data['datos'][i]['bw']+'</td>' +
                            '<td>'+data['datos'][i]['atributo']+'</td>' +
                            '<td>'+data['datos'][i]['agg_status']+'</td>' +
                            '<td>'+data['datos'][i]['commentary']+'</td>'+
                            '<td>';
                        if (data['datos'][i]['status'] == 'VACANTE') {
                            valor +=' <a onclick="selec_port_lsw_radio_gestion('+data['datos'][i]['id']+','+data['datos'][i]['port']+');" title="Selecionar"> <i class="fa fa-bullseye"> </i> <a> ';
                        }else{
                            valor +=' <i class="fa fa-warning" style="color: coral;"> </i>';
                        }
                        valor += '</td></tr>';
                        $("#list_all_port_equipmen_lsw_radio").append(valor)
                    });
                    break;
                case "nop":
                    toastr.error("No tiene placa");
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
            mensaje.textContent  = '';
        }
    });
}

function selec_port_lsw_radio_gestion(board, port){
    var modal = document.getElementById('cerra_equipmen_radio');
    var selec = $("#alta_port_gestion");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'asignar/puerto/equipo',
        data: {board:board, port:port},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    selec.append('<option selected disabled value="'+data['datos']['id']+'">'+data['datos']['port']+'</option>').trigger('change.select2');
                    modal.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
            modal.click();
        }
    });
}

function selec_port_lsw_radio(board, port){
    var modal = document.getElementById('cerra_equipmen_radio');
    var selec = $("#alta_port_datos");
    selec.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'asignar/puerto/equipo',
        data: {board:board, port:port},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    selec.append('<option selected disabled value="'+data['datos']['id']+'">'+data['datos']['port']+'</option>').trigger('change.select2');
                    modal.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
            modal.click();
        }
    });
}

function selec_equipmen_all_radio(id){
    var modal = document.getElementById("cerra_buscar_equipo_all");
    var selec = $("#alta_radio"); selec.find('option').remove();
    var equi = $("#equi_alta"); equi.find('option').remove();
    var ip = $("#ip_admin"); ip.find('option').remove();
    var radio = $("#id_modelo_radio"); radio.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'asignar/equipo/radio',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    selec.append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                    equi.append('<option selected disabled value="'+data['id_model']+'">'+data['model']+'</option>').trigger('change.select2');
                    radio.append('<option selected disabled value="'+data['id_model']+'">'+data['model']+'</option>').trigger('change.select2');
                    ip.append('<option selected disabled value="'+data['id_ip']+'">'+data['ip']+'</option>').trigger('change.select2');
                    $('#acro_radio').val(data['datos']);
                    $('#neid').val(data['ne_id']);
                    modal.click();
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
    modal.click();
}

function EquipmentBoardRadio(){
    acro_radio_node();
    var loopback = document.getElementById('input_ip_loopback');
    var loopback2 = document.getElementById('input_loopback_ip');
    var ne_id2 = document.getElementById('input_ne_id');
    var ne_id = document.getElementById('ne_id_input');
    var id = document.getElementById('equi_alta').value;
    var odu = $("#frecuencia_odu"); odu.find('option').remove();
    var antena = $("#tamano_antena"); antena.find('option').remove();
    var frecuencia = $("#id_frecuencia_radio"); frecuencia.find('option').remove();
    var ante = $("#id_tamano_antena"); ante.find('option').remove();
    if (id != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'buscar/odu/antena',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $(data['datos']['antena']).each(function(i, v){
                            antena.append('<option value="'+data['datos']['antena'][i]['id']+'">'+data['datos']['antena'][i]['port']+'</option>').trigger('change.select2');
                            ante.append('<option value="'+data['datos']['antena'][i]['id']+'">'+data['datos']['antena'][i]['port']+'</option>').trigger('change.select2');
                        });
                        $(data['datos']['odu']).each(function(j, h){
                            odu.append('<option value="'+data['datos']['odu'][j]['id']+'">'+data['datos']['odu'][j]['port']+'</option>').trigger('change.select2');
                            frecuencia.append('<option value="'+data['datos']['odu'][j]['id']+'">'+data['datos']['odu'][j]['port']+'</option>').trigger('change.select2');
                        });
                        if (data['mark'] == 2) {
                            loopback.style.display = "none";
                            loopback2.style.display = "none";
                            ne_id2.style.display = "block";
                            ne_id.style.display = "block";
                        }else{
                            loopback.style.display = "block";
                            loopback2.style.display = "block";
                            ne_id2.style.display = "none";
                            ne_id.style.display = "none";
                        }

                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function acro_radio_node(){
    var nodo = document.getElementById('nodo_al').value;
    var equi = document.getElementById('equi_alta').value;
    var radio = document.getElementById('alta_radio').value;
    let Constants;
    if (nodo != '' && equi != '' && radio == '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'acronimo/radio/nodo',
            data: {id:nodo, equi:equi},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#acro_radio').val(data['datos']);

                        //instancio el modelo de constantes de js para verificar si el modelo de equipo es aviat
                        Constants = new ConstantsModel();

                        if(data.modelo == Constants.EQUIPMENT_MODEL_AVIAT){
                            //oculto input ip loopback en claro
                            let loopback = document.getElementById('input_ip_loopback');
                            setTimeout(function(){
                                loopback.style.display = 'none';
                            }, 500)

                            //cambio el texto del label en cliente
                            let loopback_cliente = document.getElementById('input_loopback_ip').children[0];
                            loopback_cliente.textContent = 'IP de gestión';
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#acro_radio').val('');
    }
}

function acro_radio_client(){
    var client = document.getElementById('client_sub_red').value;
    var equi = document.getElementById('equi_alta').value;
    if (client != '' && equi != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'acronimo/radio/cliente',
            data: {id:client, equi:equi},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#radio_acro_2').val(data['datos']);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        $('#radio_acro_2').val('');
    }
}

function BoardPortRadio(){
    var modelo = document.getElementById('equi_alta').value;
    var radio = document.getElementById('alta_radio').value;
    var new_tbody = document.createElement('tbody');
    $("#list_new_port_radio").html(new_tbody);
    if (modelo != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'buscar/puerto/radio',
            data: {modelo:modelo,radio:radio,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#list_new_port_radio").html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="td_port_'+[i]+'">'+data['datos'][i]['port']+'</td>' +
                                '<td>'+data['datos'][i]['type']+'</td>' +
                                '<td>'+data['datos'][i]['status']+'</td>' +
                                '<td>'+data['datos'][i]['bw']+'</td>' +
                                '<td>'+data['datos'][i]['atributo']+'</td>' +
                                '<td>';
                            if (data['datos'][i]['status'] == 'VACANTE') {
                                valor += '<a onclick="selec_port_radio_new('+data['datos'][i]['id']+','+[i]+');" title="Selecionar"> <i class="fa fa-bullseye"> </i> <a>';
                            }else{
                                valor += '<a title="Ocupado"><i class="fa fa-warning" style="color: coral;"> </i><a>';
                            }
                            valor += '</td>' +
                                '</tr>';
                            $("#list_new_port_radio").append(valor)
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

function BoardPortIfRadio(){
    var modelo = document.getElementById('equi_alta').value;
    var radio = document.getElementById('alta_radio').value;
    var new_tbody = document.createElement('tbody');
    $("#list_new_port_radio").html(new_tbody);
    if (modelo != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'buscar/puerto/if/radio',
            data: {modelo:modelo,radio:radio,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#list_new_port_radio").html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="td_port_'+[i]+'">'+data['datos'][i]['port']+'</td>' +
                                '<td>'+data['datos'][i]['type']+'</td>' +
                                '<td>'+data['datos'][i]['status']+'</td>' +
                                '<td>'+data['datos'][i]['bw']+'</td>' +
                                '<td>'+data['datos'][i]['atributo']+'</td>' +
                                '<td>';
                            if (data['datos'][i]['status'] == 'VACANTE') {
                                valor += '<a onclick="selec_port_if_radio_new('+data['datos'][i]['id']+','+[i]+');" title="Selecionar"> <i class="fa fa-bullseye"> </i> <a>';
                            }else{
                                valor += '<a title="Ocupado"><i class="fa fa-warning" style="color: coral;"> </i><a>';
                            }
                            valor += '</td>' +
                                '</tr>';
                            $("#list_new_port_radio").append(valor)
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

function BoardPortIfRadio2(){
    var modelo = document.getElementById('equi_alta').value;
    var new_tbody = document.createElement('tbody');
    $("#list_new_port_radio").html(new_tbody);
    if (modelo != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'buscar/puerto/if/radio',
            data: {modelo:modelo,radio:0,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#list_new_port_radio").html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="td_port_'+[i]+'">'+data['datos'][i]['port']+'</td>' +
                                '<td>'+data['datos'][i]['type']+'</td>' +
                                '<td>'+data['datos'][i]['status']+'</td>' +
                                '<td>'+data['datos'][i]['bw']+'</td>' +
                                '<td>'+data['datos'][i]['atributo']+'</td>' +
                                '<td><a onclick="selec_port_if_radio2_new('+data['datos'][i]['id']+','+[i]+');" title="Selecionar"> <i class="fa fa-bullseye"> </i> <a></td>' +
                                '</tr>';
                            $("#list_new_port_radio").append(valor)
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

function BoardPortRadioNew(){
    var modelo = document.getElementById('equi_alta').value;
    var new_tbody = document.createElement('tbody');
    $("#list_new_port_radio").html(new_tbody);
    if (modelo != '') {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'buscar/puerto/radio',
            data: {modelo:modelo,radio:0,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#list_new_port_radio").html(new_tbody);
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="td_port_'+[i]+'">'+data['datos'][i]['port']+'</td>' +
                                '<td>'+data['datos'][i]['type']+'</td>' +
                                '<td>'+data['datos'][i]['status']+'</td>' +
                                '<td>'+data['datos'][i]['bw']+'</td>' +
                                '<td>'+data['datos'][i]['atributo']+'</td>' +
                                '<td><a onclick="NewSelecPortRadio('+data['datos'][i]['id']+','+[i]+');" title="Selecionar"> <i class="fa fa-bullseye"> </i> <a></td>' +
                                '</tr>';
                            $("#list_new_port_radio").append(valor)
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

function selec_port_radio_new (board, n_port, id){
    var modal = document.getElementById("cerra_new_port_radio");
    var port = $("#port_radio"); port.find('option').remove();
    var tex = document.getElementById("td_port_"+id).innerHTML;
    port.append('<option value="'+board+','+n_port+'">'+tex+'</option>').trigger('change.select2');
    modal.click();
}

function selec_port_if_radio_new (board, n_port, id){
    var modal = document.getElementById("cerra_new_port_radio");
    var port = $("#port_radio_if"); port.find('option').remove();
    var tex = document.getElementById("td_port_"+id).innerHTML;
    port.append('<option value="'+board+','+n_port+'">'+tex+'</option>').trigger('change.select2');
    modal.click();
}

function selec_port_if_radio2_new (board, n_port, id){
    var modal = document.getElementById("cerra_new_port_radio");
    var port = $("#port_radio2_if"); port.find('option').remove();
    var tex = document.getElementById("td_port_"+id).innerHTML;
    port.append('<option value="'+board+','+n_port+'">'+tex+'</option>').trigger('change.select2');
    modal.click();
}

function NewSelecPortRadio (board, n_port, id){
    var modal = document.getElementById("cerra_new_port_radio");
    var port = $("#new_port_radio"); port.find('option').remove();
    var tex = document.getElementById("td_port_"+id).innerHTML;
    port.append('<option value="'+board+','+n_port+'">'+tex+'</option>').trigger('change.select2');
    modal.click();
}

function clear_alta_radio(){
    $("#id_lsw").find('option').remove();
    $("#id_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#alta_port_datos").find('option').remove();
    $("#alta_port_datos").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#alta_port_gestion").find('option').remove();
    $("#alta_port_gestion").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#nodo_al").find('option').remove();
    $("#nodo_al").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#alta_radio").find('option').remove();
    $("#alta_radio").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#equi_alta").find('option').remove();
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").find('option').remove();
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin_loopback").find('option').remove();
    $("#ip_admin_loopback").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#frecuencia_odu").find('option').remove();
    $("#frecuencia_odu").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#tamano_antena").find('option').remove();
    $("#tamano_antena").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#port_radio").find('option').remove();
    $("#port_radio").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#servicio_radio").find('option').remove();
    $("#servicio_radio").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#client_sub_red").find('option').remove();
    $("#client_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_address").find('option').remove();
    $("#id_address").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_modelo_radio").find('option').remove();
    $("#id_modelo_radio").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#loopback_ip_admin").find('option').remove();
    $("#loopback_ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_frecuencia_radio").find('option').remove();
    $("#id_frecuencia_radio").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_tamano_antena").find('option').remove();
    $("#id_tamano_antena").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#new_port_radio").find('option').remove();
    $("#new_port_radio").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
}

function alta_radio_crear(){
    $('#formRadioAll').steps("reset");

    $("#formRadioAll-t-0").click();
    document.getElementById("formRadioAll").reset();
    clear_alta_radio();
    var aceptar = document.getElementById("guardar_radio");
    var cancelar = document.getElementById("cancelar_radio");
    var modal = document.getElementById("cerra_radio_all");
    aceptar.onclick = function(){
        var lsw = document.getElementById('id_lsw').value;
        var port_datos = document.getElementById('alta_port_datos').value;
        var port_gestion = document.getElementById('alta_port_gestion').value;
        var nodo = document.getElementById('nodo_al').value;
        var radio = document.getElementById('alta_radio').value;
        var modelo = document.getElementById('equi_alta').value;
        var acro_radio = document.getElementById('acro_radio').value;
        var ip_admin = document.getElementById('ip_admin').value;
        var ip_loopback = document.getElementById('ip_admin_loopback').value;
        var neid = document.getElementById('neid').value;
        var frecuencia = document.getElementById('frecuencia_odu').value;
        var antena = document.getElementById('tamano_antena').value;
        var port_radio = document.getElementById('port_radio').value;
        var servicio = document.getElementById('servicio_radio').value;
        var orden = document.getElementById('orden_radio').value;
        var client = document.getElementById('client_sub_red').value;
        var address = document.getElementById('id_address').value;
        var modelo2 = document.getElementById('id_modelo_radio').value;
        var radio_acro = document.getElementById('radio_acro_2').value;
        var ne_id_radio = document.getElementById('ne_id_radio2').value;
        var loopback_ip = document.getElementById('loopback_ip_admin').value;
        var id_frecuencia = document.getElementById('id_frecuencia_radio').value;
        var id_antena = document.getElementById('id_tamano_antena').value;
        var new_port = document.getElementById('new_port_radio').value;
        var port_radio_if = document.getElementById('port_radio_if').value;
        var port_radio2_if = document.getElementById('port_radio2_if').value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'registar/radio',
            data: {lsw:lsw,port_datos:port_datos,port_gestion:port_gestion,nodo:nodo,radio:radio,modelo:modelo,acro_radio:acro_radio,ip_admin:ip_admin,ip_loopback:ip_loopback,neid:neid,frecuencia:frecuencia,antena:antena,port_radio:port_radio,servicio:servicio,orden:orden,client:client,address:address,modelo2:modelo2,radio_acro:radio_acro,ne_id_radio:ne_id_radio,loopback_ip:loopback_ip,id_frecuencia:id_frecuencia,id_antena:id_antena,new_port:new_port,port_radio_if:port_radio_if,port_radio2_if:port_radio2_if,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#jarvis_radio').DataTable().ajax.reload();
                        modal.click();
                        break;
                    case "acronimo_exi_2":
                        toastr.error("El acronimo del Radio 2 ya existe");
                        break;
                    case "loopback_exi_2":
                        toastr.error("IP LoopBack del Radio 2 esta ocupada");
                        break;
                    case "acronimo_exi_1":
                        toastr.error("El acronimo del Radio 1 ya existe");
                        break;
                    case "ip_exi":
                        toastr.error("IP de Gestión esta ocupada");
                        break;
                    case "loopback_exi_1":
                        toastr.error("IP LoopBack del Radio 1 esta ocupada");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function update_search_radio(id){
    var modal = document.getElementById("cerrar_radio_editar");
    var aceptar = document.getElementById("edi_save");
    var cancelar = document.getElementById("edi_cancel");
    var ne_id = document.getElementById('input_edi_ne_id');
    var loopback = document.getElementById('input_edi_loopback');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/equipo',
        data: {id:id,},
        dataType: 'json',
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
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case "yes":
                    $('#mark').val(data['datos']['id_mark']);
                    $('#edi_acro_radio').val(data['datos']['acronimo']);
                    $("#edi_client").append('<option selected disabled value="'+data['datos']['id_client']+'">'+data['datos']['client']+' '+data['datos']['business_name']+'</option>').trigger('change.select2');
                    $("#edi_address").append('<option selected disabled value="'+data['datos']['address']+'">'+data['datos']['direcc']+'</option>').trigger('change.select2');
                    $('#edi_ne_id_radio').val(data['datos']['ne_id']);
                    $("#edi_model").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $("#edi_loopback").append('<option selected disabled value="'+data['datos']['id_loopback']+'">'+data['datos']['ip_loopback']+'</option>').trigger('change.select2');
                    $('#commen_edi').val(data['datos']['commentary']);
                    if (data['datos']['id_mark'] == 3) {
                        ne_id.style.display = "none";
                        loopback.style.display = "block";
                    }else{
                        ne_id.style.display = "block";
                        loopback.style.display = "none";
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var client = document.getElementById('edi_client').value;
        var address = document.getElementById('edi_address').value;
        var acro_radio = document.getElementById('edi_acro_radio').value;
        var model = document.getElementById('edi_model').value;
        var ne_id = document.getElementById('edi_ne_id_radio').value;
        var loopback = document.getElementById('edi_loopback').value;
        var commen = document.getElementById('commen_edi').value;
        var mark = document.getElementById('mark').value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'modificar/radio',
            data: {id:id,client:client,address:address,acro_radio:acro_radio,model:model,ne_id:ne_id,loopback:loopback,commen:commen,mark:mark},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#jarvis_radio').DataTable().ajax.reload();
                        modal.click();
                        break;
                    case "acronimo_exi":
                        toastr.error("El acronimo existe");
                        break;
                    case "ip_exi_loopback":
                        toastr.error("IP LoopBack esta ocupada");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}


function update_search_radio_nodo(id){
    var modal = document.getElementById("cerrar_radio_nodo_editar");
    var aceptar = document.getElementById("save_edict");
    var cancelar = document.getElementById("cancel_edi");
    var ne_id = document.getElementById('input_radio_neid');
    var loopback = document.getElementById('input_radio_ip_loopback');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/equipo',
        data: {id:id,},
        dataType: 'json',
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
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case "yes":
                    $('#mark_radio').val(data['datos']['id_mark']);
                    $('#edi_radio_acro').val(data['datos']['acronimo']);
                    $("#edi_node").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['node']+' '+data['datos']['business_name']+'</option>').trigger('change.select2');
                    $("#edi_ip_gestion").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $('#edi_radio_ne_id').val(data['datos']['ne_id']);
                    $("#edi_model_radio").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $("#edi_ip_loopback").append('<option selected disabled value="'+data['datos']['id_loopback']+'">'+data['datos']['ip_loopback']+'</option>').trigger('change.select2');
                    $('#commen_edi_radio').val(data['datos']['commentary']);
                    if (data['datos']['id_mark'] == 3) {
                        ne_id.style.display = "none";
                        loopback.style.display = "block";
                    }else{
                        ne_id.style.display = "block";
                        loopback.style.display = "none";
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var node = document.getElementById('edi_node').value;
        var acro_radio = document.getElementById('edi_radio_acro').value;
        var model = document.getElementById('edi_model_radio').value;
        var gestion = document.getElementById('edi_ip_gestion').value;
        var ne_id = document.getElementById('edi_radio_ne_id').value;
        var loopback = document.getElementById('edi_ip_loopback').value;
        var commen = document.getElementById('commen_edi_radio').value;
        var mark = document.getElementById('mark_radio').value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'modificar/radio/nodo',
            data: {id:id,node:node,acro_radio:acro_radio,model:model,gestion:gestion,ne_id:ne_id,loopback:loopback,commen:commen,mark:mark,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $('#jarvis_radio').DataTable().ajax.reload();
                        modal.click();
                        break;
                    case "acronimo_exi":
                        toastr.error("El acronimo existe");
                        break;
                    case "ip_exi_loopback":
                        toastr.error("IP LoopBack esta ocupada");
                        break;
                    case "ip_exi":
                        toastr.error("IP de Gestión esta ocupada");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function ConfirmationRadio() {
    var acro1 = document.getElementById('acro_radio').value;
    var acro2 = document.getElementById('radio_acro_2').value;
    document.getElementById("TexCelda").textContent  = $('#nodo_al').find('option:selected').text();
    document.getElementById("TexAcro1").textContent  = acro1;
    document.getElementById("TexModelo1").textContent = $('#equi_alta').find('option:selected').text();
    document.getElementById("TexPuertoIF1").textContent = $('#port_radio_if').find('option:selected').text();
    document.getElementById("TexIPGestion").textContent  = $('#ip_admin').find('option:selected').text();
    document.getElementById("TexIPLoopback1").textContent  = $('#ip_admin_loopback').find('option:selected').text();
    document.getElementById("TexNEID1").textContent  = document.getElementById('neid').value;
    document.getElementById("TexPuertoUPLink1").textContent  = $('#port_radio').find('option:selected').text();
    document.getElementById("TexAcronimoLSW").textContent  = $('#id_lsw').find('option:selected').text();
    document.getElementById("TexPuertoDatos").textContent  = $('#alta_port_datos').find('option:selected').text();
    document.getElementById("TexPuertoLSW").textContent  = $('#alta_port_gestion').find('option:selected').text();


    document.getElementById("TexFrecuencia1").textContent  = $('#frecuencia_odu').find('option:selected').text();
    document.getElementById("TexAntena1").textContent  = $('#tamano_antena').find('option:selected').text();
    document.getElementById("TexFrecuencia2").textContent  = $('#id_frecuencia_radio').find('option:selected').text();
    document.getElementById("TexAntena2").textContent  = $('#id_tamano_antena').find('option:selected').text();

    document.getElementById("TexAcroEnlace").textContent = 'RF-'+acro1+'_'+acro2;

    document.getElementById("TexCliente").textContent  = $('#client_sub_red').find('option:selected').text();
    document.getElementById("TexServicio").textContent  = $('#servicio_radio').find('option:selected').text();
    document.getElementById("TexOrden").textContent  = document.getElementById('orden_radio').value;
    document.getElementById("TexAddress").textContent  = $('#id_address').find('option:selected').text();
    document.getElementById("TexAcronimo2").textContent  = acro2;
    document.getElementById("TexModelo2").textContent  = $('#id_modelo_radio').find('option:selected').text();
    document.getElementById("TexPuertoIF2").textContent  = $('#port_radio2_if').find('option:selected').text();
    document.getElementById("TexNEID2").textContent  = document.getElementById('ne_id_radio2').value;
    document.getElementById("TexPuertoUPLink2").textContent  = $('#new_port_radio').find('option:selected').text();
    document.getElementById("TexIPLoopback2").textContent  = $('#loopback_ip_admin').find('option:selected').text();


}

function detal_port_radio_antena_odu(board, port){
    var title = document.getElementById("title_link_name");
    var extre = document.getElementById("title_link_extre");
    $('#list_odu_antena_radio').empty();
    title.textContent = '';
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/antena/odu',
        headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        data: {board:board, port:port,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    title.textContent = data['name'];
                    extre.textContent = data['extremo'];
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['type']+ '</td>' +
                            '<td>' + data['datos'][i]['model']+ '</td>' +
                            '<td class="text-center"><a data-toggle="modal" data-target="#popedi_radio_odu_antena" onclick="search_antena_odu_new('+data['datos'][i]['id']+','+data['datos'][i]['id_model']+','+data['datos'][i]['option']+');" title="Cambia '+data['datos'][i]['type']+'"> <i class="fa fa-edit" > </i></a></td>' +
                            '</tr>';
                        $("#list_odu_antena_radio").append(valor)
                    });
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function show_relate_ports(id){
    var tbody = document.createElement('tbody');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/cadena/relaciones',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    let nombre_cadena = (data['nombre_cadena']).toUpperCase();
                    $("#chain_id").val(id);

                    document.getElementById("button_relate_ports").innerHTML = '<a class="btn btn-success" data-toggle="modal" data-target="#relacionar_puertos_agg_pop" onclick="modal_relate_ports_agg('+id+');"><i class="fa fa-pencil"></i> Relacionar puertos del equipo</a>';

                    $('#cadena_name_h4').html(nombre_cadena);
                    $("#list_ports_relate").html(tbody);

                    //Logica para listar los puertos conectados sin que esten repetidos o mal organizados
                    array_conectados = [];
                    for (let i = 0; i < data['datos'].length; i++) {
                        let id_port = data['datos'][i].id_port;
                        array_conectados.push(id_port);
                        for(let j = 0; j<data['datos'].length; j++){
                            if(id_port == data['datos'][j].conectado && (array_conectados.includes(data['datos'][j].id_port)) != true){
                                //console.log(data['datos'][i].id_port + ',' + data['datos'][j].id_port);
                                if(data['datos'][j].comentario == null){
                                    data['datos'][j].comentario == ' a';
                                }
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i].acronimo + '</td>' +
                                    '<td>' + data['datos'][i].port +'</td>';
                                if(data['datos'][i].comentario == null){
                                    valor += '<td> </td>';
                                }else{
                                    valor += '<td>' + data['datos'][i].comentario +'</td>';
                                }
                                valor += '<td>' + data['datos'][j].acronimo +'</td>' +
                                    '<td>' + data['datos'][j].port + '</td>';
                                if(data['datos'][j].comentario == null){
                                    valor += '<td> </td>';
                                }else{
                                    valor += '<td>' + data['datos'][j].comentario +'</td>';
                                }
                                valor += '<td><a onclick="port_relate_free('+data['datos'][i].id_port+','+data['datos'][j].id_port+');" title="Liberar puertos relacionados"> <i class="fa fa-trash-o"> </i></a>';
                                valor += '</td></tr>';
                                $("#list_ports_relate").append(valor);
                            }
                        }
                    }

                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function search_antena_odu_new(board, model, type){
    var modal = document.getElementById('cerrar_radio_odu_antena_editar');
    var aceptar = document.getElementById("save_odu_antena");
    var cancelar = document.getElementById("cancel_odu_antena");
    $("#ante_odu_id").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/nueva/antena/odu',
        data: {board:board,model:model,type:type,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        $("#ante_odu_id").append('<option value="'+data['datos'][i]['id']+'">'+data['datos'][i]['model']+'</option>').trigger('change.select2');
                    })
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var id = document.getElementById('ante_odu_id').value;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'guardar/nueva/antena/odu',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        detal_port_radio_antena_odu(data['datos'],1);
                        modal.click();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                }
            },
            error: function(data) {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function modal_relate_ports_agg(id){
    document.querySelectorAll('#agg_chain_A option').forEach(option => option.remove());
    document.querySelectorAll('#agg_chain_B option').forEach(option => option.remove());
    $("#campo_coment_1").hide();
    $("#campo_coment_2").hide();
    $("#chain_port_first").html('');
    $("#chain_port_second").html('');

    $('#id_equipment').val(id);


    $("#agg_chain_A").append('<option selected disabled value="">seleccionar</option>');
    $("#agg_chain_B").append('<option selected disabled value="">seleccionar</option>');

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'relacionar/puerto/agregador',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(h, v){
                        $("#agg_chain_A").append('<option value="'+ data['datos'][h].id +'">' + data['datos'][h].acronimo + '</option>');
                        $("#agg_chain_B").append('<option value="'+ data['datos'][h].id +'">' + data['datos'][h].acronimo + '</option>');
                    });
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function ckChange(ckType){
    var ckName = document.getElementsByName(ckType.name);
    var checked = document.getElementById(ckType.id);

    if (checked.checked) {
        for(var i=0; i < ckName.length; i++){

            if(!ckName[i].checked){
                ckName[i].disabled = true;
            }else{
                ckName[i].disabled = false;
            }
        }
    }
    else {
        for(var i=0; i < ckName.length; i++){
            ckName[i].disabled = false;
        }
    }
}

function save_relate_ports(){
    var chain_id = $("#chain_id").val();
    let puerto_a = $('#puerto_A').val();
    let puerto_b = $('#puerto_B').val();
    let coment_a = $('#coment_1').val();
    let coment_b = $('#coment_2').val();

    let selec_a = $('#agg_chain_A option:selected').val();
    let selec_b = $('#agg_chain_B option:selected').val();

    $('#selectorId option:selected').val();
    var modal = document.getElementById('relacionar_puertos_agg_cerrar_pop');

    if (puerto_a != "" && puerto_b != "" && (puerto_a != puerto_b)){
        if(selec_a != selec_b){
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL()+'relacionar/puertos/agregadores/cadena',
                data: {puerto_a:puerto_a, puerto_b:puerto_b, coment_a:coment_a, coment_b:coment_b},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            toastr.success("Se guardo correctamente la relacion de puertos");
                            modal.click();
                            show_relate_ports(chain_id);
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            break;
                        case "nop":
                            toastr.error("Puerto Ocupado");
                            break;
                    }
                },
                error: function(data) {
                    toastr.error("Error con el servidor");
                }
            });
        } else{
            toastr.error("Seleccione 2(Dos) equipos distintos");
        }
    } else{
        if(puerto_a == puerto_b){
            toastr.error("Seleccione 2 puertos distintos!");
        } else{
            toastr.error("Seleccione 2 puertos, por favor");
        }
    }
}
function show_ports_chain_A(){
    $("#list_new_port_radio").empty();
    var id = document.getElementById('agg_chain_A').value;
    if(id != ""){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'mostrar/puertos/agregador',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="port_agg'+data['datos'][i]['id']+'">'+data['datos'][i]['port']+'</td>' +
                                '<td>'+data['datos'][i]['tipo_puerto']+'</td>' +
                                '<td>'+data['datos'][i]['status']+'</td>' +
                                '<td>'+data['datos'][i]['bw']+'</td>' +
                                '<td>'+data['datos'][i]['atributo']+'</td>' +
                                '<td>';
                            if(data['datos'][i]['connected_to'] == null){
                                valor +='<a title = "Seleccionar" onclick="new_port_chain_A('+data['datos'][i]['id']+');"> <i class="fa fa-bullseye"> </i></a>';
                            }else{
                                valor +='<i class="fa fa-unlock-alt" style="color: coral;" title="Esta conectado a otro puerto"></i>'
                            }
                            valor += '</td></tr>';
                            $("#list_new_port_radio").append(valor)
                        });
                        break;
                    case "nop":
                        toastr.error("No tiene placa");
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
    } else{
        toastr.error("Selecciona primero el agregador");
    }

}

function show_ports_chain_B(){
    $("#list_new_port_radio").empty();
    var id = document.getElementById('agg_chain_B').value;
    if(id != ""){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'mostrar/puertos/agregador',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="port_agg'+data['datos'][i]['id']+'">'+data['datos'][i]['port']+'</td>' +
                                '<td>'+data['datos'][i]['tipo_puerto']+'</td>' +
                                '<td>'+data['datos'][i]['status']+'</td>' +
                                '<td>'+data['datos'][i]['bw']+'</td>' +
                                '<td>'+data['datos'][i]['atributo']+'</td>' +
                                '<td>';
                            if(data['datos'][i]['connected_to'] == null){
                                valor +='<a title = "Seleccionar" onclick="new_port_chain_B('+data['datos'][i]['id']+');"> <i class="fa fa-bullseye"> </i></a>';
                            }else{
                                valor +='<i class="fa fa-unlock-alt" style="color: coral;" title="Esta conectado a otro puerto"></i>'
                            }
                            valor += '</td></tr>';
                            $("#list_new_port_radio").append(valor);
                        });
                        break;
                    case "nop":
                        toastr.error("No tiene placa");
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
    } else{
        toastr.error("Selecciona primero el agregador");
    }
}

function new_port_chain_A(id){
    var modal = document.getElementById("cerra_new_port_radio");
    var text_port = $('#port_agg'+id).text();
    var port = $("#chain_port_first");
    port.empty();
    port.html('<input type="text" id="'+id+'" name="puerto_id_'+id+'" readonly="readonly" class="form-control" value="'+text_port+'"></input>');
    $("#puerto_A").val(id);
    $("#coment_1").val('');
    $("#campo_coment_1").fadeIn(1300);

    modal.click();
}

function new_port_chain_B(id){
    var modal = document.getElementById("cerra_new_port_radio");
    var text_port = $('#port_agg'+id).text();
    var port = $("#chain_port_second");
    port.empty();
    port.html('<input type="text" id="'+id+'" name="puerto_id_'+id+'" readonly="readonly" class="form-control" value="'+text_port+'"></input>');
    $("#puerto_B").val(id);
    $("#coment_2").val('');
    $("#campo_coment_2").fadeIn(1300);

    modal.click();
}

function limpiar_puertos_A(){
    $("#chain_port_first").html('');
};
function limpiar_puertos_B(){
    $("#chain_port_second").html('');
}

function port_relate_free(puerto_a, puerto_b){
    var chain_id = $("#chain_id").val();
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    modal0.style.display = "block";
    mensaje.textContent  = "Esta seguro que desea eliminar la conexion?";
    aceptar.onclick = function() {
        modal0.style.display = "none";
        modal.click();
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'eliminar/relacion',
            data: {puerto_a:puerto_a, puerto_b:puerto_b},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "Exist":
                        toastr.error("Alguna IP de este Rango esta siendo usada");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        show_relate_ports(chain_id);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal0.style.display = "none";
    }
}
function list_agg_chain_equipment_a(){
    let id = $("#id_equipment").val();
    $("#list_equipment_chain").empty();

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'mostrar/equipos/cadena',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td id="port_equip'+data['datos'][i]['id']+'">'+data['datos'][i]['acronimo']+'</td>' +
                            '<td>'+data['datos'][i]['ip_gestion']+'</td>' +
                            '<td>'+data['datos'][i]['commentario']+'</td>' +
                            '<td> <a title = "Seleccionar" onclick="select_equipment_a('+data['datos'][i]['id']+');"> <i class="fa fa-bullseye"> </i></a>';
                        valor += '</td></tr>';
                        $("#list_equipment_chain").append(valor)
                    });
                    break;
                case "nop":
                    toastr.error("Error de datos");
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
}

function select_equipment_a(id){
    document.querySelectorAll('#agg_chain_A option').forEach(option => option.remove());

    var modal = document.getElementById("cerra_bus_equipo_agg");
    var text_equipment = $('#port_equip'+id).text();
    $("#agg_chain_A").append('<option selected value="'+ id +'">' + text_equipment + '</option>');

    $("#chain_port_first").html('');
    modal.click();
}

function list_agg_chain_equipment_b(){
    let id = $("#id_equipment").val();
    $("#list_equipment_chain").empty();

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'mostrar/equipos/cadena',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td id="port_equip'+data['datos'][i]['id']+'">'+data['datos'][i]['acronimo']+'</td>' +
                            '<td>'+data['datos'][i]['ip_gestion']+'</td>' +
                            '<td>'+data['datos'][i]['commentario']+'</td>' +
                            '<td> <a title = "Seleccionar" onclick="select_equipment_b('+data['datos'][i]['id']+');"> <i class="fa fa-bullseye"> </i></a>';
                        valor += '</td></tr>';
                        $("#list_equipment_chain").append(valor)
                    });
                    break;
                case "nop":
                    toastr.error("Error de datos");
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
}
function select_equipment_b(id){
    document.querySelectorAll('#agg_chain_B option').forEach(option => option.remove());

    var modal = document.getElementById("cerra_bus_equipo_agg");
    var text_equipment = $('#port_equip'+id).text();
    $("#agg_chain_B").append('<option selected value="'+ id +'">' + text_equipment + '</option>');

    $("#chain_port_second").html('');
    modal.click();
}

function agregar_puertos_agg_cadena(id){
    $("#buton_save").attr("onclick","save_changes_port_list()");
    var chain_id = $("#chain_id").val();
    var new_tbody = document.createElement('tbody');
    $("#por_alta_servicio").html(new_tbody)
    if (id == '' || id.length == 0) {
        toastr.error("Seleccione el Equipo");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'listar/filtrar/puertos/cadena',
            data: {id:id, chain_id:chain_id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        //console.log(data['datos']);
                        if (data['resul'] == 'nop') {
                            toastr.error("No tiene puerto disponible este agregador");
                        }else{
                            $(data['datos']).each(function(i, v){ // indice, valor
                                var valor = '<tr>' +
                                    '<td>' + data['datos'][i]['label'] + data['datos'][i]['f_s_p'] + data['datos'][i]['por_selec'] + '</td>';
                                /* if (data['datos'][i]['type'] != "ANILLO") {
                             valor += '<td>' + data['datos'][i]['atributo'] + '</td>';
                         }else{
                             valor += '<td>' + data['datos'][i]['type'] + '</td>';
                         }
                         */
                                valor += '<td>' + data['datos'][i]['atributo'] + '</td>';
                                valor += '<td>' + data['datos'][i]['service'] + '</td>';

                                if(data['datos'][i]['type'] != null){
                                    valor += '<td>' + data['datos'][i]['type'] + '</td>';
                                }else{
                                    valor += '<td> </td>';
                                }

                                valor += '<td>' + data['datos'][i]['commentary'] + '</td>';
                                if (data['datos'][i]['atributo'] == 'VACANTE') {
                                    valor += '<td><input type="checkbox" id='+[i]+' name="port_chain[]" value="'+data['datos'][i]['id']+'">';
                                }else{
                                    if (data['datos'][i]['type'] != "ANILLO") {
                                        if(data['datos'][i]['type'] == "CADENA"){
                                            if(data['datos'][i]['connected_to'] != null){
                                                //Si el puerto esta conectado a otro mediante una cadena
                                                valor +='<td> <i class="fa fa-chain-broken" style="color: coral;" title="Esta conectado al puerto '+data['datos'][i]['connected_to']+'"></i>';
                                            }else{
                                                //valor += '<td><input type="checkbox" id='+[i]+' name="port_chain[]" value="'+data['datos'][i]['id']+'" checked>';
                                                valor +='<td> <i class="fa fa-check" style="color: coral;" title="Puerto de la cadena"></i>';
                                            }
                                        } else{
                                            valor +='<td> <i class="fa fa-unlock-alt" style="color: coral;" title="Esta ocupado"></i>';
                                        }
                                    }else{
                                        valor +='<td> <i class="fa fa-circle-o-notch" style="color: coral;" title="Puerto del anillo"></i>';
                                    }
                                }
                                valor += '</tr>';
                                $("#por_alta_servicio").append(valor)
                            })
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function quitar_puertos_agg_cadena(id){
    $("#buton_save").attr("onclick","delete_changes_port_list()");
    var new_tbody = document.createElement('tbody');
    $("#por_alta_servicio").html(new_tbody)
    if (id == '' || id.length == 0) {
        toastr.error("Seleccione el Equipo");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'listar/filtrar/puertos/cadena',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        //console.log(data['datos']);
                        if (data['resul'] == 'nop') {
                            toastr.error("No tiene puerto disponible este agregador");
                        }else{
                            $(data['datos']).each(function(i, v){ // indice, valor
                                if(data['datos'][i]['type'] == "CADENA" && data['datos']){
                                    var valor = '<tr>' +
                                        '<td>' + data['datos'][i]['label'] + data['datos'][i]['f_s_p'] + data['datos'][i]['por_selec'] + '</td>';
                                    valor += '<td>' + data['datos'][i]['atributo'] + '</td>';
                                    valor += '<td>' + data['datos'][i]['service'] + '</td>';

                                    if(data['datos'][i]['type'] != null){
                                        valor += '<td>' + data['datos'][i]['type'] + '</td>';
                                    }else{
                                        valor += '<td> </td>';
                                    }

                                    valor += '<td>' + data['datos'][i]['commentary'] + '</td>';
                                    if (data['datos'][i]['atributo'] == 'VACANTE') {
                                        valor +='<td> <i class="fa fa-ban" style="color: coral;" title="No es parte de la cadena"></i>';
                                    }else{
                                        if (data['datos'][i]['type'] != "ANILLO") {
                                            if(data['datos'][i]['type'] == "CADENA"){
                                                if(data['datos'][i]['connected_to'] != null){
                                                    //Si el puerto esta conectado a otro mediante una cadena
                                                    valor +='<td> <i class="fa fa-chain-broken" style="color: coral;" title="Esta conectado al puerto '+data['datos'][i]['connected_to']+'"></i>';
                                                }else{
                                                    valor += '<td><input type="checkbox" id='+[i]+' name="port_chain[]" value="'+data['datos'][i]['id_port']+'">';
                                                }
                                            } else{
                                                valor +='<td> <i class="fa fa-minus-circle" style="color: coral;" title="Esta ocupado"></i>';
                                            }
                                        }else{
                                            valor +='<td> <i class="fa fa-circle-o-notch" style="color: coral;" title="Puerto del anillo"></i>';
                                        }
                                    }
                                    valor += '</tr>';
                                    $("#por_alta_servicio").append(valor)
                                }
                            })
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function save_changes_port_list(){
    var modal = document.getElementById('exit_port_chain');
    var chain_id = $("#chain_id").val();
    var ports = [];
    $('#por_alta_servicio input:checked').each(function() {
        ports.push($(this).val());
    });
    if(ports.length > 0){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'guardar/puertos/seleccionados',
            data: {ports:ports, chain_id:chain_id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "Exist":
                        toastr.error("Alguna IP de este Rango esta siendo usada");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        modal.click();
                        chain_equipment_agg(chain_id);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    else{
        toastr.error("No hay puertos seleccionados");
    }
}
function delete_changes_port_list(){
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    modal0.style.display = "block";
    mensaje.textContent  = "Esta seguro que desea borrar estos puertos?";
    var modal = document.getElementById('exit_port_chain');

    var chain_id = $("#chain_id").val();
    var selected = [];
    $('#por_alta_servicio input:checked').each(function() {
        selected.push($(this).val());
    });
    console.log(selected);
    if(selected.length > 0){

        aceptar.onclick = function() {
            modal0.style.display = "none";
            modal.click();
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL()+'borrar/puertos/agregador/seleccionados',
                data: {selected:selected},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            break;
                        case "Exist":
                            toastr.error("Alguna IP de este Rango esta siendo usada");
                            break;
                        case "yes":
                            toastr.success("Modificación Exitosa");
                            modal.click();
                            chain_equipment_agg(chain_id);
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
        cancelar.onclick = function() {
            modal0.style.display = "none";
        }
    }
}
function delete_empty_chain(id){
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    modal0.style.display = "block";
    mensaje.textContent  = "Esta seguro que desea borrar esta cadena?";

    var chain_id = $("#chain_id").val();
    console.log(chain_id);

    aceptar.onclick = function() {
        modal0.style.display = "none";
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'borrar/cadena',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "Exist":
                        toastr.error("La cadena tiene agregadores asociados");
                        break;
                    case "yes":
                        toastr.success("Modificación Exitosa");
                        $('#list_cadena').DataTable().ajax.reload();

                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal0.style.display = "none";
    }
}


function eliminar_rama(id) {
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'borrar/rama/ip',
        data: {id:id,},
        dataType: 'json',
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
                    toastr.error("Tiene IP ocupada");
                    break;
                case "yes":
                    eliminar_mas_rama(data['datos']);
                    ver_mas_rama(data['datos']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function create_reserve(){
    document.getElementById("alta_reserva").reset();
    let reserva_inicio = $("#date_reserve");
    let reserva_fin = $("#end_reserve");

    let date = new Date();
    reserva_inicio.val(format_day(date));

    var d = new Date();
    d.setDate(d.getDate() + 90);
    reserva_fin.val(format_day(d));

//Info BW cuadrado amarillo
    $("#bw_limit_info").html('0');
    $("#bw_used_info").html('0');
    $("#bw_pre_reserved").html('0');
    $("#bw_available").html('0');
    $("#proggressbar_link_info").css("width", "0%");

//Info Link + Celda cuadrado amarillo
    $("#status_node").empty();
    $("#node_info_plus").empty();
    $("#commentary_node_info").empty();
    $("#status_link").empty();
    $("#commentary_link_info").empty();

    $("#nodo_al_lsw").find('option').remove();
    $("#nodo_al_lsw").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#id_link").find('option').remove();
    $("#id_link").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#client_sub_red").find('option').remove();
    $("#client_sub_red").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');

    var aceptar = document.getElementById("alta_reserve");
    var cancelar = document.getElementById("cerrar_reserva_pop");
    var modal = document.getElementById("cerrar_reserva_pop");
    aceptar.onclick = function() {
        var number_reserve = document.getElementById("nro_reserva").value;
        var id_link = document.getElementById("id_link").value;
        var id_cliente = document.getElementById("client_sub_red").value;
        var bw_input = document.getElementById("BW_chain").value;
        //var id_user = document.getElementById("commentary_chain").value;
        //var quantity_dates = document.getElementById("commentary_chain").value;
        var oportunity = document.getElementById("oportunity").value;
        var id_service_type = document.getElementById("id_type_service").value;
        var commentary = document.getElementById("commentary_chain").value;
        var cell_status = document.getElementById("status_node").innerHTML;

        var bw_available = document.getElementById("bw_available").innerHTML*1024;
        var cell_bw_link = document.getElementById("bw_limit_info").innerHTML*1024;
        var cell_bw_usado = document.getElementById("bw_used_info").innerHTML*1024;
        var cell_bw_reserved = document.getElementById("bw_pre_reserved").innerHTML*1024;
        if($("#bw_size_info").text() != 'Mbps'){
            if($("#bw_size_info").text() == 'Gbps'){
                cell_bw_link = document.getElementById("bw_limit_info").innerHTML * 1048576 ;
            } else{
                cell_bw_link = document.getElementById("bw_limit_info").innerHTML;
            }
        }
        if($("#bw_used_size").text() != 'Mbps'){
            if($("#bw_used_size").text() == 'Gbps'){
                cell_bw_usado = document.getElementById("bw_used_info").innerHTML * 1048576 ;
            } else{
                cell_bw_usado = document.getElementById("bw_used_info").innerHTML;
            }
        }
        if($("#bw_pre_reserve_size").text() != 'Mbps'){
            if($("#bw_pre_reserve_size").text() == 'Gbps'){
                cell_bw_reserved = document.getElementById("bw_pre_reserved").innerHTML * 1048576 ;
            } else{
                cell_bw_reserved = document.getElementById("bw_pre_reserved").innerHTML;
            }
        }
        if($("#bw_available_size").text() != 'Mbps'){
            if($("#bw_available_size").text() == 'Gbps'){
                bw_available = document.getElementById("bw_available").innerHTML * 1000000 ;
            } else{
                bw_available = document.getElementById("bw_available").innerHTML;
            }
        }
        var bw_max_size = document.getElementById("bw_max_size").value;
        var bw_reserve = 0;
        switch(bw_max_size){
            case '0':
                toastr.error("Selecciona el tipo de bw");
                return;
            case '1':
                bw_reserve = bw_input;
                break;
            case '2':
                bw_reserve = bw_input*1024;
                break;
            case '3':
                bw_reserve = bw_input*1048576;
                break;
            default:
                bw_reserve = bw_input;
        }
        if(bw_available <= 0){
            swal("Error de bw remanente", "El bw remanente no puede ser negativo, notificar a DL - AR - Ing. Calidad y Capacidad", "error");
            $('#informacion_todo_pop').modal('show');
            return;
        }
        if(bw_reserve <= 0 || bw_reserve == ''){
            swal("Valor Incorrecto", "El bw ingresado no es valido", "error");
            return;
        } else if(bw_available < bw_reserve){
            swal("Limite alcanzado!", "El valor ingresado ("+ bw_reserve +" kbps) supera el bw remanente permitido ("+ bw_available + $("#bw_available_size").text() +")", "error");
            return;
        }

        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/reserva',
            data: {number_reserve:number_reserve,id_link:id_link,id_cliente:id_cliente,bw_reserve:bw_reserve,oportunity:oportunity,id_service_type:id_service_type,commentary:commentary,cell_status:cell_status,cell_bw_link:cell_bw_link, cell_bw_usado:cell_bw_usado, cell_bw_reserved:cell_bw_reserved},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        new Clipboard('.btn');
                        let pop_end_date = $(".end_date");
                        let pop_start_date = $(".start_date");
                        let pop_status_node = $(".info_status_node");
                        let pop_status_link = $(".info_status_link");
                        let pop_bw_reserved = $(".info_bw_reserved");
                        let pop_commentary = $(".info_comentary");
                        let number_reserve_span = $(".number_reserve_span");

                        $('#list_reserve').DataTable().ajax.reload();
                        modal.click();

                        $("#nro_reserva").html('');
                        pop_status_node.html('');
                        pop_status_link.html('');
                        pop_bw_reserved.html('');
                        number_reserve_span.html('');
                        pop_commentary.html('');

                        $("#nro_reserva").html(data['data'][0]['nro_reserve'])
                        number_reserve_span.html("#"+data['data'][0]['nro_reserve']);
                        pop_end_date.html(reserva_inicio.val());
                        pop_start_date.html(reserva_fin.val());
                        pop_status_node.html(data['data'][0]['status_node']);
                        pop_status_link.html(data['data'][0]['status_link']);
                        pop_bw_reserved.html(data['data'][0]['bw_reserved']);
                        pop_commentary.html(data['data'][0]['commentary']);

                        $('#pop_small_info').modal('show');

                        break;
                    case "port":
                        toastr.error("Seleccionar Equipo y Puerto");
                        break;
                    case "nop":
                        toastr.error("Puerto Ocupado");
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function select_link_list(){
    $("#list_selected_links").empty();
    var id = document.getElementById('nodo_al_lsw').value;
    if(id != ""){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'listar/links/nodo',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $(data['data']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="link_name'+data['data'][i]['id']+'">'+data['data'][i]['name']+'</td>' +
                                '<td>'+data['data'][i]['type']+'</td>' +
                                '<td>'+data['data'][i]['bw']+'</td>' +
                                '<td>'+data['data'][i]['node']+'</td>' +
                                '<td>'+data['data'][i]['commentary']+'</td>' +
                                '<td> <a title = "Seleccionar" onclick="select_link('+data['data'][i]['id']+');"> <i class="fa fa-bullseye"> </i></a></td>';
                            valor += '</tr>';
                            $("#list_selected_links").append(valor);
                        });
                        break;
                    case "nop":
                        toastr.error("Error imprevisto");
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
    } else{
        toastr.error("Selecciona primero el link");
    }
}

function select_link(id){
    var modal = document.getElementById("cerrar_buscar_link_pop");
    var text_link = $('#link_name'+id).text();
    var link_input = $("#id_link");
    $("#id_link").find('option').remove();
    $("#id_link").append('<option selected value="'+ id +'">' + text_link + '</option>');
//Cargar info cuadrado amarillo

    let status_link = $("#status_link");
    let proggressbar_link_info = $("#proggressbar_link_info");
    let commentary_link_info = $("#commentary_link_info");
    let bw_limit_info = $("#bw_limit_info");
    let bw_size_info = $("#bw_size_info");
    let bw_used_info = $("#bw_used_info");
    let bw_used_size = $("#bw_used_size");
    let bw_available = $("#bw_available");

    let bw_available_size = $("#bw_available_size");
    let bw_pre_reserve = $("#bw_pre_reserved");
    let bw_pre_reserve_size = $("#bw_pre_reserve_size");
    let status_node = $("#status_node");
    let commentary_node_info = $("#commentary_node_info");
    let node_info_plus = $("#node_info_plus");

    let id_link = link_input.val();
    if(id_link != ""){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url:getBaseURL()+'info/link',
            data: {id_link:id_link},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        //Celda
                        let bw_limit = 0;
                        status_node.html(data['data'][0]['status_node']);
                        commentary_node_info.html(data['data'][0]['commentary_node']);
                        node_info_plus.html(data['data'][0]['node_info_plus'])
                        //Link
                        status_link.html(data['data'][0]['status']);
                        if(data['data'][0]['status'] == 'ALTA'){
                            proggressbar_link_info.css("width", "100%");
                        } else{
                            proggressbar_link_info.css("width", "100%");
                            proggressbar_link_info.addClass( "bg-danger" );
                            toastr.warning('La celda uplink no esta habilitada');
                        }
                        commentary_link_info.html(data['data'][0]['commentary']);
                        bw_limit_info.text(data['data'][0]['bw']);
                        bw_size_info.text(data['data'][0]['bw_size']);
                        bw_used_info.text(data['data'][0]['bw_used_info']);
                        bw_used_size.text(data['data'][0]['bw_used_size']);
                        bw_pre_reserve.text(data['data'][0]['bw_pre_reserve']);
                        bw_pre_reserve_size.text(data['data'][0]['bw_pre_reserve_size']);
                        bw_available.text(data['data'][0]['bw_available']);
                        bw_available_size.text(data['data'][0]['bw_available_size']);

                        if(data['data'][0]['status_node'] == "NO APTA"){
                            swal("Cuidado!", "La celda tiene un contrato vencido", "warning");
                        }
                        break;
                    case "nop":
                        toastr.error("Error imprevisto");
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
    } else{
        toastr.error("Error al buscar informacion del link");
    }

    modal.click();
}
function cancell_reserve(id){
    swal({
        title: "Estás seguro?",
        text: "Estás por cancelar una reserva!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, cancelar!",
        cancelButtonText: "No, volver",
        closeOnConfirm: false,
    },function (isConfirm) {
        if (!isConfirm) return;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'cancelar/reserva',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        swal("Error al borrar!", "Por favor intentar luego", "error");
                        break;
                    case "Exist":
                        swal("Error Imprevisto!", "Por favor intentar luego", "error");
                        break;
                    case "yes":
                        swal("Cancelada!", "La reserva ha sido cancelada.", "success");
                        $('#list_reserve').DataTable().ajax.reload();
                        break;
                }
            },
            error: function() {
                swal("Error al borrar!", "Por favor intentar luego", "error");
            }
        });
    });
}

function reserve_detail(id){
    if(id.length == 0){}else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'info/reserva/nodo',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        toastr.error("No se recibe correctamente la reserva");
                        break;
                    case "yes":
                        let status_node = $("#status_node_pop_info");
                        let node_bw = $("#node_bw_pop_info");
                        let node_bw_size = $("#node_bw_pop_info_size");
                        let node_bw_used = $("#node_bw_used_pop_info");
                        let node_bw_used_size = $("#node_bw_used_size_pop_info");
                        let node_bw_reserved = $("#node_bw_reserved_pop_info");
                        let node_bw_reserved_size = $("#node_bw_reserved_pop_info_size");
                        let node_bw_remanent = $("#node_bw_remanent_pop_info");
                        let node_bw_remanent_size = $("#node_bw_remanent_pop_info_size");

                        status_node.text(data['data']['status']);
                        node_bw.text(data['data']['cell_bw']);
                        node_bw_size.text(data['data']['cell_bw_size']);
                        node_bw_used.text(data['data']['bw_used']);
                        node_bw_used_size.text(data['data']['bw_used_size']);
                        node_bw_reserved.text(data['data']['cell_bw_reserved']);
                        node_bw_reserved_size.text(data['data']['cell_bw_reserved_size']);
                        node_bw_remanent.text(data['data']['bw_available']);
                        node_bw_remanent_size.text(data['data']['bw_available_size']);

                        $(".info_number_reserve").html(data['data']['number_reserve'])
                        $(".info_name_node").html(data['data']['node'])
                        $(".info_name_link").html(data['data']['link'])
                        $(".info_bw_reserved").html(data['data']['bw_reserve'] + "[" + data['data']['bw_reserve_size'] + "]")
                        $(".oportunitty").html(data['data']['oportunity'])
                        $(".client").html(data['data']['client'])
                        $(".info_comentary").html(data['data']['commentary'])
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}
function reserve_edit_modal(id){
//swal("Todavia en desarrollo", " ... pero el id de esta reserva es: "+id+"!");

    document.getElementById("edit_alta_reserve").reset();
    var aceptar = document.getElementById("edit_alta_reserve_save");
    var cancelar = document.getElementById("edit_cancell_reserve");
    var modal = document.getElementById("pop_edic_alta_reserve_close");
    $('#id_reserve_edit').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'buscar/reserva',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    var fecha = new Date(data['data']['date_start']);
                    var dias = data['data']['quantity_dates']; // Número de días a agregar
                    var dia_final = new Date();
                    var end_date = new Date(fecha.setDate(fecha.getDate() + dias)).toISOString().split("T")[0];

                    $("#edic_nodo_al_lsw").append('<option selected disabled value="">'+ data['data']['node'] +'</option>').trigger('change.select2');
                    $("#edic_id_link").append('<option selected disabled value="">'+ data['data']['link'] +'</option>').trigger('change.select2');
                    $("#edic_client_sub_red").append('<option selected disabled value="'+data['data']['client_id']+'">'+ data['data']['client'] +'</option>').trigger('change.select2');
                    $("#bw_limit_pop_info").val(data['data']['bw_limit']);
                    $(".bw_limit_pop_info").html(data['data']['bw_limit']);
                    $('#edic_number_reserve').html('#'+data['data']['number_reserve']);
                    $('#edic_oportunity').val(data['data']['oportunity']);
                    $('#edic_id_type_service').val(data['data']['id_service_type']);
                    $('#edic_BW_reserve').val(data['data']['bw']);
                    $('#edic_commentary_reserve').val(data['data']['commentary']);
                    $('#edit_date_reserve').val(data['data']['date_start']);
                    $('#edit_end_reserve').val(end_date);
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        swal({
            title: "Guardar cambios?",
            text: "Configurar cambios de la reserva!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, guardar!",
            cancelButtonText: "No, deshacer",
            closeOnConfirm: false,
        },function (isConfirm) {
            if (!isConfirm) return;
            var id_reserve = document.getElementById("id_reserve_edit").value;
            var id_cliente = document.getElementById("edic_client_sub_red").value;
            var oportunity = document.getElementById("edic_oportunity").value;
            var edic_id_type_service = document.getElementById("edic_id_type_service").value;
            var BW = document.getElementById("edic_BW_reserve").value;
            var max = document.getElementById("edic_bw_max_size").value;
            var commentary = document.getElementById("edic_commentary_reserve").value;
            var bw_reserve_edit = 0;
            let bw_limit_pop_info = $("#bw_limit_pop_info").val();

            switch(max){
                case '':
                    toastr.error("Selecciona el tipo de bw");
                    return;
                case '1':
                    bw_reserve_edit = BW;
                    bw_limit_pop_info = bw_limit_pop_info*10;
                    break;
                case '2':
                    bw_reserve_edit = BW*1024;
                    break;
                case '3':
                    bw_reserve_edit = BW*1048576;
                    break;
            }
            if(bw_limit_pop_info < 0){
                swal("Error limite!", "Id reserva: "+id_reserve+ "Por favor contactar con soporte de Jarvis", "error")
                $('#informacion_todo_pop').modal('show');
                return;
            }
            if(bw_reserve_edit <= 0 || bw_reserve_edit == ''){
                swal("Valor Incorrecto", "El bw ingresado no es valido", "error");
                return;
            }
            if(bw_limit_pop_info > bw_reserve_edit){
                $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
                $.ajax({
                    type: "POST",
                    url: getBaseURL()+'modificar/reserva',
                    data: {id_reserve:id_reserve, id_cliente:id_cliente, oportunity:oportunity, edic_id_type_service:edic_id_type_service, bw_reserve_edit:bw_reserve_edit, commentary:commentary},
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        switch (data['resul']) {
                            case "login":
                                refresh();
                                break;
                            case "autori":
                                swal("Error al modificar reserva!", "Por favor intentar luego", "error");
                                break;
                            case "no":
                                swal("Error Imprevisto!", "Por favor intentar luego", "error");
                                break;
                            case "bw_limit":
                                swal("Error bw!", "El bw ingresado es mayor al bw limite", "error");
                                break;
                            case "yes":
                                swal("Modificacion exitosa!", "Los cambios han sido guardados", "success");
                                $('#list_reserve').DataTable().ajax.reload();
                                modal.click();
                                break;
                            default:
                                swal("???? Error desconocido ???","error");
                        }
                    },
                    error: function() {
                        swal("Error al modificar!", "Por favor intentar luego", "error");
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors['errors'], function (ind, elem) {
                            toastr.error(elem);
                        });
                    }
                });
            } else{
                swal("Limite alcanzado!", "El valor ingresado ("+ bw_reserve_edit +" kbps) supera el bw remanente permitido ("+ bw_limit_pop_info +" kbps)", "error");
                return;
            }

        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function add_time_reserve(id){
    swal({
        title: "Agregar tiempo dias a la reserva?",
        text: "Estás por agregar 30 dias al vencimiento!",
        type: "info",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, agregar!",
        cancelButtonText: "No, volver",
        closeOnConfirm: false,
    },function (isConfirm) {
        if (!isConfirm) return;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'agregar/tiempo/reserva',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        swal("Error al agregar tiempo!", "Por favor intentar luego", "error");
                        break;
                    case "no":
                        swal("Error Imprevisto!", "Por favor intentar luego", "error");
                        break;
                    case "yes":
                        swal("Modificacion exitosa!", "El tiempo de reserva ahora es de 120 dias.", "success");
                        $('#list_reserve').DataTable().ajax.reload();
                        break;
                }
            },
            error: function() {
                swal("Error al borrar!", "Por favor intentar luego", "error");
            }
        });
    });
}
////// Fin Reserva /////
function create_new_ring_ipran(){
    var modal = document.getElementById('cerrar_anillo_ipran');
    var cancelar = document.getElementById("ring_ipran_exi");
    var aceptar = document.getElementById("ring_ipran_new");
    var lsw = $("#id_lsw");
    document.getElementById("anillo_ipran").reset();
    $("#campos_port_ipran").empty();
    $("#campos_vlan_ring_ipran").empty();
    $('#ipran_vlan_ls_arr').val('');
    $("#nodo_all").find('option').remove();
    $("#nodo_all").append('<option selected disabled value="">seleccionar</option>');
    $("#ipran_vlan_ls").find('option').remove();
    $("#ipran_vlan_ls").append('<option selected disabled value="0">0000</option>');
    $("#ipran_vlan_radio").find('option').remove();
    $("#ipran_vlan_radio").append('<option selected disabled value="0">0000</option>');
    lsw.find('option').remove();
    lsw.append('<option selected disabled value="">seleccionar</option>');
    lsw.off();
    lsw.on('change.select2', function() {
        $("#ipran_vlan_ls").find('option').remove();
        $("#ipran_vlan_ls").append('<option selected disabled value="0">0000</option>');
        $("#ipran_vlan_radio").find('option').remove();
        $("#ipran_vlan_radio").append('<option selected disabled value="0">0000</option>');
        get_free_vlans(3);
        get_free_vlans(4);
    });
    $('#ipran_vlan_ls_arr').off().on('change', function() {
        next_vlan(3);
    });
    aceptar.onclick = function() {
        var nodo = document.getElementById('nodo_all').value;
        var lsw = document.getElementById('id_lsw').value;
        var ipran_acro = document.getElementById('ipran_acro_ring').value;
        var commen = document.getElementById('commen_ring_ipran').value;
        var dedica = document.getElementById('dedica_ipran').value;
        var type = document.getElementById('type_ipran').value;
        var vlan_ls = document.getElementById('ipran_vlan_ls').value;
        var vlan_radio = document.getElementById('ipran_vlan_radio').value;
        var ip_ls = document.getElementById('ipran_ip_ls_id').value;
        var ip_radio = document.getElementById('ipran_ip_radio_id').value;
        var port_all = document.getElementsByClassName("port_ring_ipran_new");
        var vlan_all = [];
        var port = [];
        if (ip_ls == ip_radio) {
            toastr.error("La Ip de Gestión LS y Radio deben ser distintas.");
            return;
        }
        vlan_all[0] = `1_${vlan_ls}_${ip_ls}`;
        if (!empty(vlan_radio) && vlan_radio != '0') {
            if (!empty(ip_radio) && ip_radio != '0') {
                vlan_all[1] = `2_${vlan_radio}_${ip_radio}`;
            } else {
                toastr.error("Debe especificar una IP de Gestión Radio.");
                return;
            }
        }

        for (var i = 0; i < port_all.length; ++i) {
            if (typeof port_all[i].value !== "undefined") {
                port.push(port_all[i].value);
            }
        }

        var data = {id:0,nodo:nodo,lsw:lsw,commen:commen,port:port,dedica:dedica,type:type,ipran_acro:ipran_acro,vlan_all:vlan_all};
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/anillo/ipran',
            data: data,
            dataType: 'json',
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
                        toastr.error("Error con el servidor");
                        break;
                    case "yes":
                        $('#anillo_list').DataTable().ajax.reload();
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                    case "ip_exis":
                        toastr.error("El Acronimo ya Existe");
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function sele_lws_ring(id){
    var cerrar = document.getElementById('cerra_bus_equipo_lsw');
    $('#id_lsw').find('option').remove();
//$('#agg').find('option').remove();
    if (id != '' && id !=  null) {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'asignar/equipo',
            data: {id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']){
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        $("#id_lsw").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        //$("#agg").append('<option selected disabled value="'+id+'">'+data['datos']+'</option>').trigger('change.select2');
                        cerrar.click();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        cerrar.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function bw_port_ring_ipran(){
    var id = document.getElementById("id_lsw").value;
    var bw = document.getElementById("bw_port_ipran").value;
    $("#port_all_ring_ipran").empty();
    if (id != '' && bw != null) {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'puerto/ipran/anillo',
            data: {id:id, bw:bw , id_anillo:0},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'nop':
                        toastr.error("No tiene puerto disponible este LSW");
                        break;
                    default:
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var label = data['datos'][i]['f_s_p'];
                            if (data['datos'][i]['f_s_p'] == '@@') {
                                var label = '';
                            }
                            var valor = '<tr>' +
                                '<td>' + data['datos'][i]['label'] + label + data['datos'][i]['por_selec'] + '</td>' +
                                '<td>' + data['datos'][i]['type'] + '</td>' +
                                '<td>' + data['datos'][i]['status'] + '</td>' +
                                '<td>' + data['datos'][i]['commentary'] + '</td>' +
                                '<td>';
                            if (data['datos'][i]['id_status'] == 2) {
                                valor += '<input type="checkbox"  name="port_ipran[]" value="'+data['datos'][i]['por_selec']+'@'+data['datos'][i]['id']+'">';
                            }else{
                                valor += '<i class="fa fa-warning" style="color: coral;"> </i>';
                            }
                            valor += ' <a title = "Detalle de puerto" data-toggle="modal" data-target="#detalle_agg_puerto" onclick="detal_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['por_selec']+');"> <i class="fa fa-twitch"> </i></a>';
                            valor +='</td></tr>';
                            $("#port_all_ring_ipran").append(valor)
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

function port_ring_selec_ipran(){
    let id = [];
    $('#port_all_ring_ipran input[type=checkbox]').each(function(){
        if (this.checked) { id.push($(this).val()); }
    });
// var id_anillo = document.getElementById("id_anillo").value;
    var modal = document.getElementById("exit_port_ipran");
    $("#campos_port_ipran").empty();
    if (id != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'mostrar/puertos',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    default:
                        $(data).each(function(i, v){
                            campo = '<input type="text" readonly="readonly" class="form-control" value="'+data[i]['slot']+data[i]['port']+'">     <input type="hidden" class="port_ring_ipran_new" id="port_ring_ipran_new['+[i]+']" name="port_ring_ipran_new['+[i]+']" value="'+data[i]['port']+'@'+data[i]['board']+'">';
                            $("#campos_port_ipran").append(campo);
                        })
                        break;
                }
                modal.click();
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function format_day(date){
//dd-mm-yyyy
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

//fechas info
    if(month < 10){
        return `${day}-0${month}-${year}`;
//console.log(`${day}-0${month}-${year}`)
    }else{
//console.log(`${day}-${month}-${year}`)
        return `${day}-${month}-${year}`;
    }
}

function selec_anillo_ipran(id){
    var modal = document.getElementById("cerra_bus_anillo");
    $("#id_ring_new").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'seleccionar/anillo/ipran',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "no":
                    toastr.error("No se Encontro el anillo");
                    break;
                case "yes":
                    $("#id_ring_new").append('<option selected value="'+id+'">'+data['name']+' '+data['type']+', Agregador:'+data['acronimo']+'</option>').trigger('change.select2');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    modal.click();
}


// function bw_anillo_ipran_clint(){
//     var id = document.getElementById("equi_alta_lsw").value;
//     var id_anillo = document.getElementById("id_ring_new").value;
//     var bw = document.getElementById("bw_max_ipran").value;
//     var new_tbody = document.createElement('tbody');
//     $("#new_port_ring_ipran_clien").html(new_tbody)
//     $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
//     $.ajax({
//         type: "POST",
//         url: getBaseURL() +'puerto/anillo',
//         data: {id:id, bw:bw , id_anillo:id_anillo},
//         dataType: 'json',
//         cache: false,
//         success: function(data) {
//             switch (data['resul']) {
//                 case 'login':
//                     refresh();
//                 break;
//                 case 'autori':
//                     toastr.error("Usuario no autorizado");
//                 break;
//                 case 'nop':
//                     toastr.error("No tiene puerto disponible este agregador");
//                 break;
//                 default:
//                     $(data['datos']).each(function(i, v){ // indice, valor
//                         var label = '';
//                         if (data['datos'][i]['f_s_p'] != '@@') {
//                             var label = data['datos'][i]['f_s_p'];
//                         }
//                         var valor = '<tr>' +
//                                 '<td>' + data['datos'][i]['label'] + label + data['datos'][i]['por_selec'] + '</td>' +
//                                 '<td>' + data['datos'][i]['type'] + '</td>' +
//                                 '<td>' + data['datos'][i]['status'] + '</td>' +
//                                 '<td>' + data['datos'][i]['commentary'] + '</td>' +
//                                 '<td><input type="checkbox" onclick="checkbo();" name="por'+data['datos'][i]['id']+'" value="'+data['datos'][i]['por_selec']+'@'+data['datos'][i]['id']+'">'+
//                                 ' <a title = "Detalle de puerto" data-toggle="modal" data-target="#detalle_agg_puerto" onclick="detal_port_equipmen('+data['datos'][i]['id']+','+data['datos'][i]['por_selec']+');"> <i class="fa fa-twitch"> </i></a></td>' +
//                             '</tr>';
//                         $("#new_port_ring_ipran_clien").append(valor)
//                     })
//                 break;
//             }
//         },
//         error: function() {
//             toastr.error("Error con el servidor");
//         }
//     });
// }


function port_lanswitch_ipran_cliente(){
    var anilo = document.getElementById("id_ring_new").value;
    var table_por_2 = document.getElementById('table_por_2');
    var placa_alta = document.getElementsByClassName("placa_alta_lsw");
    var placa = [];
    for (var i = 0; i < placa_alta.length; ++i) {
        if (typeof placa_alta[i].value !== "undefined"){ placa.push(placa_alta[i].value);}
    }
    $("#new_port_ring_ipran_clien").empty();
    $("#campos_port_link_all").empty();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/lanswitch',
        data: {anilo:anilo, placa:placa,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "nop":
                    toastr.error("El equipo no tiene puerto del ancho de banda del anillo");
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){
                        var label = '';
                        if (data['datos'][i]['slot'] != '@@') {
                            var label = data['datos'][i]['slot'];
                        }
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['label'] + label + data['datos'][i]['port'] + '</td>' +
                            '<td>' + data['datos'][i]['type'] + '</td>' +
                            '<td><input type="checkbox" class="PortIpranRing" name="PortIpranRing[]" value="'+data['datos'][i]['port']+'|'+data['datos'][i]['id']+'@'+data['datos'][i]['label'] + label + data['datos'][i]['port']+'">'+
                            '</tr>';
                        $("#new_port_ring_ipran_clien").append(valor)
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function CheckboxPortRing() {
    $("#list_all_port_link").empty();
    $("#campos_port_link_all").empty();
    var modal = document.getElementById("ExitRingIpranPort");
    var val = document.getElementsByClassName("PortIpranRing");
    for (var i = 0; i < val.length; ++i) {
        if (val[i].checked == true) {
            var all = val[i].value.split('@');
            var divi = all[0].split('|');
            var valor = '<input type="text" class="form-control" readonly="readonly" value="'+all[1]+'">';
            valor += '<input type="hidden"  class="port_link_id" name="port_link_id[]" value="'+divi[1]+','+divi[0]+'">';
            $("#campos_port_link_all").append(valor);
        }
    }
    $("#new_port_ring_ipran_clien").empty();
    modal.click();
}

function pre_view_ring_ipran(){
    var id = document.getElementById("id_anillo_ipran").value;
    var acro_selec = document.getElementById("acro_ring_ipran_sele").value;
    var num = document.getElementById("num_acro_ipran").value;
    if (acro_selec != '' && num!= '') {
        switch (num.length) {
            case 1:
                var numero = '000'+num;
                break;
            case 2:
                var numero = '00'+num;
                break;
            case 3:
                var numero = '0'+num;
                break;
            default:
                var numero = num;
                break;
        }
        var mostrar = 'ME-'+acro_selec+'_'+numero;
        $('#ipran_acro_ring').val(mostrar);
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'anillo/acronimo',
            data: {acronimo:mostrar,id:id,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#acro_ring_ipran_msj').text(data['datos']);
            },
            error: function() {
                toastr.error("Error con el servidor");
                $('#acro_ring_ipran_msj').text('');
            }
        });
    }else{
        $('#ipran_acro_ring').val('');
        $('#acro_ring_ipran_msj').text('');
    }
}

$("#num_acro_ipran").on("keyup", function() {
    pre_view_ring_ipran();
});

function acronimo_lanswitch_ipran(){
    var id = document.getElementById("id_lsw_new").value;
    var anillo = document.getElementById("id_ring_new").value;
    var client = document.getElementById("client_lsw").value;
    if (anillo != '' && client.length > 0 && client != '' && anillo.length > 0 && id == 0) {
        $('#acro_lsw').val('');
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'acronimo/lanswitch',
            data: {anillo:anillo, client:client, id:0,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "nop":
                        toastr.error("Error. el Cliente no tiene acronimo");
                        break;
                    case "yes":
                        $('#acro_lsw').val(data['acronimo']);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function BwRingRadioService() {
    var lsw = document.getElementById("id_lsw").value;
    var service = document.getElementById("servicio_radio").value;
    if (lsw != '' && service != '') {
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'buscar/anillo/lsw/servico',
            data: {lsw:lsw, service:service},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":




                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
}

function search_vlan_ip_node(id){
    $("#list_ip_vlan_nodo").empty();
    $('#id_node_vlan').val(id);
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/vlan/ip/nodo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $("#list_ip_vlan_nodo").empty();
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr id="linea'+ data['datos'][i].id +'" >' +
                            '<td>' + data['datos'][i].name + '</td>' +
                            '<td>' + data['datos'][i].vlan + '</td>' +
                            '<td>' + data['datos'][i].ip +'/'+ data['datos'][i].prefixes + '</td>' +
                            '<td><a> <i class="fa fa-trash" title="Eliminar Vlan" onclick="delete_vlan_ip_node(' + data['datos'][i].id + ');"> </i></a></td>' +
                            '</tr>';
                        $("#list_ip_vlan_nodo").append(valor);
                    })
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function list_equipments_in_node(id){
    $('#node_list_name').empty();
    $("#list_new_equipment_node").empty();

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipos/nodo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    $('#node_list_name').html(data['node_name']);
                    $(data['data']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>'+data['data'][i]['acronimo']+'</td>' +
                            '<td>'+data['data'][i]['client']+'</td>' +
                            '<td>'+data['data'][i]['type']+'</td>' +
                            '<td>'+data['data'][i]['status']+'</td>' +
                            '<td>'+data['data'][i]['service']+'</td>' +
                            '<td>'+data['data'][i]['commentary']+'</td>';
                        valor += '</tr>';
                        $("#list_new_equipment_node").append(valor)
                    });
                    break;
                case "nop":
                    swal("Vacio!", "El nodo seleccionado no tiene equipos asociados", "warning");
                    $("#close_pop_list_equipment_node").click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function delete_vlan_ip_node(id){
    var modal0 = document.getElementById('confirmacion');
    var aceptar = document.getElementById("myBtnSi");
    var cancelar = document.getElementById("myBtnNo");
    modal0.style.display = "block";
    mensaje.textContent  = "Esta seguro que desea eliminar el registro?";
    aceptar.onclick = function() {
        modal0.style.display = "none";
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'eliminar/vlan/ip/nodo',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "Exist":
                        toastr.error("Alguna IP de este Rango esta siendo usada");
                        break;
                    case "yes":
                        search_vlan_ip_node(data['datos']);
                        toastr.success("Modificación Exitosa");
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal0.style.display = "none";
    }
}

function MigrationPortModelNew(num) {
    var placa_alta = document.getElementsByClassName("placa_alta");
    var board = [];
    for (var i = 0; i < placa_alta.length; ++i) {
        if (typeof placa_alta[i].value !== "undefined"){ board.push(placa_alta[i].value);}
    }
    $("#list_all_port_migration").empty();
    if (board.length > 0) {
        $('#new_port_migration').modal('show');
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'buscar/puerto/migrar',
            data: {board:board},
            dataType: 'json',
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
                        toastr.error("No tiene puertos");
                        break;
                    case "yes":
                        $("#list_all_port_migration").empty();
                        $(data['datos']).each(function(i, v){ // indice, valor
                            var valor = '<tr>' +
                                '<td id="value_'+[i]+'">'+data['datos'][i].full +'</td>'+
                                '<td>'+data['datos'][i].type +'</td>'+
                                '<td> <input type="hidden" id="slot'+[i]+'" value="'+data['datos'][i].slot_board+'"> <a> <i class="fa fa-bullseye" title="Selecionar" onclick="port_value_migration('+data['datos'][i].id+','+[i]+', '+num+');"> </i></a></td>' +
                                '</tr>';
                            $("#list_all_port_migration").append(valor);
                        })

                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }else{
        toastr.error("Agrega las placas");
    }
}

function port_value_migration(board, port, id, num) {
    var resul = 'yes';
    var val = document.getElementById('value_'+id).innerHTML;
    var slot = document.getElementById('slot'+id).value;
    var placa = [];
    var value = board+','+port;
    var port_new = document.getElementsByClassName("port_new");
    for (var i = 0; i < port_new.length; ++i) {
        if (port_new[i].value != "") {
            var old = port_new[i].value.split(',');
            placa.push(old[0]+'|'+old[1]+'|'+old[2]);
        }
    }
    if (placa.length > 0) {
        $(placa).each(function(i, v){
            if (placa[i] == board+'|'+port+'|'+slot) {
                resul = 'not';
            }
        });
    }
    if (resul == 'yes') {
        var selec = "#port_new"+num;
        $(selec).find('option').remove();
        $(selec).append('<option selected value="'+value+','+slot+'">'+val+'</option>').trigger('change.select2');
        $('#new_port_migration').modal('toggle').hide();
    }else{
        toastr.error("Puerto Duplicado");
    }
}

$('#FormMigrationAll').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('_token', $('input[name=_token]').val());
    $.ajax({
        type:'POST',
        url: getBaseURL()+'migrar/puerto/modelo/equipo',
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "unique":
                    toastr.error("Puertos Nuevo Duplicado");
                    break;
                case "board":
                    toastr.error("Quito una placa que un puerto necesita");
                    break;
                case "nop":
                    toastr.error("Cantidad de puerto viejos y nuevos diferentes");
                    break;
                case "yes":
                    toastr.success("Modificación Exitosa");
                    location.href =getBaseURL()+data['datos'];
                    break;
            }
        },
        error: function(data) {
            var errors = $.parseJSON(data.responseText);
            $.each(errors['errors'], function (ind, elem) {
                toastr.error(elem);
            });
        }
    });
});

function commen_group_update(equip, group){
    var cancelar = document.getElementById("button_cancelar");
    var aceptar = document.getElementById("button_aceptar");
    var modal = document.getElementById("cerrar_comen_puerto");
    var title_msj = document.getElementById("title_port_commen");
    $('#commen_port_all').val('');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/comentario/lacp/equipo',
        data: {group:group},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#commen_port_all').val(data['datos']);
                    title_msj.textContent  = data['acronimo'];
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen_port_all").value;
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'registrar/comentario/lacp/equipo',
            data: {group:group, commen:commen,},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "yes":
                        inf_equip_port(equip);
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}
function reserve_list(){
    $("#id_reserve_choosen").find('option').remove();
    $("#id_reserve_choosen").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $(".info_number_reserve").html("");
    $(".info_name_node").html("");
    $(".info_name_link").html("");
    $(".info_bw_reserved").html("");
    $(".oportunitty").html("");
    $(".client").html("");
    $(".info_comentary").html("");
    $("#node_bw_used_pop_info").html("0");
    $("#node_bw_pop_info").html("0");
    $("#node_bw_reserved_pop_info").html("0");
    $("#node_bw_remanent_pop_info").html("0");

    let id_equipment = $("#equip").val();
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'reserve/mostrar/equipos',
        data: {id_equipment:id_equipment},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    if(data['data'].length == 0){
                        toastr.warning("No se encontraron reservas para este equipo");
                    } else{
                        let select_reserve = $("#id_reserve_choosen");
                        $(data['data']).each(function(i, v){ // indice, valor
                            select_reserve.append(
                                '<option value="'+ data['data'][i]['id'] + '">' +  data['data'][i]['number_reserve'] + '</option>'
                            );
                            //console.log(data['data'][i]);
                        })
                    }


                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function selec_reserve(){
    $("#close_reserve_list").click();
    $("#reserve_option").find('option').remove();
    $('#reserve_option').append('<option selected value="'+$("#id_reserve_choosen").val()+'">'+ $('#id_reserve_choosen').find(":selected").text()+'</option>').trigger('change.select2');
    let bw_reservado = $('.info_bw_reserved').text();
    let bw_number = bw_reservado.replace(/\D/g,"");
    let bw_size = bw_reservado.replace(/[^A-Za-z]/g, '');
    if(bw_size == 'Gbps'){
        bw_number = bw_number*1024;
    }
    if(bw_size == 'Kbps'){
        bw_number = bw_number/1024;
    }
    $('.bw_reserve').html(bw_number);

    let bw_reserve = $(".bw_reserve").text();
    let bw_service = $(".bw_service").text();
    if((bw_service > 0 && bw_reserve > 0) && (bw_service > bw_reserve)){
        //toastr.warning("CUIDADO! el bw de servicio es mayor al de reserva");
        swal("CUIDADO!", "El bw de servicio es mayor al de la reserva", "warning");
    }
}

function select_lanswitch_port(board_id, port_n, port_acr) {
    $("#cerra_bus_equipo_servi").trigger("click");
    $("#port_field").find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/puerto/equipo',
        data: {board:board_id, port:port_n},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#ls_port_id").val(data['datos']['id']);
                    $("#puertus").val(port_acr);

                    $("#port_field").append('<option selected disabled value="'+data['datos']['id']+'">'+data['datos']['port']+'</option>').trigger('change.select2');
                    break;
                case "nop":
                    toastr.error("El puerto esta ocupado");
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
}

function delete_link_ipran(id){
    swal({
        title: "Estás seguro?",
        text: "Estás por eliminar un link!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, eliminar!",
        cancelButtonText: "No, volver",
        closeOnConfirm: false,
    },function (isConfirm) {
        if (!isConfirm) return;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'eliminar/link',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        swal("Error al borrar!", "No dispone de permisos para realizar esta accion", "error");
                        break;
                    case "yes":
                        swal("Eliminado!", "El link fue eliminado con exito.", "success");
                        $('#list_link_ipran').DataTable().ajax.reload();
                        break;
                    case "services":
                        swal("Error al eliminar!", "El link tiene asociado servicios.", "error");
                        $('#list_link_ipran').DataTable().ajax.reload();
                        break;
                    case "reserve":
                        swal("Error al eliminar!", "El link tiene asociado reservas vigentes.", "error");
                        $('#list_link_ipran').DataTable().ajax.reload();
                        break;
                }
            },
            error: function() {
                swal("Error al borrar!", "Por favor intentar luego", "error");
            }
        });
    });
}
function relate_ls_uplink() {
    var uplink_id = $("#uplink_field").find('option:selected').val();
    var board_id = $("#attach_board_id").val();
    var port_n = $("#attach_port_n").val();
    if (uplink_id == '' || uplink_id == null) {
        toastr.warning("Debe seleccionar un uplink");
        return;
    }
    if (port_n == '' || port_n == null) {
        toastr.warning("Debe seleccionar un puerto de equipo");
        return;
    }
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'relacion/lanswitch/uplink',
        data: {board_id:board_id, port_n:port_n, uplink_id:uplink_id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    toastr.success("Operaci&oacute;n exitosa");
                    $("#close_attach_uplink_equipment").click();
                    break;
                case "nop":
                    toastr.error("Error: "+data['datos']);
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
}

function relate_equip_ports(board_id, port_n, port_type, port_bw) {
    $("#cerra_bus_equipo_servi").trigger("click");
    $("#eq_select").select2("val", "");
    $("#port_select").select2("val", "");
    $("#eq_select").find('option').remove();
    $("#port_select").find('option').remove();
    $("#type_eq_select").prop('selectedIndex',0);

    $("#current_board_id").val(board_id);
    $("#current_port_n").val(port_n);
    $("#current_port_type").val(port_type);
    $("#current_port_bw").val(port_bw);
    $("#other_eq_id").val('');
    $("#other_board_id").val('');
    $("#other_port_n").val('');

    $("#type_eq_select").change( function () {
        $("#search_eq_button")
            .attr("onClick", "list_equipment_2(\'"+$("#type_eq_select option:selected").text()+"\');")
            .attr("data-target", "#equip_list_modal");
    });
    $("#eq_select").on("change.select2", function () {
        $("#search_port_button")
            .attr('onClick','port_list_by_equipment('+$("#other_eq_id").val()+', false);')
            .attr("data-target", "#port_list_modal");
    });
    $("#rel_port_eq_accept").click(function () {
        if ($("#other_board_id").val() == '' || $("#other_port_n").val() == '') {
            toastr.error('Debe seleccionar equipo y puerto');
        } else {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "post",
                url: getBaseURL() +'relacionar/equipos/puertos',
                data: {
                    current_board_id: $("#current_board_id").val(),
                    current_port_n: $("#current_port_n").val(),
                    other_board_id: $("#other_board_id").val(),
                    other_port_n: $("#other_port_n").val(),
                },
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
                        case "nop":
                            toastr.error(data['datos']);
                            break;
                        case "yes":
                            toastr.success("Operaci&oacute;n exitosa");
                            $("#rel_port_eq_close").click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    });
}

function select_equipment_modal(equip_id) {
    var modal = document.getElementById("equip_list_modal_close");
    var select = $("#eq_select");
    select.find('option').remove();

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'asignar/equipo',
        data: {id:equip_id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#other_eq_id").val(equip_id).trigger('change');
                    select.append('<option selected disabled value="'+equip_id+'">'+data['datos']+'</option>');
                    select.val(equip_id).trigger('change.select2');
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
    modal.click();
}

function select_port_modal(board_id, port_n, acr, type, bw) {
// Cuando se vincula a dos equipos entre sí
    var select = $("#port_select");
    var msg = '';
    select.find('option').remove();
    select.append('<option selected disabled">'+acr+'</option>');
    select.trigger('change.select2');
    $("#other_board_id").val(board_id).trigger('change');
    $("#other_port_n").val(port_n).trigger('change');
    if (type != $("#current_port_type").val() && $("#current_port_type").val() != '') msg += '- Tipo de puerto de origen distinto al de destino\n';
    if (bw != $("#current_port_bw").val() && $("#current_port_bw").val() != '') msg += '- Diferencia en ancho de banda entre puertos';
    if (msg != '') swal('ADVERTENCIA', msg, 'warning');

// Cuando se vincula a un ls con uplink
    var select2 = $("#port_field");
    select2.find('option').remove();
    select2.append('<option selected disabled">'+acr+'</option>');
    select2.trigger('change.select2');
    $("#attach_board_id").val(board_id).trigger('change');
    $("#attach_port_n").val(port_n).trigger('change');

    $("#port_list_modal_close").click();
}

function create_service_reserve() {
    document.getElementById("alta_reserva_servicio").reset();
    var service_sel = $("#service_sel");
    var client_sel = $("#client_sel");
    var type_sel = $("#type_sel");
    var bw_input = $("#bw_input");
    var id_link = $("#link_hidden");
    var comment_input = $("#comment_input");
    var op_input = $("#op_input");
    var current_service_bw = '';
    var bw_remanence = '';

// Información de celda al momento de reservar
    var node_status = $("#node_status");
    var node_type = $("#node_type");
    var node_commentary = $("#node_commentary");

// Información de link al momento de reservar
    var link_proggressbar = $("#link_proggressbar");
    var link_status = $("#link_status");
    var link_commentary = $("#link_commentary");
    var bw_limit_data = $("#bw_limit_data");
    var bw_limit_unit = $("#bw_limit_unit");
    var bw_use_data = $("#bw_use_data");
    var bw_use_unit = $("#bw_use_unit");
    var bw_prereserve_data = $("#bw_prereserve_data");
    var bw_prereserve_unit = $("#bw_prereserve_unit");
    var bw_remanence_data = $("#bw_remanence_data");
    var bw_remanence_unit = $("#bw_remanence_unit");

    var start = new Date();
    var end = new Date();
    end.setDate(end.getDate() + 90);
    $("#start_input").val(format_day(start));
    $("#end_input").val(format_day(end));

    id_link.unbind();
    service_sel.find('option').remove();
    service_sel.append('<option selected disabled value="">seleccionar</option>');
    $("#select2-service_sel-container").text('seleccionar');
    client_sel.find('option').remove();
    type_sel.find('option').remove();
    bw_input.empty();

    node_status.empty();
    node_type.empty();
    node_commentary.empty();
    link_status.empty();
    link_commentary.empty();

    bw_limit_data.html('0');
    bw_use_data.html('0');
    bw_prereserve_data.html('0');
    bw_remanence_data.html('0');
    link_proggressbar.css("width", "0%");

    service_sel.on('change.select2', function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            type: "get",
            url: getBaseURL()+'detalle/servicio/'+this.value,
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
                    case "nop":
                        toastr.error(data['datos']);
                        return;
                    case "yes":
                        client_sel.append('<option selected disabled value="'+data['client_id']+'">'+data['client_name']+'</option>').trigger('change.select2');
                        type_sel.append('<option selected disabled value="'+data['type_id']+'">'+data['type_name']+'</option>').trigger('change.select2');
                        id_link.val(data['uplink_id']).trigger('change');
                        current_service_bw = bw_input.val();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    });
// Recuadro amarillo
    id_link.on('change', function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url:getBaseURL()+'info/link',
            data: {id_link:id_link.val()},
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
                    case "nop":
                        toastr.error("Error imprevisto");
                        break;
                    case "yes":
                        //Celda
                        node_status.html(data['data'][0]['status_node']);
                        node_commentary.html(data['data'][0]['commentary_node']);
                        node_type.html(data['data'][0]['node_info_plus'])
                        //Link
                        link_status.html(data['data'][0]['status']);
                        if(data['data'][0]['status'] == 'ALTA'){
                            link_proggressbar.css("width", "100%");
                        } else{
                            link_proggressbar.css("width", "100%");
                            link_proggressbar.addClass( "bg-danger" );
                            toastr.warning('La celda uplink no esta habilitada');
                        }
                        link_commentary.html(data['data'][0]['commentary']);
                        bw_limit_data.text(data['data'][0]['bw']);
                        bw_limit_unit.text(data['data'][0]['bw_size']);
                        bw_use_data.text(data['data'][0]['bw_used_info']);
                        bw_use_unit.text(data['data'][0]['bw_used_size']);
                        bw_prereserve_data.text(data['data'][0]['bw_pre_reserve']);
                        bw_prereserve_unit.text(data['data'][0]['bw_pre_reserve_size']);
                        bw_remanence_data.text(data['data'][0]['bw_available']);
                        bw_remanence_unit.text(data['data'][0]['bw_available_size']);

                        if(data['data'][0]['status_node'] == "NO APTA"){
                            swal("Advertencia", "La celda tiene un contrato vencido", "warning");
                        }
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    });

    $("#alta_reserve_service").unbind().on('click', function(){
        var bw_max_size = document.getElementById("size_sel").value;
        var bw_reserve = 0;
        switch (bw_max_size) {
            case '1': bw_reserve = bw_input.val(); break;
            case '2': bw_reserve = bw_input.val()*1024; break;
            case '3': bw_reserve = bw_input.val()*1048576; break;
            default: toastr.error("Selecciona el tipo de bw"); return;
        }

        var cell_bw_link = 0;
        var cell_bw_usado =  0;
        var cell_bw_reserved = 0;
        switch (bw_limit_unit.text()) {
            case 'Kbps': cell_bw_link = bw_limit_data.html(); break;
            case 'Mbps': cell_bw_link = bw_limit_data.html()*1024; break;
            case 'Gbps': cell_bw_link = bw_limit_data.html()*1048576; break;
        }
        switch (bw_use_unit.text()) {
            case 'Kbps': cell_bw_usado = bw_use_data.html(); break;
            case 'Mbps': cell_bw_usado = bw_use_data.html()*1024; break;
            case 'Gbps': cell_bw_usado = bw_use_data.html()*1048576; break;
        }
        switch (bw_prereserve_unit.text()) {
            case 'Kbps': cell_bw_reserved = bw_prereserve_data.html(); break;
            case 'Mbps': cell_bw_reserved = bw_prereserve_data.html()*1024; break;
            case 'Gbps': cell_bw_reserved = bw_prereserve_data.html()*1048576; break;
        }
        switch (bw_remanence_unit.text()) {
            case 'Kbps': bw_remanence = parseFloat(bw_remanence_data.text()); break;
            case 'Mbps': bw_remanence = parseFloat(bw_remanence_data.text())*1024; break;
            case 'Gbps': bw_remanence = parseFloat(bw_remanence_data.text())*1048576; break;
        }

        if (bw_reserve <= current_service_bw) {
            toastr.error("El BW final de la reserva debe ser mayor que el existente en el servicio");
            return;
        }
        if (bw_reserve > bw_remanence) {
            toastr.error("El BW final de la reserva no puede superar al remanente del uplink");
            return;
        }

        $.ajax({
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            type: "POST",
            url: getBaseURL()+'registrar/reserva',
            data: {
                id_link: id_link.val(),
                id_cliente: client_sel.find('option').val(),
                bw_reserve: bw_reserve-current_service_bw,
                oportunity: op_input.val(),
                id_service_type: type_sel.find('option').val(),
                commentary: comment_input.val(),
                cell_status: node_status.html(),
                cell_bw_link: cell_bw_link,
                cell_bw_usado: cell_bw_usado,
                cell_bw_reserved: cell_bw_reserved,
                id_service: service_sel.find('option').val(),
                type: 'UPGRADE'
            },
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
                    case "port":
                        toastr.error("Seleccionar Equipo y Puerto");
                        break;
                    case "nop":
                        toastr.error("Puerto Ocupado");
                        break;
                    case "yes":
                        new Clipboard('.btn');
                        let number_reserve = $("#nro_reserva");
                        let pop_end_date = $(".end_date");
                        let pop_start_date = $(".start_date");
                        let pop_status_node = $(".info_status_node");
                        let pop_status_link = $(".info_status_link");
                        let pop_bw_reserved = $(".info_bw_reserved");
                        let pop_commentary = $(".info_comentary");
                        let number_reserve_span = $(".number_reserve_span");

                        $('#list_reserve').DataTable().ajax.reload();
                        $("#serv_res_close").trigger('click');

                        number_reserve.html('');
                        pop_status_node.html('');
                        pop_status_link.html('');
                        pop_bw_reserved.html('');
                        number_reserve_span.html('');
                        pop_commentary.html('');

                        number_reserve.html(data['data'][0]['nro_reserve'])
                        number_reserve_span.html("#"+data['data'][0]['nro_reserve']);
                        pop_end_date.html('-');
                        pop_start_date.html('-');
                        pop_status_node.html(data['data'][0]['status_node']);
                        pop_status_link.html(data['data'][0]['status_link']);
                        pop_bw_reserved.html(data['data'][0]['bw_reserved']);
                        pop_commentary.html(data['data'][0]['commentary']);

                        $('#pop_small_info').modal('show');
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    });
}

function service_uplink(link_id) {
    var new_tbody = document.createElement('tbody');
    $("#servi_equipo").html(new_tbody);
    $.ajax({
        type: 'get',
        url: getBaseURL()+'ver/uplink/servicios/'+link_id,
        dataType: 'json',
        cache: false,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "nop":
                    toastr.error(data['datos']);
                    break;
                case "yes":
                    var valor = '';
                    if (data['datos'].length > 0) {
                        $(data['datos']).each(function(i, v){ // indice, valor
                            valor += '<tr>' +
                                '<td>'+data['datos'][i]['label']+data['datos'][i]['slot']+data['datos'][i]['n_port']+'</td>' +
                                '<td>'+data['datos'][i]['vlan']+'</td>' +
                                '<td>'+data['datos'][i]['number']+'</td>' +
                                '<td>'+data['datos'][i]['bw_service']+'</td>' +
                                '<td>'+data['datos'][i]['business_name']+'</td>' +
                                '<td><a data-toggle="modal" data-target="#editar_recurso_servicio_pop" onclick="resource_service_edit('+data['datos'][i]['id']+', '+data['datos'][i]['service']+');" title="Modificar recurso"><i class="fa fa-edit"></i></a>'+
                                '<a title="Ingeneria" href="http://coronel2.claro.amx:8010/WebIngenieria/pages/buscarIngenieria.xhtml?email=true&servicio='+data['datos'][i]['number']+'" target="_blank"> <i class="fa fa-clipboard"> </i> </a>'+
                                '</td>'+'</tr>';
                        });
                    }
                    $("#servi_equipo").append(valor);
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}

function apply_service_reserve(reserve_id) {
    $.ajax({
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        type: 'get',
        url: getBaseURL()+'info/reserva/'+reserve_id,
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
                    $("#serv_current_bw").text(data['datos']['current_bw']+' '+data['datos']['current_bw_size']);
                    $("#serv_new_bw").text(data['datos']['new_bw']+' '+data['datos']['new_bw_size']);
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });

    $("#apply_serv_res_accept").unbind().on("click",function(){
        $.ajax({
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            type: 'get',
            url: getBaseURL()+'aplicar/reserva/'+reserve_id,
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
                    case "nop":
                        toastr.error("Error con el servidor");
                        console.log(data['datos']);
                        break;
                    case "yes":
                        toastr.success("Operaci&oacute;n realizada con &eacute;xito");
                        $('#list_reserve').DataTable().ajax.reload();
                        $("#apply_serv_res_close").trigger("click");
                        break;
                }
            },
            error: function(data) {
                toastr.error("Error con el servidor");
            }
        });
    });
}

function disconnect_port(board_id, port_n) {
    $('#disc_accept').click(function () {
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "post",
            url: getBaseURL() +'desconectar/equipos/puertos',
            data: {board_id:board_id, port_n:port_n},
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
                        $('#cerra_bus_equipo_servi').click();
                        toastr.success("Operaci&oacute;n exitosa");
                        $('#disc_cancel').click();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    });
}

////////////   ADMIN VLAN
function range_vlan_index(id){
    let id_equipment = id;
    $("#agg_id").val(id_equipment);
    let div_gestion = $("#vlan_gestion");
    let vlan_gestion_all = $("#vlan_gestion_all");
    if(id == 0){
        let range_vlan_title = $("#range_vlan_title");
        let range_vlan_subtitle = $("#range_vlan_subtitle");
        let range_gestion = $("#range_gestion");
        $("#frontier_div").addClass('hidden');
        $("#title_gnral_ranges").addClass('hidden');
        range_gestion.text('Rangos generales');
        range_vlan_title.text('Configurar Rangos');
        range_vlan_subtitle.text('En esta pantalla se podran configurar los rangos de vlan generales');
    }
    $("#vlan_gestion").html("");
    $("#vlan_gestion_all").html("");

    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'vlan/rango/equipo',
        data: {id_equipment:id_equipment},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    if(data['data'].length == 0){
                        div_gestion.append("<center> <h4>No existen rangos de gestion</h4> </center>");
                        toastr.warning("No se encontraron rangos para este agregador");
                    } else{
                        $("#agg_id").val(id);
                        $(data['data']).each(function(i, v){
                                bg = 'bg-danger';
                                if(data['data'][i]['name'] == 'GESTIÓN RADIO'){
                                    bg = 'bg-warning';
                                } else if(data['data'][i]['name'] == 'GESTIÓN LS' || data['data'][i]['name'] == 'GESTIÓN ANILLO IPRAN'){
                                    bg = 'bg-success'
                                }
                                let id_range = '"'+data['data'][i]['id'].toString()+'"';

                                if(data['data'][i]['id_equipment'] != 0){
                                    div_gestion.append(
                                        " <div class='col-sm-12' style='display:flex; justify-content: center; align-items: center'>"+
                                        "<div class='p-xxs b-r-md m-t-xs "+ bg +" col-sm-2 text-center'>"+
                                        "<strong>"+ data['data'][i]['name'] +"</strong>"+
                                        "</div>"+
                                        "<div class='col-sm-3'>"+
                                        "<div class='form-group'>"+
                                        "<label>Desde</label>"+
                                        "<div class='bw_all' id='bw_all' >"+
                                        "<input class='form-control hide-arrow-select' maxlength='4' disabled onkeypress='return esNumero(event);' value='"+ data['data'][i]['range_from'] +"' id='min_gestion_"+data['data'][i]['id']+"'>"+
                                        "</div>"+
                                        "</div>"+
                                        "</div>"+
                                        "<div class='col-sm-3'>"+
                                        "<div class='form-group'>"+
                                        "<label>Hasta</label>"+
                                        "<div class='bw_all' id='bw_all' >"+
                                        "<input class='form-control hide-arrow-select' maxlength='4' disabled onkeypress='return esNumero(event);' value='"+data['data'][i]['range_until']+"' id='max_gestion_"+data['data'][i]['id']+"'>"+
                                        "</div>"+
                                        "</div>"+
                                        "</div>"+
                                        "<div class='m-t-sm col-sm-2 p-xxs'>"+
                                        "<a id='save_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-primary hidden' title='Guardar' onclick='edit_gestion_range("+id_range+");'><i class='fas fa-check-double'> </i></a> "+
                                        " <a id='edit_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-info' title='Editar' onclick='enable_gestion_input("+id_range+");'><i class='fa fa-pencil-alt'></i> </a>"+
                                        " <a id='delete_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-info' title='Borrar' onclick='delete_gestion_range("+id_range+");'><i class='fa fa-trash-alt'></i> </a>"+
                                        " <a id='undo_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-danger hidden' title='Cancelar edicion' onclick='edit_undo("+id_range+");'><i class='fa fa-times'></i> </a> "+
                                        "</div>"+
                                        "</div>"
                                    );
                                } else{
                                    vlan_gestion_all.append(
                                        " <div class='col-sm-12' style='display:flex; justify-content: center; align-items: center'>"+
                                        "<div class='p-xxs b-r-md m-t-xs "+ bg +" col-sm-2 text-center'>"+
                                        "<strong>"+ data['data'][i]['name'] +"</strong>"+
                                        "</div>"+
                                        "<div class='col-sm-3'>"+
                                        "<div class='form-group'>"+
                                        "<label>Desde</label>"+
                                        "<div class='bw_all' id='bw_all' >"+
                                        "<input class='form-control hide-arrow-select' maxlength='4' disabled onkeypress='return esNumero(event);' value='"+ data['data'][i]['range_from'] +"' id='min_gestion_"+data['data'][i]['id']+"'>"+
                                        "</div>"+
                                        "</div>"+
                                        "</div>"+
                                        "<div class='col-sm-3'>"+
                                        "<div class='form-group'>"+
                                        "<label>Hasta</label>"+
                                        "<div class='bw_all' id='bw_all' >"+
                                        "<input class='form-control hide-arrow-select' maxlength='4' disabled onkeypress='return esNumero(event);' value='"+data['data'][i]['range_until']+"' id='max_gestion_"+data['data'][i]['id']+"'>"+
                                        "</div>"+
                                        "</div>"+
                                        "</div>"+
                                        "<div class='m-t-sm col-sm-2 p-xxs'>"+
                                        "<a id='save_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-primary hidden' title='Guardar' onclick='edit_gestion_range("+id_range+");'><i class='fas fa-check-double'> </i></a> "+
                                        " <a id='edit_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-info' title='Editar' onclick='enable_gestion_input("+id_range+");'><i class='fa fa-pencil-alt'></i> </a>"+
                                        " <a id='delete_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-info' title='Borrar' onclick='delete_gestion_range("+id_range+");'><i class='fa fa-trash-alt'></i> </a>"+
                                        " <a id='undo_gestion_"+data['data'][i]['id']+"' class='ico_input btn btn-danger hidden' title='Cancelar edicion' onclick='edit_undo("+id_range+");'><i class='fa fa-times'></i> </a> "+
                                        "</div>"+
                                        "</div>"
                                    );
                                }
                            }
                        )};
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function edit_undo(id_range){
    let range_min = $("#min_gestion_"+id_range);
    let range_max = $("#max_gestion_"+id_range);
    range_min.val('');
    range_max.val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "post",
        url: getBaseURL() +'info/rango/edit',
        data: {id_range:id_range},
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "yes":
                    range_min.val(data['data'][0]['range_from']);
                    range_max.val(data['data'][0]['range_till']);
                    $("#min_gestion_"+id_range).prop("disabled", true);
                    $("#max_gestion_"+id_range).prop("disabled", true);
                    $("#save_gestion_"+id_range).addClass("hidden");
                    $("#undo_gestion_"+id_range).addClass("hidden");
                    $("#edit_gestion_"+id_range).removeClass("hidden");
                    toastr.info("No se generó ningun cambio.");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function add_range_vlan(){
    let agg_id = $("#agg_id").val();
    let type_vlan_id = $("#pop_type_vlan_id").val();
    let range_min = parseInt($("#pop_add_range_min").val());
    let range_max = parseInt($("#pop_add_range_max").val());
    if(type_vlan_id == '' || range_min == '' || range_max == ''){
        toastr.error("Hay campos vacios obligatorios");
        return;
    }
    if(range_min > range_max){
        toastr.error("El  rango minimo debe ser menor al maximo");
        return;
    }
    if(range_max == range_min){
        toastr.error("Los rangos no pueden ser iguales");
        return;
    }
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "post",
        url: getBaseURL() +'agregar/rango/vlan',
        data: {agg_id:agg_id, type_vlan_id:type_vlan_id, range_min:range_min, range_max:range_max},
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "used":
                    toastr.error("El rango ingresado esta siendo usado");
                    break;
                case "exceds":
                    toastr.error("El rango ingresado excede el limite");
                    break;
                case "redundancy":
                    console.log(data['datos']);
                    toastr.error("El rango ingresado ya existe tal cual esta ingresado");
                    break;
                case "vlan_unknown":
                    toastr.error("Ingrese el tipo de producto");
                    break;
                case "yes":
                    $('#close_pop_add_range_vlan').click();
                    range_vlan_index(agg_id);
                    toastr.success("Se agregó la vlan de forma exitosa");

                    //$('#close_vlan_range_config').click();
                    break;
                case "nop":
                    toastr.error("A");
                    console.log(data['datos']);
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function edit_gestion_range(id_range){
    let agg_id = $("#agg_id").val();
    let min = parseInt($("#min_gestion_"+id_range).val());
    let max = parseInt($("#max_gestion_"+id_range).val());

    if(min <= 0 || max <= 0){
        toastr.error("Introduzca un rango valido");
        return;
    }
    console.log(min + " " + max);
    if(min > max){
        toastr.error("El  rango minimo debe ser menor al maximo");
        return;
    }
    if(min == max){
        toastr.error("No pueden tener el mismo valor");
        return;
    }


    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "post",
        url: getBaseURL() +'editar/rango/vlan',
        data: {id_range:id_range, min:min, max:max,agg_id:agg_id},
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "used":
                    toastr.error("El rango ingresado esta siendo usado");
                    break;
                case "exceds":
                    toastr.error("El rango ingresado excede el limite");
                    break;
                case "exists":
                    toastr.warning("Existen vlans usadas dentro del rango que se quiere modificar.");
                    break;
                case "yes":
                    toastr.success("El rango fue modificado!");
                    $("#min_gestion_"+id_range).prop("disabled", true);
                    $("#max_gestion_"+id_range).prop("disabled", true);
                    $("#save_gestion_"+id_range).addClass("hidden");
                    $("#undo_gestion_"+id_range).addClass("hidden");
                    $("#edit_gestion_"+id_range).removeClass("hidden");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}
function clear_add_vlan_inputs(){
    $("#pop_type_vlan_id").val($("#pop_type_vlan_id option:first").val());
    $("#pop_add_range_min").val('');
    $("#pop_add_range_max").val('');
}
function delete_gestion_range(id_range){
    let agg_id = $("#agg_id").val();
    swal({
        title: "Estás seguro?",
        text: "Estás por borrar un rango!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, borrar!",
        cancelButtonText: "No, volver",
        closeOnConfirm: false,
    },function (isConfirm) {
        if (!isConfirm) return;
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'borrar/rango/vlan',
            data: {id_range:id_range, agg_id:agg_id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        swal("Error al borrar!", "Por favor intentar luego", "error");
                        break;
                    case "exists":
                        swal("Error!", "Existen vlans usadas dentro del rango que se quiere borrar", "error");
                        break;
                    case "yes":
                        range_vlan_index(agg_id);
                        swal("Rango borrado!", "El registro fue eliminado con exito.", "success");
                        break;
                }
            },
            error: function() {
                swal("Error al borrar!", "Por favor intentar luego", "error");
            }
        });
    });
}

function enable_gestion_input(id_range){
    $("#min_gestion_"+id_range).prop("disabled", false);
    $("#max_gestion_"+id_range).prop("disabled", false);
    $("#edit_gestion_"+id_range).addClass("hidden");
    $("#undo_gestion_"+id_range).removeClass("hidden");
    $("#save_gestion_"+id_range).removeClass("hidden");
}
function next_free_vlan(fun = null) {
    if (fun == 6) {
        var id_list_use_vlan = 2;
        var id_equipment = document.getElementById('agg').value;
        var select = $("#me_vlan_radio");
        var id_frontier = null;
    } else if (fun == 5) {
        var id_list_use_vlan = 1;
        var id_equipment = document.getElementById('agg').value;
        var select = $("#me_vlan_ls");
        var id_frontier = null;
    } else if (fun == 4) {
        var id_list_use_vlan = 2;
        var id_equipment = document.getElementById('id_lsw').value;
        var select = $("#ipran_vlan_radio");
        var id_frontier = null;
    } else if (fun == 3) {
        var id_list_use_vlan = 1;
        var id_equipment = document.getElementById('id_lsw').value;
        var select = $("#ipran_vlan_ls");
        var id_frontier = null;
    } else if (fun == 2) {
        var id_list_use_vlan = document.getElementById("use_vlan").value;
        var id_equipment = document.getElementById('id_equip_vlan').value;
        var select = $("#free_vlans");
        var id_frontier = document.getElementById("select_frontier").value;
    } else if (fun == 1) {
        var id_list_use_vlan = 1;
        var id_equipment = document.getElementById('id_lsw').value;
        var select = $("#free_vlans");
        var id_frontier = null;
    } else {
        var id_list_use_vlan = document.getElementById("use_vlan").value;
        var id_equipment = document.getElementById('agg').value;
        var select = $("#free_vlans");
        var id_frontier = document.getElementById("select_frontier").value;
    }
    var current = select.find("option");
    var value = current.val();
    current.remove();
    $.ajax({
        type: "get",
        url: getBaseURL()+'vlan/proxima/'+id_list_use_vlan+'/'+id_equipment+'/'+id_frontier+'/'+value,
        cache: false,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
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
                    if (data['datos'].length == 0) {
                        toastr.error("No hay Vlan libres de este tipo con este agregador");
                        select.append('<option selected disabled value="0">0000</option>').trigger('change.select2');
                    } else {
                        select.append('<option disabled selected value="'+parseInt(data['datos'])+'">'+data['datos']+'</option>').trigger('change.select2');
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function relate_agg_pe_pei(aggid = null) {
    if (aggid == null) {
        $("#agg_row_1").css("display","block");
        $("#agg_row_2").css("display","none");
        var agg = $("#agg_sel");
    } else {
        $("#agg_row_1").css("display","none");
        $("#agg_row_2").css("display","block");
        var agg = $("#agg_inpt");
        var agg_id = $("#agg_hidden");
    }
    var agg_prefix = $("#prefix_inpt");
    var ip = $("#ip_inpt");
    var zona_home = $("#zh_sel");
    var zona_multihome = $("#zmh_sel");
    var pe_1 = $("#pe_mlps_sel_1");
    var pei_1 = $("#pe_int_sel_1");
    var pe_2 = $("#pe_mlps_sel_2");
    var pei_2 = $("#pe_int_sel_2");
    var data = {};

    document.getElementById("relate_agg_pe_pei_form").reset();
    if (aggid == null) {
        agg.find('option').remove();
        agg.append('<option selected disabled value="0">Ninguno</option>');
    } else {
        agg_id.val(aggid);
    }
    pe_1.find('option').remove();
    pei_1.find('option').remove();
    pe_2.find('option').remove();
    pei_2.find('option').remove();
    zona_home.find('option').remove();
    zona_multihome.find('option').remove();
    pe_1.append('<option selected disabled value="0">Ninguno</option>');
    pei_1.append('<option selected disabled value="0">Ninguno</option>');
    pe_2.append('<option selected disabled value="0">Ninguno</option>');
    pei_2.append('<option selected disabled value="0">Ninguno</option>');
    zona_home.append('<option>Seleccionar</option>');
    zona_multihome.append('<option>Seleccionar</option>');

    $.ajax({
        type: "get",
        url: getBaseURL()+'listar/zonas',
        cache: false,
        headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
                case "nop":
                    toastr.error("Error con el servidor");
                    console.log(data['datos']);
                    break;
                case "yes":
                    for (var d in data['datos']) {
                        let val = data['datos'][d]['value'];
                        let desc = data['datos'][d]['description'].replace('Zona: ', '');
                        zona_home.append("<option value="+val+">"+desc+"</option>");
                        zona_multihome.append("<option value="+val+">"+desc+"</option>");
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

    if (aggid == null) {
        agg.on('change.select2', function(){
            $.ajax({
                type: "post",
                url: getBaseURL()+'asignar/equipo',
                data: {id:agg.find('option').val()},
                cache: false,
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            break;
                        case "nop":
                            toastr.error("Error con el servidor");
                            break;
                        case "yes":
                            if (aggid == null) agg.find('option').text(data['datos']);
                            else agg.val(data['datos']);
                            if (!empty(data['ip'])) ip.val(data['ip']);
                            let num = data['ip'].split("").reverse().join("");
                            num = num.substring(num.indexOf('/')+1, num.indexOf('.'));
                            num = num.split("").reverse().join("");
                            num = num.padStart(3, "0");
                            agg_prefix.val(num);
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        });
    } else {
        $.ajax({
            type: "post",
            url: getBaseURL()+'asignar/equipo',
            data: {id:agg_id.val()},
            cache: false,
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("Usuario no autorizado");
                        break;
                    case "nop":
                        toastr.error("Error con el servidor");
                        break;
                    case "yes":
                        if (aggid == null) agg.find('option').text(data['datos']);
                        else agg.val(data['datos']);
                        if (!empty(data['ip'])) ip.val(data['ip']);
                        let num = data['ip'].split("").reverse().join("");
                        num = num.substring(num.indexOf('/')+1, num.indexOf('.'));
                        num = num.split("").reverse().join("");
                        num = num.padStart(3, "0");
                        agg_prefix.val(num);
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    }

    zona_home.on('change', function(){
        pe_1.find('option').remove();
        pei_1.find('option').remove();
        pe_1.append('<option selected disabled value="0">Ninguno</option>');
        pei_1.append('<option selected disabled value="0">Ninguno</option>');
        $("#pe_mlps_btn_1").attr("onClick", "pe_by_zone("+this.value+","+3+",\'"+pe_1.attr('id')+"\')");
        $("#pe_int_btn_1").attr("onClick", "pe_by_zone("+this.value+","+6+",\'"+pei_1.attr('id')+"\')");
    });
    zona_multihome.on('change', function(){
        pe_2.find('option').remove();
        pei_2.find('option').remove();
        pe_2.append('<option selected disabled value="0">Ninguno</option>');
        pei_2.append('<option selected disabled value="0">Ninguno</option>');
        $("#pe_mlps_btn_2").attr("onClick", "pe_by_zone("+this.value+","+3+",\'"+pe_2.attr('id')+"\')");
        $("#pe_int_btn_2").attr("onClick", "pe_by_zone("+this.value+","+6+",\'"+pei_2.attr('id')+"\')");
    });

    $('#accept_relate_agg_pe_pei').unbind().on('click', function(){
        data = {
            agg_prefix:        agg_prefix.val(),
            home_zone_id:      zona_home.val(),
            pe_home_id:        pe_1.find('option').val(),
            pe_home_acr:       pe_1.find('option').text(),
            pei_home_id:       pei_1.find('option').val(),
            pei_home_acr:      pei_1.find('option').text(),
            multihome_zone_id: zona_multihome.val(),
            pe_multihome_id:   pe_2.find('option').val(),
            pe_multihome_acr:  pe_2.find('option').text(),
            pei_multihome_id:  pei_2.find('option').val(),
            pei_multihome_acr: pei_2.find('option').text()
        };
        data.agg_id  = aggid == null ? agg.find('option').val() : aggid;
        data.agg_acr = aggid == null ? agg.find('option').text() : agg.val();

        if (empty(ip.val()) || ip.val() == '-') { toastr.error('No hay IP declarada para este agregador'); }
        else if (empty(data.pe_home_id) || empty(data.pei_home_id) || empty(data.pe_multihome_id) || empty(data.pei_multihome_id)) { toastr.error('Todos los tipos de equipo deben estar seleccionados'); }
        else if (data.home_zone_id == data.multihome_zone_id) { toastr.error('Las zonas home y multihome debe ser distintas'); }
        else if (data.pe_home_id == data.pei_home_id || data.pe_multihome_id == data.pei_multihome_id) { toastr.error('Los equipos home y multihome debe ser distintos'); }
        else {
            $.ajax({
                type: "post",
                url: getBaseURL()+'registrar/agregador/asociacion',
                data: data,
                cache: false,
                headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            break;
                        case "nop":
                            if (data['datos'] == 'Este agregador ya se utiliza en otra asociaci&oacute;n') {
                                toastr.error(data['datos']);
                            } else {
                                toastr.error("Error con el servidor");
                                console.log(data['datos']);
                            }
                            break;
                        case "yes":
                            toastr.success("Operaci&oacute;n exitosa");
                            document.getElementById('close_relate_agg_pe_pei').click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }
    });
}

function select_eq_modal(eq_id, eq_acr, element_id) {
    var query_id = "#"+element_id;
    var element = $(query_id);
    element.find('option').remove();
    element.append('<option selected disabled value="'+eq_id+'">'+eq_acr+'</option>');
    element.trigger('change.select2');
    switch (element_id) {
        case 'pe_mlps_sel_1': document.getElementById('pe_pei_modal_close').click(); break;
        case 'pe_int_sel_1': document.getElementById('pe_pei_modal_close').click(); break;
        case 'pe_mlps_sel_2': document.getElementById('pe_pei_modal_close').click(); break;
        case 'pe_int_sel_2': document.getElementById('pe_pei_modal_close').click(); break;
        case 'agg_sel': document.getElementById('cerra_bus_equipo_agg').click(); break;
    }
    return;
}

function enable_disable_agg(id, status){
    if (status == 'ALTA') {
        var text = "Estás por deshabilitar un equipo agregador";
        var color = "#DD6B55";
        var btn_text = "Sí, deshabilitar";
    } else if (status == 'DESHABILITADO') {
        var text = "Estás por habilitar un equipo agregador";
        var color = "#51a351";
        var btn_text = "Sí, habilitar";
    } else {
        toastr.error('Estado de equipo no válido para esta acción');
        return;
    }
    swal({
        title: "¿Estás seguro?",
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: btn_text,
        cancelButtonText: "No, volver",
        closeOnConfirm: true,
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            url: getBaseURL()+'cambiar/agg/estado',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("No dispone de permisos para realizar esta acción");
                        break;
                    case "nop":
                        toastr.error("Error con el servidor");
                        console.log(data['datos']);
                        break;
                    case "yes":
                        toastr.success("Operación exitosa");
                        $('#agg_assoc_table').DataTable().ajax.reload();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    });
}

function alta_sar_crear(){
    var mensaje = document.getElementById("title_sar");
    mensaje.textContent  = 'REGISTRAR SAR';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "block";
    var aceptar = document.getElementById("alta_sar_pop");
    var cancelar = document.getElementById("baja_sar_pop");
    var modal = document.getElementById('cerra_sar_pop');
    document.getElementById("alta_sar").reset();
    $('#id_equipos').val('0');
    $("#equi_alta").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#nodo_al").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $("#equi_alta").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $('#nodo_al').append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    $("#ip_admin").append('<option selected disabled value="">seleccionar</option>').trigger('change.select2');
    aceptar.onclick = function() {
        var placa = document.getElementsByClassName("placa_alta");
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var equipo = document.getElementById("equi_alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        var port = [];
        for (var i = 0; i < placa.length; ++i) {
            if (typeof placa[i].value !== "undefined") { port.push(placa[i].value); }
        }
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/SAR',
            data: {id:0, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:equipo, port:port, nodo:nodo, id_zone:id_zona},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                        break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                        break;
                    case 'yes':
                        $('#jarvis_sar').DataTable().ajax.reload();
                        toastr.success("Registro Exitoso");
                        modal.click();
                        break;
                }
            },
            error: function(data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors['errors'], function (ind, elem) {
                    toastr.error(elem);
                });
            }
        });
    }
    cancelar.onclick = function() {
        modal.click();
    }
}

function search_sar(id){
    var mensaje = document.getElementById("title_sar");
    mensaje.textContent  = 'MODIFICAR SAR';
    var boton = document.getElementById('boton_buscar_equipo_all');
    boton.style.display = "none";
    var aceptar = document.getElementById("alta_sar_pop");
    var cancelar = document.getElementById("baja_sar_pop");
    var modal = document.getElementById('cerra_sar_pop');
    document.getElementById("alta_sar").reset();
    $('#id_equipos').val(id);
    $("#nodo_al").find('option').remove();
    $("#ip_admin").find('option').remove();
    $("#equi_alta").find('option').remove();
    $("#zone_sel option:selected").removeAttr('selected');
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'buscar/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'nop':
                    toastr.error("Error. Equipo no encontrado");
                    break;
                case 'yes':
                    $('#local_equipmen').val(data['datos']['location']);
                    $("#equi_alta").append('<option selected disabled value="'+data['datos']['id_model']+'">'+data['datos']['model']+'</option>').trigger('change.select2');
                    $('#name').val(data['datos']['acronimo']);
                    $('#ip').val(data['datos']['id_ip']);
                    $('#commen').val(data['datos']['commentary']);
                    $('#alta').val(data['datos']['ir_os_up']);
                    $("#nodo_al").append('<option selected disabled value="'+data['datos']['id_node']+'">'+data['datos']['cell_id']+' '+data['datos']['node']+'</option>').trigger('change.select2');
                    $("#ip_admin").append('<option selected disabled value="'+data['datos']['id_ip']+'">'+data['datos']['ip']+'</option>').trigger('change.select2');
                    $(`#zone_sel option[value="${data['datos']['id_zone']}"]`).attr('selected', 'selected');
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var commen = document.getElementById("commen").value;
        var nodo = document.getElementById("nodo_al").value;
        var ip_admin = document.getElementById("ip_admin").value;
        var local = document.getElementById("local_equipmen").value;
        var name = document.getElementById("name").value;
        var alta = document.getElementById("alta").value;
        var id_zona = document.getElementById("zone_sel").value;
        if (alta == '' || alta.length == 0 ) {
            toastr.error("El IR Alta es obligatorio.")
        }else if (name == '' || name.length == 0 ) {
            toastr.error("El Acronimo es obligatorio.");
        }else if (ip_admin == '' || ip_admin.length == 0) {
            toastr.error("La ip de Gestión es obligatorio.");
        }else if (id_zona == '' || id_zona.length == 0) {
            toastr.error("La zona es obligatoria.");
        }else{
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/SAR',
                data: {id:id, alta:alta, name:name, ip_admin:ip_admin, local:local, commen:commen, equipo:0, port:0, nodo:nodo, id_zone:id_zona},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case 'login':
                            refresh();
                            break;
                        case 'autori':
                            toastr.error("Usuario no autorizado");
                            break;
                        case 'yes':
                            $('#jarvis_sar').DataTable().ajax.reload();
                            toastr.success("Modificación Exitosa");
                            modal.click();
                            break;
                    }
                },
                error: function(data) {
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors['errors'], function (ind, elem) {
                        toastr.error(elem);
                    });
                }
            });
        }
    }
    cancelar.onclick = function() {
        modal.click();
    }
}
function clean_frontier(){
    document.getElementById("alta_frontera").reset();
    $("#equip_A").find('option').remove();
    $('#equip_A').append('<option value="0">seleccionar</option>');
    $("#equip_B").find('option').remove();
    $('#equip_B').append('<option value="0">seleccionar</option>');
    $("#ports_frontier_B").html('');
    $("#ports_frontier_A").html('');
    $("#id_type_equip_A").val(' ');
    $("#id_type_equip_B").val(' ');
    $("#modify_this").val(' ');
    $("#bw_lacp_A").val(' ');
    $("#bw_lacp_B").val(' ');
    $(".equip_type_A").text(" ");
    $(".equip_type_B").text(" ");
    $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'ultima/frontera',
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case 'login':
                    refresh();
                    break;
                case 'autori':
                    toastr.error("Usuario no autorizado");
                    break;
                case 'yes':
                    $("#frontier_number").val(data['data']['n_frontier']);
                    break;
            }
        },
        error: function(data) {
            var errors = $.parseJSON(data.responseText);
            $.each(errors['errors'], function (ind, elem) {
                toastr.error(elem);
            });
        }
    });

}
function lacp_frontier(){
    var type = $("#equip_to_work").val();
    var id = '';
    if(type == 0){
        var id = $('#equip_A').find('option:selected').val();
    } else{
        var id = $('#equip_B').find('option:selected').val();
    }
    var modal = document.getElementById("exit_port_lacp_sevi");
    var mensaje = document.getElementById("title_port_lacp");
    mensaje.textContent  = 'CREAR LACP';
    var new_tbody = document.createElement('tbody');
    $("#port_lacp_sevice").html(new_tbody)
    var cancelar = document.getElementById("lacp_cancelar");
    var aceptar = document.getElementById("lacp_aceptar");
    $('#come_lacp_equi').val('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'puerto/recurso',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['label'] +' '+ data['datos'][i]['f_s_p'] +''+ data['datos'][i]['por_selec'] +'</td>' +
                            '<td>' + data['datos'][i]['model'] + '</td>' +
                            '<td>' + data['datos'][i]['servicios'] + '</td>' +
                            '<td > <input type="checkbox" id="por_lacp" name="por_lacp[]" value="'+ data['datos'][i]['id_po_bo'] +'"></td>'+
                            '</tr>';
                        $("#port_lacp_sevice").append(valor);
                    })
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    cancelar.click();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
    aceptar.onclick = function() {
        var come = document.getElementById('come_lacp_equi').value;
        let lacp = [];
        $('[name="por_lacp[]"]:checked').each(function(){
            lacp.push(this.value);
        });
        if (lacp.length > 0) {
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/lacp',
                data: {id:lacp, come:come},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case "login":
                            refresh();
                            break;
                        case "yes":
                            modal.click();
                            load_lacp_frontier(type);
                            break;
                        case "autori":
                            toastr.error("Usuario no autorizado");
                            cancelar.click();
                            break;
                    }
                },
                error: function() {
                    toastr.error("Error con el servidor");
                }
            });
        }else{
            toastr.error("Seleccione puertos");
        }
    }
    cancelar.onclick = function() {
        var new_tbody = document.createElement('tbody');
        $("#port_lacp_sevice").html(new_tbody)
        modal.click();
    }
}
function load_lacp_frontier(type){
    $("#list_all_lacp_equipmen").html("");
    var id;
    if(type == 0){
        var id = $('#equip_A').find('option:selected').val();
    } else{
        var id = $('#equip_B').find('option:selected').val();
    }
    $("#equip_to_work").val(type);

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'puerto/equipo',
        data: {id:id},
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
                        var valor = '<tr>' +
                            '<td>' + data['group'][i]['lacp_number'] +'</td>' +
                            '<td>' + data['group'][i]['port'] + '</td>' +
                            '<td>' + data['group'][i]['atributo'] + '</td>' +
                            '<td>' + data['group'][i]['commentary'] + '</td>' +
                            '<td >'+
                            '<a onclick="delecte_lacp('+data['group'][i]['id']+');" title="Eliminar LACP"> <i class="fa fa-trash-o"> </i></a> '+
                            '<a onclick="select_lacp('+data['group'][i]['id']+');" title="Seleccionar LACP"> <i class="fas fa-dot-circle"></i></a> '+
                            '</td>'+
                            '<a onclick="select_lacp('+data['group'][i]['id']+');" title="Editar LACP"> <i class="fa fa-edit"></i></a> '+
                            '</td>'+
                            '</tr>';
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
function select_lacp(id){
    let id_lacp_group = id;
    let type = $("#equip_to_work").val();
    let modal_close = $("#cerrar_lacp_frontier");
    let div_to_modify = '';
    let input_lacp = '';
    let interfacc = '';
    if(type == 0){
        var id = $('#equip_A').find('option:selected').val();
        $("#lacp_id_A").val(id);
        div_to_modify = 'ports_frontier_A';
        input_lacp = 'lacp_id_A';
        bw_lacp_input = 'bw_lacp_A';
        interfacc = 'interfaz_a';
    } else{
        var id = $('#equip_B').find('option:selected').val();
        $("#lacp_id_B").val(id);
        div_to_modify = 'ports_frontier_B';
        input_lacp = 'lacp_id_B';
        bw_lacp_input = 'bw_lacp_B';
        interfacc = 'interfaz_b';
    }
    $("#"+div_to_modify).html('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url:getBaseURL()+'puerto/equipo',
        data: {id:id},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    $('#equip').val(id);
                    $("#"+input_lacp).val(id_lacp_group);
                    //Escribir primero en un id hidden que nada el id del lacp para despues guardar el 'nombre interfaz' en el comentario del bundle
                    //Traer los puertos seleccionados y dibujarlos en un div
                    $(data['group']).each(function(i, v){
                        if(data['group'][i]['id'] == id_lacp_group){
                            let ports = (data['group'][i]['port']).split(" ");
                            ports = ports.filter(function(n){ return n != "" })
                            ports_name = [];
                            $(ports).each(function(j,b){
                                if((ports[j] != " ") && (ports[j] != null) ){
                                    ports_name.push(ports[j].replace(/[^A-Za-z]/g, ''));
                                    var valor = "<input type='text' class='form-control' placeholder='' readonly aria-label='port' aria-describedby='basic-addon1' value='"+ ports[j] +"'>"
                                    $("#"+div_to_modify).append(valor);
                                }
                            })
                            $("#"+div_to_modify).append("<span><i>Total:<strong>"+ data['group'][i]['bw_lacp_group'] +"</strong></i></span>");
                            $("#"+bw_lacp_input).val(data['group'][i]['bw_lacp_pure']);
                            $("#"+interfacc).val("Bundle-Ether"+ $("#frontier_number").val());
                            if(($("#bw_lacp_A").val() != " " && $("#bw_lacp_B").val() != " ") && ($("#bw_lacp_A").val() != "" && $("#bw_lacp_B").val() != "") && ($("#bw_lacp_A").val() != $("#bw_lacp_B").val())){
                                toastr.warning("Los valores de bw son distintos, revisar grupo lacp seleccionado");

                            } else if($("#bw_lacp_A").val() == $("#bw_lacp_B").val()){
                                $("#bw_total_frontier").val(data['group'][i]['bw_lacp_group']);
                            }
                            modal_close.click();
                            return;
                        }
                        else{
                            console.log("No se encuentra el grupo LACP");
                            modal_close.click();
                        }
                    })
                    break;
            }
        }
    });
}

function save_frontier(){
    let modal_close = $("#cerrar_frontera_pop")

    let id_zone = $("#id_zone").val();
    let frontier_number = $("#frontier_number").val();
    let equip_A = $( "#equip_A option:selected" ).text();
    let equip_B = $( "#equip_B option:selected" ).text();
    let lacp_id_A = $("#lacp_id_A").val();
    let lacp_id_B = $("#lacp_id_B").val();
    let bw_lacp_A = $("#bw_lacp_A").val();
    let bw_lacp_B = $("#bw_lacp_B").val();
    let interfaz_a = $("#interfaz_a").val();
    let interfaz_b = $("#interfaz_b").val();
    let acronimo_frontier = $("#acronimo_frontier").val();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'agregar/frontera',
        data: {frontier_number:frontier_number, id_zone:id_zone, equip_A:equip_A, equip_B:equip_B, lacp_id_A:lacp_id_A, lacp_id_B:lacp_id_B, bw_lacp_A:bw_lacp_A, bw_lacp_B:bw_lacp_B, interfaz_a:interfaz_a, interfaz_b:interfaz_b, acronimo_frontier:acronimo_frontier},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    return;
                    break;
                case "incomplete":
                    toastr.error("Datos incompletos");
                    return;
                    break;
                case "different":
                    toastr.error("El bw debe ser igual en ambos equipos");
                    return;
                    break;
                case "n_frontier":
                    toastr.error("El numero de frontera ya existe");
                    return;
                    break;
                case "yes":
                    toastr.success("La frontera se agregó de forma exitosa!");
                    modal_close.click();
                    $('#list_frontier_adm_vlan').DataTable().ajax.reload();
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });

}
function list_agg_frontier(type){
    var equip_select = '';
    if(type == 1){
        var id = $("#id_type_equip_B").val();
        var equip_select = 'equip_B';
    } else if(type == 0){
        var id = $("#id_type_equip_A").val();
        var equip_select = 'equip_A';
    }
    $("#list_equipment_frontier").html('');
    var id_zone = $("#id_zone").val();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'listar/equipos/frontera',
        data: {id:id, id_zone:id_zone},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']) {
                case "login":
                    refresh();
                    break;
                case "yes":
                    $("#modify_this").val(equip_select);
                    $(data['datos']).each(function(i, v){ // indice, valor
                        var valor = '<tr>' +
                            '<td>' + data['datos'][i]['acronimo'] + '</td>' +
                            '<td>' + data['datos'][i]['status'] + '</td>' +
                            '<td>' + data['datos'][i]['node'] + '</td>' +
                            '<td > <a title="Seleccionar" onclick="selec_agg_frontier('+data['datos'][i]['id']+');"> <i class="fas fa-dot-circle"></i></a>'+
                            '</tr>';
                        $("#list_equipment_frontier").append(valor);
                    })
                    break;
                case "no":
                    toastr.warning("No se encontraron equipos para esta zona");
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    })
};
function selec_agg_frontier(id){
    var cerrar = $("#cerra_bus_equipo_agg");
    var option = ($("#modify_this").val());
    var selected = $("#"+option+"");
    selected.find('option').remove();
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "POST",
        url: getBaseURL()+'acronimo/equipo',
        data: {id:id,},
        dataType: 'json',
        cache: false,
        success: function(data) {
            switch (data['resul']){
                case "login":
                    refresh();
                    break;
                case "yes":
                    selected.append(
                        '<option value="'+id+'">'+ data['datos']+'</option>'
                    ).trigger('change.select2');
                    if(($("#equip_A option:selected").text()!="seleccionar" && $("#equip_B option:selected").text()!="seleccionar") && $("#equip_A option:selected").text()!="" && $("#equip_B option:selected").text()!=""){
                        let name_A = $("#equip_A option:selected" ).text().substring(0,3);
                        let name_B = $("#equip_B option:selected" ).text().substring(0,3);
                        let frontier_n = $("#frontier_number").val();
                        $("#acronimo_frontier").val("FR-"+name_A+"-"+name_B+"-_"+frontier_n);
                    }
                    cerrar.click();
                    break;
                case "autori":
                    toastr.error("Usuario no autorizado");
                    break;
            }
        },
        error: function(data) {
            toastr.error("Error con el servidor");
        }
    });
}
function enable_disable_frontier(id, status){
    if (status == 'ALTA') {
        var text = "Estás por deshabilitar una Frontera";
        var color = "#DD6B55";
        var btn_text = "Sí, deshabilitar";
    } else if (status == 'DESHABILITADA') {
        var text = "Estás por habilitar una Frontera";
        var color = "#51a351";
        var btn_text = "Sí, habilitar";
    } else {
        toastr.error('Estado de Frontera no válido para esta acción');
        return;
    }
    swal({
        title: "¿Estás seguro?",
        text: text,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: btn_text,
        cancelButtonText: "No, volver",
        closeOnConfirm: true,
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
            url: getBaseURL()+'cambiar/estado/frontera',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case "login":
                        refresh();
                        break;
                    case "autori":
                        toastr.error("No dispone de permisos para realizar esta acción");
                        break;
                    case "nop":
                        toastr.error("Error con el servidor");
                        break;
                    case "yes":
                        swal("Perfecto!", "Modificación en Fronteras exitosa", "success");
                        $('#list_frontier_adm_vlan').DataTable().ajax.reload();
                        break;
                }
            },
            error: function() {
                toastr.error("Error con el servidor");
            }
        });
    });
}

async function get_free_vlans(fun = null) {
    switch (fun) {
        case 10:
            var id_list_use_vlan = 3;
            var id_equipment = document.getElementById("equip_id_inp").value;
            var input = $('#free_vlans_recur3');
            var id_frontier = $('#frt_name_sel').val();
            break;
        case 9:
            var id_list_use_vlan = document.getElementById("use_vlan_recur3").value;
            var id_equipment = document.getElementById("equip").value;
            var input = $('#free_vlans_recur3');
            var id_frontier = null;
            break;
        case 8:
            var id_list_use_vlan = document.getElementById("use_vlan_recur2").value;
            var id_equipment = null;
            var input = $('#free_vlans_recur2');
            var id_frontier = null;
            break;
        case 7:
            var id_list_use_vlan = document.getElementById("use_vlan_recur1").value;
            var id_equipment = null;
            var input = $('#free_vlans_recur1');
            var id_frontier = null;
            break;
        case 6:
            var id_list_use_vlan = 2;
            var id_equipment = document.getElementById('agg').value;
            var input = $('#me_vlan_radio_arr');
            var id_frontier = null;
            break;
        case 5:
            var id_list_use_vlan = 1;
            var id_equipment = document.getElementById('agg').value;
            var input = $('#me_vlan_ls_arr');
            var id_frontier = null;
            break;
        case 4:
            var id_list_use_vlan = 8;
            var id_equipment = document.getElementById('id_lsw').value;
            var input = $('#ipran_vlan_radio_arr');
            var id_frontier = null;
            break;
        case 3:
            var id_list_use_vlan = 7;
            var id_equipment = document.getElementById('id_lsw').value;
            var input = $('#ipran_vlan_ls_arr');
            var id_frontier = null;
            break;
        case 2:
            var id_list_use_vlan = document.getElementById("use_vlan").value;
            var id_equipment = document.getElementById('id_equip_vlan').value;
            var input = $("#free_vlans_arr");
            var id_frontier = document.getElementById("select_frontier").value;
            break;
        case 1:
            var id_list_use_vlan = 1;
            var id_equipment = document.getElementById('id_lsw').value;
            var id_frontier = null;
            break;
        default:
            var id_list_use_vlan = document.getElementById("use_vlan").value;
            var id_equipment = document.getElementById('agg').value;
            var id_frontier = document.getElementById("select_frontier").value;
            break;
    }

    input.val('');

    $.ajax({
        type: "get",
        url: getBaseURL()+'vlan/obtener/'+id_list_use_vlan+'/'+id_equipment+'/'+id_frontier,
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
                    if (data['datos'].length == 0) {
                        toastr.error("No hay Vlan libres de este tipo con este agregador");
                    } else {
                        input.val(JSON.stringify(data['datos'])).trigger('change');
                    }
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

async function next_vlan(fun = null) {
    if (fun == 8) {
        var free_vlans = JSON.parse($('#mtag_arr').val());
        var select = $("#vlan_name_sel_2");
    } else if (fun == 7) {
        var free_vlans = JSON.parse($('#ctag_arr').val());
        var select = $("#ctag_name_sel");
    } else if (fun == 6) {
        var free_vlans = JSON.parse($('#me_vlan_radio_arr').val());
        var select = $("#me_vlan_radio");
    } else if (fun == 5) {
        var free_vlans = JSON.parse($('#me_vlan_ls_arr').val());
        var select = $("#me_vlan_ls");
    } else if (fun == 4) {
        var free_vlans = JSON.parse($('#ipran_vlan_radio_arr').val());
        var select = $("#ipran_vlan_radio");
    } else if (fun == 3) {
        var free_vlans = JSON.parse($('#ipran_vlan_ls_arr').val());
        var select = $("#ipran_vlan_ls");
    } else if (fun == 2) {
        var free_vlans = JSON.parse($('#free_vlans_arr').val());
        var select = $("#free_vlans");
    } else if (fun == 1) {
        var select = $("#free_vlans");
    } else {
        var select = $("#free_vlans");
    }
    if ( select.find('option').val() == 0 ) {
        select.find('option').remove();
        select.append('<option disabled selected value="'+parseInt(free_vlans[0])+'">'+free_vlans[0]+'</option>').trigger('change.select2');
    } else {
        let current = free_vlans.indexOf(select.find('option').text());
        let next = free_vlans[current+1] == undefined ? 0 : current+1;
        select.find('option').remove();
        select.append('<option disabled selected value="'+parseInt(free_vlans[next])+'">'+free_vlans[next]+'</option>').trigger('change.select2');
    }
}

function alta_servicio_recurso_2(service_type){
    const equip = $('#equip_sel');
    const equip_type = document.getElementById('type_equip_sel');
    const agg_type = document.getElementById('agg_type_inp');
    const agg_id = document.getElementById('agg_id_inp');
    const agg_acr = document.getElementById('agg_acr_inp');
    const ring_id = document.getElementById('ring_id_inp');
    const ring_name = document.getElementById('ring_name_inp');
    const form1 = document.getElementById('form1');
    const form2 = document.getElementById('form2');
    const form3 = document.getElementById('form3');
    const form4 = document.getElementById('form4');

    equip.remove('option');
    equip.append('<option selected disabled value="">seleccionar</option>');
    agg_type.value = '';
    agg_id.value = '';
    agg_acr.value = '';
    ring_id.value = '';
    ring_name.value = '';
    form1.style.display = 'none';
    form2.style.display = 'none';
    form3.style.display = 'none';
    form4.style.display = 'none';
    form5.style.display = 'none';

    equip.on('change.select2', function(){
        if (equip_type.value != 4) {
            form1.style.display = 'none';
            form2.style.display = 'none';
            form3.style.display = 'none';
            form4.style.display = 'none';
            form5.style.display = 'block';
        } else {
            $.ajax({
                type: "get",
                url: `${getBaseURL()}equipo/anillo/buscar/${equip.find('option').val()}`,
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
                            if (data['datos'].agg_type == 'AGGI') agg_type.value = 'AGGI';
                            else agg_type.value = '';
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

            if (agg_type.value != 'AGGI' && service_type == '15') {
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form1.style.display = 'block';
            } else if (agg_type.value == 'AGGI' && service_type == '15') {
                form1.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form2.style.display = 'block';
            } else if ((agg_type.value != 'AGGI' && service_type == '20') || (agg_type.value != 'AGGI' && service_type == '24')) {
                form1.style.display = 'none';
                form2.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'none';
                form3.style.display = 'block';
            } else if ((agg_type.value == 'AGGI' && service_type == '20') || (agg_type.value == 'AGGI' && service_type == '24')) {
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form5.style.display = 'none';
                form4.style.display = 'block';
            } else {
                form1.style.display = 'none';
                form2.style.display = 'none';
                form3.style.display = 'none';
                form4.style.display = 'none';
                form5.style.display = 'block';
            }
        }
    })

}

