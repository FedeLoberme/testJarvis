<div class="modal inmodal fade" id="pop_funtion" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                    <h6 class="modal-title">FUNCIONES</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="edic_funtion"  action="{{ url('prueba/ver') }}">
                    {{ csrf_field() }}
                    <input id="id_equipm" type="hidden" name="id_equipm">
                    <input id="function_old" type="hidden" name="function_old">
                        <div class="form-group">
                            <div class="form-group" id="funtion2">
                            <label>Funtion</label>
                            <select class="form-control" multiple="multiple" id="funtions" name="funtions[]" onclick="multi();">
                                @foreach($function as $func)
                                        <option value="{{ $func->id }}">{{ $func->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn " data-dismiss="modal" id="exit_pop">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" type="submit">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
                </form>                
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>