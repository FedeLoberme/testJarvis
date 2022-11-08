//--------------------Funsion de DataTable--------------------
$(document).ready( function () {
    $('#claro_jarvis').DataTable();
} );

//--------------------Funsion de DataTable Para Cliente--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if(str >= 3){
        if (str >= 5) {
            $.fn.dataTable.ext.errMode = 'throw';
            $('#cliente').DataTable( {
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
                        exportOptions: {columns: [ 0, 1, 2]},
                    },
                    {
                        extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                        className: 'btn btn-warning',
                        exportOptions: {columns: [ 0, 1, 2]},
                    },
                    {
                        extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                        className: 'btn btn-primary',
                        exportOptions: {columns: [ 0, 1, 2]},
                    },
                    {
                        extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                        className: 'btn btn-danger',
                        exportOptions: {columns: [ 0, 1, 2]},
                    },
                    {
                        extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                        className: 'btn btn-success buttons-html5',
                        exportOptions: {columns: [ 0, 1, 2]},
                        customize: function (win){
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size', '10px');
                                $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                ],
                "ajax": getBaseURL() +'listar/cliente',
                "columns": [
                    { data: 'business_name' },
                    { data: 'acronimo' },
                    { data: 'cuit' },
                    {
                        sortable: false,
                        "render": function ( data, type, full, meta ) {
                            var buttonID = full.id;
return '<a data-toggle="modal" data-target="#popedit" onclick="search_acronimo('+buttonID+');" title="Editar cliente"> <i class="fa fa-edit" > </i></a>';
                        }
                    },
                ]
            } );
        }else{
            $('#cliente').DataTable( {
                deferRender: true,
                "autoWidth": true,
                "paging": true,
                stateSave: true,
                destroy: true,
                "processing": true,
                "ajax": getBaseURL() +'listar/cliente',
                "columns": [
                    { data: 'business_name' },
                    { data: 'acronimo' },
                    { data: 'cuit' },
                ]
            } );
        }
    }
} );

//--------------------Funsion de DataTable Para Modelado--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    $.fn.dataTable.ext.errMode = 'throw';
    $('#claro_modelo').DataTable( {
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
                exportOptions: {columns: [ 0, 1, 2, 3 ]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3 ]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3 ]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3 ]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3 ]},
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'listar/modelo',
        "columns": [
            { data: 'name' },
            { data: 'mark' },
            { data: 'model' },
            { data: 'description' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var buttonID = full.id;
                    if (str >= 5) {
                        opcion = '<a data-toggle="modal" data-target="#detalle" title="Detalle de Equipo" onclick="detal('+buttonID+');"> <i class="fa fa-eye"> </i></a>';
                    }
                    opcion +='<a data-toggle="modal" data-target="#crear_equipo" title="Editar Equipo" onclick="editar_equipo_boton('+buttonID+');"> <i class="fa fa-edit"> </i></a>';
                    if (str >= 5) {
                        opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+buttonID+');"> <i class="far fa-image"> </i></a>'+
                            '<a data-toggle="modal" data-target="#inf_equip" title="Detalle Placas Soportadas" onclick="inf_equip('+buttonID+');"> <i class="fa fa-info-circle"> </i> </a>';
                    }
                    opcion += '<a href="' + getBaseURL() + 'crear/puerto/' + buttonID + '" title=" Agregar/Quitar"> <img class="iconos svg" src="' + getBaseURL() +'public/icono/ja-board-blue.svg"/></a>';
                    return opcion;
                }
            },
        ]
    });
} );

//--------------------Funsion de DataTable Para Historial--------------------
$(document).ready( function () {
    $.fn.dataTable.ext.errMode = 'throw';
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (str >= 3) {
        $('#claro_historial').DataTable( {
            "order": [[0, "desc"]],
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
                    exportOptions: {columns: [ 0, 1, 2]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            "ajax": getBaseURL()+'listar/historial',
            "columns": [
                { data: 'created_at' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var name = full.name;
                        var last_name = full.last_name;
                    return name +' '+last_name;
                    }
                },
                { data: 'description' },
            ]
        } );
    }
} );

//--------------------Funsion de DataTable Para placa--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (str >= 3) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#claro_placa').DataTable( {
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            "ajax": getBaseURL()+'listar/placa',
            "columns": [
                { data: 'module_board' },
                { data: 'type_board' },
                { data: 'quantity' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var port_f_i = full.port_f_i;
                        var port_f_f = full.port_f_f;
                        return port_f_i+' - '+port_f_f;
                    }
                },
                { data: 'port' },
                { data: 'connector' },
                { data: 'bw_max_port' },
                { data: 'label' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var port_l_i = full.port_l_i;
                        var port_l_f = full.port_l_f;
                        return port_l_i+' - '+port_l_f;
                    }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var opcion = '';
                        if (str >= 5) {
                            opcion ='<a data-toggle="modal" data-target="#popcrear_port" title="Editar Puerto" onclick="search_port('+id+');"> <i class="fa fa-edit"> </i></a>';
                        }
                        return opcion;
                    }
                },
            ]
        });
    }
});

//--------------------Funsion de DataTable Para nodo--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) { str = permi.value; }else{ str = 0; }
    if (str >= 3) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#nodo_list').DataTable({
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            "ajax": getBaseURL() +'listar/nodo',
            "columns": [
                { data: 'cell_id' },
                { data: 'node' },
                { data: 'type' },
                { data: 'owner' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var fe = full.contract_date;
                        if (fe == null){
                            var fecha = '-----';
                        }else{
                            var fecha = fe.split(" ");
                            var date = fecha[0].split("-");
                            var fecha = ''+date[2]+ '/'+date[1]+'/'+date[0]+'';
                        }
                        return fecha;
                    }
                },
                { data: 'dire' },
                { data: 'status' },
                { data: 'apt_node'},
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var comen = full.commentary;
                        var valor = '';
                        if (str >= 5) {
                            valor += '<a data-toggle="modal" data-target="#popcrear_nodo" title="Editar Nodo" onclick="search_nodo('+id+');"> <i class="fa fa-edit"> </i></a>';
                        }
                        valor += '<a data-toggle="modal" data-target="#popcomen" title="Ver Comentario" onclick="comen_nodo('+id+');"> <i class="fa fa-comment"> </i></a>';
                        valor += '<a data-toggle="modal" data-target="#pop_ip_anillo_vlan" title="Vlan e IP" onclick="search_vlan_ip_node('+id+');"> <i class="fa fa-sitemap"> </i></a>';
                        valor += '<a data-toggle="modal" data-target="#pop_list_equipments_node" title="Listar equipos del nodo" onclick="list_equipments_in_node('+id+');"> <i class="fas fa-list-ol"></i></a>';
                        return valor;
                    }
                },
            ]
        });
    }
} );

