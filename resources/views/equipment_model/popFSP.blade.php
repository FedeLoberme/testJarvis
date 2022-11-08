<div class="modal inmodal fade" id="fsp_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="cerrar_fsp_register" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h6 class="modal-title">FORMATO PUERTO</h6>
            </div>
            <div class="modal-body">
                <form method="POST" id ="new_fsp">
                    <input id="id_equip" type="hidden">
                    <input id="id_port" type="hidden">
                    <input id="id_relation" type="hidden">
                        <div class="form-group">
                            <label>Cantidad de elemento</label>
                            <select class="form-control" id="elemento" name="elemento" onchange="labelSelected();">
                                @foreach($equipment['elemento'] as $key => $elemento)
                                    @if (old('elemento') == $key)
                                        <option value="{{ $key }}" selected>{{ $elemento }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $elemento }}</option>
                                    @endif
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <div id="elemen0" style="display: none;">
                            <label>Separador</label>
                            <select class="form-control" onchange="labelSeparador();" id="separador" name="separador">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equipment['separador'] as $key => $separador)
                                    @if (old('separador') == $key)
                                        <option value="{{ $key }}" selected>{{ $separador }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $separador }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="elemen1" style="display: none;">
                        <label>Etiqueta</label> 
                        <div class="bw_all" id="bw_all" >
                            <input type="text" placeholder="Label" class="form-control" id="eleme1" name="eleme1" maxlength="10" style="text-transform: capitalize;">
                            <input type="text" placeholder="Minimo" autocomplete="off" id="afsp1" name="afsp1" onkeypress="return esNumero(event);" class="form-control" value="{{old('afsp1')}}" maxlength="3">

                            <input type="text" onkeypress="return esNumero(event);" placeholder="Maximo" autocomplete="off" id="afsp2" name="afsp2"class="form-control" value="{{old('afsp2')}}" maxlength="3">
                        </div>
                        </div>

                        <div id="elemen2" style="display: none;">
                        <div class="bw_all" id="bw_all" >
                            <input type="text" placeholder="Label" class="form-control" id="eleme2" name="eleme2" maxlength="10" style="text-transform: capitalize;">
                            <input type="text" onkeypress="return esNumero(event);" placeholder="Minimo" autocomplete="off" id="bfsp1" name="bfsp1"class="form-control" value="{{old('bfsp1')}}" maxlength="3">

                            <input type="text" onkeypress="return esNumero(event);" placeholder="Maximo" autocomplete="off" id="bfsp2" name="bfsp2"class="form-control" value="{{old('bfsp2')}}" maxlength="3">
                        </div>
                        </div>

                        <div id="elemen3" style="display: none;">
                        <div class="bw_all" id="bw_all">
                             <input type="text" placeholder="Label" class="form-control" id="eleme3" name="eleme3" maxlength="10" style="text-transform: capitalize;">
                            <input type="text" onkeypress="return esNumero(event);" placeholder="Minimo" autocomplete="off" id="cfsp1" name="cfsp1"class="form-control" value="{{old('cfsp1')}}" maxlength="3">

                            <input type="text" onkeypress="return esNumero(event);" placeholder="Maximo" autocomplete="off" id="cfsp2" name="cfsp2"class="form-control" value="{{old('cfsp2')}}" maxlength="3">
                        </div>
                        </div>

                        <div id="elemen4" style="display: none;">
                        <div class="bw_all" id="bw_all" >
                            <input type="text" placeholder="Label" class="form-control" id="eleme4" name="eleme4" maxlength="10" style="text-transform: capitalize;">
                            <input type="text" onkeypress="return esNumero(event);" placeholder="Minimo" autocomplete="off" id="dfsp1" name="dfsp1"class="form-control" value="{{old('dfsp1')}}" maxlength="3">

                            <input type="text" onkeypress="return esNumero(event);" placeholder="Maximo" autocomplete="off" id="dfsp2" name="dfsp2"class="form-control" value="{{old('dfsp2')}}" maxlength="3">
                        </div>
                        </div>
                    </div>
                </form>
                <CENTER>
                    <h3 id="pre_v"></h3>
                </CENTER>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal" id="exit_pop">
                    <i class="fa fa-times-rectangle-o"></i>
                    <strong>  Cancelar</strong>
                </button>
                <button class="btn btn-primary" onclick="label_fsp();" type="button">
                    <i class="fa fa-floppy-o"></i>
                    <strong>  Guardar</strong>
                </button>
            </div>
        </div>
    </div>
</div>