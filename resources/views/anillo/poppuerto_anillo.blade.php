<div class="modal inmodal fade" id="UpdatePortRingAll" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_bus_equipo_lsw" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-circle-o-notch modal-icon"></i>
                <h4 class="modal-title" id="NameRingNewPort"></h4> 
            </div>
                <div class="col-sm-12">
                    <center>
                        <a class="btn btn-success" data-toggle="modal" data-target="#PortNewRing" onclick="NewPortRingSelec();"><i class="fa fa-pencil"></i> 
                                Nuevo Puerto
                        </a>
                    </center>
                  <table class="table table-striped table-bordered table-hover dataTables-example table_jarvis">
                        <thead>
                            <tr>
                                <th>Acronimo</th>
                                <th>Puerto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="PortRingAllUpdate">
                            
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer"> 
                </div>
        </div>
    </div>
</div>
