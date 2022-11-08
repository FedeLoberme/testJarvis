// -------------------url base---------------------------------------
    function getBaseURL () {
        return location.protocol + "//" + location.hostname + (location.port && ":" + location.port) + "/";
    }
//--------------------Funsion de tranformar todo en mayuscula--------------------
    function mayus(e) { 
        e.value = e.value.toUpperCase();
    }
    
//--------------------Funsion de no volver atras--------------------   
    if(history.forward(1)){
        location.replace( history.forward(1) );
    }
//--------------------Funsion de ciut--------------------   
    function user_cuit(){
        var $val=$('#cuit').val(),$length=$val.length;
        if($length==2){
            $('#cuit').val($val+'-');
        }
        if($length==11){
            $('#cuit').val($val+'-');
        }
        if($length>13){
            $('#cuit').val($val.toString().substr(0,13));
        }
    } 

//--------------------Funsion de solo numero y guion-------------------- 
    function num_guion(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /[0-9\-]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }

//--------------------Funsion de numero de telefono-------------------- 
    function cel(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /[0-9\-\+\#\(\)\*]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }

//--------------------Funsion de solo letra-------------------- 
    function letra(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /[a-zA-Z ]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }

//--------------------Funsion de solo numero-------------------- 
    function esNumero(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /^[0-9]*\.?[0-9]*$/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }

    function transfo(){
        var cadena = document.getElementById("username").value;
        cadena = cadena.toUpperCase();
        $('#login #username').val(cadena);
    }
//------------- numero y letra-----------------------
    function Number_letra(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /[0-9a-zA-Z]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }
//--------------------modal de confirmacion-------------------- 
    // Get the modal
    var modal = document.getElementById('confirmacion');
    // Get the button that opens the modal
    var btnSi = document.getElementById("myBtnSi");
    var btnNo = document.getElementById("myBtnNo"); 
    // Get the button that opens the modal
    var mensaje = document.getElementById("myMensaje");
    // When the user clicks the button, open the modal 
    function confirmation(url,msj) {
        modal.style.display = "block";
        mensaje.textContent  = msj;
        btnSi.onclick = function() {
            location.href =url;
        }
        btnNo.onclick = function() {
            modal.style.display = "none";
        }
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

//--------------------enter de confirmacion login-------------------- 
        function enter(e) {
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 13) { login_resul(); }
            return (tecla != 13);
        }

//--------------------modal de confirmacion login-------------------- 
    function login_resul(){        
        var user = $('#login #username').val();
        var password = $('#login #password').val();
        if (user == '' || user == ' ') {
            toastr.error("El campo usuario es obligatorio."); 
        }else{
            if (password == '' || password == ' ') {
            toastr.error("El campo contraseña es obligatorio."); 
            }else{
                var username = user.toUpperCase();
                $('#login #username').val(username);
                $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
                $.ajax({
                    type: "POST",
                    url: "consul/usuario",
                    data: {username:username, password:password},
                    dataType: 'json',
                    cache: false,
                    success: function(data){
                        switch (data['resul']) {
                            case 'nada':
                                toastr.error("Esta credencial no coincide con nuestro registro."); 
                            break;
                            case 'connection':
                                toastr.error("Error en la conexión."); 
                            break;
                            case 'nop':
                                $("#login #inicio").click(); 
                            break;
                            case 'sin':
                                $("#login #inicio").click(); 
                            break;
                            default:
                                var modal = document.getElementById('confirmacion');
                                var btnSi = document.getElementById("myBtnSi");
                                var btnNo = document.getElementById("myBtnNo"); 
                                var mensaje = document.getElementById("myMensaje");
        
                                modal.style.display = "block";
                                mensaje.textContent  = 'Hay una sesion abierta la quiere cerrar';
                                
                                btnSi.onclick = function() {
                                    $("#login #inicio").click();
                                }
                                btnNo.onclick = function() {
                                    modal.style.display = "none";
                                    $('#login #username').val("");
                                    $('#login #password').val("");
                                }
                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        btnNo.click();
                                    }
                                }
                        }
                    }
                });
            }
        }
    }