//--------------------Funsion de DataTable Para agregador--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    var functi = document.getElementById("functi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (functi != null) {
        fun = functi.value;
    }else{
        fun = 0;
    }
    if (str >= 3 && fun != 'RADIO_ENLACE') {
        var url = getBaseURL() +'listar/equipo/'+fun;
        $.fn.dataTable.ext.errMode = 'throw';
        switch (fun) {
            case 'AGG':
                $('#claro_agregador').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                            className: 'btn btn-warning',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                            className: 'btn btn-primary',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                            className: 'btn btn-success buttons-html5',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": url,
                    "columns": [
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var cell_id = full.cell_id;
                                var nodo = full.node;
                                return ''+cell_id+ ' "'+nodo+'"';
                            }
                        },
                        { data: 'acronimo' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var admin = full.admin;
                                return ''+admin+'';
                            }
                        },
                        { data: 'status' },
                        { data: 'commentary' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var opcion ='';
                                opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>'+
                                    '<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"></i> </a>'+
                                    '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"></i> </a>';
                                if (status == 'ALTA') {
                                    if (str >= 5) {
                                        opcion += '<a data-toggle="modal" data-target="#crear_agg_pop" title="Editar Equipo" onclick="search_agg('+id+');"> <i class="fa fa-edit"></i> </a>'+
                                            '<a data-toggle="modal" data-target="#lista_acronimo_agg" onclick="search_acronimo_agg('+id+');" title="Acronimo Asignado"> <i class="fa fa-address-card"></i> </a>'+
                                            '<a data-toggle="modal" data-target="#recurso_servicio_pop" onclick="new_recur_equipmen('+id+');" title="Asignar recurso a un servicio"> <i class="fa fa-exchange"></i> </a>'+
                                            '<a data-toggle="modal" data-target="#service_ring_all" onclick="agg_service_ring('+id+');" title="Ver servicio"> <i class="fa fa-desktop"></i> </a>'+
                                            '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"></i> </a>'+
                                            '<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"></i> </a>'+
                                            '<a data-toggle="modal" data-target="#poprelate_agg_pe_pei" onclick="relate_agg_pe_pei('+id+');" title="Asociar AGG PE/PEI"> <i class="fa fa-slideshare"></i> </a>';
                                        // opcion += '<a data-toggle="modal" data-target="#" onclick="" title="Deshabilitar AGG"> <i class="fa fa-toggle-off"></i> </a>';
                                    }
                                    if (str >= 10) {
                                        opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                    }
                                }
                                /*
                                if (status == 'DESHABILITADO' && str >= 5) {
                                    opcion += '<a data-toggle="modal" data-target="#" onclick="" title="Habilitar AGG"> <i class="fa fa-toggle-on"></i> </a>';
                                }
                                */
                                const newLocal = '<a data-toggle="modal" data-target="#vlan_range_config" title="Configurar VLAN Rangos" onclick="range_vlan_index('+id+');"> <i class="fa fa-sliders"> </i> </a>';
                                opcion +=newLocal;
                                return opcion;
                            }
                        },
                    ]
                });
            break;
            case 'CPE':
                $('#cpe_list').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4, 5]},
                        },
                        {
                            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                            className: 'btn btn-warning',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                        },
                        {
                            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                            className: 'btn btn-primary',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                        },
                        {
                            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                        },
                        {
                            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                            className: 'btn btn-success buttons-html5',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": getBaseURL() +'listar/todo/equipo/CPE',
                    "columns": [
                        { data: 'acronimo' },
                        { data: 'client' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var admin = full.admin;
                                var ip_equipment = full.ip_equipment;
                                if (ip_equipment != null && ip_equipment != '') {
                                    return ''+ip_equipment+'';
                                }else{
                                    return ''+admin+'';
                                }
                            }
                        },
                        { data: 'model' },
                        { data: 'service' },
                        { data: 'status' },
                        {
                            sortable: true,
                            "render": function ( data, type, full, meta ) {
                                var cell_id = full.cell_id;
                                var nodo = full.node;
                                var address = full.address;

                                if (nodo != null) {
                                    return ''+cell_id+ ' "'+nodo+'"';
                                }else{
                                    return address;
                                }
                            }
                        },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var opcion = '';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion += '<a data-toggle="modal" data-target="#crear_cpe_pop" title="Editar Equipo" onclick="search_cpe('+id+');"> <i class="fa fa-edit"> </i></a>';
                                }
                                opcion += '<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#recurso_servicio_pop" onclick="new_recur_equipmen('+id+');" title="Asignar recurso a un servicio"> <i class="fa fa-exchange"></i></a>'+
                                        '<a data-toggle="modal" data-target="#pop_servi_equipo" onclick="service_equipmen('+id+');" title="Ver servicio"> <i class="fa fa-desktop"></i></a>'+
                                        '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+id+');"> <i class="far fa-image"> </i></a>'+
                                        '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                                }
                                if (str >= 10 && status == 'ALTA') {
                                    opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                }
                                return opcion;
                            }
                        },
                    ]
                });
            break;
            case 'PE':
                $('#jarvis_pe').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                            className: 'btn btn-warning',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                            className: 'btn btn-primary',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                            className: 'btn btn-success buttons-html5',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": url,
                    "columns": [
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var cell_id = full.cell_id;
                                var nodo = full.node;
                                return ''+cell_id+ ' "'+nodo+'"';
                            }
                        },
                        { data: 'acronimo' },
                        { data: 'admin' },
                        { data: 'status' },
                        { data: 'zone' },
                        { data: 'commentary' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var opcion ='';
                                if (str >= 5 && status == 'ALTA'){
                                    opcion = '<a data-toggle="modal" data-target="#crear_pe_pop" title="Editar Equipo" onclick="search_pe('+id+');"> <i class="fa fa-edit"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion += '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"> </i></a>'+
                                        '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                                }
                                if (str >= 10 && status == 'ALTA') {
                                    opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                }
                                return opcion;
                            }
                        },
                    ]
                });
            break;
            case 'PEI':
                $('#jarvis_pei').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                            className: 'btn btn-warning',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                            className: 'btn btn-primary',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                            className: 'btn btn-success buttons-html5',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": url,
                    "columns": [
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var cell_id = full.cell_id;
                                var nodo = full.node;
                                return ''+cell_id+ ' "'+nodo+'"';
                            }
                        },
                        { data: 'acronimo' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var admin = full.admin;
                                return ''+admin+'';
                            }
                        },
                        { data: 'status' },
                        { data: 'zone' },
                        { data: 'commentary' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var opcion ='';
                                if (str >= 5 && status == 'ALTA'){
                                    opcion = '<a data-toggle="modal" data-target="#crear_pei_pop" title="Editar Equipo" onclick="search_pei('+id+');"> <i class="fa fa-edit"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion += '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"> </i></a>'+
                                        '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                                }
                                if (str >= 10 && status == 'ALTA') {
                                    opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                }
                                return opcion;
                            }
                        },
                    ]
                });
            break;
            case 'RADIO':
                $('#jarvis_radio').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6]},
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
                            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": url,
                    "columns": [
                        { data: 'acronimo' },
                        { data: 'client' },
                        { data: 'admin' },
                        { data: 'model' },
                        { data: 'service' },
                        { data: 'type' },
                        { data: 'status' },
                        { data: 'address' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var name = full.acronimo;
                                var type = full.type;
                                var node = full.node;
                                var opcion = '';
                                if (str >= 5 && status == 'ALTA'){
                                    if (node == null) {
                                        opcion += '<a data-toggle="modal" data-target="#popcrear_radio_editar" title="Editar Equipo" onclick="update_search_radio('+id+');"> <i class="fa fa-edit"> </i></a>';
                                    }else{
                                        opcion += '<a data-toggle="modal" data-target="#popcrear_radio_nodo_editar" title="Editar Equipo" onclick="update_search_radio_nodo('+id+');"> <i class="fa fa-edit"> </i></a>';
                                    }
                                }
                                opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#recurso_servicio_pop" onclick="new_recur_equipmen('+id+');" title="Asignar recurso a un servicio"> <i class="fa fa-exchange"></i></a>'+
                                        '<a data-toggle="modal" data-target="#pop_servi_equipo" onclick="service_equipmen('+id+');" title="Ver servicio"> <i class="fa fa-desktop"></i></a>'+
                                        '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"> </i></a>'+
                                    '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                //     opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                                }
                                if (str >= 10 && status == 'ALTA') {
                                    opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                }
                                return opcion;
                            }
                        },
                    ]
                });
            break;
            case 'DM':
                $('#jarvis_dm').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                            className: 'btn btn-warning',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                            className: 'btn btn-primary',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                            className: 'btn btn-success buttons-html5',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": url,
                    "columns": [
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var cell_id = full.cell_id;
                                var nodo = full.node;
                                return ''+cell_id+ ' "'+nodo+'"';
                            }
                        },
                        { data: 'acronimo' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var admin = full.admin;
                                return ''+admin+'';
                            }
                        },
                        { data: 'status' },
                        { data: 'zone' },
                        { data: 'commentary' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var opcion ='';
                                if (str >= 5 && status == 'ALTA'){
                                    opcion = '<a data-toggle="modal" data-target="#crear_dm_pop" title="Editar Equipo" onclick="search_dm('+id+');"> <i class="fa fa-edit"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion += '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"> </i></a>'+
                                        '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                                }
                                if (str >= 10 && status == 'ALTA') {
                                    opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                }
                                return opcion;
                            }
                        },
                    ]
                });
            break;
            case 'SAR':
                $('#jarvis_sar').DataTable({
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
                            exportOptions: { columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                            className: 'btn btn-warning',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                            className: 'btn btn-primary',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                            className: 'btn btn-danger',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                        },
                        {
                            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                            className: 'btn btn-success buttons-html5',
                            exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                            customize: function (win){
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');
                                    $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                            }
                        },
                    ],
                    "ajax": url,
                    "columns": [
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var cell_id = full.cell_id;
                                var nodo = full.node;
                                return ''+cell_id+ ' "'+nodo+'"';
                            }
                        },
                        { data: 'acronimo' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var admin = full.admin;
                                return ''+admin+'';
                            }
                        },
                        { data: 'status' },
                        { data: 'zone' },
                        { data: 'commentary' },
                        {
                            sortable: false,
                            "render": function ( data, type, full, meta ) {
                                var id = full.id;
                                var status = full.status;
                                var img = full.img;
                                var opcion ='';

                                if (str >= 5 && status == 'ALTA'){
                                    opcion = '<a data-toggle="modal" data-target="#crear_sar_pop" title="Editar Equipo" onclick="search_sar('+id+');"> <i class="fa fa-edit"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion += '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                                }
                                opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"> </i></a>'+
                                        '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                                if (str >= 5 && status == 'ALTA') {
                                    opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                                }
                                if (str >= 10 && status == 'ALTA') {
                                    opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                                }
                                return opcion;
                            }
                        },
                    ]
                });
            break;
        }
    }
} );

