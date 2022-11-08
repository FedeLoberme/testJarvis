<div class="modal inmodal fade" id="lis_acronimo_agg" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                    <h6 class="modal-title" id="msj_list_agg"></h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_acron">
                    <div class="form-group">
                            <label>Acrónimo*</label> 
                            <input type="hidden" id="id_agg_edic" name="id_agg_edic" >
                            <input type="hidden" id="id_agg_acro" name="id_agg_acro" >
                            <input type="hidden" id="id_rela" name="id_rela" >
                            <input style="text-transform: uppercase;" type="text" placeholder="Acrónimo" autocomplete="off" id="acroni_agg" name="acroni_agg"class="form-control" value="{{old('acroni_agg')}}" maxlength="50">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="acro_pop_cer">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" onclick="new_acron_agg();" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
            </div>
        </div>
    </div>
</div>