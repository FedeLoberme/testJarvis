//--Funsion de mostrar permiso en tiempo real en modificar perfil----------
    function ShowSelected(){
        var cod = document.getElementById("perfil").value;
        $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        var url = getBaseURL() +'buscar/perfil';
        $.ajax({
                type: "POST",
                url: url,
                data: {cod:cod},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    var new_tbody = document.createElement('tbody');
                    $("#tbodyprofile").html(new_tbody);
                    if (data[0]['contar'] > 0) {
                        for (  i = 0 ; i <= data[0]['contar']; i++){
                            var valor = '<tr>' +
                                            '<td>' + data[i].appli + '</td>' +
                                            '<td>' + data[i].permi + '</td>' +
                                        '</tr>';
                            $("#tbodyprofile").append(valor)  
                        }
                    } 
                }
            });
    }

//--------------------Funsion para mostrar el cliente-------------------- 
    function mostrar(name) {
        var social = $("#name").val();
        social = social.toUpperCase();
        social = social.trim();
        social = social.replace(/\s{2,}/g, ' ');
        if(social.length > 0 && social != "0") {
            $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: "../buscar/cliente",
                data: {social:social},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 'sip') {
                        var elemento = document.getElementById("name");
                            elemento.className += " error";
                        $('#Razon_exitoso').text('La razón social "' + data['name']+ '" existe con el acronimo: '+data['acronimo']);
                    }else {
                        $('#name').removeClass("error");
                        $('#Razon_exitoso').text(data['name']);
                    }
                }
            });
        } else {
            $('#name').removeClass("error");
            $('#Razon_exitoso').text("");
        } 
    }

    //--------------------Funsion para mostrar el cuit-------------------- 
    function cuit_msj(cuit) {
        var cuit = $("#cuit").val();
        if(cuit.length > 10 && cuit != "0") {
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'buscar/cuit',
                data: {cuit:cuit},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 'sip') {
                        var elemento = document.getElementById("cuit");
                            elemento.className += " error";
                        $('#Cuit_exitoso').text('El CUIT existe con la razón social "' + data['name']+ '" y el acronimo "'+data['acronimo']+'"');
                    }else {
                        $('#cuit').removeClass("error");
                        $('#Cuit_exitoso').text(data['name']);
                    }
                }
            });
        } else {
            $('#cuit').removeClass("error");
            $('#Cuit_exitoso').text("");
        } 
    }


//--------------------Funsion para mostrar el acronimo-------------------- 
    function acronimo_msj(acronimo) {
        var acronimo = $("#acronimo").val();
        acronimo = acronimo.toUpperCase();
        if(acronimo.length > 3 && acronimo != "0") {
            $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'buscar/acronimo',
                data: {acronimo:acronimo},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 'sip') {
                        var elemento = document.getElementById("acronimo");
                            elemento.className += " error";
                        $('#Acronimo_exitoso').text('El acronimo existe con la razón social "' + data['name']+ '"');
                    }else {
                        $('#acronimo').removeClass("error");
                        $('#Acronimo_exitoso').text(data['name']);
                    }
                }
            });
        } else {
            $('#acronimo').removeClass("error");
            $('#Acronimo_exitoso').text("");
        } 
    }

//--------------------Funsion para validar el cliente--------------------     
    function validate_acronimo(){
        var patron = /[0-9]{11,11}/;
        var name = document.getElementById("name").value.toUpperCase().trim();
        var functi = document.getElementById("functi").value;
        name = name.replace(/\s{2,}/g, ' ');
        var cuit = document.getElementById("cuit").value;
        var acronimo = document.getElementById("acronimo").value;
        if ( name == "" || name.length < 1 ){
            toastr.error("La razón social es obligatorio");
        } else if (cuit == "" || cuit.length < 1){
            toastr.error("el CUIT es obligatorio");
        } else if (acronimo == "" || acronimo.length < 1){
            toastr.error("El acronimo es obligatorio.");
        } else if (!(patron.test(cuit))) {
            toastr.error("El CUIT no es valido falta caracteres. solo 11 numero");
        }else{
            $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'validar/acronimo',
                data: {name:name, cuit:cuit, acronimo:acronimo, id:0},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 4) {
                        new_acronimo(name, cuit, acronimo, functi);
                    }else{
                        if (data['resul'] == 1) {
                            toastr.error("La Razón social y CUIT existe");
                        }else{
                            var msj = '';
                            switch (data['resul']) {
                                case 3:
                                    msj = 'El CUIT existe con la razon social "' + data['name'] + ' ". ¿Desea continuar guardando?';
                                break;
                                case 2:
                                    msj = 'La razón social existe con el CUIT "' + data['cuit'] + ' ". ¿Desea continuar guardando?';
                                break;
                                case 5:
                                    msj = 'La razón social y el acronimo existe. ¿Desea continuar guardando?';
                                break;
                                case 0:
                                    msj = 'El acronimo existe con la razon social "' + data['name'] + ' ". ¿Desea continuar guardando?' ;
                                break;
                                case 6:
                                    msj = 'El CUIT y el acronimo existe. ¿Desea continuar guardando?';
                                break;
                                case 7:
                                    msj = 'La razón social y el CUIT existe. ¿Desea continuar guardando?';
                                break;
                            }
                            $('#name').attr('disabled', '');
                            $('#cuit').attr('disabled', '');
                            $('#acronimo').attr('disabled', '');
                            var modal = document.getElementById('confirmacion');
                            var btnSi = document.getElementById("myBtnSi");
                            var btnNo = document.getElementById("myBtnNo"); 
                            var mensaje = document.getElementById("myMensaje");
                            modal.style.display = "block";
                            mensaje.textContent  = msj;  
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    btnNo.click();
                                }
                            } 
                            btnSi.onclick = function() {
                                $('#name').removeAttr('disabled');
                                $('#cuit').removeAttr('disabled');
                                $('#acronimo').removeAttr('disabled');
                                new_acronimo(name, cuit, acronimo);
                            }
                            btnNo.onclick = function() {
                                $('#name').removeAttr('disabled');
                                $('#cuit').removeAttr('disabled');
                                $('#acronimo').removeAttr('disabled');
                                modal.style.display = "none";
                            }
                        }
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

//--------------------Funsion para registra el cliente-------------------- 
    function new_acronimo(name, cuit, acronimo, functi=null){
        var modal = document.getElementById("cerrar_cliente"); 
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'registrar/cliente',
            data: {name:name, cuit:cuit, acronimo:acronimo},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'yes':
                        toastr.success("Registro Exitoso");
                        if (functi == null || functi == "Cliente") {
                            $('#cliente').DataTable().ajax.reload();
                            modal.click();
                        }else{
                            client_table_select();
                            modal.click();                        
                        }
                    break;
                    case 'login':
                        refresh();
                    break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                    break;
                }                
            }
        });  
    }

//--------------------Funsion para refrescar-------------------- 
    function refresh(){
        location.reload(true);
    }

//--------------------Funsion para buscar cliente-------------------- 
    function search_acronimo(id){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'modificar/cliente',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'yes') {
                    document.clip_edit.name.value = data['name'];
                    $('#clip_edit #cuit').val(data['cuit']);
                    $('#clip_edit #acronimo').val(data['acronimo']);
                    $('#clip_edit #id').val(data['id']);
                }else{ 
                    if (data['resul'] == 'home') {
                        toastr.error("Usuario no autorizado");
                        var int=self.setInterval('refresh()',700);
                    }else{
                        if (data['resul'] == "no") {
                            toastr.success("Cliente no encontrado");
                            var int=self.setInterval('refresh()',700); 
                        }else{
                            window.location.href ="/jarvis";
                        }
                    }
                }
            }
        });  
    }
