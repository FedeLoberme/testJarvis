<div class="modal inmodal fade" id="crear_equipo" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: auto;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img alt="image" class="img-circle modal-icon" style="width:72px; height:72px;" src="../public/img/ico_rou.jpg" />
                <h4 class="modal-title" id="title_equip"></h4> 
            </div>
                <form enctype="multipart/form-data" role="form" method="POST" id ="new_equipment" action="{{ url('gestion/equipo') }}">
                    {{ csrf_field() }}
                    <div class="col-sm-6 b-r">
                        <div class="form-group" id="equipo2">
                            <label>Tipo de equipo</label>
                            <input type="hidden" id="nom_equipo" name="nom_equipo" >
                            <input type="hidden" id="id_editar" name="id_editar" value="0">
                            <div class="bw_all" id="bw_all" >  
                            <select class="form-control" id="equipo" name="equipo" onchange="EquiSelected();">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equip as $equipo)
                                    @if (old('equipo') == $equipo->id)
                                        <option value="{{ $equipo['id'] }}" selected>{{ $equipo->name }}</option>
                                    @else
                                        <option value="{{ $equipo->id }}">{{ $equipo->name }}</option>
                                    @endif
                                @endforeach
                            </select>

                        </div>
                        </div>
                        <div class="form-group" id="marca2">
                            <label>Marca</label>
                            <div class="bw_all" id="bw_all" >  
                            <select class="form-control" id="marca" name="marca">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equi_mark as $mark)
                                    @if (old('marca') == $mark->id)
                                        <option value="{{ $mark->id }}" selected>{{ $mark->name }}</option>
                                    @else
                                        <option value="{{ $mark->id }}">{{ $mark->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(2);" title="Agregar Marca"> <i class="fa fa-plus"> </i></a>
                            </div>
                        </div>
                        <div class="form-group" id="modelo2">
                            <label>Modelo</label> 
                            <input style="text-transform: uppercase;" type="text" placeholder="Modelo" autocomplete="off" id="modelo" name="modelo"class="form-control" maxlength="30" value="{{old('modelo')}}">
                        </div>
                        <div class="form-group" id="sap2">
                            <label>Código SAP</label> 
                            <input onkeypress="return esNumero(event);" type="text" placeholder="Código sap" maxlength="30" autocomplete="off" name="sap" id="sap" class="form-control" value="{{old('sap')}}">
                        </div>
                        <div class="form-group" id="status2">
                            <label>Estatus</label>
                            <select class="form-control" id="status" name="status">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equipment['status'] as $key => $status)
                                    @if (old('status') == $key)
                                        <option value="{{ $key }}" selected>{{ $status }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $status }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="descri2">
                            <label>Descripción</label> 
                            <input style="text-transform: capitalize;" type="text" placeholder="Descripción" maxlength="" autocomplete="off" id="descri" name="descri"class="form-control" value="{{old('descri')}}">
                        </div>
                        <div class="form-group" id="image2">
                            <label>Imagen</label> 
                            <input type="file" autocomplete="off" name="image" id="image" class="form-control" value="{{old('image')}}">
                        </div>
                        <div class="form-group" id="funtion2">
                            <label>Función</label>
                            <select class="form-control" multiple="multiple" id="funtion" name="funtion[]" onclick="multi();">
                                @foreach($function as $func)
                                    <option value="{{ $func->id }}">{{ $func->name }}</option>
                                @endforeach
                            </select>
                        </div>
             
                    </div>
<!-- ---------------------------divicion--------------------------------------- -->    
                    <div class="col-sm-6">
                        <div class="form-group" id="max2">
                            <label>Bandwitdh max</label>
                            <div class="bw_all" id="bw_all" >
                                <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max" id="n_max" class="form-control" value="{{old('n_max')}}">
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
                        <div class="form-group" id="licen2">
                            <label>Bandwitdh básico licenciado</label>
                            <div class="bw_all" id="bw_all" >
                                <input type="text"  onkeypress="return number_decimal(event,this);" placeholder="0" name="n_licen" id="n_licen" class="form-control" value="{{old('n_licen')}}">
                                <select class="form-control" id="licen" name="licen">
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
                        <div class="form-group" id="encrip2">
                            <label>Bandwitdh c/encripción</label>
                            <div class="bw_all" id="bw_all" >
                                <input type="text" onkeypress="return number_decimal(event, this);" placeholder="0" name="n_encrip" id="n_encrip" class="form-control" value="{{old('n_encrip')}}">
                                <select class="form-control" id="encrip" name="encrip">
                                    @foreach($equipment['bw'] as $key => $encrip)
                                        @if (old('encrip') == $key)
                                            <option value="{{ $key }}" selected>{{ $encrip }}</option>
                                        @else
                                            <option value="{{ $key }}">{{ $encrip }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="alimenta2">
                            <label>Alimentación</label>
                            <div class="bw_all" id="bw_all" >  
                            <select class="form-control" id="alimenta" name="alimenta">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($electrical_power as $alimenta)
                                    @if (old('alimenta') == $alimenta->id)
                                        <option value="{{ $alimenta->id }}" selected>{{ $alimenta->name }}</option>
                                    @else
                                        <option value="{{ $alimenta->id }}">{{ $alimenta->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(3);" title="Agregar Alimentación"> <i class="fa fa-plus"> </i></a>
                            </div>
                        </div>
                        <div class="form-group" id="dual2">
                            <label>Dual stack</label>
                            <select class="form-control" id="dual" name="dual">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equipment['confir'] as $key => $dual)
                                    @if (old('dual') == $key)
                                        <option value="{{ $key }}" selected>{{ $dual }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $dual }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="full2">
                            <label>Full table</label>
                            <select class="form-control" id="full" name="full">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equipment['confir']  as $key => $full)
                                    @if (old('full') == $key)
                                        <option value="{{ $key }}" selected>{{ $full }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $full }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="multi2">
                            <label>Multivrf</label>
                            <select class="form-control" id="multi" name="multi">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($equipment['confir'] as $key => $multi)
                                    @if (old('multi') == $key)
                                        <option value="{{ $key }}" selected>{{ $multi }}</option>
                                    @else
                                        <option value="{{ $key }}">{{ $multi }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group" id="banda2" style="display: none;">
                            <label>Banda</label>
                            <div class="bw_all" id="bw_all" > 
                            <select class="form-control" id="banda" name="banda">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($band as $banda)
                                    @if (old('banda') == $banda->id)
                                        <option value="{{ $banda->id }}" selected>{{ $banda->name }}</option>
                                    @else
                                        <option value="{{ $banda->id }}">{{ $banda->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(5);" title="Agregar Banda"> <i class="fa fa-plus"> </i></a>
                            </div>
                        </div>
                        <div class="form-group" id="radio2" style="display: none;">
                            <label>Tipo radio</label>
                            <div class="bw_all" id="bw_all" > 
                            <select class="form-control" id="radio" name="radio">
                                <option selected disabled value="">seleccionar</option>
                                @foreach($radio as $radio)
                                    @if (old('radio') == $radio->id)
                                        <option value="{{ $radio->id }}" selected>{{ $radio->name }}</option>
                                    @else
                                        <option value="{{ $radio->id }}">{{ $radio->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <a class="ico_input btn btn-info " data-toggle="modal" data-target="#lis_selec" onclick="list_database(4);" title="Agregar Radio"> <i class="fa fa-plus"> </i></a>
                            </div>
                        </div>
                        <div class="form-group" id="modulo2">
                            <label>Modulos / slots (Cant.)</label> 
                            <input onkeypress="return esNumero(event);" value="0" type="text" placeholder="Modelos" autocomplete="off" name="modulo" id="modulo" class="form-control" value="{{old('modulo')}}">
                        </div>
                    </div>  
                            
                    <button disabled id="new_equi" style="display: none;" type="submit"></button>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn" data-dismiss="modal">
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button class="btn btn-primary" onclick="new_equipo();" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
        </div>
    </div>
</div>