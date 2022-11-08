// Arma listado de equipos Lanswitch una vez cargada la vista
$(document).ready(function () {
    var permi = document.getElementById("permi");
    var functi = document.getElementById("functi");
    var str = (permi != null) ? permi.value : 0;
    var fun = (functi != null) ? functi.value : 0;

    if (str >= 3 && fun != 'RADIO_ENLACE') {
        var url = getBaseURL() +'listar/equipo/'+fun;
        $.fn.dataTable.ext.errMode = 'throw';
        $('#lanswitch_list').DataTable({
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
                        var opcion = '';
                        if (str >= 5 && status == 'ALTA'){
                            if (type == 'Ipran Celda') {
                                opcion += '<a data-toggle="modal" data-target="#crear_lsw_pop" title="Editar Equipo" onclick="update_search_lsw('+id+');"> <i class="fa fa-edit"> </i></a>';
                                opcion += '<a data-toggle="modal" data-target="#puerto_lsw_new_link" title="Puerto de link" onclick="search_lsw_port_link('+id+')"> <i class="fa fa-unlink"> </i></a>';
                            } else {
                                opcion += '<a data-toggle="modal" data-target="#crear_lanswitch_pop" title="Editar Equipo" onclick="search_lanswitch('+id+');"> <i class="fa fa-edit"> </i></a>';
                                opcion += '<a data-toggle="modal" data-target="#puerto_lsw_anillo" title="Puerto de anillo" onclick="search_lanswitch_port_ring('+id+');"> <i class="fa fa-circle-o-notch"></i></a>';
                            }
                        }
                        opcion +='<a data-toggle="modal" data-target="#inf_equip_agg" title="Detalle Placas Asignadas" onclick="inf_equip_agg('+id+');"> <i class="fa fa-info-circle"> </i> </a>';
                        if (str >= 5 && status == 'ALTA') {
                            opcion +=`<a data-toggle="modal" data-target="#popasignar_recurso" onclick="equip_service_assignment(${id},'${name}')" title="Asignar servicio"> <i class="fa fa-exchange"></i></a>`+
                                '<a data-toggle="modal" data-target="#pop_servi_equipo" onclick="service_equipmen('+id+');" title="Ver servicio"> <i class="fa fa-desktop"></i></a>'+
                                '<a data-toggle="modal" data-target="#pop_baja_equipo" onclick="down_equipmen_id('+id+');" title="Baja del equipo"> <i class="fa fa-window-close"> </i></a>';
                        }
                        opcion +='<a data-toggle="modal" data-target="#img_equip" title="Imagen del Equipo" onclick="img_equip('+img+');"> <i class="far fa-image"> </i></a>'+
                            '<a data-toggle="modal" data-target="#inf_equip_port" title="Detalle Puerto" onclick="inf_equip_port('+id+');"> <i class="fa fa-keyboard-o"> </i> </a>';
                        if (str >= 5 && status == 'ALTA') {
                            opcion +='<a data-toggle="modal" data-target="#inf_equip_placa" title="Agregar y/o Quitar placa" onclick="buscar_placa('+id+');"> <i class="fa fa-tasks"> </i> </a>';
                        }
                        if (str >= 10 && status == 'ALTA') {
                            opcion += '<a title="Cambiar Modelo" href="'+getBaseURL()+'migrar/modelo/puertos/'+id+'"> <i class="fa fa-codepen"> </i> </a>';
                        }
                        opcion += '<a title="Excel" href="'+getBaseURL()+'ver/importar/anillo/'+name+'" target="_blank"> <i class="fa fa-clipboard"> </i> </a>'
                        return opcion;
                    }
                },
            ]
        });
    }
});
