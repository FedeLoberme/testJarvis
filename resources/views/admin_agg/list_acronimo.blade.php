<div class="modal inmodal fade" id="lista_acronimo_agg" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h6 class="modal-title">LISTA DE ACRÓNIMO</h6>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <center>
                        <a class="btn btn-success" data-toggle="modal" data-target="#lis_acronimo_agg" onclick="agg_crear_acronimo();"><i class="fa fa-pencil"></i> 
                                Nuevo Acrónimo
                            </a>
                    </center>
                    <input type="hidden" name="id_agg_pop" id="id_agg_pop">

                   <br>
                <thead>
                    <tr>
                        <th>Acrónimo</th>
                        <th>Opción</th>
                    </tr>
                </thead>
                <tbody id="lis_acro_agg">
                                        
                </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>