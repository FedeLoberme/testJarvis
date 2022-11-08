<div class="modal inmodal fade" id="popstock_ip" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="cerra_stock_ip_pop" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title" id="title_stock_ip"></h4>
            </div>
            <form role="form" method="POST" id="new_stock_ip_all">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Estado*</label>
                        <select class="form-control" id="status_stock" name="status_stock">
                            <option selected disabled value="">seleccionar</option>    
                            <option value="VACANTE">Vacante</option>   
                            <option value="RESERVEDO">Reservado</option>    
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>IP*</label> 
                        <input class="form-control" onkeypress="return val_ip(event);" type="text" placeholder="000.000.000.000" maxlength="15" autocomplete="off" id="ip_stock" name="ip_stock">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Uso</label> 
                        <input class="form-control" type="text" placeholder="uso" maxlength="50" autocomplete="off" id="use_ip_stock" name="use_ip_stock">
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="stock_ip_cerra"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" type="button" id="stock_ip_seguir"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </div>
    </div>

</div>