//--------------------funcion sin espacio en blanco-------------------- 
    function blankSpace(e) {
        var tecla = (document.all) ? e.keyCode : e.which;

        //Tecla de retroceso para borrar, siempre la permite
        if (tecla == 8) {
            return true;
        }

        // Patron de entrada, en este caso solo acepta numeros y letras
        var patron = /[A-Za-z0-9#@-]/;
        var tecla_final = String.fromCharCode(tecla);
        return patron.test(tecla_final);
    }

    //--------------------Funsion de IP-------------------- 
    function val_ip(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla == 8) return true;
        patron = /[0-9\.]/;
        te = String.fromCharCode(tecla);
        return patron.test(te);
    }

    function number_decimal(evt,input){
        // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
        var key = window.Event ? evt.which : evt.keyCode;    
        var chark = String.fromCharCode(key);
        var tempValue = input.value+chark;
        if(key >= 48 && key <= 57){
            if(filter(tempValue)=== false){
                return false;
            }else{       
                return true;
            }
        }else{
              if(key == 8 || key == 13 || key == 0) {     
                  return true;              
              }else if(key == 46){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
              }else{
                  return false;
              }
        }
    }

    function filter(__val__){
        var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
        if(preg.test(__val__) === true){
            return true;
        }else{
           return false;
        }
        
    }

    function confimar_placa(id){
        var mens = 'Está seguro que quiere desactivar la placa';
        var url = getBaseURL() +'desactivar/relacion/'+id;
        confirmation(url,mens);
    }

    function active_placa(id){
        location.href = getBaseURL() +'activar/relacion/'+id;
    }

    //--------------------Funcion de bienvenido --------------------
    $(document).ready(function() {
        
        var url = getBaseURL();
        var flag = true;
        var ip_server = location.hostname;

        if(ip_server == '10.92.197.196' || ip_server == 'jarvisweb02atl.claro.amx'){
            $("#clear_server_status").addClass("badge-primary");
            $('#clear_server_status').html('Servidor Testing');
        } else if(ip_server == '10.92.197.197' || ip_server == 'jarvisweb03adl.claro.amx'){
            $("#clear_server_status").addClass("badge-warning");
            $('#clear_server_status').html('Servidor Desarrollo');
            } else if(url =='http://localhost/'){
                $("#clear_server_status").addClass("badge-success");
                $('#clear_server_status').html('Servidor Local');
                }

        if(flag){
            if(location.href== url +'home'){
                    toastr.success('Bienvenido a JARVIS');
                flag = false;
                if(ip_server == '10.92.197.196' || ip_server == 'jarvisweb02atl.claro.amx'){
                    createNoty('Servidor de Testing [Testear y avisar por bugs o problemas en funcionabilidades dentro de JARVIS &#128187;]', 'testing');
                    $('.page-alert .close').click(function(e) {
                        e.preventDefault();
                        $(this).closest('.page-alert').slideUp();
                    });
                } else if(ip_server == '10.92.197.197' || ip_server == 'jarvisweb03adl.claro.amx'){
                    createNoty('Servidor de desarrollo [Hacer pruebas directas de lo recien desarrollado &#x1f9ea;]', 'development');
                    $('.page-alert .close').click(function(e) {
                        e.preventDefault();
                        $(this).closest('.page-alert').slideUp();
                    });
                    } else if(url =='http://localhost/'){
                        createNoty('Servidor local [Desarrollar tranquilo &#x2615]', 'localhost');
                        $('.page-alert .close').click(function(e) {
                            e.preventDefault();
                            $(this).closest('.page-alert').slideUp();
                        });
                        }
            }
        }
    //--------Funcion de doghnuts/tortas ---------
    if ( document.getElementById( "doughnutChart" )) {
        var doughnutData = {
            labels: ["Usados","Libres","lorem" ],
            datasets: [{
                data: [300,50,100],
                backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
            }]
        } ;


        var doughnutOptions = {
            responsive: false,
            legend: {
                display: false
            }
        };


        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});

        var doughnutData = {
            labels: ["Usados","Libres","lorem" ],
            datasets: [{
                data: [70,27,85],
                backgroundColor: ["#a3e1d4","#dedede","#9CC3DA"]
            }]
        } ;


        var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
        new Chart(ctx4, {type: 'doughnut', data: doughnutData, options:doughnutOptions});
    }
    //--------Funcion de contador ---------
    
        $('.count').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });

     //--------Funcion de tab/popup "Crear sub-red" ---------
    var currentBoxNumber = 0;
    // Focus en otro input al poner un '.' || alcanzar max length
    $(".crear_subred").keyup(function (event) {

        textboxes = $("input.crear_subred");
        currentBoxNumber = textboxes.index(this);

        /* if($(this).val().length > 2) {
            nextBox = textboxes[currentBoxNumber + 1];
                nextBox.focus();
                nextBox.select();
                event.preventDefault();
                return false;
        } */
        if ((event.keyCode == 190 || event.keyCode == 191 || event.keyCode == 110 || event.keyCode == 111 || event.keyCode == 188 ) && textboxes[currentBoxNumber + 1] != null) {
                nextBox = textboxes[currentBoxNumber + 1];
                nextBox.focus();
                nextBox.select();
                event.preventDefault();
                return false;
        }
    });

    //--------Funcion de seleccionar todos los inputs de ips ---------
    function checkAll(bx) {
        var cbs = document.getElementsByTagName('input');
        for(var i=0; i < cbs.length; i++) {
          if(cbs[i].type == 'checkbox') {
            cbs[i].checked = bx.checked;
          }
        }
      }
    //------Admin Radio ------------
    
    $(document).ready(function(){
        $("#code_ne").on("input", function(){
            // Print entered value in a div box
            //$("#result").text($(this).val());
            console.log($(this).val());
        });
    });
    
    function cambio_modelo(modelo){
        //console.log(modelo.value)
        
        //vaciar selects
        $('#frecuencia_odu')
            .find('option')
            .remove()
            .end()
            .append('<option value="default">seleccionar</option>')
            .val('default')
        ;
        $('#tamano_antena')
            .find('option')
            .remove()
            .end()
            .append('<option value="default">seleccionar</option>')
            .val('default')
        ;

        let nombre = ($('#equi_alta').find("option:selected").text())
        $('#modelo_radio_info').val(nombre);
        if (nombre.includes("NOKIA")){
            $("#display_ne_id").fadeIn("slow");
            $(".display_ne_id").fadeIn("slow");
            document.getElementById("acronimoA").value = "RA00";
        }else{
            $("").hide();
        };

        if (nombre.includes("HUAWEI")){
            document.getElementById("acronimoA").value = "CRH00";
            $(".display_ip_loopback").fadeOut("slow");
        };
        if (nombre.includes("ALCATEL")){
            document.getElementById("acronimoA").value ="CRA00";
        }else{
            $("").hide();
        };
    }
    
    $("#code_ne").change(function() {
        alert("asd");
        let codigo_ne = $('input[name = code_ne]').val(); 
        console.log(codigo_ne);
        document.getElementById("ne_id_info").value = codigo_ne;
    });
    
    function cambio_cliente(){
        let nombre = ($('#client_sub_red').find("option:selected").text())
        acronimoB = nombre.substr(0,3);
        document.getElementById("acro").value = acronimoB+"AAAA"+"00"+"RA"+"00";
    }
    function hideSelect() {
        var equipo = document.getElementById('boton_buscar_equipo_all');
        var ip = document.getElementById('boton_buscar_ip');
        var LoopBack = document.getElementById('boton_buscar_LoopBack');
        if($('.checkbox_radio').is(":checked")){
            $(".radio_select").fadeIn("slow");
            equipo.style.display = "none";
            ip.style.display = "none";
            LoopBack.style.display = "none";
        }else{
            $("#alta_radio").find('option').remove();
            $("#alta_radio").append('<option value="">seleccionar</option>').trigger('change.select2');
            $("#equi_alta").find('option').remove();
            $("#equi_alta").append('<option value="">seleccionar</option>').trigger('change.select2');
            $("#ip_admin").find('option').remove();
            $("#ip_admin").append('<option value="">seleccionar</option>').trigger('change.select2');
            
            $(".radio_select").hide();
            equipo.style.display = "block";
            ip.style.display = "block";
            LoopBack.style.display = "block";
        };
    }

    function createNoty(message, type) {
        var html = '<div class="alert-' + type + ' alert-dismissable page-alert">';    
        html += '<button type="button" class="close"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
        html += '<center style="padding-top:2px;">' + message + '</center>';
        html += '</div>';    
        $(html).hide().prependTo('#noty-holder').slideDown();
    };
    
    $('#select_option_reserve').change(function(){
        if($(this).val() == '2'){
            $("#reserve_input").fadeIn("slow");
        } else{
          $("#reserve_input").hide();
        }
    });

    //   Funcion para conseguir el bw de un equipo en change de select
    $('#select_option_reserve').on('change', function() {
        if(this.value == 1){
            $('#bw_equipment_info').show();
            let id_equipment = $("#equip").val();
            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'reserve/equipment',
                data: {id_equipment:id_equipment,},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']){
                        case "login":
                            refresh();
                        break;
                        case "yes":
                            $("#bw_equipment").val(data['bw_equipment']);
                        break;
                        case "no":
                            toastr.error("No se puede calcular el bw del equipo");
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
        } else if(this.value == 2){
            $('#bw_equipment_info').hide();
        }
      });

      // Funcion para Frontera
      function choose_type_equipment(){
        //3 PE
        //6 PEI
        //5 DM
        //8 SAR 
        if(($("#id_type_frontier").find(":selected").val() != 0) && ($("#id_type_service").find(":selected").val() != 0) ){
            let type_frontier = $("#id_type_frontier").find(":selected").val();
            let type_service = $("#id_type_service").find(":selected").val();

            $("#id_zone").val("0");
            $("#equip_A").val("0");
            $("#equip_B").val("0");
            $("#id_zone").val("0");
            if(type_frontier == 1 && type_service == 1){
                $('.equip_type_A').html('Router PEI');
                $('.equip_type_B').html('Router DM');
                $('#id_type_equip_A').val(6);
                $('#id_type_equip_B').val(5);
                
            }
            if(type_frontier == 1 && type_service == 2){
                $('.equip_type_A').html('Router PE');
                $('.equip_type_B').html('Router DM');
                $('#id_type_equip_A').val(3);
                $('#id_type_equip_B').val(5);
            }
            if(type_frontier == 1 && type_service == 3){
                $('.equip_type_A').html(' - ');
                $('.equip_type_B').html(' - ');
                $('#id_type_equip_A').val('');
                $('#id_type_equip_B').val('');
                toastr.error('Tipo de conexi&oacute;n inv&aacute;lido');
            }
            if(type_frontier == 2 && type_service == 1){
                $('.equip_type_A').html('Router PEI');
                $('.equip_type_B').html('Router SAR');
                $('#id_type_equip_A').val(6);
                $('#id_type_equip_B').val(8);
            }
            if(type_frontier == 2 && type_service == 2){
                $('.equip_type_A').html('Router PE');
                $('.equip_type_B').html('Router SAR');
                $('#id_type_equip_A').val(3);
                $('#id_type_equip_B').val(8);
            }
            if(type_frontier == 2 && type_service == 3){
                $('.equip_type_A').html('Router DM');
                $('.equip_type_B').html('Router SAR');
                $('#id_type_equip_A').val(5);
                $('#id_type_equip_B').val(8);
            }
          }
      };

    
// Inspired by PHP empty function
function empty(n){
    return !(!!n ? typeof n === 'object' ? Array.isArray(n) ? !!n.length : !!Object.keys(n).length : true : false);
}

/**
 * Función para manejar errores en peticion ajax.
 * Status 200: Para casos de mensajes predeterminados.
 * Otros errores: Logicos, sintaxis, ruta inexistente, etc. da error con servidor.
 * La peticion ajax debe ser dataType JSON.
 * @param {*} r respuesta enviada desde controlador
 * @returns void
 */
function ajaxErrorHandler(r) {
    if (r.status === 200) {
        if (r.responseText === 'login') refresh();
        else if (r.responseText === 'autori') toastr.error("No tiene permisos para esta operación");
        else toastr.error(r.responseText);
    } else {
        toastr.error("Error con el servidor");
    }
    return;
}