//--------------------Funsion para validar modificacion cliente-------------------- 
    function edict_validate_acronimo(){
        var patron = /[0-9]{11,11}/;
        var name = $('#clip_edit #name').val();
        name = name.toUpperCase();
        name = name.trim();
        name = name.replace(/\s{2,}/g, ' ');
        var cuit = $('#clip_edit #cuit').val();
        var acronimo = $('#clip_edit #acronimo').val();
        acronimo = acronimo.toUpperCase();
        var id = $('#clip_edit #id').val();
        if (name == "" || name.length < 1 ){
            toastr.error("La razón social es obligatorio");
        } else if (cuit == "" || cuit.length < 1){
            toastr.error("El CUIT es obligatorio");
        } else if (acronimo == "" || acronimo.length < 1){
            toastr.error("El acronimo es obligatorio.");
        } else if (!(patron.test(cuit))) {
            toastr.error("El CUIT no es valido. solo 11 numero");
        }else{
            $.ajaxSetup({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'validar/acronimo',
                data: {name:name, cuit:cuit, acronimo:acronimo, id:id},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 4) {
                        edict_acronimo(name, cuit, acronimo, id);
                    }else{
                        if (data['resul'] == 1) {
                            toastr.error("La Razón social y CUIT existe");
                        }else{
                            var msj = '';
                            switch (data['resul']) {
                                case 3:
                                    msj = 'El CUIT existe con la razon social "' + data['name'] +'" ¿Desea continuar guardando?' ;
                                break;
                                case 2:
                                    msj = 'La razón social existe con el CUIT "' + data['cuit'] +'" ¿Desea continuar guardando?';
                                break;
                                case 0:
                                    msj = 'El acronimo existe con la razon social "' + data['name'] +'" ¿Desea continuar guardando?';
                                break;
                                case 5:
                                    msj = 'La razón social y el acronimo existe. ¿Desea continuar guardando?';
                                break;
                                case 6:
                                    msj = 'El CUIT y el acronimo existe. ¿Desea continuar guardando?';
                                break;
                                case 7:
                                    msj = 'La razón social y el CUIT existe. ¿Desea continuar guardando?';
                                break;
                            }
                            $('#clip_edit #name').attr('disabled', '');
                            $('#clip_edit #cuit').attr('disabled', '');
                            $('#clip_edit #acronimo').attr('disabled', '');
                            var modal = document.getElementById('confirmacion');
                            var btnSi = document.getElementById("myBtnSi");
                            var btnNo = document.getElementById("myBtnNo"); 
                            var mensaje = document.getElementById("myMensaje");
                            modal.style.display = "block";
                            mensaje.textContent  = msj;   
                            btnSi.onclick = function() {
                                $('#clip_edit #name').removeAttr('disabled');
                                $('#clip_edit #cuit').removeAttr('disabled');
                                $('#clip_edit #acronimo').removeAttr('disabled');
                                edict_acronimo(name, cuit, acronimo, id);
                            }
                            btnNo.onclick = function() {
                                $('#clip_edit #name').removeAttr('disabled');
                                $('#clip_edit #cuit').removeAttr('disabled');
                                $('#clip_edit #acronimo').removeAttr('disabled');
                                modal.style.display = "none";
                                // refresh();
                            }
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    btnNo.click();
                                }
                            }
                        }
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
//--------------------Funsion para modificar cliente-------------------- 
    function edict_acronimo(name, cuit, acronimo, id){
        var modal = document.getElementById("cerrar_edic_client");
        $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'editar/cliente',
            data: {name:name, cuit:cuit, acronimo:acronimo, id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == "yes") {
                    toastr.success("Modificación Exitosa");
                }else{ if (data['resul'] == 'home') {
                            toastr.error("Usuario no autorizado");
                        }else{
                            if (data['resul'] == "no") {
                                toastr.error("Cliente no encontrado");
                            }else{
                                window.location.href ="/jarvis";
                            }
                        }
                }
                $('#cliente').DataTable().ajax.reload();
                modal.click();
            }
        });
    } 

//--------------------Funsion para formulario del selec de equipo-------------------- 
    function EquiSelected(){
        var equipo = document.getElementById("equipo").value;
        var equipo2 = document.getElementById("equipo2").value;
        var marca2 = document.getElementById('marca2');
        var modelo2 = document.getElementById('modelo2');
        var sap2 = document.getElementById('sap2');
        var status2 = document.getElementById('status2');
        var descri2 = document.getElementById('descri2');
        var max2 = document.getElementById('max2');
        var licen2 = document.getElementById('licen2');
        var encrip2 = document.getElementById('encrip2');
        var alimenta2 = document.getElementById('alimenta2');
        var dual2 = document.getElementById('dual2');
        var full2 = document.getElementById('full2');
        var multi2 = document.getElementById('multi2');
        var banda2 = document.getElementById('banda2');
        var radio2 = document.getElementById('radio2');
        var modulo2 = document.getElementById('modulo2');
        banda2.style.display = "block";
        radio2.style.display = "block"; 
        var combo = document.getElementById("equipo");
        var selected = combo.options[combo.selectedIndex].text;
        $('#new_equipment #nom_equipo').val(selected);  

        switch (selected) {
            // Router
            case 'ROUTER':
                banda2.style.display = "none";
                radio2.style.display = "none";
                $('#banda').val("");
                $('#radio').val("");
                licen2.style.display = "block";
                dual2.style.display = "block";
                full2.style.display = "block";
                multi2.style.display = "block";
                encrip2.style.display = "block";
            break;
            // Radio
            case 'RADIO':
                dual2.style.display = "none";
                encrip2.style.display = "none";
                full2.style.display = "none";
                multi2.style.display = "none";
                $('#n_encrip').val("");
                $('#dual').val("");
                $('#full').val("");
                $('#multi').val("");
                licen2.style.display = "block";
                banda2.style.display = "block";
                radio2.style.display = "block";
            break;
            // Lanswitch
            case 'LANSWITCH': 
                licen2.style.display = "none";
                dual2.style.display = "none";
                full2.style.display = "none";
                multi2.style.display = "none";
                encrip2.style.display = "none";
                banda2.style.display = "none";
                radio2.style.display = "none";
                $('#banda').val("");
                $('#radio').val("");
                $('#n_licen').val("");
                $('#dual').val("");
                $('#full').val("");
                $('#multi').val("");
                $('#n_encrip').val("");
            break;
            case 'SAR': 
                licen2.style.display = "none";
                dual2.style.display = "none";
                full2.style.display = "none";
                multi2.style.display = "none";
                encrip2.style.display = "none";
                banda2.style.display = "none";
                radio2.style.display = "none";
                $('#banda').val("");
                $('#radio').val("");
                $('#n_licen').val("");
                $('#dual').val("");
                $('#full').val("");
                $('#multi').val("");
                $('#n_encrip').val("");
            break;
            default:
                licen2.style.display = "block";
                dual2.style.display = "block";
                full2.style.display = "block";
                multi2.style.display = "block";
                encrip2.style.display = "block";
                banda2.style.display = "block";
                radio2.style.display = "block";
            break;
        }
    }  

