<div class="modal inmodal fade" id="inf_equip_placa" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_bus_equipo_placa" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title"> AGREGAR Y/O QUITAR PLACA</h4> 
                <h5 class="modal-title" id="title_board"> </h5> 
                <a class="btn btn-success" data-toggle="modal" data-target="#inf_equip_placa_nueva" title="Agregar Placa"><i class="fa fa-plus"></i> 
                    Agregar
                </a>
            </div>
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis">
                        <thead>
                            <tr>
                                <th>F/S/P</th>
                                <th>Modelo</th>
                                <th>Placa</th>
                                <th>N° Pto</th>
                                <th>P.F/I</th>
                                <th>P.F/F</th>
                                <th>Tipo</th>
                                <th>Conector</th>
                                <th>BW</th>
                                <th>Label</th>
                                <th>P.L/I</th>
                                <th>P.L/F</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="list_all_equipmen_board">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"> 
                </div>
        </div>
    </div>
</div>
