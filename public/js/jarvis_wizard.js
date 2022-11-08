$(document).ready(function(){
    $("#form").steps({
        bodyTag: "fieldset",
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Always allow going backward even if the current step contains invalid fields!
            if (currentIndex > newIndex)
            {
                return true;
            }

            // Forbid suppressing "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age").val()) < 18)
            {
                return false;
            }

            var form = $(this);

            // Clean up if user went backward before
            if (currentIndex < newIndex)
            {
                // To remove error styles
                $(".body:eq(" + newIndex + ") label.error", form).remove();
                $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
            }

            // Disable validation on fields that are disabled or hidden.
            form.validate().settings.ignore = ":disabled,:hidden";

            // Start validation; Prevent going forward if false
            return form.valid();
        },
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            // Suppress (skip) "Warning" step if the user is old enough.
            if (currentIndex === 2 && Number($("#age").val()) >= 18)
            {
                $(this).steps("next");
            }

            // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
            if (currentIndex === 2 && priorIndex === 3)
            {
                $(this).steps("previous");
            }
        },
        onFinishing: function (event, currentIndex)
        {
            var form = $(this);

            // Disable validation on fields that are disabled.
            // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
            form.validate().settings.ignore = ":disabled";

            // Start validation; Prevent form submission if false
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            var form = $(this);

            // Submit form input
            form.submit();
        }
    }).validate({
                errorPlacement: function (error, element)
                {
                    element.before(error);
                },
                rules: {
                    confirm: {
                        equalTo: "#password"
                    }
                }
            });

    //Servicio Wizard 
    
    $("#form input[type=text]").change(function() 
    { 
        let nroServicio = $("#form #service").val();
        let ordenServicio = $("#form #ord").val();
        let anchoServicio = $("#form #n_max").val();
        let relacionadoServicio = $("#form #service_input_relation").val();
        let comentario = $("#form #come").val();

        $("#showFormValues #nroServicio").text(nroServicio);
        $("#showFormValues #ordenServicio").text(ordenServicio);
        $("#showFormValues #anchoServicio").text(anchoServicio);
        $("#showFormValues #relacionadoServicio").text(relacionadoServicio);
        $("#showFormValues #comentario").text(comentario);

         
        //Radio Wizard
        
        let modeloRadio = $("#form #modelo_radio").val();
        let acronimo = $("#form #acronimo").val();
        let ip_gestion = $("#form #ip_gestion").val();
        let ip_loopback = $("#form #ip_loopback").val();
        let code_ne = $("#form #code_ne").val();
        let frecuencia = $("#form #frecuencia").val();
        let tamano_antena = $("#form #tamano_antena").val();
        
        $("#showFormValues #modelo_radio_celda").text(modeloRadio);
        $("#showFormValues #acronimo").text(acronimo);
        $("#showFormValues #ip_gestion").text(ip_gestion);
        $("#showFormValues #ip_loopback").text(ip_loopback);
        $("#showFormValues #code_ne").text(code_ne);
        $("#showFormValues #frecuencia").text(frecuencia);
        $("#showFormValues #tamano_antena").text(tamano_antena);
    });

    $("#form select").change(function()
    { 
        let tipoServicio = $("#form #type_servi option:selected").text();
        let clienteServicio = $("#form #id_client_servi option:selected").text();
        let bandaServicio = $("#form #max option:selected").text();
        let direccionA = $("#form #direc_a option:selected").text();
        let direccionB = $("#form #direc_b option:selected").text();
        
        $("#showFormValues #tipoServicio").text(tipoServicio);
        $("#showFormValues #clienteServicio").text(clienteServicio);
        $("#showFormValues #bandaServicio").text(bandaServicio);
        $("#showFormValues #direccionA").text(direccionA);
        $("#showFormValues #direccionB").text(direccionB);

        //Radio Wizard
        let radio = $("#form #radio option:selected").text();
        $("#showFormValues #radio").text(radio);
    });































    $("#formRadioAll").steps({
        bodyTag: "fieldset",
        onStepChanged: function (event, currentIndex, priorIndex)
        {
            ConfirmationRadio();
            $('#formRadioAll').find('a[href="#finish"]').remove(); 
            if (currentIndex === 2){
                $('#guardar_radio').removeAttr('disabled');
            }else{
                $('#guardar_radio').attr('disabled', '');
            }
        },
        onFinishing: function (event, currentIndex)
        {
            ConfirmationRadio();
            return true;
        }
    });
});