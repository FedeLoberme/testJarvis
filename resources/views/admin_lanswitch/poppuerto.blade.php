<div class="modal inmodal fade" id="new_placa_lans_alta" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_puerto_all" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-circle-o-notch modal-icon"></i>
                <h4 class="modal-title">SELECCIONES PUERTOS</h4> 
            </div>
            <input type="hidden" name="count_port" id="count_port">
            <div class="modal-body" >
                <div class="form-group">
                    <label id="title_equi_1"></label><br>
                    <label id="title_por_1"></label>
                        <select class="form-control" id="por1" name="por1">
                        <option selected disabled value="">seleccionar</option>     
                    </select>
                </div>
                <div class="form-group" id="table_por_2">
                    <label id="title_equi_2"></label><br>
                    <label id="title_por_2"></label>
                        <select class="form-control" id="por2" name="por2">
                        <option selected disabled value="">seleccionar</option>     
                    </select>
                 </div>
            </div>   
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" >
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button onclick="port_lanswitch_all();" class="btn btn-primary" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>   
            </div>
        </div>
    </div>
</div>