$(document).ready( function () {
$('#ListRadioEnlace').DataTable({
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
            exportOptions: { columns: [ 0, 1, 2, 3]},
        },
        {
            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
            className: 'btn btn-warning',
            exportOptions: {columns: [ 0, 1, 2, 3]},
        },
        {
            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
            className: 'btn btn-primary',
            exportOptions: {columns: [ 0, 1, 2, 3]},
        },
        {
            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            exportOptions: {columns: [ 0, 1, 2, 3]},
        },
        {
            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
            className: 'btn btn-success buttons-html5',
            exportOptions: {columns: [ 0, 1, 2, 3]},
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        },
    ],
    "ajax": getBaseURL()+'radio/enlace/listar',
    "columns": [
        { data: 'name' },
        { data: 'extreme_1_port1' },
        { data: 'extreme_2_port2' },
        { data: 'bw' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id_extreme_2;
                var opcion = '';
                    opcion += '<a data-toggle="modal" data-target="#pop_servi_equipo" onclick="service_equipmen('+id+');" title="Ver servicio"> <i class="fa fa-desktop"></i></a>';
                return opcion;
            }
        },
    ]
});
} );
//--------------------Funsion de DataTable Para anillo--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (str >= 3) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#anillo_list').DataTable({
            "rowCallback": function( Row, Data) {
                var info = Data.number;
                if (info < 65 ) {
                    $($(Row).find("td")[8]).css('background-color', '#75F552');
                }else{
                    if (info >= 65 && info <= 90) {
                        $($(Row).find("td")[8]).css('background-color', '#EEF552');
                    }else{
                        $($(Row).find("td")[8]).css('background-color', '#F56F52');
                    }
                }
                if (Data.act == 'Apto') {
                    $($(Row).find("td")[9]).css('background-color', '#75F552');
                }else{
                    $($(Row).find("td")[9]).css('background-color', '#F56F52');
                }
            },
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            "ajax": getBaseURL() +'listar/anillo',
            "columns": [
                { data: 'name' },
                { data: 'acronimo' },
                { data: 'type' },
                { data: 'dedicated' },
                { data: 'status' },
                { data: 'cantidad' },
                { data: 'bw_max_port' },
                { data: 'utilizado' },
                { data: 'libre' },
                { data: 'act' },
                { data: 'type_ring' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var id_equip = full.id_equipment;
                        var status = full.status;
                        var name = full.name;
                        var opcion = '';
                        if (str >= 5 && status != 'BAJA') {
                            opcion += '<a data-toggle="modal" data-target="#popcrear_anillo_editar" title="Editar anillo" onclick="search_anillo('+id+');"> <i class="fa fa-edit"> </i></a>'+
                                    '<a data-toggle="modal" data-target="#puerto_anillo_new" title="Cambiar puerto" onclick="update_ring_port('+id+');"> <i class="fa fa-keyboard-o"> </i></a>';
                        }
                        if (status != 'BAJA') {
                            opcion +='<a data-toggle="modal" data-target="#pop_ip_anillo_vlan" title="Vlan e IP" onclick="search_vlan_ip('+id+','+id_equip+');"> <i class="fa fa-sitemap"> </i></a>'+
                                    '<a data-toggle="modal" data-target="#service_ring_all" onclick="service_ring('+id+');" title="Ver servicio"> <i class="fa fa-desktop"></i></a>' +
                                    '<a data-toggle="modal" data-target="#buscar_equipo_anillo_all" title="Equipo en el anillo" onclick="inf_anillo('+id+');"> <i class="fa fa-info-circle"></i></a>';
                        }
                        if (str >= 5 && status != 'BAJA') {
                            opcion +='<a data-toggle="modal" data-target="#confimacion_full" title="Baja de anillo" onclick="delete_ring('+id+');"> <i class="fa fa-window-close"> </i></a>';
                        }
                        opcion += '<a title="Excel" href="'+getBaseURL()+'ver/importar/anillo/'+name+'" target="_blank"> <i class="fa fa-clipboard"> </i> </a>'
                        opcion +='<a onclick="PortRingAllNew('+id+');" data-toggle="modal" data-target="#UpdatePortRingAll" title="Agregar y Quitar puerto al anillo"> <i class="fa fa-plug"></i></a>';
                        return opcion;
                    }
                },
            ]
        });
    }
} );

//--------------------Funsion de DataTable Para grupo--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    var url = getBaseURL() +'listar/grupo';
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (str >= 3) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#lis_group_ip').DataTable({
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": url,
            "columns": [
                { data: 'name' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var opcion = '';
                        if (str >= 5) {
                            opcion += '<a data-toggle="modal" data-target="#popcrear_grupo" title="Editar Grupo" onclick="search_group('+id+');"> <i class="fa fa-edit"> </i></a>'+
                            '<a data-toggle="modal" data-target="#popagregar_quitar_usuario" title="Agregar y/o Quitar Usuarios" onclick="search_user_agre_qui('+id+');"> <i class="fa fa-vcard"> </i></a>'+
                            '<a data-toggle="modal" data-target="#popagregar_quitar_permiso" title="Agregar y/o Quitar Permiso" onclick="search_per_agre_qui('+id+');"> <i class="fa fa-unlock"> </i></a>';
                        }
                        return opcion;
                    }
                },
            ]
        });
    }
});

//--------------------Funsion de DataTable Para permiso especiales--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    var url = getBaseURL() +'listar/permiso';
    $.fn.dataTable.ext.errMode = 'throw';
        $('#lis_permiso_ip').DataTable({
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": url,
            "columns": [
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var name = full.name;
                        var last_name = full.last_name;
                        return name+' '+last_name;
                    }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var branch = full.branch;
                        var ip_old = full.ip;
                        if (ip_old == null) {
                            ip = '';
                        }else{
                            ip = ip_old;
                        }
                        return branch+' '+ip;
                    }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var permis = full.permissions;
                        switch (permis) {
                            case "0":
                                var msj = 'Sin acceso';
                            break;
                            case "3":
                                var msj = 'Lectura';
                            break;
                            case "5":
                                var msj = 'Modificar';
                            break;
                            case "10":
                                var msj = 'Crear';
                            break;
                        }
                        return msj;
                    }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        return '<a data-toggle="modal" data-target="#popcrear_permiso_especial" title="Editar Permiso" onclick="search_permiss('+id+');"> <i class="fa fa-edit"> </i></a>';
                    }
                },
            ]
        });
});

//--------------------Funsion de DataTable Para direcciones--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    var url = getBaseURL() +'listar/direccion';
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (str >= 3) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_address').DataTable({
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            "ajax": url,
            "columns": [
                { data: 'countries' },
                { data: 'provinces' },
                { data: 'location' },
                { data: 'street' },
                { data: 'height' },
                { data: 'floor' },
                { data: 'department' },
                { data: 'postal_code' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var opcion = '<a data-toggle="modal" data-target="#buscar_contenido_direccion" title="Contenido de Dirrección" onclick="content_direc('+id+');"> <i class="fa fa-archive"></i></a>';
                        if (str >= 5) {
                            opcion += '<a data-toggle="modal" data-target="#popaddress_general" title="Editar Dirrección" onclick="search_address('+id+');"> <i class="fa fa-edit"></i></a>';
                        }
                        return opcion;
                    }
                },
            ]
        });
    }
});

//--------------------Funsion de DataTable Para servicio--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) {
        str = permi.value;
    }else{
        str = 0;
    }
    if (str >= 3) {
        $.fn.dataTable.ext.errMode = 'throw';
        $('#servicios_list').DataTable( {
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print ">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
            "ajax": getBaseURL()+'listar/servicio',
            "columns": [
                { data: 'number' },
                { data: 'name' },
                { data: 'order_high' },
                { data: 'bw_service' },
                { data: 'business_name' },
                { data: 'status' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var buttonID = full.id;
                        var status = full.status;
                        var number = full.number;
                        var ip = full.require_ip;
                        var opcion = '';
                        'NO'
                        if (str >= 5) {
                            if (status == "ALTA") {
                                opcion +='<a data-toggle="modal" data-target="#crear_servicio_pop" title="Editar servicio" onclick="search_service('+buttonID+');"> <i class="fa fa-edit"> </i></a>'+
                                        '<a data-toggle="modal" data-target="#mostrar_recurso_servicio_pop" title="Ver Recurso" onclick="ver_recurso_servicio('+buttonID+','+full.type+');"> <i class="fa fa-list-alt"> </i> </a>';
                                if (ip != "NO") opcion += '<a data-toggle="modal" data-target="#recur_sevi_ip_pop" title="Ver IP" onclick="ver_ip_servicio('+buttonID+');"> <img class="iconos svg" src="' + getBaseURL() + 'public/icono/ja-ip.svg" title="Ver IP"/> </a>';
                                opcion += '<a data-toggle="modal" data-target="#ip_new_ser_baja" title="Baja del servicio" onclick="down_servi('+buttonID+');"> <i class="fa fa-window-close"> </i> </a>'+
                                        '<a data-toggle="modal" data-target="#cancelar_sevi" title="Cancelar servicio" onclick="cancelar_servicio('+buttonID+');"> <i class="fa fa-trash-o"> </i> </a>';
                            } else {
                                opcion +='<a title="Alta de servicio" onclick="up_service('+buttonID+');"> <i class="fa fa-toggle-on"> </i> </a>';
                            }
                        }
                        opcion +='<a title="Ingeneria" href="http://coronel2.claro.amx:8010/WebIngenieria/pages/buscarIngenieria.xhtml?email=true&servicio='+number+'" target="_blank"> <i class="fa fa-clipboard"> </i> </a>';
                        return opcion;
                    }
                },
            ]
        });
    }
});

$(document).ready( function () {
    //--------------------Funsion de DataTable Para equipo selec--------------------
    var functi = document.getElementById("functi");
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_equipmen').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/seleccion/'+fun,
        "columns": [
            { data: 'equipment' },
            { data: 'model' },
            { data: 'mark' },
            { data: 'bw_max_hw' },
            { data: 'stock_benavidez' },
            { data: 'description' },
            { data: 'status' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Seleccione" onclick="selec_equipmen('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
                }
            },
        ]
    });

    //--------------------Funsion de DataTable Para cliente selec--------------------
    // $('#list_all_cliente').DataTable( {
    //     stateSave: true,
    //     destroy: true,
    //     "processing": true,
    //     "ajax": getBaseURL() +'listar/cliente',
    //     "columns": [
    //         { data: 'business_name' },
    //         { data: 'acronimo' },
    //         { data: 'cuit' },
    //         {
    //             sortable: false,
    //             "render": function ( data, type, full, meta ) {
    //                 var id = full.id;
    //                 return '<a title="Seleccionar"> <i class="fa fa-bullseye" onclick="selec_client('+id+');"> </i></a>';
    //             }
    //         },
    //     ]
    // });


});

