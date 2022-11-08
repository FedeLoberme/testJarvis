<div class="modal inmodal fade" id="list_equip_agg_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_equip_agg_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-database modal-icon"></i>
                <h4 class="modal-title"> LISTA DE EQUIPO</h4> 
            </div>
            <div class="col-sm-12">
                {{-- <center>
                    <a class="btn btn-success" data-toggle="modal" data-target="#crear_asignar_agg_pop" onclick="new_agg_chain();">
                        <i class="fa fa-pencil"></i> Asociar AGG
                    </a>
                    <a class="btn btn-success" data-toggle="modal" data-target="#relacionar_puertos_pop" onclick="relate_ports_agg();">
                        <i class="fa fa-pencil"></i> Relacionar puertos del equipo
                    </a>
                </center> --}}
                <table class="table table-striped table-bordered table-hover dataTables-example">
                    <input type="hidden" name="chain_id" id="chain_id">
                    <thead>
                        <tr>
                            <th>Agregador</th>
                            <th>Puerto</th>
                            <th>Nodo CID</th>
                            <th>IP Gestión</th>
                            <th>Opción</th>
                        </tr>
                    </thead>
                    <tbody id="list_agg_chain">
                            
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div> 
        </div>
    </div>
</div>