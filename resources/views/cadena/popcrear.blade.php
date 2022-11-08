<div class="modal inmodal fade" id="crear_cadena_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_cadena_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_cadena"></h4> 
            </div>
            <form role="form" method="POST" id="alta_cadena">
                {{ csrf_field() }}
                <input type="hidden" name="id_chain" id="id_chain">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Nombre*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="name_chain" name="name_chain"class="form-control" value="{{old('name_chain')}}" maxlength="50">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>extremo 1*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="extrem_1" name="extrem_1"class="form-control" value="{{old('extrem_1')}}" maxlength="100">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>extremo 2*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="extrem_2" name="extrem_2"class="form-control" value="{{old('extrem_2')}}" maxlength="100">
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>BW</label>
                        <div class="bw_all" id="bw_all" >
                            <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="BW_chain" id="BW_chain" class="form-control" value="{{old('BW_chain')}}">
                            <select class="form-control" id="max_chain" name="max_chain">
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
                        <label>Equipo*</label> 
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control" onchange="port_chain_all_show();" disabled="true" id="agg" name="agg" >
                                <option selected disabled value="">seleccionar</option>       
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_agg_all" onclick="list_agg_chain_all();"><i class="fa fa-search" title="Buscar Agregador" > </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" id="port_input_chain" style="display:none">
                    <div class="form-group">
                        <label>Puerto*</label> 
                        <a id="agregador" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="inf_equip_port_chain();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar o Quitar Puerto</a>
                        <div id="campos_chain_port">
                                    
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                     <div class="form-group">
                        <label>Comentario</label> 
                        <input type="text" placeholder="Comentario" maxlength="100" autocomplete="off" id="commentary_chain" name="commentary_chain"class="form-control" value="{{old('commentary_chain')}}">
                    </div>
                </div>          
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="baja_chain" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_chain" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>