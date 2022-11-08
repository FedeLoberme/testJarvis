<div class="modal inmodal fade pop_equi_general" id="popcrear_uplink" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" id="cerrar_uplink_all" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-share-alt modal-icon"></i>
                <h4 class="modal-title" id="title_uplink"></h4>
            </div>
            <form role="form" method="POST" id="uplink_new">
                <div class="modal-body">
                    <input  type="hidden" id="id_uplink" name="id_uplink" value="0">
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label>Nodo</label>
                            <div class="bw_all" id="bw_all" >  
                                <select class="form-control" id="nodo_al" name="nodo_al">
                                    <option selected disabled value="">seleccionar</option>
                                    @foreach($nodo as $nodo)
                                        @if (old('nodo_al') == $nodo->id)
                                            <option value="{{ $nodo->id }}" selected>{{$nodo->nodo}} {{$nodo->cell_id}} {{$nodo->address}}</option>
                                        @else
                                            <option value="{{ $nodo->id }}">{{$nodo->nodo}} {{$nodo->cell_id}} {{$nodo->address}}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popcrear_nodo" onclick="crear_nodo('10');" title="Agregar Nodo"> <i class="fa fa-plus"> </i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label>uplink</label> 
                            <input style="text-transform: uppercase;" class="form-control " type="text" id="uplink" placeholder="uplink" autocomplete="off" name="uplink" value="{{old('uplink')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" id="max2">
                            <label>Bandwitdh max</label>
                            <div class="bw_all" id="bw_all" >
                                <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max" id="n_max" maxlength="8" class="form-control" value="{{old('n_max')}}">
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
                    </div>
        
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Equipo SAR</label> 
                            <input type="text" placeholder="00000000000" autocomplete="off" name="equipment_sat" id="equipment_sat"  class="form-control" value="{{old('equipment_sat')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>IP de Gestión</label> 
                            <input type="text" placeholder="00000000000" autocomplete="off" name="ip_gestion" id="ip_gestion"  class="form-control" value="{{old('ip_gestion')}}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Puerto Uplink del SAR</label> 
                            <input type="text" placeholder="00000000000" autocomplete="off" name="por_sar" id="por_sar"  class="form-control" value="{{old('por_sar')}}">
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Metro Tag</label> 
                            <input type="text" placeholder="00000000000" autocomplete="off" name="mtr_tag" id="mtr_tag"  class="form-control" value="{{old('mtr_tag')}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Customer Tag</label> 
                            <input type="text" placeholder="00000000000" autocomplete="off" name="cus_tag" id="cus_tag"  class="form-control" value="{{old('cus_tag')}}">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Vlan</label> 
                            <input type="text" placeholder="00000000000" autocomplete="off" name="vlan" id="vlan"  class="form-control" value="{{old('vlan')}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="validation_uplink();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