//--------------------Funsion para registra en el inventario-------------------- 
    function new_equipo(){
        var equipo = $('#new_equipment #equipo').val();
        var marca = $('#new_equipment #marca').val();
        var modelo = $('#new_equipment #modelo').val();
        var sap = $('#new_equipment #sap').val();
        var status = $('#new_equipment #status').val();
        var descri = $('#new_equipment #descri').val();
        var image = $('#new_equipment #image').val();
        var n_max = $('#new_equipment #n_max').val();
        var max = $('#new_equipment #max').val();
        var n_licen = $('#new_equipment #n_licen').val();   
        var licen = $('#new_equipment #licen').val();
        var n_encrip = $('#new_equipment #n_encrip').val();
        var encrip = $('#new_equipment #encrip').val();
        var alimenta = $('#new_equipment #alimenta').val();
        var dual = $('#new_equipment #dual').val(); 
        var full = $('#new_equipment #full').val();
        var multi = $('#new_equipment #multi').val();
        var banda = $('#new_equipment #banda').val();
        var radio = $('#new_equipment #radio').val();
        var modulo = $('#new_equipment #modulo').val();   
        var nom_equipo = $('#new_equipment #nom_equipo').val();   
        var equipo_funtion = $('#new_equipment #funtion').val();   
        if (equipo == "" || equipo == null ){
            toastr.error("El Tipo de equipo es obligatorio");
        } else if (marca == "" || marca == null){
            toastr.error("La Marca es obligatorio");
        } else if (modelo == "" || modelo.length < 1){
            toastr.error("El Modelo es obligatorio.");
        } else if (sap == "" || sap.length < 1) {
            toastr.error("El Código sapo es obligatorio");
        }else if (status == "" || status == null) {
            toastr.error("El Estatus es obligatorio");
        }else if (descri == "" || descri.length < 1) {
            toastr.error("La Descripción es obligatorio");
        }else if (n_max == "" || n_max.length < 1){
            toastr.error("El Bandwitdh max es obligatorio");
        }else if (alimenta == "" || alimenta == null){
            toastr.error("La Alimentación es obligatoria");
        }else if (modulo == "" || modulo.length < 1){
            toastr.error("La Modulos / slots (Cant.) son obligatorios");
        }else if (equipo_funtion.length < 1){
            toastr.error("La Función es obligatoria");
        }else{
            switch (equipo) {
                // Router
                case '1':
                    if (n_licen == "" || n_licen.length < 1){
                    return toastr.error("La Bandwitdh básico licenciado es obligatorio");
                    }else if (n_encrip == "" || n_encrip.length < 1){
                        return toastr.error("La Bandwitdh c/encripción es obligatorio");
                    }else if (dual == "" || dual == null){
                        return toastr.error("El Dual stack es obligatorio");
                    }else if (full == "" || full == null){
                        return toastr.error("La Full table es obligatorio");
                    }else if (multi == "" || multi == null){
                        return toastr.error("La Multivrf es obligatorio");
                    }
                break;
                // Radio
                case '2':
                    if (n_licen == "" || n_licen.length < 1){
                    return toastr.error("La Bandwitdh básico licenciado es obligatorio");
                    }else if (banda == "" || banda == null){
                        return toastr.error("La Banda es obligatorio");
                    }else if (radio == "" || radio == null){
                        return toastr.error("El Tipo radio es obligatorio");
                    }
                break;
            }
            var fileInput = document.getElementById('image');
            var filePath = fileInput.value;

            var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
            if (image != ''|| image.length > 1) {
                if(!allowedExtensions.exec(filePath) ){
                    return toastr.error("El Formato de la igangen debe ser .jpeg/.jpg/.png/.gif");
                }
            }
            var id = $('#new_equipment #id_editar').val();;
            $.ajaxSetup({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'validar/modelo',
                data: {equipo:equipo, marca:marca, modelo:modelo, id:id, alimenta:alimenta},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 'nop') {
                        $('#equipo').removeAttr('disabled');
                        $('#new_equipment #new_equi').removeAttr('disabled');
                        $("#new_equipment #new_equi").click();
                    }else{
                        return toastr.error("El quipo ya existe");
                    }
                }
            });
            
        }
    } 

//--------------------Funsion para ver detalle del equipo-------------------- 
    function detal(id){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
                type: "POST",
                url: getBaseURL() +'detalle/modelo',
                data: {id:id},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case 'login':
                            
                        break;
                        case 'autori':
                            
                        break;
                        case 'yes':
                            switch (data['datos']['id']) {
                                case '1':
                                    $('#detal_licen2').show();
                                    $('#detal_dual2').show();
                                    $('#detal_full2').show();
                                    $('#detal_multi2').show();
                                    $('#detal_encrip2').show();
                                    $('#detal_banda2').hide();
                                    $('#detal_radio2').hide();
                                break;
                                case '2':
                                    $('#detal_licen2').show();
                                    $('#detal_banda2').show();
                                    $('#detal_radio2').show();
                                    $('#detal_dual2').hide();
                                    $('#detal_encrip2').hide();
                                    $('#detal_full2').hide();
                                    $('#detal_multi2').hide();
                                break;
                                case '3':
                                    $('#detal_licen2').hide();
                                    $('#detal_dual2').hide();
                                    $('#detal_full2').hide();
                                    $('#detal_multi2').hide();
                                    $('#detal_banda2').hide();
                                    $('#detal_encrip2').hide();
                                    $('#detal_radio2').hide();
                                break;
                                default:
                                    $('#detal_licen2').show();
                                    $('#detal_dual2').show();
                                    $('#detal_full2').show();
                                    $('#detal_multi2').show();
                                    $('#detal_encrip2').show();
                                    $('#detal_banda2').show();
                                    $('#detal_radio2').show();
                                break;
                            }
                            $('#detal_equipo').val(data['datos']['equipo']); 
                            $('#detal_marca').val(data['datos']['marca']);
                            $('#detal_modelo').val(data['datos']['model']);
                            $('#detal_sap').val(data['datos']['cod_sap']);
                            $('#detal_status').val(data['datos']['status']);
                            $('#detal_descri').text(data['datos']['description']);
                            $('#detal_alimenta').val(data['datos']['electrical_power_supply']);
                            $('#detal_modulo').val(data['datos']['model_slots']);
                            $('#detal_n_max').val(data['datos']['bw_max_hw']);
                            $('#detal_n_encrip').val(data['datos']['bw_encriptado']);
                            $('#detal_n_licen').val(data['datos']['bw_bas_lic'])
                            $('#detal_dual').val(data['datos']['dual_stack']);
                            $('#detal_full').val(data['datos']['full_table']);
                            $('#detal_multi').val(data['datos']['multivrf']);
                            $('#detal_radio').val(data['datos']['t_radio']);
                            $('#detal_banda').val(data['datos']['banda']);
                        break;
                    }      
                }
            });
    }

//--------------------Funsion para activar la modificacion del equipo-------------------- 
    function editar_equipo_boton(id){
        var mensaje = document.getElementById("title_equip");
        mensaje.textContent = 'MODIFICAR EL EQUIPO';
        $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
                type: "POST",
                url: getBaseURL() +'buscar/modelo',
                data: {id:id},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    $('#id_editar').val(id); 
                    $('#dual').val(data['dual_stack']);
                    $('#full').val(data['full_table']);
                    $('#multi').val(data['multivrf']);
                    $('#n_encrip').val(data['bw_encriptado']);
                    $('#encrip').val(data['bw_encriptado_logo']);
                    $('#radio').val(data['t_radio']).trigger('change.select2');
                    $('#banda').val(data['banda']).trigger('change.select2');
                    $('#equipo').val(data['t_equipo']);  
                    $('#nom_equipo').val(data['t_n_equipo']); 
                    $('#marca').val(data['marca']).trigger('change.select2');
                    $('#modelo').val(data['model']);
                    $('#sap').val(data['cod_sap']);
                    $('#status').val(data['status']);
                    $('#descri').val(data['description']);
                    $('#equipo').val(data['t_equipo']).trigger('change.select2');  
                    $('#alimenta').val(data['electrical_power_supply']).trigger('change.select2');
                    $('#modulo').val(data['model_slots']);
                    $('#n_max').val(data['bw_max_hw']);
                    $('#max').val(data['bw_max_hw_logo']);
                    $('#n_licen').val(data['bw_bas_lic']);
                    $('#licen').val(data['bw_bas_lic_logo']);
                    if (data['t_n_equipo'] == 'ROUTER') {
                            $('#licen2').show();
                            $('#dual2').show();
                            $('#full2').show();
                            $('#multi2').show();
                            $('#encrip2').show();
                            $('#banda2').hide();
                            $('#radio2').hide();
                        }else{
                            if (data['t_n_equipo'] == 'RADIO') {
                                $('#licen2').show();
                                $('#banda2').show();
                                $('#radio2').show();
                                $('#dual2').hide();
                                $('#encrip2').hide();
                                $('#full2').hide();
                                $('#multi2').hide();
                            }else{
                                if (data['t_n_equipo'] == 'LANSWITCH' ) {
                                    $('#licen2').hide();
                                    $('#dual2').hide();
                                    $('#full2').hide();
                                    $('#multi2').hide();
                                    $('#banda2').hide();
                                    $('#encrip2').hide();
                                    $('#radio2').hide();
                                }
                            }
                        }              
                }
            });
        function_model(id);
        $('#equipo').attr('disabled', '');
    } 

    function new_equipment_function(){
        var mensaje = document.getElementById("title_equip");
        mensaje.textContent = 'REGISTRAR EQUIPO';
        var id_editar = $('#id_editar').val(); 
        $('#equipo').removeAttr('disabled');
            $('#id_editar').val('0'); 
            $('#dual').val('');
            $('#full').val('');
            $('#multi').val('');
            $('#n_encrip').val('');
            $('#encrip').val('1');
            $('#radio').val('').trigger('change.select2');
            $('#banda').val('').trigger('change.select2'); 
            $('#nom_equipo').val(''); 
            $('#marca').val('').trigger('change.select2');
            $('#modelo').val('');
            $('#sap').val('');
            $('#status').val('');
            $('#descri').val('');
            $('#equipo').val('').trigger('change.select2');  
            $('#alimenta').val('').trigger('change.select2');
            $('#modulo').val('');
            $('#n_max').val('');
            $('#max').val('1');
            $('#n_licen').val('');
            $('#licen').val('1');
            $('#funtion').val('').trigger('change.select2');
    }
    
