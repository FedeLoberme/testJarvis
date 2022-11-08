<div class="modal inmodal fade" id="popcrear_anillo_editar" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-circle-o-notch modal-icon"></i>
                <h4 class="modal-title"> MODIFICAR ANILLO</h4>
            </div>
            <form role="form" method="POST" id="anillo_edi">
                <div class="modal-body">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Nodo*</label> 
                            <input type="text" disabled="true" autocomplete="off"  id="nodo_motrar"  class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Agregador*</label>
                           <input type="text" disabled="true" autocomplete="off"  id="agg_motrar"  class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <div class="form-group">
                        <label>Nombre de anillo*</label>
                        <div class="bw_all" id="bw_all" >
                            <input style="width:53px;" disabled="true" type="text" class="form-control" value="ME-">
                            <select class="form-control" id="acro_selec_edi" name="acro_selec_edi" onchange="acronimo_anillo_alta();">
                                <option selected disabled value="">seleccionar</option>
                                         
                            </select>
                            <input type="text" style="width:60px;" placeholder="0000" maxlength="4" autocomplete="off" name="num_acro_edi" id="num_acro_edi"  class="form-control" value="{{old('num_acro')}}">
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label>Pre-view</label>
                            <input type="text" placeholder="00000000000" disabled="true" autocomplete="off" name="acro_anillo_edi" id="acro_anillo_edi"  class="form-control" value="{{old('acro_anillo')}}">
                            <p class="mensajeInput" id="acro_anillo_msj_edic"></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Dedicado*</label>
                            <select class="form-control" id="dedica_edi" name="dedica_edi">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($confi as $key => $con)
                                    @if (old('dedica_edi') == $key)
                                        <option value="{{ $key }}" selected>{{ $con }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $con }}</option>
                                    @endif
                                @endforeach    
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label>Tipo de anillo*</label>
                        <select class="form-control" id="type_edi" name="type_edi">
                            <option selected disabled value="">seleccionar</option>
                            <option value="Bifilar">Bifilar</option>
                            <option value="Unifilar">Unifilar</option>
                                     
                        </select>
                        </div>
                    </div>
                    <div class="form-group" id="max2">
                            <label>BW max</label>
                            <div class="bw_all" id="bw_all" >
                                <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max_edi" id="n_max_edi" class="form-control" value="{{old('n_max_edi')}}">
                                <select class="form-control" id="max_edi" name="max_edi">
                                    @foreach($bw as $key => $licen)
                                        @if (old('licen') == $key)
                                            <option value="{{ $key }}" selected>{{ $licen }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $licen }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <div class="form-group">
                        <label>Puertos* </label> 
                        <!-- <a id="port_mas" data-toggle="modal" data-target="#new_placa_anillo_alta"><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar y/o Quitar Puerto</a> -->
                        <div id="campos_port_edi">
                                    
                        </div>
                    </div>
                   
                    <div class="form-group" id="descri2">
                        <label>Comentarios</label> 
                        <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" id="commen_edi" maxlength="100" name="commen_edi"class="form-control">
                    </div>             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="edi_port_anillo_selec();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
