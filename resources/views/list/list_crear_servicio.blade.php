<div class="modal inmodal fade" id="lis_crear_servi" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="exit_pop_cerra_tipo_servi" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title" id="title_type_ser"></h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_lis_servi">
                    <input type="hidden" id="id_type_ser" name="id_type_ser" >
                    <div class="form-group">
                        <label>Nombre*</label> 
                        <input style="text-transform: uppercase;" type="text" placeholder="Nombre" autocomplete="off" id="lis_name" name="lis_name"class="form-control" value="{{old('lis_name')}}" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>IP*</label> 
                        <select class="form-control" id="servi_ip" name="servi_ip">
                            <option selected disabled value="">seleccionar</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Rango IP*</label> 
                        <select class="form-control" id="servi_rango_ip" name="servi_rango_ip">
                            <option selected disabled value="">seleccionar</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Ancho de Banda*</label> 
                        <select class="form-control" id="servi_bw" name="servi_bw">
                            <option selected disabled value="">seleccionar</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Relación*</label> 
                        <select class="form-control" id="servi_rela" name="servi_rela">
                            <option selected disabled value="">seleccionar</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" onclick="new_list_servi();" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
            </div>
        </div>
    </div>
</div>