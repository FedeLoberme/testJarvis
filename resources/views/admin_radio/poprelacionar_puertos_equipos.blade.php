<div class="modal inmodal fade pop_equi_general overflow-modal" id="poprel_port_eq" role="dialog" aria-hidden="true"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="rel_port_eq_close" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="fa fa-compress modal-icon"></i>
                <h4 class="modal-title" id="title_recurso">RELACIONAR PUERTOS ENTRE EQUIPOS</h4>
            </div>
            <form role="form" method="POST" id="rel_port_eq_form">
                {{ csrf_field() }}
                <input type="hidden" id="current_port_type" name="current_port_type">
                <input type="hidden" id="current_port_bw" name="current_port_bw">
                <input type="hidden" id="current_board_id" name="current_board_id">
                <input type="hidden" id="current_port_n" name="current_port_n">
                <input type="hidden" id="other_eq_id" name="other_eq_id">
                <input type="hidden" id="other_board_id" name="other_board_id">
                <input type="hidden" id="other_port_n" name="other_port_n">
                <input type="hidden" id="other_port_type" name="other_port_type">
                
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Tipo de equipo*</label>
                        <select class="form-control" onchange="" id="type_eq_select" name="type_eq_select">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($functi as $functi)
                                @if (old('type_equip_select') == $functi->id)
                                    <option value="{{ $functi->id }}" selected>{{$functi->name}}</option>
                                @else
                                    <option value="{{ $functi->id }}">{{$functi->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <label>Equipo de destino*</label>
                        <div class="bw_all" id="bw_all">
                            <!-- Lo pisa el modal 'admin_agg.popcrear_recurso' que declara al elemento #equip como un input -->
                            <select class="form-control equip hide-arrow-select" id="eq_select" name="eq_select" disabled="true">
                                <!--<option selected disabled value="">seleccionar</option>-->
                            </select>
                            <a class="ico_input btn btn-info" id="search_eq_button" data-toggle="modal" title="Buscar Equipo">
                                <i class="fa fa-search"> </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Puerto de destino*</label>
                        <div class="bw_all">
                            <select class="form-control equip hide-arrow-select" id="port_select" name="port_select" disabled="true">
                                <!--<option selected disabled value="">seleccionar</option>-->
                            </select>
                            <a class="ico_input btn btn-info" id="search_port_button" data-toggle="modal" title="Buscar Puerto">
                                <i class="fa fa-search"> </i> Buscar</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12">
                    <div class="form-group">
                        <div id="campos_port">

                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" id="rel_port_eq_cancel" class="btn" data-dismiss="modal">
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong> Cancelar</strong>
                    </button>
                    <!-- Utilizar onclick llamando a una funcion nueva, propia de este modal ya que
                        la existente alta_service_recurso() requiere de elementos que no existen acá -->
                    <button type="button" class="btn btn-primary" id="rel_port_eq_accept">
                        <i class="fa fa-floppy-o"></i>
                        <strong> Guardar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
