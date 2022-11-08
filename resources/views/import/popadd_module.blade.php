<div class="modal inmodal fade" id="popadd_module" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal"{{--id="address_exit"--}} ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> 
                <i class="fa fa-microchip modal-icon"></i>
                <h4 class="modal-title" id="title_add_module"></h4>
            </div>
            <form role="form" method="POST" id="add_module" style="overflow-y: auto; max-height: 450px;">
                <div class="modal-body" >
					<div class="col-sm-6">
						<div class="form-group">
							<label>Nombre Modulo* </label>
							<input type="text" placeholder="Nombre del Modulo" autocomplete="off" id="nombre_modulo" name="nombre_modulo" maxlength="50" class="form-control" value="">
						</div>
					</div>
                	<div class="col-sm-6">
		                <div class="form-group">
		                    <label>Tipo de Modulo*</label>
		                    <select class="form-control" id ="tipo_modulo" name="tipo_modulo">
			                    <option selected disabled value="">Seleccionar</option> 
			                    @foreach($tipos_modulo as $tipo)
		                            <option value="{{$tipo}}" >{{$tipo}}</option>
	                            @endforeach
							</select> 
						</div>
	                </div>
					<div class="col-sm-6">
						<div class="d-flex">
							<label>Distancia*</label>
							<div class="bw_all">
							<input type="text" placeholder="Distancia" autocomplete="off" id="distancia" maxlength="5" name="distancia"class="form-control" value="{{old('distancia')}}">
							<select class="form-control" id="km" name="km">
								<option value="Km">KM</option>
								<option value="m">M</option>
							</select>
						</div>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" >
							<label>Fibra*</label> 
							<select class="form-control" name="fibra" id="fibra">
			                    <option selected disabled value="">Seleccionar</option> 
								<option value="Cobre">Cobre</option>
								<option value="MM">MM</option>
								<option value="SM">SM</option>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group" >
							<label>Corta | Larga*</label> 
							<select class="form-control" name="corta_larga" id="corta_larga">
			                    <option selected disabled value="">Seleccionar</option> 
								<option value="Corta">Corta</option>
								<option value="Larga">Larga</option>
							</select>
						</div>
					</div>      
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="register_module();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