//--------------------Funsion de DataTable Para servicio selec--------------------
    function service_table_select(){
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_all_servicio').DataTable( {
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL() +'todos/servicio/selecion',
            "columns": [
                { data: 'number' },
                { data: 'name' },
                { data: 'order_high' },
                { data: 'bw_service' },
                { data: 'business_name' },
                { data: 'status' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var status = full.status;
                        if (status == 'ALTA') {
                            return `<a title="Seleccionar" onclick="selec_service(${id});"> <i class="fa fa-bullseye"> </i></a>`;
                        }else{
                            return '<a> <i class="fa fa-warning" title=" No Seleccionar"> </i></a>';
                        }
                    }
                },
            ]
        });
    }

    function service_table_select_radio(){
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_all_servicio').DataTable( {
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL() +'todos/servicio/selecion',
            "columns": [
                { data: 'number' },
                { data: 'name' },
                { data: 'order_high' },
                { data: 'bw_service' },
                { data: 'business_name' },
                { data: 'status' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var status = full.status;
                        if (status == 'ALTA') {
                            return '<a title="Seleccionar" onclick="selec_service_radio('+id+');"> <i class="fa fa-bullseye"> </i></a>';
                        }else{
                            return '<a> <i class="fa fa-warning" title=" No Seleccionar"> </i></a>';
                        }
                    }
                },
            ]
        });
    }

    //--------------------Funsion de DataTable Para nodo selec--------------------
    function node_table_select(){
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_all_node').DataTable({
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL() +'listar/nodo',
            "columns": [
                { data: 'cell_id' },
                { data: 'node' },
                { data: 'type' },
                { data: 'commentary' },
                { data: 'dire' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        return '<a title="Seleccionar" onclick="selec_node('+id+');"> <i class="fa fa-bullseye"> </i></a>';
                    }
                },
            ]
        });
    }

function node_table_select_lsw_new(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_node').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/nodo',
    "columns": [
        { data: 'cell_id' },
        { data: 'node' },
        { data: 'type' },
        { data: 'commentary' },
        { data: 'dire' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccionar" onclick="selec_node_lsw_new('+id+');"> <i class="fa fa-bullseye"> </i></a>';
            }
        },
    ]
});
}

//--------------------Funsion de DataTable Para puerto ocupado--------------------
$(document).ready( function () {
    var id = document.getElementById("id_equip");
    if (id != null) {
        id_equip = id.value;
    }else{
        id_equip = 0;
    }
    $.fn.dataTable.ext.errMode = 'throw';
        $('#lis_port_occupied').DataTable( {
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL() +'listar/puerto/ocupado/'+id_equip,
            "columns": [
                { data: 'board' },
                { data: 'type_board' },
                { data: 'quantity' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var port_f_i = full.port_f_i;
                        var port_f_f = full.port_f_f;
                        return port_f_i+' - '+port_f_f;
                    }
                },
                { data: 'port' },
                { data: 'connector' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var bw = full.bw_max_port;
                        if (bw < 1000) {
                            return ''+bw+' Kbps';
                        }else{
                            if (bw > 999 && bw < 1000000) {
                                var bw_new = bw/1000;
                                return ''+bw_new+' Mbps';
                            }else{
                                var bw_new = bw/1000000;
                                return ''+bw_new+' Gbps';
                            }
                        }
                    }
                },
                { data: 'label' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var pose = full.description_label;
                        var pose_full ='';
                        if (pose != null) {
                            var pos_all = pose.split('#');
                            $(pos_all).each(function(p, o){ // indice, valor
                                var po_divi = pos_all[p].split('%');
                                if (pose_full =='') {
                                    pose_full = po_divi[0]+' ('+po_divi[1]+'-'+po_divi[2]+')';
                                }else{
                                    pose_full = pose_full +po_divi[3]+po_divi[0]+' ('+po_divi[1]+'-'+po_divi[2]+')';
                                }

                            })
                        }
                        return pose_full;

                    }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var port_l_i = full.port_l_i;
                        var port_l_f = full.port_l_f;
                        return port_l_i+' - '+port_l_f;
                    }
                },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var status = full.status;
                        if (status != 'Activo') {
                            var opcion = '<a onclick="active_placa('+id+')" title="Activar"> <i class="fa fa-toggle-on"> </i></a>';
                        }else{
                            var opcion = '<a onclick="confimar_placa('+id+')" title="Desactivar"> <i class="fa fa-toggle-off"> </i></a>';
                        }
                            opcion += '<a title="Editar F/S/P" data-toggle="modal" data-target="#fsp_pop" onclick="search_relation('+id+');"> <i class="fa fa-edit"> </i></a>';
                    return opcion;
                    }
                },
            ]
        });

    $('#lis_port_free').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/puerto/libre/'+id_equip,
        "columns": [
            {data: 'board'},
            {data: 'type_board'},
            {data: 'quantity'},
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var port_f_i = full.port_f_i;
                    var port_f_f = full.port_f_f;
                    return port_f_i+' - '+port_f_f;
                }
            },
            {data: 'port'},
            {data: 'connector'},
            {data: 'bw_max_port'},
            {data: 'label'},
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var port_l_i = full.port_l_i;
                    var port_l_f = full.port_l_f;
                    return port_l_i+' - '+port_l_f;
                }
            },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var opcion = '<a title="Asignado Puerto" data-toggle="modal" data-target="#fsp_pop" onclick="port_equip('+id+','+id_equip+');"> <i class="fa fa-dot-circle-o"> </i></a>'+
                            '<a title="Modificar Placa" data-toggle="modal" data-target="#popcrear_port" onclick="search_port('+id+');"> <i class="fa fa-edit"> </i></a>';
                    return opcion;
                }
            },
        ]
    });
});

//--------------------Funsion de DataTable Para importar informacion agg --------------------
$(document).ready( function () {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#impor_agg_data').DataTable( {
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
        "ajax": getBaseURL()+'listar/importar/agregadores',
        "columns": [
            { data: 'ip' },
            { data: 'hostname' },
            { data: 'interface' },
            { data: 'adminstatus' },
            { data: 'operstatus' },
            { data: 'descripcion' },
            { data: 'nombremodulo' },
            { data: 'descripmodulo' },
            { data: 'date' },
        ]
    });
});


//--------------------Funsion de DataTable Para usuarios --------------------
$(document).ready( function () {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#user_lis_all').DataTable( {
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
                exportOptions: { columns: [ 0, 1, 2, 3, 4, 5]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5]},
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL()+'lista/usuario',
        "columns": [
            { data: 'name' },
            { data: 'workgroup' },
            { data: 'profile' },
            { data: 'status' },
            { data: 'inicio' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var fin = full.fin;
                    var id = full.id;
                    if (fin != null) {
                        var opcion = fin;
                    }else{
                        var opcion = '<a data-toggle="modal" data-target="#confimacion_full" onclick="users_sesion('+id+')" title="Expulsar Usuario"> <i class="fa fa-bullseye"> </i></a>';
                    }
                    return opcion;
                }
            },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    var opcion = '<a href="'+getBaseURL()+'modificar/perfil/'+id+'"> <i class="fa fa-edit" title="Editar perfil"> </i></a>';
                    if (status === 'Activado') {
                        opcion += '<a data-toggle="modal" data-target="#confimacion_full" onclick="users_desactivar('+id+')" title="Activado"> <i class="fa fa-toggle-on"> </i></a>';
                    }else{
                        opcion += '<a title="Desactivado" onclick="users_activar('+id+');"> <i class="fa fa-toggle-on"> </i></a>';
                    }
                    return opcion;
                }
            },

        ]
    });
});

//--------------------Funsion de DataTable Para importar informacion stock --------------------
$(document).ready( function () {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#impor_stock_data').DataTable( {
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
                    exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]},
                },
                {
                    extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                    className: 'btn btn-warning',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]},
                },
                {
                    extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                    className: 'btn btn-primary',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]},
                },
                {
                    extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]},
                },
                {
                    extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                    className: 'btn btn-success buttons-html5',
                    exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]},
                    customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                },
            ],
        "ajax": getBaseURL()+'listar/importar/stock',
        "columns": [
            {data: 'tecn'},
            {data: 'marca'},
            {data: 'codsap'},
            {data: 'codsap_anterior'},
            {data: 'descripcion'},
            {data: 'stock_benavidez'},
            {data: 'stock_cordoba'},
            {data: 'stock_mantenimiento'},
            {data: 'stock_proyectos'},
            {data: 'traslado_origen'},
            {data: 'oc_generada'},
            {data: 'stock_mimnimo'},
            {data: 'futuro_uso1'},
            {data: 'futuro_uso2'},
            {data: 'costo_uss'},
        ]
    });
});

$(document).ready( function () {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_stock').DataTable( {
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
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL()+'listar/stock',
        "columns": [
            { data: 'codsap' },
            { data: 'tecn' },
            { data: 'marca' },
            { data: 'stock_benavidez' },
            { data: 'descripcion' },
        ]
    } );
} );

function client_table_select(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_cliente').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/cliente',
        "columns": [
            { data: 'business_name' },
            { data: 'acronimo' },
            { data: 'cuit' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Seleccionar" onclick="selec_client('+id+');"> <i class="fa fa-bullseye"></i></a>';
                }
            },
        ]
    });
}

function client_table_select_lsw(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_cliente').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/cliente',
        "columns": [
            { data: 'business_name' },
            { data: 'acronimo' },
            { data: 'cuit' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Seleccionar" onclick="selec_client_lsw('+id+');"> <i class="fa fa-bullseye"></i></a>';
                }
            },
        ]
    });
}

