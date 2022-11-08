<div class="modal inmodal fade" id="add_range_vlan" aria-hidden="true" style="overflow-y: auto; max-height: 635px;" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_pop_add_range_vlan"data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Agregar Rango</h4>
                <small class="font-bold">Ingrese los datos correctos para agregar un rango de vlan al agregador.</small>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Producto <span style="color:red">*</span></label> 
                            <div class="bw_all" id="bw_all" >  
                                <select class="form-control" id="pop_type_vlan_id" name="pop_type_vlan_id">
                                    <option selected disabled value="">seleccionar</option>
                                    @foreach($vlan_type as $product)
                                        @if ($product->id != 7 && $product->id != 8)
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6" style="">
                        <label for=":p">Nro Frontera (Deshabilitado)</label>
                        <input type="text" placeholder="000" maxlength="4" disabled onkeypress="return esNumero(event);" autocomplete="off"  id="vlan_recurso" name="vlan_recurso" class="form-control">
                    </div> --}}
                </div>
                
                <div class="col-sm-12">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Desde<span style="color:red"></span></label> 
                            <div class="bw_all" id="bw_all" > 
                                <input class="form-control hide-arrow-select" id="pop_add_range_min" onkeypress="return esNumero(event);" autocomplete="off"  name="pop_add_range_min" placeholder="Ejemplo: 700">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Hasta<span style="color:red"></span></label> 
                            <div class="bw_all" id="bw_all" > 
                                <input class="form-control hide-arrow-select" id="pop_add_range_max" onkeypress="return esNumero(event);" autocomplete="off"  name="pop_add_range_max" placeholder="Ejemplo: 1200">
                            </div>
                        </div>
                    </div>
                </div>
                

                <small style="color:transparent;">a</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="add_range_vlan();"class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>