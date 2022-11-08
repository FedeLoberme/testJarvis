<div class="modal inmodal fade" id="popaddress_general" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="address_exit"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title" id="title_address_general"></h4>
                <input type="hidden" id="id_address_edic" name="id_address_edic" >
            </div>
            <form role="form" method="POST" id="address_general" style="overflow-y: auto; max-height: 450px;">
                <div class="modal-body" >
                	<div class="col-sm-6">
		                <div class="form-group">
		                    <label>País*</label>
		                    <select class="form-control" onchange="provincia_all();" id="pais" name="pais">
			                    <option selected disabled value="">seleccionar</option> 
			                    @foreach($pais as $ps)
		                            @if (old('pais') == $ps->id)
		                                <option value="{{$ps->id}}" selected>{{$ps->name}}</option>
		                            @else
		                                <option value="{{$ps->id}}">{{$ps->name}}</option>
		                            @endif
	                            @endforeach     
		                    </select>
		                </div>
	                    </div>
	                    <div class="col-sm-6">
		                    <div class="form-group">
		                        <label>Provincia* </label>
			                    <select class="form-control" id="provin" name="provin">
			                        <option selected disabled value="">seleccionar</option>     
			                    </select>
		                    </div>
	                    </div>
	                    <div class="col-sm-4">
		                    <div class="form-group" >
		                        <label>Localidad*</label> 
		                        <input style="text-transform: capitalize;" type="text" placeholder="Localidad" autocomplete="off" id="local" maxlength="50" name="local"class="form-control" value="{{old('local')}}">
		                    </div>
	                    </div>
	                    <div class="col-sm-8">
		                    <div class="form-group" >
		                        <label>Calle*</label> 
		                        <input style="text-transform: none;" type="text" placeholder="Calle" autocomplete="off" id="calle" maxlength="200" name="calle"class="form-control" value="{{old('calle')}}">
		                    </div>
	                    </div>
	                    <div class="col-sm-3">
		                    <div class="form-group" >
		                        <label>Altura*</label> 
		                        <input onkeypress="return esNumero(event);" type="text" placeholder="Altura" autocomplete="off" id="altura" maxlength="30" name="altura"class="form-control" value="{{old('altura')}}">
		                    </div>
	                    </div>
	                    <div class="col-sm-3">
		                    <div class="form-group" >
		                        <label>Piso</label> 
		                        <input onkeypress="return Number_letra(event);" style="text-transform: capitalize;" type="text" placeholder="Piso" autocomplete="off" id="piso" maxlength="30" name="piso"class="form-control" value="{{old('piso')}}">
		                    </div>
	                    </div>
	                    <div class="col-sm-3">
		                    <div class="form-group" >
		                        <label>Departamento</label> 
		                        <input style="text-transform: capitalize;" type="text" placeholder="Apartamento" autocomplete="off" id="apartamento" maxlength="50" name="apartamento"class="form-control" value="{{old('apartamento')}}">
		                    </div>
	                    </div>
	                    <div class="col-sm-3">
		                    <div class="form-group">
		                        <label>Código Postal</label> 
		                        <input onkeypress="return esNumero(event);" type="text" placeholder="Código Postal" autocomplete="off" id="postal" maxlength="5" name="postal"class="form-control" value="{{old('postal')}}">
		                    </div>
	                    </div>                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="register_address();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
