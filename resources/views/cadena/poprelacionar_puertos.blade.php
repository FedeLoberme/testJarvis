<div class="modal inmodal fade" id="relacionar_puertos_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="relacionar_puertos_cerrar_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">PUERTOS RELACIONADOS</h4>
                <h5 class="modal-title" id="cadena_name_h4"></h5>
            </div>
            <br>
            <center>
            <div id="button_relate_ports">
                
            </div>
            </center>
            <br>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover dataTables-example" id="list_ports_related">
                    {{-- <input type="hidden" name="chain_id" id="chain_id"> --}}
                    <thead>
                        <tr>
                            <th>Agregador A</th>
                            <th>Puerto A</th>
                            <th>Comentario A</th>
                            <th>Agregador B</th>
                            <th>Puerto B</th>
                            <th>Comentario B</th>
                            <th>Opción</th>
                        </tr>
                    </thead>
                    <tbody id="list_ports_relate">
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>