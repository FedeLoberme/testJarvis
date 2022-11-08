<div class="modal inmodal fade" id="popcrear_port" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-tasks modal-icon"></i>
                <h4 class="modal-title" id="title_placa" ></h4> 
            </div>
                <form role="form" method="POST" id="placa_new">
                    <div class="col-sm-6 ">
                            <div class="form-group">
                                <label>Placa modelo</label>
                                <div class="bw_all" id="bw_all" > 
                                <select class="form-control" id="m_placa" name="m_placa">
                                    <option selected disabled value="">seleccionar</option>
                                    @foreach($selection['module_board'] as $m_placa)
                                        @if (old('m_placa') == $m_placa->id)
                                            <option value="{{ $m_placa->id }}" selected>{{ $m_placa->name }}</option>
                                        @else
                                            <option value="{{ $m_placa->id }}">{{ $m_placa->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <a id="placa_boton" class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(6);" title="Agregar Modelo de Placa"> <i class="fa fa-plus"> </i></a>
                            </div>
                            </div>
                            <div class="form-group">
                                <label>Tipo placa</label>
                                <select class="form-control" onchange="selec_edict_por();" id="type_placa" name="type_placa">
                                    <option selected disabled value="">seleccionar</option>
                                    @foreach($equipment['type_placa'] as $key => $type_placa)
                                        @if (old('type_placa') == $key)
                                            <option value="{{ $key }}" selected>{{ $type_placa }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $type_placa }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cantidad puerto</label> 
                                <input type="text" onkeypress="return esNumero(event);" placeholder="0" id="canti" name="canti"class="form-control" value="{{old('canti')}}">
                            </div>
                            <div class="form-group">
                                <label>Puerto fisico inicio</label> 
                                <input type="text" onkeypress="return esNumero(event);" name="pfi" id="pfi" class="form-control" value="{{old('pfi')}}">
                            </div>
                            <div class="form-group">
                                <label>Puerto fisico fin</label> 
                                <input  type="text" onkeypress="return esNumero(event);" autocomplete="off" name="pff" id="pff" class="form-control" value="{{old('pff')}}">
                            </div>
                            <div class="form-group">
                                <label>Tipo puerto</label>
                            <div class="bw_all" id="bw_all" >  
                                <select class="form-control" id="type_port" name="type_port">
                                    <option selected disabled value="">seleccionar</option>
                                    @foreach($selection['list_port'] as $type_port)
                                        @if (old('type_port') == $type_port->id)
                                            <option value="{{ $type_port->id }}" selected>{{ $type_port->name }}</option>
                                        @else
                                            <option value="{{ $type_port->id }}">{{ $type_port->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(7);" title="Agregar Tipo de Puerto"> <i class="fa fa-plus"> </i></a>
                            </div>
                            </div>               
                        
                    </div>
                    <div class="col-sm-6 ">
                        
                            <div class="form-group">
                                <label>Conector</label>
                            <div class="bw_all" id="bw_all" >  
                                <select class="form-control" id="conector" name="conector">
                                    <option selected disabled value="">seleccionar</option>
                                    @foreach($selection['connector'] as $conector)
                                        @if (old('conector') == $conector->id)
                                            <option value="{{ $conector->id }}" selected>{{ $conector->name }}</option>
                                        @else
                                            <option value="{{ $conector->id }}">{{ $conector->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(8);" title="Agregar Conector"> <i class="fa fa-plus"> </i></a>
                            </div>
                            </div>
                            <div class="form-group">
                                    <label>Bandwitdh max</label>
                                    <div class="bw_all" id="bw_all" >
                                        <input type="text" onkeypress="return number_decimal(event, this);" placeholder="0" name="n_max" id="n_max" class="form-control" value="{{old('n_max')}}">
                                        <select class="form-control" id="max" name="max">
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
                            <div class="form-group">
                                <label>Label</label>
                                <div class="bw_all" id="bw_all" >  
                                    <select class="form-control" id="label" name="label">
                                        <option selected disabled value="">seleccionar</option>
                                        @foreach($selection['label'] as $label)
                                            @if (old('label') == $label->id)
                                                <option value="{{ $label->id }}" selected>{{ $label->name }}</option>
                                            @else
                                                <option value="{{ $label->id }}">{{ $label->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(9);" title="Agregar Label"> <i class="fa fa-plus"> </i></a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Puerto lógico inicial</label> 
                                <input type="text" id="pli" onkeypress="return esNumero(event);" name="pli" class="form-control" value="{{old('pli')}}">
                            </div>
                            <input type="hidden" id="id_por" name="id_por">
                            <div class="form-group">
                                <label>Puerto lógico final</label> 
                                <input type="text" id="plf" onkeypress="return esNumero(event);" name="plf" class="form-control" value="{{old('plf')}}">
                            </div> 
                            <div class="form-group">
                                <label>Código SAP</label> 
                                <input onkeypress="return esNumero(event);" type="text" placeholder="Código sap" maxlength="30" autocomplete="off" name="cod_sap" id="cod_sap" class="form-control" value="{{old('cod_sap')}}">
                            </div>             
                    
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn " id="cerrarPop" data-dismiss="modal">
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button class="btn btn-primary" onclick="new_update_port();" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
        </div>
    </div>
</div>