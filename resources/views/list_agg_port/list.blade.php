<div class="modal inmodal fade" id="list_agg_port" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="close_list_agg_port" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-share-alt modal-icon"></i>
                <h4 class="modal-title">PUERTOS <span id="port_agg_list_type"><b> </b></span></h4>
            </div>
            @csrf
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis" id="list_port_agg">
                        <thead>
                            <tr>
                                <th>Acrónimo Agg</th>
                                <th>Estado</th>
                                <th>Anillos Vacantes</th>
                                <th>Anillos Utilizados</th>
                                <th>Puertos Vacantes</th>
                                <th>% Ocupacion anillos</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