function detal_addres(fun){
if (fun == 3) {
    var table = $('#list_all_address_servi')
}else{
    var table = $('#list_all_address');
}
$.fn.dataTable.ext.errMode = 'throw';
table.DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/direccion',
    "columns": [
        { data: 'countries' },
        { data: 'provinces' },
        { data: 'location' },
        { data: 'street' },
        { data: 'height' },
        { data: 'floor' },
        { data: 'department' },
        { data: 'postal_code' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccione" onclick="selec_address('+id+','+fun+');"> <i class="fa fa-bullseye"> </i></a>';
            }
        },
    ]
});
}

function detal_addres_radio(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_address').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/direccion',
    "columns": [
        { data: 'countries' },
        { data: 'provinces' },
        { data: 'location' },
        { data: 'street' },
        { data: 'height' },
        { data: 'floor' },
        { data: 'department' },
        { data: 'postal_code' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccione" onclick="selec_address_radio('+id+');"> <i class="fa fa-bullseye"> </i></a>';
            }
        },
    ]
});
}

function selec_list_addres_lsw_new(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_address').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/direccion',
    "columns": [
        { data: 'countries' },
        { data: 'provinces' },
        { data: 'location' },
        { data: 'street' },
        { data: 'height' },
        { data: 'floor' },
        { data: 'department' },
        { data: 'postal_code' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccione" onclick="selec_address_lsw_new('+id+');"> <i class="fa fa-bullseye"> </i></a>';
            }
        },
    ]
});
}

function list_equipmen_servi(fun) {
    $('#list_all_equip_servi').DataTable({
        stateSave: true,
        "bDestroy": true,
        "ajax": getBaseURL() +'listar/equipo/'+fun,
        "columns": [
            { data: 'acronimo' },
            { data: 'model' },
            { data: 'mark' },
            { data: 'status' },
            { data: 'address' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    if (status != 'BAJA') {
                        return '<a onclick="sele_equi_servi('+id+');" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                    }else{
                        return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                    }
                }
            },
        ]
    });
}

function list_equipment_2(type_equip) {
    $('#eq_table').DataTable({
        stateSave: true,
        "bDestroy": true,
        "ajax": getBaseURL() +'listar/equipo/'+type_equip,
        "columns": [
            { data: 'acronimo' },
            { data: 'model' },
            { data: 'mark' },
            { data: 'status' },
            { data: 'address' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    if (full.status != 'BAJA') {
                        return '<a onclick="select_equipment_modal('+full.id+');" title="seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                    } else {
                        return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                    }
                }
            },
        ]
    });
}

function service_ring(id){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_service_ring').DataTable({
        stateSave: true,
        "bDestroy": true,
        "ajax": getBaseURL() +'servicio/anillo/'+id,
        "columns": [
            { data: 'acronimo' },
            { data: 'number' },
            { data: 'name' },
            { data: 'bw' },
            { data: 'client' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var number = full.number;
                    return '<a title="Ingeneria" href="http://coronel2.claro.amx:8010/WebIngenieria/pages/buscarIngenieria.xhtml?email=true&servicio='+number+'" target="_blank"> <i class="fa fa-clipboard"> </i> </a>';
                }
            },
        ]
    });
}

function agg_service_ring(id){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_service_ring').DataTable({
        stateSave: true,
        "bDestroy": true,

        "processing": true,
        dom: 'lfrtip<"html5buttons"B>',
        buttons:[
            {
                extend: 'copy', text: '<i class="fa fa-copy">', titleAttr: 'Copiar',
                className: 'btn btn-info',
                exportOptions: { columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'agregador/servicio/anillo/'+id,
        "columns": [
            { data: 'acronimo' },
            { data: 'number' },
            { data: 'name' },
            { data: 'bw' },
            { data: 'client' },
        ]
    });
}

//--------------------Funsion de DataTable Para nodo selec anillo--------------------
function node_table_select_anillo(funti = 0){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_node').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/nodo/anillo',
    "columns": [
        { data: 'cell_id' },
        { data: 'node' },
        { data: 'type' },
        { data: 'commentary' },
        { data: 'dire' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccionar" onclick="selec_node_anillo('+id+', '+funti+');"> <i class="fa fa-bullseye"> </i></a>';
            }
        },
    ]
});
}

function nodo_lsw_ipran(){
$("#id_lsw").find('option').remove();
$("#id_lsw").append('<option selected disabled value="">seleccionar</option>');
var nodo = document.getElementById("nodo_all").value;
if (nodo != '' && nodo != null) {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_lsw_equip').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'LSW/anillo/'+nodo,
        "columns": [
            { data: 'acronimo' },
            { data: 'ip' },
            { data: 'commentary' },
            { data: 'status' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Seleccionar" onclick="sele_lws_ring('+id+');" data-dismiss="modal"> <i class="fa fa-bullseye"> </i></a>';
                }
            },
        ]
    });
}
}
function list_anillo_servi(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_ring_service').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/anillo',
        "columns": [
            { data: 'name' },
            { data: 'acronimo' },
            { data: 'type' },
            { data: 'dedicated' },
            { data: 'cantidad' },
            { data: 'bw_max_port' },
            { data: 'libre' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    if (status == 'ALTA') {
                        option = '<a title="Seleccionar" onclick="selec_anillo_service('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
                    }else{
                        option = '<a title="Fuera de la red"> <i class="fa fa-warning" style="color: coral;"></i> </a>';
                    }
                    return option;

                }
            },
        ]
    });
}

function equipo_table_select(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_equip_ip').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/seleccion/equipo/ip',
        "columns": [
            { data: 'acronimo' },
            { data: 'model' },
            { data: 'mark' },
            { data: 'status' },
            { data: 'address' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    if (status != 'BAJA') {
                        return '<a onclick="sele_equi_admin_ip('+id+');" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                    }else{
                        return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                    }
                }
            },
        ]
    });
}

function list_anillo_filter(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_ring_service').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/anillo',
        "columns": [
            { data: 'name' },
            { data: 'acronimo' },
            { data: 'type' },
            { data: 'dedicated' },
            { data: 'cantidad' },
            { data: 'bw_max_port' },
            { data: 'libre' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    if (status == 'ALTA') {
                        option = '<a title="Seleccionar" onclick="selec_anillo_ip('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
                    }else{
                        option = '<a title="Fuera de la red"> <i class="fa fa-warning" style="color: coral;"></i> </a>';
                    }
                    return option;

                }
            },
        ]
    });
}

function client_table_select_ip(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_cliente').DataTable( {
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/cliente',
        "columns": [
            { data: 'business_name' },
            { data: 'acronimo' },
            { data: 'cuit' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Seleccionar" onclick="selec_client_ip('+id+');"> <i class="fa fa-bullseye"></i></a>';
                }
            },
        ]
    });
}

function service_table_select_ip(){
        $.fn.dataTable.ext.errMode = 'throw';
        $('#list_all_servicio').DataTable( {
            deferRender: true,
            "autoWidth": true,
            "paging": true,
            stateSave: true,
            destroy: true,
            "processing": true,
            "ajax": getBaseURL() +'todos/servicio/selecion',
            "columns": [
                { data: 'number' },
                { data: 'name' },
                { data: 'order_high' },
                { data: 'bw_service' },
                { data: 'business_name' },
                { data: 'status' },
                {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                        var id = full.id;
                        var status = full.status;
                        if (status == 'ALTA') {
                            return '<a title="Seleccionar" onclick="selec_service_ip('+id+');"> <i class="fa fa-bullseye"> </i></a>';
                        }else{
                            return '<a> <i class="fa fa-warning" title=" No Seleccionar"> </i></a>';
                        }
                    }
                },
            ]
        });
    }

function equipo_table_select_ip(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_equip_ip').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/seleccion/equipo/ip',
    "columns": [
        { data: 'acronimo' },
        { data: 'model' },
        { data: 'mark' },
        { data: 'status' },
        { data: 'address' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                if (status != 'BAJA') {
                    return '<a onclick="sele_equi_admin_ip_list('+id+');" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                }else{
                    return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                }
            }
        },
    ]
});
}
//--------------------Funsion de DataTable Para importar informacion agg --------------------
$(document).ready( function () {
$.fn.dataTable.ext.errMode = 'throw';
$('#impor_list_module').DataTable( {
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
                exportOptions: { columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success',
                exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]},
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
    "ajax": getBaseURL()+'listar/importar/module',
    "columns": [
        { data: 'nombre_modulo' },
        { data: 'tipo_modulo' },
        { data: 'distancia' },
        { data: 'fibra' },
        { data: 'corta_larga' },
    ]
});
});

//--------------------Funsion de DataTable Para Modelado--------------------
$(document).ready( function () {
var permiso = 0;
var permi = document.getElementById("permi");
if (permi != null) {
    permiso = permi.value;
}
if (permiso >= 10) {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_stock_all_ip').DataTable( {
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
                exportOptions: {columns: [ 0, 1, 2]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2]},
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            },
            ],
            "ajax": getBaseURL() +'listar/stock/IP',
            "columns": [
                    { data: 'rank' },
                    { data: 'status' },
                    { data: 'use' },
                    {
                        sortable: false,
                        "render": function ( data, type, full, meta ) {
                            var id = full.id;
                            var status = full.status;
                            var valor = '';
                            if (status == 'VACANTE') {
                                valor += '<a title="Editar rango" onclick="search_stock_ip('+id+');" data-toggle="modal" data-target="#popstock_ip"> <i class="fa fa-edit" > </i></a>';
                            }
                            return valor;
                        }
                    },
                ]
            } );
}
} );

function stock_ip_table_select(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_stock_ip').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'seleccionar/IP/stock',
    "columns": [
        { data: 'rank' },
        { data: 'status' },
        { data: 'use' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                if (status == 'VACANTE') {
                    return '<a onclick="sele_stock_ip_list('+id+');" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                }else{
                    return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                }
            }
        },
    ]
});
}

