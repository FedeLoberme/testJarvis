<div class="modal inmodal fade overflow-modal" id="cancelar_sevi" role="dialog"  aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-sm">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button"  id="cerra_recurso_servi_can" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">CANCELAR SERVICIO</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_ser_can" id="id_ser_can">
                <div class="form-group">
                    <label>Motivo*</label>
                    <div class="bw_all" id="bw_all" >
                        <select class="form-control" id="mot_can" name="mot_can">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($down as $do)
                                @if (old('mot_can') == $do->id)
                                    <option value="{{ $do->id }}" selected>{{$do->name}}</option>
                                @else
                                    <option value="{{ $do->id }}">{{$do->name}}</option>
                                @endif
                            @endforeach 
                        </select>
                        <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(13);" title="Agregar Motivo"> <i class="fa fa-plus"> </i></a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="cancelar_sevi_cerrar"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                <button class="btn btn-primary" type="button" id="cancelar_sevi_aceptar"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </div>
    </div>
</div>
