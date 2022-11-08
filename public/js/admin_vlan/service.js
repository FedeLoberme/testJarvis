/** ASIGNACION DE SERVICIOS **/

//listar los servicios

$(document).ready( function () {
    $('#claro_jarvis').DataTable();
    print_services_table();
} );

function print_services_table()
{
    $('#list_vlan_services').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        dom: 'lfrtip<"html5buttons"B>',
        buttons:[
            {
                extend: 'copy', text: '<i class="fa fa-copy">', titleAttr: 'Copiar',
                className: 'btn btn-info',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6]},
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'listar/servicios',
        "columns": [
            { data: 'service' },
            { data: 'service_type' },
            { data: 'bw' },
            { data: 'mtag' },
            { data: 'ctag' },
            { data: 'frontier' },
            { data: 'pe_pei' },
            { data: 'aggi' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    opcion = '';
                    //id de asignacion_servicio_vlan
                    id = full.id;
                    /**opcion+= `<a onclick="search_frontier(${id})" title="Editar Frontera" data-toggle="modal" data-target="#popeditar_frontera"> <i class="fa fa-edit"></i> </a>`;**/
                    opcion+= `<a onclick="delete_service_assignment(${id})" title="Eliminar Asignación" data-toggle="modal" data-target="#poplist_acronimo"> <i class="fa fa-trash-o"></i> </a>`;
                    if(full.has_list_use_vlan === 'si'){
                        opcion+= `<a onclick="edit_ctag(${id})" title="Editar CTAG" data-toggle="modal" data-target="#poplist_ctag"> <i class="fa fa-edit"></i> </a>`;
                    }

                    return opcion;
                }
            },
        ]
    });
}

function re_print_services_table(){
    $('#list_vlan_services').empty()
    print_services_table();
}
//EDITAR CTAG

function edit_ctag(id){
    console.log('hola')
    let ctag_input = document.getElementById('edit_service_ctag');
    let service_id = document.getElementById('service_id');

    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $.ajax({
        type: "GET",
        url: getBaseURL() + 'servicio/get-ctag',
        data: {id: id},
        dataType: 'json',
        cache: false,
        success: function (data){
            ctag_input.setAttribute('value', data.ctag ? data.ctag : '');
            ctag_input.value = data.ctag ? data.ctag : '';
            service_id.setAttribute('value', data.asignacion_id);
        },
        error: function (err){
            console.log(err);
        }
    })
}

//gUARDAR CTAG
function save_ctag(){
    let ctag_input = document.getElementById('edit_service_ctag').value;
    let service_id = document.getElementById('service_id').value;

    let valid_ctag = true;

    if(ctag_input > 4096){
        $('#cerrar_ctag_edit').click();
        Swal.fire({
            title: 'El valor máximo es 4096',
            text: "",
            icon: 'error',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cerrar'
        })

        re_print_services_table();
        valid_ctag = false;
    }

    if(ctag_input < 2){
        $('#cerrar_ctag_edit').click();
        Swal.fire({
            title: 'El valor mínimo es 2',
            text: "",
            icon: 'error',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Cerrar'
        })

        re_print_services_table();
        valid_ctag = false;
    }

    if(valid_ctag){
        let formData = new FormData;
        formData.append('service_id', service_id);
        formData.append('ctag', ctag_input);

        $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
        $.ajax({
            type: "POST",
            url: getBaseURL() + 'servicio/guardar-ctag',
            data: formData,
            processData: false,  // tell jQuery not to process the data
            contentType: false,   // tell jQuery not to set contentType
            cache: false,
            success: function (data){
                toastr.success("Modificación Exitosa");
                $('#cerrar_ctag_edit').click();

                Swal.fire({
                    title: 'Modificación exitosa',
                    text: "",
                    icon: 'success',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Cerrar'
                })
                    .then((res)=>{
                        if(res.isConfirmed){
                            re_print_services_table();
                        }
                    })
            },
            error: function(err){
                console.log(err);
            }
        })
    }
}


//"ELIMINAR" SERVICIO

function delete_service_assignment(id){
    Swal.fire({
        title: '¿Estás seguro de que deseas eliminar la asignación?',
        text: "Esto no se va a poder revertir",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí'
    }).then((result) => {
        if (result.isConfirmed) {
            let formData = new FormData;
            formData.append('id', id);

            $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
            $.ajax({
                type: "POST",
                url: getBaseURL() + 'servicio/eliminar-servicio',
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,   // tell jQuery not to set contentType
                cache: false,
                success: function (data){
                    toastr.success("Modificación Exitosa");
                    Swal.fire({
                        title: 'Modificación exitosa',
                        text: "",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Cerrar'
                    })
                        .then((res)=>{
                            if(res.isConfirmed){
                                re_print_services_table();
                            }
                        })
                },
                error: function(err){
                    console.log(err);
                }
            })

        }
    })
}