function selec_ring_ip_wan(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_ring_all').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/anillo',
    "columns": [
        { data: 'name' },
        { data: 'acronimo' },
        { data: 'type' },
        { data: 'dedicated' },
        { data: 'cantidad' },
        { data: 'bw_max_port' },
        { data: 'libre' },
        {
            sortable: false,
                "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                if (status == 'ALTA') {
                    option = '<a title="Seleccionar" onclick="selec_anillo_ip_wan('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
                }else{
                    option = '<a title="Fuera de la red"> <i class="fa fa-warning" style="color: coral;"></i> </a>';
                }
                return option;
            }
        },
    ]
});
}

//--------------------Funsion de DataTable Para Modelado--------------------
$(document).ready( function () {
    var permi = document.getElementById("permi");
    if (permi != null) {
        var str = permi.value;
    }else{
        var str = 0;
    }
    var buscar = document.getElementById("data_buscar");
    if (buscar != null) {
        var info = buscar.value;
    }else{
        var info = '';
    }
    $.fn.dataTable.ext.errMode = 'throw';
    $('#jarvis_excel_anillo').DataTable( {
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
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10, 11, 12, 13 ]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10, 11, 12, 13 ]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10, 11, 12, 13 ]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10, 11, 12, 13 ]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10, 11, 12, 13 ]},
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'importar/anillo/lista',
        "columns": [
            { data: 'anillo' },
            { data: 'bw_anillo' },
            { data: 'acronimo_sw' },
            { data: 'bwcpe' },
            { data: 'capacidad' },
            { data: 'ic_alta' },
            { data: 'cliente' },
            { data: 'direccion' },
            { data: 'sw_viejo' },
            { data: 'ip_gestion' },
            { data: 'vlan_gestion' },
            { data: 'by_pass' },
            { data: 'modelo' },
            { data: 'bw_migrado' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    opcion = '<a data-toggle="modal" data-target="#port_excel" title="Detalle de puerto" onclick="detal_port_excel_ring('+id+');"> <i class="fa fa-search"> </i></a>';
                    return opcion;
                }
            },
        ]
    }).search(info).draw();

    $('#list_cadena').DataTable( {
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
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'listar/cadena',
        "columns": [
            { data: 'name' },
            { data: 'bw' },
            { data: 'extreme_1' },
            { data: 'extreme_2' },
            { data: 'status' },
            { data: 'commentary' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    opcion = '<a data-toggle="modal" data-target="#edic_cadena_pop" title="Editar cadena" onclick="edic_chain('+id+');"> <i class="fa fa-edit"> </i></a>';
                    opcion += '<a data-toggle="modal" data-target="#list_equip_agg_pop" title="lista de agregadores asociados" onclick="chain_equipment_agg('+id+');"> <i class="fa fa-list-alt"> </i></a>';
                    opcion += '<a data-toggle="modal" data-target="#relacionar_puertos_pop" title="Relacionar puertos" onclick="show_relate_ports('+id+');"> <i class="fa  fa-podcast"> </i></a>';
                    opcion += '<a data-toggle="modal" data-target="#crear_asignar_agg_pop" title="Asociar aggregador" onclick="new_agg_chain('+id+');"> <i class="fa fa-superpowers"> </i></a>';
                    opcion += '<a data-toggle="modal" data-target="#" title="Borrar cadena" onclick="delete_empty_chain('+id+');"> <i class="fa fa-ban"> </i></a>';
                    return opcion;
                }
            },
        ]
    });

$('#list_link').DataTable( {
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
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
        },
        {
            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
            className: 'btn btn-warning',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
        },
        {
            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
            className: 'btn btn-primary',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
        },
        {
            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
        },
        {
            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
            className: 'btn btn-success buttons-html5',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5]},
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        },
    ],
    "ajax": getBaseURL() +'listar/link',
    "columns": [
        { data: 'name' },
        { data: 'type' },
        { data: 'node' },
        { data: 'bw' },
        { data: 'commentary' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                opcion = '<a data-toggle="modal" data-target="#modify_link_pop" title="Editar link" onclick="update_search_link('+id+');"> <i class="fa fa-edit"> </i></a>';
                return opcion;
            }
        },
    ]
});
$('#list_reserve').DataTable( {
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
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7]},
        },
        {
            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
            className: 'btn btn-warning',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7]},
        },
        {
            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
            className: 'btn btn-primary',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7]},
        },
        {
            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7]},
        },
        {
            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
            className: 'btn btn-success buttons-html5',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7]},
            customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
            }
        },
    ],
    "ajax": getBaseURL() +'listar/reserva',
    "columns": [
        { data: 'number_reserve' },
        { data: 'bw' },
        { data: 'status' },
        { data: 'user' },
        { data: 'date' },
        { data: 'quantity_dates' },
        { data: 'oportunity' },
        { data: 'node' },
        { data: 'service' },
        //{ data: 'cell_bw_reserved' },
        // { data: 'list_type_link' },
        { data: 'commentary' },
        {
            sortable: true,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                var days = full.days;
                var type = full.type;
                opcion ='<a data-toggle="modal" data-target="#reserve_info_pop" title="Detalle Celda Asignada" onclick="reserve_detail('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                if (status == 'VIGENTE') {
                    if(str >= 3 ){
                        //mostrar info
                    }
                    if(str >= 5){
                        opcion += '<a data-toggle="modal" data-target="#pop_edic_alta_reserve" title="Editar reserva" onclick="reserve_edit_modal('+id+');"> <i class="fa fa-edit"> </i> </a>';
                        if (type == 'UPGRADE') opcion += '<a data-toggle="modal" data-target="#aplicar_reserva_servicio_pop" title="Aplicar reserva sobre servicio" onclick="apply_service_reserve('+id+');"> <i class="fa fa-clipboard-check"></i> </i> </a>';
                        if (days <= 90) opcion += '<a data-toggle="modal" title="Agregar dias" onclick="add_time_reserve('+id+');"> <i class="fa fa-clock-o"> </i></a>';
                    }
                    if (str >= 10) opcion += '<a data-toggle="modal" title="Cancelar reserva" onclick="cancell_reserve('+id+');"> <i class="fa fa-ban"> </i></a>';
                }
                return opcion;
            }
        },
    ]
});

$('#list_link_ipran').DataTable( {
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
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
            className: 'btn btn-warning',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
            className: 'btn btn-primary',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
            className: 'btn btn-success buttons-html5',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        },
    ],
    "ajax": getBaseURL() +'listar/link/ipran',
    "columns": [
        { data: 'name' },
        { data: 'type' },
        { data: 'node' },
        { data: 'equipment' },
        { data: 'link_status' },
        { data: 'bw' },
        { data: 'bw_reservado' },
        { data: 'bw_remanente' },
        { data: 'bw_used' },
        { data: 'node_status' },
        { data: 'commentary' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.link_status;
                opcion = '<a data-toggle="modal" data-target="#modify_link_pop" title="Editar link" onclick="update_search_link('+id+');"> <i class="fa fa-edit"> </i></a>';
                opcion += '<a data-toggle="modal" data-target="#pop_servi_equipo" title="Ver servicio" onclick="service_uplink('+id+');"> <i class="fa fa-desktop"> </i></a>';
                if(status != 'BAJA'){
                    opcion += '<a data-toggle="modal" title="Elimnar link" onclick="delete_link_ipran('+id+');"> <i class="fa fa-trash-o"> </i></a>';
                }
                return opcion;
            }
        },
    ]
});
 $('#list_admin_vlan').DataTable( {
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
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4]},
                customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'listar/vlan',
        "columns": [
            { data: 'nro_vlan' },
            { data: 'type_vlan' },
            { data: 'acronimo' },
            { data: 'ring' },
            { data: 'cell' },
            { data: 'n_frontier' },
            { data: 'ip' },
            { data: 'status' },
        ]
    });
    $('#list_frontier_adm_vlan').DataTable( {
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
        "ajax": getBaseURL() +'listar/frontera',
        "columns": [
            { data: 'commentary' },
            { data: 'number_frontier' },
            { data: 'equipment_0' },
            { data: 'bundle_0' },
            { data: 'equipment_1' },
            { data: 'bundle_1' },
            { data: 'zone' },
            { data: 'status' },
            { data: 'bw' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    opcion = '';
                    id = full.id;
                    if (full.status == 'ALTA') {
                        opcion += `<a onclick="enable_disable_frontier(${full.id},'${full.status}')" title="Deshabilitar Frontera"> <i class="fa fa-toggle-on"></i> </a>`;
                    } else if (full.status == 'DESHABILITADA') {
                        opcion += `<a onclick="enable_disable_frontier(${full.id},'${full.status}')" title="Habilitar Frontera"> <i class="fa fa-toggle-off"></i> </a>`;
                    }
                    opcion+= `<a onclick="search_frontier(${id})" title="Editar Frontera" data-toggle="modal" data-target="#popeditar_frontera"> <i class="fa fa-edit"></i> </a>`;
                    opcion+= `<a onclick="search_frontier_to_edit_acronimo(${id})" title="Editar Acrónimo" data-toggle="modal" data-target="#poplist_acronimo"> <i class="fa fa-keyboard-o"></i> </a>`;
                    return opcion;

                }
            },
        ]
    });

