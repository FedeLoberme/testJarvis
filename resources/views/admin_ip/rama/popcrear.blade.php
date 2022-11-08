<div class="modal inmodal fade" id="popcrear_rama" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" id="cerrar_pop_rama" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-leaf modal-icon"></i>
                <h4 class="modal-title" id="rama_title"></h4>
            </div>
            <form role="form" method="POST" id="rama_new">
                <input  type="hidden" id="id_rama" name="id_rama">
                <input  type="hidden" id="id_ip_edi" name="id_ip_edi">
                <input  type="hidden" id="padre" name="padre">
                <div class="modal-body">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Rango*</label>
                            <select class="form-control" onchange="rango_anillo();" id="rango" name="rango">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($confi as $key => $rango)
                                    <option value="{{ $key }}">{{ $rango }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Nombre*</label> 
                            <input type="text" placeholder="Nombre" autocomplete="off" name="rama" id="rama"  class="form-control" value="{{old('rama')}}">
                        </div>
                    </div>
                    <div id="ran_positivo" style="display: none;">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>Tipo*</label>
                                <select class="form-control" id="type" name="type">
                                    <option selected disabled value="">seleccionar</option>
                                    <option value="IPV. 4">IPV. 4</option>
                                    <option value="IPV. 6">IPV. 6</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label>IP*</label> 
                                <div class="bw_all" id="bw_all">
                                    <input type="text" placeholder="000.000.000.0" autocomplete="off" name="ip_rama" onkeypress="return val_ip(event)" id="ip_rama" class="form-control" value="{{old('ip_rama')}}">
                                    <a class="ico_input btn btn-info" onclick="stock_ip_table_select();" data-toggle="modal" data-target="#pop_ip_stock_all"><i class="fa fa-search" title="Buscar en Stock" > </i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Prefijo*</label> 
                                <input type="text" onkeypress="return esNumero(event)" placeholder="---" autocomplete="off" name="pre" id="pre" maxlength="2" class="form-control" value="{{old('pre')}}">
                            </div>
                        </div>
                        <div class="col-sm-12"> 
                            <center>
                                <p id="pre_vi"></p>
                            </center>
                        </div> 
                    </div> 
                    <div class="col-sm-12">                   
                        <div class="form-group">
                            <label>Descripción</label> 
                            <input style="text-transform: capitalize;" type="text" placeholder="Descripción" autocomplete="off" id="descrit" name="descrit"class="form-control" value="{{old('descrit')}}">
                        </div>             
                    </div>             
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                    <button class="btn btn-primary" type="button" onclick="validation_rama();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                </div>
            </form>
        </div>
    </div>

</div>
