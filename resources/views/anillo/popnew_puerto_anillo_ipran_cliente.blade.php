<div class="modal inmodal fade" id="puerto_anillo_ipran_cliente" role="dialog" data-backdrop="static" style="overflow-y: auto;" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="ExitRingIpranPort"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Asignar puerto</h4> 
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Posición</th>
                                <th>Tipo puerto</th>
                                <th style="width: 50px">Seleccinar</th>
                            </tr>
                        </thead>
                        <tbody id="new_port_ring_ipran_clien">
                            
                        </tbody>
                        </table>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="CheckboxPortRing();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </div>  
        </div>
    </div>
</div>
