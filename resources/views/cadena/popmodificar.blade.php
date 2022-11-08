<div class="modal inmodal fade" id="edic_cadena_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="edic_cerra_cadena_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">MODIFICAR CADENA AGG</h4> 
            </div>
            <form role="form" method="POST" id="edic_alta_cadena">
                {{ csrf_field() }}
                <input type="hidden" name="edic_id_chain" id="edic_id_chain">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nombre*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="edic_name_chain" name="edic_name_chain"class="form-control" value="{{old('edic_name_chain')}}" maxlength="50">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>extremo 1*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="edic_extrem_1" name="edic_extrem_1"class="form-control" value="{{old('edic_extrem_1')}}" maxlength="100">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>extremo 2*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="edic_extrem_2" name="edic_extrem_2"class="form-control" value="{{old('edic_extrem_2')}}" maxlength="100">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>BW</label>
                        <div class="bw_all" id="bw_all" >
                            <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="edic_BW_chain" id="edic_BW_chain" class="form-control" value="{{old('edic_BW_chain')}}">
                            <select class="form-control" id="edic_max_chain" name="edic_max_chain">
                                @foreach($equipment['bw'] as $key => $licen)
                                    @if (old('licen') == $key)
                                            <option value="{{ $key }}" selected>{{ $licen }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $licen }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                     <div class="form-group">
                        <label>Comentario</label> 
                        <input type="text" placeholder="Comentario" maxlength="100" autocomplete="off" id="edic_commentary_chain" name="edic_commentary_chain"class="form-control" value="{{old('edic_commentary_chain')}}">
                    </div>
                </div>          
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="edic_baja_chain" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="edic_alta_chain" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>