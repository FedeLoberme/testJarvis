<div class="modal inmodal fade" id="popcrear_red" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-m">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" id="cerrar_pop_rango_fin" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">CREAR SUB-RED</h4>
            </div>
            <form role="form" method="POST" id="crear_subred_new">
                <input  type="hidden" id="id_red" name="id_red">
                <div class="modal-body">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="crear_subred" class="mb-2">RED*</label> 
                            <div class="bw_all" id="bw_all" > 
                                <div class="split5">
                                    <input onkeypress="return esNumero(event);" type="text" name="ip_mascara1" id="ip_mascara1"  class="form-control crear_subred " maxlength="3" value="{{old('ip_mascara1')}}">
                                </div>
                                <span class="char_crearsubred">.</span>
                                <div class="split5">
                                    <input onkeypress="return esNumero(event);" type="text" maxlength="3" name="ip_mascara2" id="ip_mascara2"  class="form-control crear_subred" value="{{old('ip_mascara2')}}">
                                </div>
                                <span class="char_crearsubred">.</span>
                                <div class="split5">
                                    <input onkeypress="return esNumero(event);" type="text" maxlength="3" name="ip_mascara3" id="ip_mascara3"  class="form-control crear_subred" value="{{old('ip_mascara3')}}">
                                </div>
                                <span class="char_crearsubred">.</span>
                                <div class="split5">
                                    <input onkeypress="return esNumero(event);" type="text" maxlength="3" name="ip_mascara4" id="ip_mascara4"  class="form-control crear_subred" value="{{old('ip_mascara4')}}">
                                </div>
                                <span class="char_crearsubred">/</span>
                                <div class="split5">
                                    <input style="width: 45px;" onkeypress="return esNumero(event);" type="text" name="mask" maxlength="2" id="mask"  class="form-control crear_subred" value="{{old('mask')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 ">
                    <div class="form-group" id="dual2">
                        <label class="mb-2">Estado*</label>
                        <select class="form-control" id="status_rango" name="status_rango">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($status as $status)
                                <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>            
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                    <button class="btn btn-primary" type="button" onclick="validation_seb_red();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
