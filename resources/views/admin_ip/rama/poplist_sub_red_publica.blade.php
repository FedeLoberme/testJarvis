<div class="modal inmodal fade overflow-modal" id="buscar_sub_red_ip" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_all_list_ip" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">INFORMACIÓN DE SUB-REDES</h4> 
            </div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 300px;">
                        <label>Rama*</label>
                        <select class="form-control" onchange="FilterBuscarSebRed();" id="rama_sub_red" name="rama_sub_red">
                            <option value="">seleccionar</option>
                            <option value="4">METROETHERNET</option>
                            <option value="449">Paraguy</option>
                            <option value="7">Pública</option>
                            <option value="8">Privada</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" style="width: 300px;">
                        <label>Estado de la Sub-Red*</label>
                        <select class="form-control" onchange="FilterBuscarSebRed();" id="status_sub_red" name="status_sub_red">
                            <option selected disabled value="">seleccionar</option>
                            @foreach($status as $status)
                                <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12">
                  <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis" id="list_all_sub_red">
                        <thead>
                            <tr>
                                <th>IP</th>
                                <th>Estado</th>
                                <th>Atributo</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer"> 
                </div>
        </div>
    </div>
</div>
