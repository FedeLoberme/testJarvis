<div class="modal inmodal fade" id="new_localización_alta" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_local" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class=" modal-icon"></i>
                <h4 class="modal-title">SELECCIÓN DE LOCALIZACIÓN</h4> 
            </div>
            <div class="modal-body" >
                <div class="form-group">
                    <label> N° de Elemento</label>
                        <select class="form-control" id="elemen_local" name="elemen_local">
                        <option selected disabled value="">seleccionar</option>     
                        <option value="1">1</option>     
                        <option value="2">2</option>     
                        <option value="3">3</option>     
                        <option value="4">4</option>     
                        <option value="5">5</option>     
                        <option value="6">6</option>     
                        <option value="7">7</option>     
                    </select>
                </div>
                <!-- <div class="form-group">
                    <a style="width: 100%;" class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(14);" title="Agregar localización"> <i class="fa fa-plus"> </i> Nueva localización</a> 
                 </div> -->
                <div id="elemento_localizacion">
                
                </div>
            </div>   
            <div class="modal-footer">
                <button type="button" class="btn" id="localtion_exit" data-dismiss="modal" >
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" id="localtion_success" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>   
            </div>
        </div>
    </div>
</div>
