<div class="modal inmodal fade overflow-modal" id="crear_link_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_link_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title" id="title_link"></h4> 
            </div>
            <form role="form" method="POST" id="alta_link">
                {{ csrf_field() }}
                <div class="col-sm-4">     
                    <div class="form-group">
                        <label>Tipo</label>
                        <select class="form-control" id="type_link" name="type_link">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($type_link as $link)
                                @if (old('type_link') == $link->id)
                                    <option value="{{$link->id}}" selected>{{$link->name}}</option>
                                @else
                                    <option value="{{$link->id}}">{{$link->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label>Nodo*</label>
                        <div class="bw_all" id="bw_all" >  
                            <select class="form-control hide-arrow-select" onchange="acro_link();" id="nodo_al" name="nodo_al" disabled="true">
                                <option selected disabled value="">seleccionar</option>
                                     
                            </select>
                            <a onclick="node_table_select();" class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_nodo_all" title="Buscar Nodo"><i class="fa fa-search"  > </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">     
                    <div class="form-group">
                        <label>BW max</label>
                        <div class="bw_all">
                            <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max_link" id="n_max_link" class="form-control" value="{{old('n_max_link')}}">
                            <select class="form-control" id="max_link" name="max_link">
                                @foreach($equipment['bw'] as $key => $licen)
                                    @if (old('licen') == $key)
                                        <option value="{{$key}}" selected>{{$licen}}</option>
                                    @else
                                        <option value="{{$key}}">{{$licen}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Nombre*</label> 
                        <input type="text" placeholder="Nombre" autocomplete="off" id="name_link" name="name_link"class="form-control" value="{{old('name_link')}}" maxlength="20">
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Comentario</label> 
                        <input type="text" placeholder="Comentario" autocomplete="off" id="commentary_link" name="commentary_link"class="form-control" maxlength="255" value="{{old('commentary_link')}}">
                    </div>
                </div>  
                <input type="hidden" name="id_link_new" id="id_link_new">
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="baja_link_pop" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="alta_link_pop" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
