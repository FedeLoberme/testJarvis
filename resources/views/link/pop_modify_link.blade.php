<div class="modal inmodal fade overflow-modal" id="modify_link_pop" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="close_modify_link_pop" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">Modificar Link</h4> 
            </div>
            <div class="modal-body">
                <form role="form" method="POST" id="modify_link">
                    <input type="hidden" id="id_link_modify" name="id_link_modify">
                    {{ csrf_field() }}
                    <div class="col-sm-4">     
                        <div class="form-group">
                            <label>Tipo</label>
                            <select class="form-control" id="type_link_modify" name="type_link_modify">
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
                                <select class="form-control hide-arrow-select" id="nodo_al_modify" name="nodo_al_modify" disabled="true">
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
                                <input type="text" onkeypress="return number_decimal(event,this);" placeholder="0" name="n_max_link_modify" id="n_max_link_modify" class="form-control" value="{{old('n_max_link')}}">
                                <select class="form-control" id="max_link_modify" name="max_link_modify">
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
                            <input type="text" placeholder="Nombre" autocomplete="off" id="name_link_modify" name="name_link_modify"class="form-control" value="{{old('name_link')}}" maxlength="20">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Comentario</label> 
                            <input type="text" placeholder="Comentario" autocomplete="off" id="commentary_link_modify" name="commentary_link_modify"class="form-control" maxlength="255" value="{{old('commentary_link')}}">
                        </div>
                    </div>
                </form>
            
            <small class="small" style="color:transparent">a</small>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="close_modify_link_pop" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="modify_link_pop_save" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>