//--------------------Funsion para registra puerto del inventario-------------------- 
    function port_regiter(){
        var modal = document.getElementById("cerrar_fsp_register");
        var id_port = document.getElementById("id_port").value;
        var id_equip = document.getElementById("id_equip").value;
        var elemento = document.getElementById("elemento").value;
        var eleme1 = document.getElementById("eleme1").value;
        eleme1.toUpperCase();
        var afsp1 = document.getElementById("afsp1").value;
        var afsp2 = document.getElementById("afsp2").value;
        var eleme2 = document.getElementById("eleme2").value;
        eleme2.toUpperCase();
        var bfsp1 = document.getElementById("bfsp1").value;
        var bfsp2 = document.getElementById("bfsp2").value;
        var eleme3 = document.getElementById("eleme3").value;
        eleme3.toUpperCase();
        var cfsp1 = document.getElementById("cfsp1").value;
        var cfsp2 = document.getElementById("cfsp2").value;
        var eleme4 = document.getElementById("eleme4").value;
        eleme4.toUpperCase();
        var dfsp1 = document.getElementById("dfsp1").value;
        var dfsp2 = document.getElementById("dfsp2").value;
        var separador = document.getElementById("separador").value;
        if (elemento == "" || elemento == null){
            toastr.error("La Cantidad de elemento es obligatorio");
        } else if (separador == "" && elemento!= 0){
            toastr.error("El Separador es obligatorio.");
        }else if (afsp1 == "" && elemento >= 1){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (afsp2 == "" && elemento >= 1){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (bfsp1 == "" && elemento >= 2){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (bfsp2 == "" && elemento >= 2){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (cfsp1 == "" && elemento >= 3){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (cfsp2 == "" && elemento >= 3){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (dfsp1 == "" && elemento >= 4){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (dfsp2 == "" && elemento >= 4){
            toastr.error("Todo los valore del label es obligatorio.");
        }else if (afsp1 > afsp2){
            toastr.error("En el elemento 1 el minimo no puede ser superior al maximo");
        }else if (bfsp1 > bfsp2){
            toastr.error("En el elemento 2 el minimo no puede ser superior al maximo");
        }else if (cfsp1 > cfsp2){
            toastr.error("En el elemento 2 el minimo no puede ser superior al maximo");
        }else if (dfsp1 > dfsp2){
            toastr.error("En el elemento 2 el minimo no puede ser superior al maximo");
        }else{
            var p1 =  eleme1 +'%'+ afsp1 +'%'+afsp2+'%'+separador;
            var p2 =  eleme2 +'%'+ bfsp1 +'%'+bfsp2+'%'+separador;
            var p3 = eleme3 +'%'+cfsp1+'%'+cfsp2+'%'+separador;
            var p4 = eleme4 +'%'+ dfsp1 +'%'+dfsp2+'%'+separador;
            var label = '';
            switch (elemento) {
                case '1':
                    label = p1;
                break;
                case '2':
                    label = p1+'#'+p2;
                break;
                case '3':
                    label = p1+'#'+p2+'#'+p3;
                break;
                case '4':
                    label = p1+'#'+p2+'#'+p3+'#'+p4;
                break;
            }
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                    type: "POST",
                    url: getBaseURL() +'registar/relacion',
                    data: {label:label, id_port:id_port, id_equip:id_equip},
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        switch (data['resul']) {
                            case 'login':
                                window.location.href ="/jarvis";
                            break;
                            case 'authori':
                                toastr.error("Usuario no autorizado");
                            break;
                            case 'yes':
                                toastr.success("Registro Exitoso");
                                $('#lis_port_occupied').DataTable().ajax.reload();
                                $('#lis_port_free').DataTable().ajax.reload();
                                modal.click();
                            break;
                        }
                    }
                });
        }
        
    }

//--------------------Funsion para cancelar puerto-------------------- 
    function port_cancelar(){
        window.location.href = "/jarvis/ver/inventario";
    }

//--------------------Funsion para buscar y y mostrar puerto-------------------- 
    function search_port(id){
        $('#m_placa').attr('disabled', '')
        document.getElementById('placa_boton').style.display = "none";
        document.getElementById("title_placa").textContent = 'MODIFICAR PLACA';
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL()+'buscar/puerto',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                if (data['resul'] == 'yes') {
                    $('#id_por').val(data['id']);
                    $('#m_placa').val(data['module_board']).trigger('change.select2');
                    $('#type_placa').val(data['type_board']).trigger('change.select2');
                    $('#canti').val(data['quantity']); 
                    $('#pfi').val(data['porf_f_i']); 
                    $('#pff').val(data['port_f_f']); 
                    $('#type_port').val(data['t_port']).trigger('change.select2'); 
                    $('#conector').val(data['connector']).trigger('change.select2');
                    $('#label').val(data['label']).trigger('change.select2');
                    $('#fps').val(data['f_s_p']);
                    $('#pli').val(data['port_l_i']);
                    $('#plf').val(data['port_l_f']);
                    $('#n_max').val(data['bw_max_port']);
                    $('#max').val(data['bw_max_port_logo']);
                    $('#cod_sap').val(data['cod_sap']);
                }else{ 
                    if (data == 'home') {
                        toastr.error("Usuario no autorizado");
                        var int=self.setInterval('refresh()',700);
                    }else{
                        if (data == "no") {
                            toastr.success("Puerto no encontrado");
                            var int=self.setInterval('refresh()',700); 
                        }else{
                            window.location.href ="/jarvis";
                        }
                    }
                }
            }
        }); 
    }

    function acronimo_client(){
        var pantalla = 1;
        var razon = $('#clip_new #name').val();
        if (razon == "" || razon == null){
            var razon = $('#clip_edit #name').val();
            pantalla = 2;
        }
        if (razon == "" || razon == null){
            toastr.error("La Razon social es obligatorio");
        }else{  
            $.ajaxSetup({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                    type: "POST",
                    url: "../agregar/acronimo",
                    data: {razon:razon},
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        if (pantalla == 1) {
                            $('#acronimo').removeClass("error");
                            $('#Acronimo_exitoso').text("");
                            $('#clip_new #acronimo').val(data['acronimo']);
                        }else{
                            $('#clip_edit #acronimo').val(data['acronimo']);
                        }
                    }
                }); 
        }
    }

    function cancelar_cerra(){
        refresh();
    }
    function create_client(){
        document.getElementById("clip_new").reset();
        $('#id').val(0);
    }

    function list_database(list,edi=null){
        var cancelar = document.getElementById("list_cerrar");
        var aceptar = document.getElementById("list_nuevo");
        var mensaje = document.getElementById("msj_list");
        var modal = document.getElementById("exit_pop_cer");
        $('#name_equip').val("");
        switch (list) {
            case 1:
                msj_list = 'REGISTRAR EQUIPO';
                var option = $("#equipo");
                var url = getBaseURL() +'lista/equipo';
            break;
            case 2:
                msj_list = 'REGISTRAR MARCA';
                var option = $("#marca");
                var url = getBaseURL() +'lista/marca';
            break;
            case 3:
                msj_list = 'REGISTRAR ALIMENTACIÓN';
                var option = $("#alimenta");
                var url = getBaseURL() +'lista/alimentacion';
            break;
            case 4:
                msj_list = 'REGISTRAR RADIO';
                var option = $("#radio");
                var url = getBaseURL() +'lista/radio';
            break;
            case 5:
                msj_list = 'REGISTRAR BANDA';
                var option = $("#banda");
                var url = getBaseURL() +'lista/banda';
            break;
            case 6:
                msj_list = 'REGISTRAR MODELO DE PLACA';
                var option = $("#m_placa");
                var url = getBaseURL() +'lista/placa';
            break;
            case 7:
                msj_list = 'REGISTRAR TIPO DE PUERTO';
                var option = $("#type_port");
                var url = getBaseURL() +'lista/puerto';
            break;
            case 8:
                msj_list = 'REGISTRAR CONECTOR';
                var option = $("#conector");
                var url = getBaseURL() +'lista/conector';
            break;
            case 9:
                msj_list = 'REGISTRAR LABEL';
                var option = $("#label");
                var url = getBaseURL() +'lista/etiqueta';
            break;
            case 10:
                msj_list = 'REGISTRAR ESTADO IP';
                var url = getBaseURL() +'lista/estado';
            break;
            case 11:
                msj_list = 'REGISTRAR PAIS';
                var option = $("#pais");
                var url = getBaseURL() +'lista/pais';
            break;
            case 12:
                msj_list = 'REGISTRAR PROVINCIA';
                var option = $("#provin");
                var url = getBaseURL() +'lista/provincia';
            break;
            case 13:
                msj_list = 'REGISTRAR MOTIVO';
                var option = $("#mot");
                var url = getBaseURL() +'lista/baja';
            break;
            case 14:
                msj_list = 'REGISTRAR LOCALIZACIÓN';
                var url = getBaseURL() +'lista/tipo/localizacion';
            break;
            case 15:
                msj_list = 'REGISTRAR TIPO DE LINK';
                var url = getBaseURL() +'lista/tipo/link';
            break;
        }
        mensaje.textContent = msj_list;
        aceptar.onclick = function() {
            if (list != 12) {
                var name = document.getElementById("name_equip").value.toUpperCase().trim().replace(/\s{2,}/g, ' ');
                var pais = '';
            }else{
                var name = document.getElementById("name_lis_povince").value.toUpperCase().trim().replace(/\s{2,}/g, ' ');
                var pais = document.getElementById("list_id_pais").value
            }
            if ( name == "" || name.length < 1 ){
                toastr.error("El nombre es obligatorio");
            }else{
                
                $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
                $.ajax({
                    type: "POST",
                    url: getBaseURL() +'registrar/lista',
                    data: {table:list, name:name, id:0, pais:pais},
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
                                toastr.error("El nombre ya existe");
                            break;
                            case 'yes':
                                toastr.success("Registro Exitoso");
                                modal.click();
                                if ($('#claro_jarvis').length) {
                                    window.location = url;
                                } else {
                                    if (list != 14) {
                                        option.find('option').remove();
                                        option.append('<option selected disabled value="">seleccionar</option>');
                                        $(data['datos']).each(function(i, v){ 
                                            option.append(
                                                '<option value="' + data['datos'][i]['id'] + '">' + data['datos'][i]['name'] + '</option>'
                                            );
                                        })
                                    }else{
                                        var local = document.getElementById("elemen_local").value;
                                        $('#elemen_local').val('').trigger('change.select2');
                                        $('#elemen_local').val(local).trigger('change.select2');
                                    }
                                    if (list == 13) {
                                        var moti_can = $("#mot_can");
                                        moti_can.find('option').remove();
                                        moti_can.append('<option selected disabled value="">seleccionar</option>');
                                        $(data['datos']).each(function(i, v){ // indice, valor
                                            moti_can.append(
                                                '<option value="'+data['datos'][i]['id']+'">'+data['datos'][i]['name']+'</option>'
                                            );
                                        });
                                    }
                                }
                            break;
                        }
                    }
                }); 
            }        
        }
        cancelar.onclick = function() {
            modal.click();
        }
    }

    // function new_list(){
    //     var table = document.getElementById("table_list").value;
    // }

    function labelSelected(){
        pre_v();
        var num = document.getElementById("elemento").value;
        var elemen0 = document.getElementById('elemen0');
        var elemen1 = document.getElementById('elemen1');
        var elemen2 = document.getElementById('elemen2');
        var elemen3 = document.getElementById('elemen3');
        var elemen4 = document.getElementById('elemen4');
        if (num != 0) {
            elemen0.style.display = "block";
        }else{
            elemen0.style.display = "none";
        }
        switch (num) {
            case '0':
                elemen1.style.display = "none";
                elemen2.style.display = "none";
                elemen3.style.display = "none";
                elemen4.style.display = "none";
            break;
            case '1':
                elemen1.style.display = "block";

                elemen2.style.display = "none";
                elemen3.style.display = "none";
                elemen4.style.display = "none";
            break;
            case '2':
                elemen1.style.display = "block";
                elemen2.style.display = "block";
                elemen3.style.display = "none";
                elemen4.style.display = "none";
            break;
            case '3':
                elemen1.style.display = "block";
                elemen2.style.display = "block";
                elemen3.style.display = "block";
                elemen4.style.display = "none";
                $('#4fsp1').val("");
                $('#4fsp2').val("");
            break;
            case '4':
                elemen1.style.display = "block";
                elemen2.style.display = "block";
                elemen3.style.display = "block";
                elemen4.style.display = "block";
            break;
        }
    }

    function port_equip(id_port, id_equip){
        var mensaje = document.getElementById("pre_v");
        mensaje.textContent  = '';
        var elemen0 = document.getElementById('elemen0');
        var elemen1 = document.getElementById('elemen1');
        var elemen2 = document.getElementById('elemen2');
        var elemen3 = document.getElementById('elemen3');
        var elemen4 = document.getElementById('elemen4');
        elemen0.style.display = "none";
        elemen1.style.display = "none";
        elemen2.style.display = "none";
        elemen3.style.display = "none";
        elemen4.style.display = "none";
        document.getElementById("new_fsp").reset();
        $('#id_equip').val(id_equip);
        $('#id_port').val(id_port);
        $('#id_relation').val("0");
        $('#elemento').val("0");
    }

    function search_relation(id){
        var elemen0 = document.getElementById('elemen0');
        var elemen1 = document.getElementById('elemen1');
        var elemen2 = document.getElementById('elemen2');
        var elemen3 = document.getElementById('elemen3');
        var elemen4 = document.getElementById('elemen4');
        $.ajaxSetup({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +"editar/relacion",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#id_relation').val(id);
                if (data[0] > 0) {
                    $('#elemento').val(data[0]);
                    $('#separador').val(data[1][0]['sep']);
                    $('#eleme1').val(data[1][0]['let']);
                    $('#afsp1').val(data[1][0]['min']);
                    $('#afsp2').val(data[1][0]['max']);
                    if (data[0] > 1) {
                        $('#eleme2').val(data[1][1]['let']);
                        $('#bfsp1').val(data[1][1]['min']);
                        $('#bfsp2').val(data[1][1]['max']);
                    }else{
                        pre_v();
                        elemen0.style.display = "block";
                        elemen1.style.display = "block";
                        elemen2.style.display = "none";
                        elemen3.style.display = "none";
                        elemen4.style.display = "none";
                    }
                    switch (data[0]) {
                        case 2:
                            elemen0.style.display = "block";
                            elemen1.style.display = "block";
                            elemen2.style.display = "block";
                            elemen3.style.display = "none";
                            elemen4.style.display = "none";
                            pre_v();
                        break;
                        case 3:
                            elemen0.style.display = "block";
                            elemen1.style.display = "block";
                            elemen2.style.display = "block";
                            elemen3.style.display = "block";
                            elemen4.style.display = "none";
                            $('#eleme3').val(data[1][2]['let']);
                            $('#cfsp1').val(data[1][2]['min']);
                            $('#cfsp2').val(data[1][2]['max']);
                            pre_v();
                        break;
                        case 4:
                            elemen0.style.display = "block";
                            elemen1.style.display = "block";
                            elemen2.style.display = "block";
                            elemen3.style.display = "block";
                            elemen4.style.display = "block";
                            $('#eleme3').val(data[1][2]['let']);
                            $('#cfsp1').val(data[1][2]['min']);
                            $('#cfsp2').val(data[1][2]['max']);
                            $('#eleme4').val(data[1][3]['let']);
                            $('#dfsp1').val(data[1][3]['min']);
                            $('#dfsp2').val(data[1][3]['max']);
                            pre_v();
                        break;
                    }
                }else{
                    elemen0.style.display = "none";
                    elemen1.style.display = "none";
                    elemen2.style.display = "none";
                    elemen3.style.display = "none";
                    elemen4.style.display = "none";
                    pre_v();
                }
            }
        }); 
    }

    function labelSelectedEdict(){
        var num = document.getElementById("elemento_edict").value;
        var elemen0 = document.getElementById('elemen0edict');
        var elemen1 = document.getElementById('elemen1edict');
        var elemen2 = document.getElementById('elemen2edict');
        var elemen3 = document.getElementById('elemen3edict');
        var elemen4 = document.getElementById('elemen4edict');
        switch (num) {
            case '0':
                elemen0.style.display = "none";
                elemen1.style.display = "none";
                elemen2.style.display = "none";
                elemen3.style.display = "none";
                elemen4.style.display = "none";
                $('#eleme3_edi').val("");
                $('#cfsp1_edi').val("");
                $('#cfsp2_edi').val("");
                $('#eleme4_edi').val("");
                $('#dfsp1_edi').val("");
                $('#dfsp2_edi').val("");
            break;
            case '1':
                elemen0.style.display = "block";
                elemen1.style.display = "block";
                elemen2.style.display = "none";
                elemen3.style.display = "none";
                elemen4.style.display = "none";
                $('#eleme3_edi').val("");
                $('#cfsp1_edi').val("");
                $('#cfsp2_edi').val("");
                $('#eleme4_edi').val("");
                $('#dfsp1_edi').val("");
                $('#dfsp2_edi').val("");
            break;
            case '2':
                elemen0.style.display = "block";
                elemen1.style.display = "block";
                elemen2.style.display = "block";
                elemen3.style.display = "none";
                elemen4.style.display = "none";
                $('#eleme3_edi').val("");
                $('#cfsp1_edi').val("");
                $('#cfsp2_edi').val("");
                $('#eleme4_edi').val("");
                $('#dfsp1_edi').val("");
                $('#dfsp2_edi').val("");
            break;
            case '3':
                elemen0.style.display = "block";
                elemen1.style.display = "block";
                elemen2.style.display = "block";
                elemen3.style.display = "block";
                elemen4.style.display = "none";
                $('#eleme4_edi').val("");
                $('#dfsp1_edi').val("");
                $('#dfsp2_edi').val("");
            break;
            case '4':
                elemen0.style.display = "block";
                elemen1.style.display = "block";
                elemen2.style.display = "block";
                elemen3.style.display = "block";
                elemen4.style.display = "block";
            break;
        }
    }

    function relation_edict(){
        var modal = document.getElementById("cerrar_fsp_register");
        var id_relation = document.getElementById("id_relation").value;
        var elemento = document.getElementById("elemento").value;
        var eleme01 = document.getElementById("eleme1").value;
        var eleme1 = eleme01.toUpperCase();
        var afsp1 = document.getElementById("afsp1").value;
        var afsp2 = document.getElementById("afsp2").value;
        var eleme02 = document.getElementById("eleme2").value;
        var eleme2 = eleme02.toUpperCase();
        var bfsp1 = document.getElementById("bfsp1").value;
        var bfsp2 = document.getElementById("bfsp2").value;
        var eleme03 = document.getElementById("eleme3").value;
        var eleme3 = eleme03.toUpperCase();
        var cfsp1 = document.getElementById("cfsp1").value;
        var cfsp2 = document.getElementById("cfsp2").value;
        var eleme04 = document.getElementById("eleme4").value;
        var eleme4 = eleme04.toUpperCase();
        var dfsp1 = document.getElementById("dfsp1").value;
        var dfsp2 = document.getElementById("dfsp2").value;
        var separador = document.getElementById("separador").value;
        if (elemento == "" || elemento == null){
            toastr.error("La Cantidad de elemento es obligatorio");
        } else if (separador == "" || separador.length < 1){
            toastr.error("El Separador es obligatorio.");
        } else{
            var p1 =  eleme1 +'%'+ afsp1 +'%'+afsp2+'%'+separador;
            var p2 =  eleme2 +'%'+ bfsp1 +'%'+bfsp2+'%'+separador;
            var label = '';
            switch (elemento) {
                case '2':
                    label = p1+'#'+p2;
                break;
                case '3':
                    var p3 = eleme3 +'%'+cfsp1+'%'+cfsp2+'%'+separador;
                    label = p1+'#'+p2+'#'+p3;
                break;
                case '4':
                    var p3 = eleme3 +'%'+cfsp1+'%'+cfsp2+'%'+separador;
                    var p4 = eleme4 +'%'+ dfsp1 +'%'+dfsp2+'%'+separador;
                    label = p1+'#'+p2+'#'+p3+'#'+p4;
                break;
            }
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                    type: "POST",
                    url: getBaseURL() +"modificar/relacion",
                    data: {label:label, id_relation:id_relation},
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        switch (data['resul']) {
                            case 'login':
                                window.location.href ="/jarvis";
                            break;
                            case 'authori':
                                toastr.error("Usuario no autorizado");
                            break;
                            case 'yes':
                                toastr.success("Registro Exitoso");
                                $('#lis_port_occupied').DataTable().ajax.reload();
                                modal.click();
                            break;
                        }
                    }
                });
        }
    }

    function inf_equip(id){
        var new_tbody = document.createElement('tbody');
        $("#port_asignada_body").html(new_tbody);
        $.ajaxSetup({
        headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +"listar/puerto",
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                switch (data['resul']) {
                    case 'login':
                        refresh();
                    break;
                    case 'yes':
                        $(data['datos']).each(function(i, v){
                            var valor = '<tr>' +
                                            '<td>' + data['datos'][i]['module_board'] + '</td>' +
                                            '<td>' + data['datos'][i]['type_board'] + '</td>' +
                                            '<td>' + data['datos'][i]['quantity'] + '</td>' +
                                            '<td>' + data['datos'][i]['label'] + '</td>' +
                                        '</tr>';
                            $("#port_asignada_body").append(valor);
                        });
                    break;
                    case 'autori':
                        toastr.error("Usuario no autorizado");
                    break;
                }
                
            }
        });
    }

    function selec_edict_por(){
        var id_por = document.getElementById("id_por").value;
        var type_placa = document.getElementById("type_placa").value;
        if (id_por != 0) {
            $.ajaxSetup({
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'tipo/puerto',
                data: {id:id_por},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    if (data['resul'] == 'yes') {
                        if (data['name'] != type_placa) {
                            var modal = document.getElementById('confirmacion');
                            var btnSi = document.getElementById("myBtnSi");
                            var btnNo = document.getElementById("myBtnNo"); 
                            var mensaje = document.getElementById("myMensaje");
                            modal.style.display = "block";
                            mensaje.textContent  = 'Esta seguro de cambiar el tipo de placa';
                            btnSi.onclick = function() {
                                modal.style.display = "none";
                            }
                            btnNo.onclick = function() {
                                modal.style.display = "none";
                                $('#type_placa').val(data['name']).trigger('change.select2');
                            }
                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    btnNo.click();
                                }
                            }
                        }
                    }
                }
            });       
        }
    }

    $("#eleme1").on("keyup", function() {
        pre_v();        
    });

    $("#eleme2").on("keyup", function() {
        pre_v();        
    });

    $("#eleme3").on("keyup", function() {
        pre_v();        
    });

    $("#eleme4").on("keyup", function() {
        pre_v();        
    });

    $("#afsp1").on("keyup", function() {
        pre_v();        
    });

    $("#afsp2").on("keyup", function() {
        pre_v();        
    });

    $("#bfsp1").on("keyup", function() {
        pre_v();        
    });

    $("#bfsp2").on("keyup", function() {
        pre_v();        
    });

    $("#cfsp1").on("keyup", function() {
        pre_v();        
    });

    $("#cfsp2").on("keyup", function() {
        pre_v();        
    });

    $("#dfsp1").on("keyup", function() {
        pre_v();        
    });

    $("#dfsp2").on("keyup", function() {
        pre_v();        
    });

    function labelSeparador(){
        pre_v(); 
    }

    function pre_v(){
        var id_port = document.getElementById("id_port").value;
        var id_equip = document.getElementById("id_equip").value;
        var elemento = document.getElementById("elemento").value;
        var eleme01 = document.getElementById("eleme1").value;
        var eleme1 = eleme01.toUpperCase();
        var afsp1 = document.getElementById("afsp1").value;
        var afsp2 = document.getElementById("afsp2").value;
        var eleme02 = document.getElementById("eleme2").value;
        var eleme2 = eleme02.toUpperCase();
        var bfsp1 = document.getElementById("bfsp1").value;
        var bfsp2 = document.getElementById("bfsp2").value;
        var eleme03 = document.getElementById("eleme3").value;
        var eleme3 = eleme03.toUpperCase();
        var cfsp1 = document.getElementById("cfsp1").value;
        var cfsp2 = document.getElementById("cfsp2").value;
        var eleme04 = document.getElementById("eleme4").value;
        var eleme4 = eleme04.toUpperCase();
        var dfsp1 = document.getElementById("dfsp1").value;
        var dfsp2 = document.getElementById("dfsp2").value;
        var separador = document.getElementById("separador").value;
        var mensaje = document.getElementById("pre_v");
        var label = '';
        switch (elemento) {
            case '0':
                label = "";
            break;
            case '1':
                var p1 =  eleme1 +' ('+ afsp1 +'-'+afsp2+')';
                label = p1;
            break;
            case '2':
                var p1 =  eleme1 +' ('+ afsp1 +'-'+afsp2+')';
                var p2 =  eleme2 +' ('+ bfsp1 +'-'+bfsp2+')';
                label = p1+' '+separador+' '+p2;
            break;
            case '3':
                var p1 =  eleme1 +' ('+ afsp1 +'-'+afsp2+')';
                var p2 =  eleme2 +' ('+ bfsp1 +'-'+bfsp2+')';
                var p3 = eleme3 +' ('+cfsp1+'-'+cfsp2+')';
                label = p1+' '+separador+' '+p2+' '+separador+' '+p3;
            break;
            case '4':
                var p1 =  eleme1 +' ('+ afsp1 +'-'+afsp2+')';
                var p2 =  eleme2 +' ('+ bfsp1 +'-'+bfsp2+')';
                var p3 = eleme3 +' ('+cfsp1+'-'+cfsp2+')';
                var p4 = eleme4 +' ('+ dfsp1 +'-'+dfsp2+')';
                label = p1+' '+separador+' '+p2+' '+separador+' '+p3+' '+separador+' '+p4;
            break;
        }
        mensaje.textContent  = label;
    }

    function crear_port(){
        var placa_boton = document.getElementById('placa_boton');
        placa_boton.style.display = "block";
        var mensaje = document.getElementById("title_placa");
        mensaje.textContent = 'CREAR PLACA';
        document.getElementById("placa_new").reset();
        $('#id_por').val("0");
        $('#m_placa').val("").trigger('change.select2');
        $('#type_placa').val("").trigger('change.select2');
        $('#type_port').val("").trigger('change.select2'); 
        $('#conector').val("").trigger('change.select2');
        $('#label').val("").trigger('change.select2');
        $('#max').val("1");
        $('#m_placa').removeAttr('disabled');
    }

    //--------------------Funsion para registra y modificar puerto del inventario-------------------- 
    function new_update_port(){
        var id = document.getElementById("id_por").value;
        var m_placa = document.getElementById("m_placa").value;
        var type_placa = document.getElementById("type_placa").value;
        var canti = document.getElementById("canti").value;
        var pfi = document.getElementById("pfi").value;
        var pff = document.getElementById("pff").value;
        var type_port = document.getElementById("type_port").value;
        var conector = document.getElementById("conector").value;
        var n_max = document.getElementById("n_max").value;
        var max = document.getElementById("max").value;
        var label = document.getElementById("label").value;
        var pli = document.getElementById("pli").value;
        var plf = document.getElementById("plf").value;
        var sap = document.getElementById("cod_sap").value;
        var pfi_f = (parseInt(pff) - parseInt(pfi)) + 1;
        var pli_f = (parseInt(plf) - parseInt(pli)) + 1;
        if (m_placa == "" || m_placa == null){
            toastr.error("El modelo de la placa es obligatorio");
        }else if (type_placa == "" || type_placa== null){
            toastr.error("El tipo de placa es obligatorio");
        }else if (canti == "" || canti== null){
            toastr.error("La cantidad de puerto es obligatorio");
        }else if (pfi == "" || pfi== null){
            toastr.error("El puerto fisico inicial es obligatorio");
        }else if (pff == "" || pff== null){
            toastr.error("El puerto fisico final es obligatorio");
        }else if (type_port == "" || type_port== null){
            toastr.error("El tipo de puerto es obligatorio");
        }else if (conector == "" || conector== null){
            toastr.error("El conector es obligatorio");
        }else if (n_max == "" || n_max== null){
            toastr.error("El bandwitdh max es obligatorio");
        }else if (label == "" || label== null){
            toastr.error("El label es obligatorio");
        }else if (pli == "" || pli== null){
            toastr.error("El puerto lógico inicial es obligatorio");
        }else if (plf == "" || plf== null){
            toastr.error("El puerto lógico final es obligatorio");
        }else if ( pfi > pff){
            toastr.error("El puerto fisico inicial tiene que ser menor al final");
        }else if ( (pfi_f != canti && canti != 1) || (canti == 1 && pff != pfi)){
            toastr.error("Los puerto fisico inicial y final no contiene los puerto que esta en cantidad");
        }else if ( pli > plf){
            toastr.error("El puerto lógico inicial tiene que ser menor al final");
        }else if ( (pli_f != canti && canti != 1) || (canti == 1 && plf != pli)){
            toastr.error("Los puerto lógico inicial y final no contiene los puerto que esta en cantidad");
        }else{   
            var modal = document.getElementById('cerrarPop');
            $.ajaxSetup({ headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                type: "POST",
                url: getBaseURL() +'registrar/puerto',
                data:   {m_placa:m_placa, type_placa:type_placa, canti:canti, pfi:pfi, pff:pff,
                        type_port:type_port, conector:conector, n_max:n_max, max:max, label:label,
                        pli:pli, plf:plf, id:id, sap:sap,
                        },
                dataType: 'json',
                cache: false,
                success: function(data) {
                    switch (data['resul']) {
                        case 'login':
                            window.location.href = getBaseURL();
                        break;
                        case 'authori':
                            toastr.error("Usuario no autorizado");
                            modal.click();
                        break;
                        case 'exist':
                            toastr.error("La placa ya existe");
                        break;
                        case 'utilizando':
                            toastr.error("La placa esta siendo usada no se puede modificar");
                        break;
                        default:
                            if (id == 0) {
                                toastr.success("Registro Exitoso");
                            }else{
                                toastr.success("Modificación Exitosa");
                            }
                            $('#claro_placa').DataTable().ajax.reload();
                            $('#lis_port_free').DataTable().ajax.reload();
                            crear_port();
                            modal.click();
                    }
                }
            });
        }
    }

    function img_equip(id){
        var url = getBaseURL() +'imagen/modelo';
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
                type: "POST",
                url: url,
                data: {id:id},
                dataType: 'json',
                cache: false,
                success: function(data) {
                    var image = getBaseURL() +'public/img/equipo/'+data['img'];
                    $('#imagenes').html("<img class='img_equi_mos' src=" + image + ">");
                }
        });
    }

    function label_fsp(){
        var id = document.getElementById("id_relation").value;
        if (id == 0) {
            port_regiter();
        }else{
           relation_edict();
        }
    }

    function function_model(id){
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'funsion/modelo',
            data: {id:id},
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('#funtion').select2('val', data['datos'].toString().split(','));
            }       
        });
    }

    $(document).ready(function(){
        $(".perfil").select2();

        $("#funct").select2();

        $("#client").select2();

        $("#agg").select2();

        $('#marca').select2();

        $("#alimenta").select2();

        $('#banda').select2();

        $('#radio').select2();

        $("#funtion").select2({
            placeholder: "seleccionar",
            allowClear: true
        });

        $('#type_servi').select2();
        
        $('#funtions').select2();

        $('#atribu').select2();

        $('#user').select2();

        $('.rama').select2();

        $('#pais').select2();

        $('#provin').select2();

        $("#type_placa").select2();

        $("#m_placa").select2();

        $("#type_port").select2();

        $("#conector").select2();

        $("#label").select2();

        $(".equip").select2();

        $(".servicio_recurso").select2();
        
        $("#id_client_servi").select2();

        $("#atributo_ip_rese").select2();
    });

    function clip_new_list(){
        $('#name_lis').val('');
        $('#list_id').val(0);
    }

    function new_list_index(table){
        if (table == 12) {
            var name = document.getElementById("name_lis_povince").value.toUpperCase().trim().replace(/\s{2,}/g, ' ');
            var pais = document.getElementById("list_id_pais").value;
            var id = document.getElementById("list_id_provice").value;
        }else{
            var name = document.getElementById("name_lis").value.toUpperCase().trim().replace(/\s{2,}/g, ' ');
            var pais = '';
            var id = document.getElementById("list_id").value;
        }
        if ( name == "" || name.length < 1 ){
            toastr.error("La nombre es obligatorio");
        }else{
            var modal = document.getElementById("exit_pop_cerra");
            var modal2 = document.getElementById("exit_pop_cerra_province");
            $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
            $.ajax({
                    type: "POST",
                    url: getBaseURL() +'registrar/lista',
                    data: {table:table, name:name, id:id, pais:pais},
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
                                if (id != 0) {
                                    toastr.success("Modificación Exitoso");
                                }else{
                                    toastr.success("Registro Exitoso");
                                }
                                modal.click();
                                switch (table) {
                                    case 1:
                                        var url = getBaseURL() +'lista/equipo';
                                    break;
                                    case 2:
                                        var url = getBaseURL() +'lista/marca';
                                    break;
                                    case 3:
                                        var url = getBaseURL() +'lista/alimentacion';
                                    break;
                                    case 4:
                                        var url = getBaseURL() +'lista/radio';
                                    break;
                                    case 5:
                                        var url = getBaseURL() +'lista/banda';
                                    break;
                                    case 6:
                                        var url = getBaseURL() +'lista/placa';
                                    break;
                                    case 7:
                                        var url = getBaseURL() +'lista/puerto';
                                    break;
                                    case 8:
                                        var url = getBaseURL() +'lista/conector';
                                    break;
                                    case 9:
                                        var url = getBaseURL() +'lista/etiqueta';
                                    break;
                                    case 10:
                                        var url = getBaseURL() +'lista/estado';
                                    break;
                                    case 11:
                                        var url = getBaseURL() +'lista/pais';
                                    break;
                                    case 12:
                                        provincia_lista(pais);
                                        modal2.click();
                                    break;
                                    case 13:
                                        var url = getBaseURL() +'lista/baja';
                                    break;
                                    case 14:
                                        var url = getBaseURL() +'lista/tipo/localizacion';
                                    break;
                                    case 15:
                                        var url = getBaseURL() +'lista/tipo/link';
                                    break;

                                }
                                if (table != 12) {
                                    window.location = url;
                                }
                            break;
                        }
                    }
                }); 
        }        
    }