$('#list_ledzite').DataTable( {
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
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
            className: 'btn btn-warning',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
            className: 'btn btn-primary',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
            className: 'btn btn-danger',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
        },
        {
            extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
            className: 'btn btn-success buttons-html5',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        },
    ],
    "ajax": getBaseURL() +'listar/ledzite',
    "columns": [
        { data: 'cell_id' },
        { data: 'node' },
        { data: 'type' },
        { data: 'status' },
        //{ data: 'address' },
        { data: 'contract_date' },
        { data: 'owner' },
        { data: 'commentary' },
        //{ data: 'id_uplink' },
        { data: 'sit_codigo' },
        { data: 'clu_codigo' },
        { data: 'geo_id' },
        { data: 'alm_codigo' },
        { data: 'sit_nombre' },
        { data: 'sit_latitud' },
        { data: 'sit_longitud' },
        { data: 'sit_calle' },
        { data: 'sit_numero' },
        { data: 'sit_address' },
        { data: 'sit_hsnm' },
        { data: 'sit_prefijo_telco' },
        { data: 'sit_prefijo_cti' },
        { data: 'sit_area_explotacion' },
        { data: 'sit_common_bcch' },
        { data: 'sit_observaciones' },
        { data: 'sit_coubicacion' },
        { data: 'tsi_codigo' },
        { data: 'sit_gsm' },
        { data: 'sit_umts' },
        { data: 'sit_id_fija' },
        { data: 'lcc_id' },
        { data: 'pro_id' },
        { data: 'sit_ns_activo' },
        { data: 'sit_ns_integrado' },
        { data: 'sit_ns_tipo_celda' },
        { data: 'sit_ns_ci' },
        { data: 'ccn_id' },
        { data: 'sit_ns_clasificacion' },
        { data: 'sit_ns_creacion' },
        { data: 'sit_ns_actualizacion' },
        { data: 'locl_codigo' },
        { data: 'sit_estado' },
        { data: 'sit_fecha_carga' },
        { data: 'sit_owner' },
        { data: 'sit_fecha_vencimiento' },
        { data: 'sit_tipo_estructura' },
        { data: 'sit_lte' },
        { data: 'sit_factor_fo' },
        { data: 'opr_id' },
        { data: 'te_id' },
        { data: 'sit_te_altura' },
        { data: 'sit_te_camuflaje' },
        { data: 'sit_te_compartible' },
        { data: 'sit_fecha_baja' },
        { data: 'tipos_soluciones' },
        { data: 'sit_fecha_alta' },
        { data: 'sit_granja' },
        { data: 'sit_estado_aux' },
        { data: 'sit_distribucion_sm_3g' },
        { data: 'sit_vip' },
        { data: 'loc_area_codigo' },
        { data: 'sit_distribucion_sm_4g' },
        { data: 'sit_distribucion_sm_2g' },
        { data: 'altura_estructura' },
        { data: 'datos_enlace_tx_id' },
        { data: 'sit_ubicacion_tec_movil' },
        { data: 'sit_ubicacion_tec_fija' },
        { data: 'sit_ubicacion_tec_inmueble' },
        { data: 'sit_coubicacion_otros_claro' },
        { data: 'sit_paga_tasa_recurrente' },
        { data: 'sit_fecha_alta_municipio' },
        { data: 'sit_alquilado' },
        { data: 'ord_judicializada_hab' },
        { data: 'ord_judicializada_tasas' },
        //{ data: 'aud_fecha_ins' },
        //{ data: 'aud_fecha_upd' },
        //{ data: 'aud_usr_ins' },
        //{ data: 'aud_usr_upd' },
        { data: 'sit_ran_sharing' },
        { data: 'sit_ran_sharing_proveedor' },
        { data: 'sit_roaming' },
        { data: 'sit_roaming_proveedor' },
        { data: 'sit_propietario' },
        { data: 'sit_codigo_anterior' },
        { data: 'sit_fronterizo' },
    ]
});


} );

function list_all_equipmen_lsw(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_equipmen').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/seleccion/LANSWITCH',
    "columns": [
        { data: 'equipment' },
        { data: 'model' },
        { data: 'mark' },
        { data: 'bw_max_hw' },
        { data: 'stock_benavidez' },
        { data: 'description' },
        { data: 'status' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccione" onclick="selec_equipmen_lsw('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
            }
        },
    ]
});
}

function list_all_equipmen(){
var functi = document.getElementById("functi");
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_equipmen').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'listar/seleccion/'+fun,
    "columns": [
        { data: 'equipment' },
        { data: 'model' },
        { data: 'mark' },
        { data: 'bw_max_hw' },
        { data: 'stock_benavidez' },
        { data: 'description' },
        { data: 'status' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                return '<a title="Seleccione" onclick="selec_equipmen('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
            }
        },
    ]
});
}

function link_table_select_lsw_new(){
$.fn.dataTable.ext.errMode = 'throw';
var id = document.getElementById("nodo_al_lsw").value;
var id_lsw = document.getElementById("id_lsw_new").value;
var link = document.getElementById('link_all_node');
if (id != null && id != '') {
    if (id_lsw == 0) {
        acronimo_lsw_new(id);
    }
    link.style.display = "block";
    $('#list_all_link').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'listar/seleccion/link/'+id,
        "columns": [
            { data: 'name' },
            { data: 'node' },
            { data: 'type' },
            { data: 'bw' },
            { data: 'commentary' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    return '<a title="Seleccionar" onclick="selec_link_lsw_new('+id+');"> <i class="fa fa-bullseye"> </i></a>';
                }
            },
        ]
    });
}else{
    link.style.display = "none";
}
}

function list_all_equipmen_lsw(){
$('#list_all_equip_lsw').DataTable({
    stateSave: true,
    "bDestroy": true,
    "ajax": getBaseURL() +'listar/equipo/LANSWITCH',
    "columns": [
        { data: 'acronimo' },
        { data: 'model' },
        { data: 'mark' },
        { data: 'status' },
        { data: 'address' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                if (status != 'BAJA') {
                    return '<a onclick="selec_equipmen_all_lsw('+id+');" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                }else{
                    return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                }
            }
        },
    ]
});
}
function search_radio_node(){
var id = document.getElementById("nodo_al").value;
if (id != '') {
    $('#list_all_equip_lsw').DataTable({
        stateSave: true,
        "bDestroy": true,
        "ajax": getBaseURL() +'listar/radio/'+id,
        "columns": [
            { data: 'acronimo' },
            { data: 'model' },
            { data: 'mark' },
            { data: 'status' },
            { data: 'address' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    if (status != 'BAJA') {
                        return '<a onclick="selec_equipmen_all_radio('+id+');" title="seleccionar"> <i class="fa fa-dot-circle-o"> </i></a></td>';
                    }else{
                        return '<a><i class="fa fa-warning" style="color: coral;"></i></a>';
                    }
                }
            },
        ]
    });
}
}

function ring_ipran_all() {
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_ring').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'anillo/ipran',
    "columns": [
        { data: 'name' },
        { data: 'acronimo' },
        { data: 'type' },
        { data: 'dedicated' },
        { data: 'cantidad' },
        { data: 'bw_max_port' },
        { data: 'libre' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                if (status == 'ALTA') {
                    option = '<a title="Seleccionar" onclick="selec_anillo_ipran('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
                }else{
                    option = '<a title="Fuera de la red"> <i class="fa fa-warning" style="color: coral;"></i> </a>';
                }
                return option;
            }
        },
    ]
});
}

//--------------------Funsion de DataTable Para anillo selec--------------------
function list_ring_metro_all(){
$.fn.dataTable.ext.errMode = 'throw';
$('#list_all_ring').DataTable({
    deferRender: true,
    "autoWidth": true,
    "paging": true,
    stateSave: true,
    destroy: true,
    "processing": true,
    "ajax": getBaseURL() +'anillo/metroethernet',
    "columns": [
        { data: 'name' },
        { data: 'acronimo' },
        { data: 'type' },
        { data: 'dedicated' },
        { data: 'cantidad' },
        { data: 'bw_max_port' },
        { data: 'libre' },
        {
            sortable: false,
            "render": function ( data, type, full, meta ) {
                var id = full.id;
                var status = full.status;
                if (status == 'ALTA') {
                    option = '<a title="Seleccionar" onclick="selec_anillo_lan('+id+');"> <i class="fa fa-bullseye"> </i> </a>';
                }else{
                    option = '<a title="Fuera de la red"> <i class="fa fa-warning" style="color: coral;"></i> </a>';
                }
                return option;
            }
        },
    ]
});
}

function uplink_by_equipment(eq_id) {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#uplink_list').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": {
            'type': 'POST',
            'url': getBaseURL() + 'listar/link/ipran/nodo',
            'data': {
               id_equip: eq_id
            }
        },
        "columns": [
            { data: 'name' },
            { data: 'type' },
            { data: 'node' },
            { data: 'bw' },
            { data: 'bw_reservado' },
            { data: 'bw_remanente' },
            { data: 'commentary' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    return '<a data-toggle="modal" data-target="" title="Seleccionar" onclick="select_uplink_item('+full.id+',\''+full.name+'\')"> <i class="fa fa-dot-circle-o"> </i></a>';
                }
            },
        ]
    });
}
function ports_agg_home(id) {
    if(id == 1){
        $("#port_agg_list_type").text("GIGABITH ETHERNET");
    }else{
        $("#port_agg_list_type").text("TENGIGABITH ETHERNET");

    }
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_port_agg').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": {
            'type': 'POST',
            'url': getBaseURL() + 'listar/port_agg',
            'headers': {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            'data': {
            id: id
            }
        },
        "columns": [
            { data: 'acronimo' },
            { data: 'status' },
            { data: 'rings_available' },
            { data: 'rings' },
            { data: 'ports_available' },
            { data: 'used_percentage' },
        ]
    });
}

