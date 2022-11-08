<div class="modal inmodal animated fadeInLeft" id="vlan_range_config" focus="true "tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_vlan_range_config"data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-sliders modal-icon"></i>
                <h4 class="modal-title" id="range_vlan_title">Configurar vlan rango</h4>
                <small class="font-bold" id="range_vlan_subtitle">En esta pantalla se podran configurar los rangos de las VLAN asociadas al agregador.</small>
                <p><strong><span class="label label-success">Gestion LS</span> <span class="label label-warning">Gestion RADIO</span> <span class="label label-danger">FRONTERA</span></strong> </p>
            </div>
            <div class="modal-body">
                <input type="hidden" id="agg_id" value="">
                <div class="col-sm-12" style="display: flex; align-items:center">
                    <div class="col-sm-6 text-center">
                            <h2 class="m-t-xxs" id="range_gestion">Rangos del Agregador</h2>
                    </div>
                    <div class="col-sm-6 text-right text-center">
                            <a class="btn btn-success" data-toggle="modal" data-target="#add_range_vlan" onclick="clear_add_vlan_inputs();"><i class="fas fa-folder-plus"></i>
                                Nuevo Rango
                            </a>
                    </div>
                </div>
                <div id = "vlan_gestion">
                    <h4>No posee rangos de gestion propios del agregador</h4>
                </div>
                <div id = "title_gnral_ranges"class="col-sm-12" style="display: flex; align-items:center">
                    <div class="col-sm-6 text-center">
                        <h2 class="m-t-xxs" id="range_gestion">Rangos Generales</h2>
                    </div>
                </div>
                <div id="vlan_gestion_all">
                    
                </div>
                <small style="color:transparent">a</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>