function PortRingAllNew(id) {
    $("#PortRingAllUpdate").empty();
    $('#NameRingNewPort').text('');
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'listar/puerto/anillo',
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
                    $('#NameRingNewPort').text(data['ring']['name']);
                    $('#id_ring_new').val(id);
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                                '<td>' + data['datos'][i]['acronimo'] + '</td>' +
                                '<td>' + data['datos'][i]['port'] + '</td>' +
                                '<td class="num_port_ring"><a title="Quitar" onclick="PortRingDelete('+data['datos'][i]['id']+','+id+');"><i class="fa fa-trash-o"> </i> </a></td>' +
                            '</tr>';
                        $("#PortRingAllUpdate").append(valor);
                    });
                break;
            }
        }
    });
}

function PortRingDelete(id, ring){
    var num = document.getElementsByClassName("num_port_ring");
    if (num.length == 1) {
        toastr.error("No se puede quitar el ultimo puerto del anillo");
    }else{
        $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        $.ajax({
            type: "POST",
            url: getBaseURL() +'eliminar/puerto/anillo',
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
                    case 'yes':
                        PortRingAllNew(ring);
                        toastr.success("Liberación Exitosa");
                    break;
                }
            }
        });  
    }
}

function NewPortRingSelec() {
    $("#PortNewRingList").empty();
    $('#NameRingNew').text('');
    var id = document.getElementById("id_ring_new").value;
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'listar/puerto/nuevo/anillo',
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
                case 'yes':
                    $('#NameRingNew').text(data['acronimo']);
                    $(data['datos']).each(function(i, v){
                        var valor = '<tr>' +
                                '<td>' + data['datos'][i]['port'] + '</td>' +
                                '<td>' + data['datos'][i]['bw'] + '</td>' +
                                '<td><a title="Agregar Puerto" class="close" data-dismiss="modal" onclick="InsertNewPortRing('+data['datos'][i]['id']+','+id+');"><i class="fa fa-bullseye"> </i> </a></td>' +
                            '</tr>';
                        $("#PortNewRingList").append(valor);
                    });

                break;
            }
        }
    });
}

function InsertNewPortRing(board, port, ring) {
    $.ajaxSetup({headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
    $.ajax({
        type: "POST",
        url: getBaseURL() +'registrar/puerto/nuevo/anillo',
        data: {board:board, port:port, ring:ring},
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
                    toastr.error("Puerto Ocupado");
                break;
                case 'yes':
                    PortRingAllNew(ring);
                    toastr.success("Asignación Exitosa");
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