function port_list_by_equipment(id, only_vacant = true, not_if = true) {
$("#port_table_body").empty();
$.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
$.ajax({
    type: "POST",
    url: getBaseURL()+'puerto/equipo',
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
                    var acr = data['datos'][i]['slot']+data['datos'][i]['port'];
                    var rows = '<tr>' +
                            '<td>'+acr+'</td>' +
                            '<td>'+data['datos'][i]['type']+'</td>' +
                            '<td>'+data['datos'][i]['status']+'</td>' +
                            '<td>'+data['datos'][i]['bw']+'</td>' +
                            '<td>'+data['datos'][i]['atributo']+'</td>' +
                            '<td>'+data['datos'][i]['agg_status']+'</td>' +
                            '<td>'+data['datos'][i]['commentary']+'</td>'+
                            '<td>';
                                  if (only_vacant === true && not_if === true) {
                            if (data['datos'][i]['status'] == 'VACANTE' && data['datos'][i]['type'] != 'IF') {
                                rows += '<a onclick="select_port_modal('+data['datos'][i]['id']+','+data['datos'][i]['port']+',\''+acr+'\',\''+data['datos'][i]['type']+'\',\''+data['datos'][i]['bw']+'\');" ';
                                rows += 'title="seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                            }
                        } else if (only_vacant === true && not_if === false) {
                            if (data['datos'][i]['status'] == 'VACANTE') {
                                rows += '<a onclick="select_port_modal('+data['datos'][i]['id']+','+data['datos'][i]['port']+',\''+acr+'\',\''+data['datos'][i]['type']+'\',\''+data['datos'][i]['bw']+'\');" ';
                                rows += 'title="seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                            }
                        } else if (only_vacant === false && not_if === true) {
                            if (data['datos'][i]['type'] != 'IF') {
                                rows += '<a onclick="select_port_modal('+data['datos'][i]['id']+','+data['datos'][i]['port']+',\''+acr+'\',\''+data['datos'][i]['type']+'\',\''+data['datos'][i]['bw']+'\');" ';
                                rows += 'title="seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                            }
                        } else {
                        rows += '<a onclick="select_port_modal('+data['datos'][i]['id']+','+data['datos'][i]['port']+',\''+acr+'\',\''+data['datos'][i]['type']+'\',\''+data['datos'][i]['bw']+'\');" ';
                        rows += 'title="seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                    }
                    rows += '</td></tr>';
                    $("#port_table_body").append(rows);
                });
            break;
            case "nop":
                toastr.error("Error con el servidor");
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

function list_frontier(id_eq) {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_frontier').DataTable({
        stateSave: true,
        "bDestroy": true,
        "ajax": getBaseURL()+'listar/frontera/equipo/'+id_eq,
        "columns": [
            { data: 'sufijo_vcid' },
            { data: 'name' },
            { data: 'node' },
            { data: 'bw' },
            { data: 'commentary' },
            { data: 'status' },
            { data: 'tecnologia' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var option = '';
                    if (full.status == 'ALTA') {
                        option = '<a onclick="select_frontier_modal('+full.id+','+full.name+');" title="seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                    }
                    return option;
                }
            },
        ]
    });
}

function pe_by_zone(zone_id, eq_type, element_id) {
    $.fn.dataTable.ext.errMode = 'throw';
    $('#pe_pei_table').DataTable({
        stateSave: true,
        "bDestroy": true,
        "ajax": getBaseURL()+'listar/pe/zona/'+zone_id+'/'+eq_type,
        "columns": [
            { data: 'acronimo' },
            { data: 'ip' },
            { data: 'status' },
            { data: 'commentary' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var option = '';
                    if (full.status == 'ALTA') {
                        option = '<a onclick="select_eq_modal('+full.id+',\''+full.acronimo+'\',\''+element_id+'\');" title="Seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>';
                    }
                    return option;
                }
            },
        ]
    });
}

function frontier_by_assoc(serv_type, serv_bw, ring_id, agg_id, multihome) {
    const body = $('#frontier_list_body');
    body.find('tr').remove();
    $.ajax({
        type: "get",
        url: getBaseURL() + `frontera/buscar/${serv_type}/${serv_bw}/${ring_id}/${agg_id}/${JSON.stringify(multihome)}`,
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
                    toastr.error(data['datos']);
                    break;
                case "yes":
                    $.each(data['datos'], function(i) {
                        body.append(`
                            <tr>
                                <td>${data['datos'][i].name_frt}</td>
                                <td>${data['datos'][i].bw_limit}</td>
                                <td>${data['datos'][i].bw_occu}</td>
                                <td><a onclick='set_frt(${JSON.stringify(data['datos'][i])},${serv_type},${multihome});' title="Seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>
                            </tr>
                        `);
                    });
                    break;
            }
        },
        error: function() {
            toastr.error("Error con el servidor");
        }
    });
}

function vlan_by_frontier(vlan_type, equip_id, frt_id, serv_type, multihome) {
    const body = $('#vlan_list_body');
    body.find('tr').remove();
    $.ajax({
        type: "GET",
        url: getBaseURL() + `vlan/obtener/${vlan_type}/${equip_id}/${frt_id}`,
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
                    if (typeof data['datos'][0] === 'object') {
                        $.each(data['datos'], function(i) {
                            body.append(`
                                <tr>
                                    <td>${data['datos'][i].vlan}</td>
                                    <td><a onclick='set_vlan(${JSON.stringify(data['datos'][i])},${serv_type},${multihome});' title="Seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>
                                </tr>
                            `);
                        });
                    } else {
                        $.each(data['datos'], function(i) {
                            body.append(`
                                <tr>
                                    <td>${data['datos'][i]}</td>
                                    <td><a onclick='set_vlan(${JSON.stringify(data['datos'][i])},${serv_type},${multihome});' title="Seleccionar"><i class="fa fa-dot-circle-o"></i></a></td>
                                </tr>
                            `);
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

function ip_by_service_type($id_service_type, $id) {
    buscar_ip_wan
}

function ip_by_subnet(subnet_ip, subnet_prefix, branch_id, target_form) {
    var row = '';
    const table = $("#ip_lanswitch_table");
    table.empty();
    $.ajax({
        type: "get",
        url: getBaseURL() + `ip/obtener/${subnet_ip}/${parseInt(subnet_prefix)}/${parseInt(branch_id)}`,
        dataType: 'json',
        cache: false,
        success: function(data) {
            $(data).each(function (i, v) {
                row = `<tr>
                    <td>${data[i].ip}/${data[i].prefixes}</td>
                    <td>${data[i].acronimo}</td>
                    <td></td>`;
                if (data[i].type == 'DISPONIBLE' && data[i].id_status == 1) row += `<td><a> <i class="fa fa-bullseye" onclick='set_ip(${JSON.stringify(data[i])},${target_form})' title="Seleccionar IP"> </i></a></td>`;
                else row += '<td><a title="IP no disponible"> <i class="fa fa-warning" style="color: coral;"> </i></a></td>';
                row += `</tr>`;
                table.append(row);
            });
        },
        error: (response) => ajaxErrorHandler(response)
    });
}

//-------------------listado de asociaciones de agregador--------------------------
$(document).ready(function(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#agg_assoc_table').DataTable({
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
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
            },
            {
                extend: 'csv', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar en csv',
                className: 'btn btn-warning',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
            },
            {
                extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o">', titleAttr: 'Exportar a Excel',
                className: 'btn btn-primary',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
            },
            {
                extend: 'pdfHtml5', text: '<i class="fa fa-file-pdf-o">', titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
            },
            {
                extend: 'print', text: '<i class="fa fa-print">', titleAttr: 'Imprimir',
                className: 'btn btn-success buttons-html5',
                exportOptions: {columns: [ 0, 1, 2, 3, 4 , 5, 6, 7, 8, 9, 10]},
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            },
        ],
        "ajax": getBaseURL() +'listar/asociacion/agg',
        "columns": [
            { data: 'agg' },
            { data: 'ip' },
            { data: 'home_zone' },
            { data: 'pe_home' },
            { data: 'pei_home' },
            { data: 'multihome_zone' },
            { data: 'pe_multihome' },
            { data: 'pei_multihome' },
            { data: 'status' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var opcion = '';
                    if (full.status == 'ALTA') {
                        opcion += `<a onclick="enable_disable_agg(${full.agg_id},'${full.status}')" title="Deshabilitar AGG"> <i class="fa fa-toggle-off"></i> </a>`;
                    } else if (full.status == 'DESHABILITADO') {
                        opcion += `<a onclick="enable_disable_agg(${full.agg_id},'${full.status}')" title="Habilitar AGG"> <i class="fa fa-toggle-on"></i> </a>`;
                    }
                    return opcion;
                }
            },
        ]
    });
});

function service_table_select_2(){
    $.fn.dataTable.ext.errMode = 'throw';
    $('#list_all_servicio').DataTable({
        deferRender: true,
        "autoWidth": true,
        "paging": true,
        stateSave: true,
        destroy: true,
        "processing": true,
        "ajax": getBaseURL() +'todos/servicio/selecion',
        "columns": [
            { data: 'number' },
            { data: 'name' },
            { data: 'order_high' },
            { data: 'bw_service' },
            { data: 'business_name' },
            { data: 'status' },
            {
                sortable: false,
                "render": function ( data, type, full, meta ) {
                    var id = full.id;
                    var status = full.status;
                    var type = full.type_id;
                    if (status == 'ALTA') {
                        return `<a title="Seleccionar" onclick="selec_service_2(${id},'${type}');"> <i class="fa fa-bullseye"> </i></a>`;
                    }else{
                        return '<a> <i class="fa fa-warning" title=" No Seleccionar"> </i></a>';
                    }
                }
            },
        ]
    });
}
