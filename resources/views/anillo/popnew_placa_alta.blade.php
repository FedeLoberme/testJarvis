<div class="modal inmodal fade" id="new_placa_anillo_alta" role="dialog" data-backdrop="static" style="overflow-y: auto;" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="exit_alta_port"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title">Asignar puerto</h4> 
            </div>
            <div class="modal-body">
                <input  type="hidden" id="equi_id" name="equi_id">
                <center>
                    <div class="form-group">
                        <label>Bandwitdh max*</label> 
                        <select class="form-control" onchange="bw_anillo();" id="bw_max" name="bw_max" style="width: 200px;">
                            <option selected disabled value="">seleccionar</option>
                            <option value="1048576">1 Gbps</option>
                            <option value="10485760">10 Gbps</option>
                        </select>
                    </div>
                </center>
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>Posición</th>
                                <th>Tipo puerto</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                                <th style="width: 50px">Seleccinar</th>
                            </tr>
                        </thead>
                        <tbody id="jarvis_new_por_alta_anillo">
                            
                        </tbody>
                        </table>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="port_anillo_selec_pantalla();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </div>  
        </div>
    </div>
</div>
