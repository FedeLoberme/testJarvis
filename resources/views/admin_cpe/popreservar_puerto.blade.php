<div class="modal inmodal fade" id="popreser_port" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_reser_port" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">RESERVAR PUERTO</h6>
            </div>
            <div class="modal-body">
                <form id ="reser_port">
                    <div class="form-group">
                        <label> Motivo*</label>
                        <select class="form-control" id="mot_reser" name="mot_reser">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($status_port as $status)
                                <option value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comentario</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commen_reser" name="commen_reser"class="form-control" value="{{old('commen_reser')}}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " id="cance_reser">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" id="acep_reser" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Aceptar</strong>
                </button>
            </div>
        </div>
    </div>
</div>