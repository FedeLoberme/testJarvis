<div class="modal inmodal fade" id="estado_ip_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_estado_ip_pop" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-map-marker modal-icon"></i>
            <h4 class="modal-title">CAMBIAR ESTADO</h4>
        </div>
        <form role="form" method="POST" id="estado_new">
            <div class="modal-body">
                <div class="form-group">
                    <label>Estado*</label>
                    <select class="form-control" id="status_ip_individual" name="status_ip_individual">
                        <option selected disabled value="">seleccionar</option>
                        @foreach($status as $status)
                            @if( $status->id != 2)
                                @if (old('status_ip_individual') == $status->id)
                                    <option value="{{ $status->id }}" selected>{{ $status->name }}</option>
                                @else
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endif
                            @endif
                        @endforeach
                    </select>
                </div>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="estado_cerra"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" type="button" id="estado_seguir"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
