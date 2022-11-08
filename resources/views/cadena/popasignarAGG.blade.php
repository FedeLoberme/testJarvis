<div class="modal inmodal fade" id="crear_asignar_agg_pop" role="dialog" data-backdrop="static" aria-hidden="true" style="overflow-y: scroll;" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_asignar_agg" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sitemap modal-icon"></i>
                <h4 class="modal-title">ASIGNAR NUEVO AGREGADOR</h4> 
                <h4 class="modal-subtitle" id="cadena_nameB_h4"> </h4>

            </div>
            <form role="form" method="POST" id="asignar_cadena">
                {{ csrf_field() }}
                <div class="col-sm-6">
                    <br>
                    <div class="form-group">
                        <label>Seleccionar Agregador</label> 
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control old_agg" disabled="true" id="new_agg_B" name="new_agg_B" >
                                <option selected disabled value="">seleccionar</option>       
                            </select>
                            <a class="ico_input btn btn-info" data-toggle="modal" data-target="#buscar_agg_all" onclick="list_agg_chain_all();"><i class="fa fa-search" title="Buscar Agregador" > </i> Buscar</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12" id="port_input_chain">
                    <div class="form-group">
                        <label>Puerto*</label> 
                        <a id="agregador" data-toggle="modal" data-target="#new_puerto_servicio_alta" onclick="inf_equip_port_chain();" ><i class="fa fa-plus" title="Agregar Placa"> </i> Agregar o Quitar Puerto</a>
                        <div id="campos_chain_port_B">
                                    
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button id="cancelar_chain" type="button" class="btn" data-dismiss="modal" >
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="asignar_chain" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div> 
            </div> 
        </div>
    </div>
</div>