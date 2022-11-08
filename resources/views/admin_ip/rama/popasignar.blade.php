<div class="modal inmodal fade" id="asignar_ip_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_asignar_ip_pop" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-map-marker modal-icon"></i>
            <h4 class="modal-title">ASIGNAR IP</h4>
        </div>
        <form role="form" method="POST" id="clip_new">
            <div class="modal-body">
                <div class="form-group">
                    <label>Atributo*</label>
                    <select class="form-control" id="type_reser" onchange="search_attribute();" name="type_reser">
                        <option selected disabled value="">seleccionar</option>
                        <option value="1">Equipo</option>
                        <option value="2">Cliente</option>
                        <option value="3">Servicio</option>
                        <option value="4">Otro</option>
                    </select>
                </div>    
                <div class="form-group" id="input_atributo">
                
                </div>           
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="asignar_cerra"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" type="button" id="asignar_seguir"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
