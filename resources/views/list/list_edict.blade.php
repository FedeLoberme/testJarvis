<div class="modal inmodal fade" id="lis_edict" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="exit_pop_cerra" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">MODIFICACIÓN {{$name}}</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_lis_edict">
                    <div class="form-group" id="modelo2">
                        <label>Nombre*</label> 
                        <input type="hidden" id="list_id" name="list_id" >
                        <input style="text-transform: uppercase;" type="text" placeholder="Nombre" autocomplete="off" id="name_lis" name="name_lis"class="form-control" value="{{old('name_lis')}}" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" onclick="new_list_index(<?=$lis?>);" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
            </div>
        </div>
    </div>
</div>