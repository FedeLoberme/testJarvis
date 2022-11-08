<div class="modal inmodal fade overflow-modal" id="recur_sevi_ip_pop" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="exit_ip_recu_sevi"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title" id="title_port_ip_servi">LISTA DE IP DEL SERVICIO</h4>
            </div>
            <div class="modal-body">
                <center>
                    <a class="btn btn-success" data-toggle="modal" data-target="#ip_new_ser_recu_rank" onclick="ip_rank_new_ser_recur();"><i class="fa fa-pencil"></i>
                        Agregar Rango Público
                    </a>
                </center><br>
                <table class="table table-striped table-bordered table-hover dataTables-example">

                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>SubRed</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="ip_recurso_sevicio">

                    </tbody>
                </table>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
</div>