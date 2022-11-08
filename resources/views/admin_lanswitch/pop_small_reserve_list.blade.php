<div class="modal inmodal fade" id="buscar_reserve_all" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 400px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_reserve_list"data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Elegir reserva</h4>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label>Reserva (Activa)<span style=color:red;>*</span></label>
                        <div class="bw_all" id="bw_all" >
                            <select class="form-control" id="id_reserve_choosen" onchange="reserve_detail(this.options[this.selectedIndex].value);" name="id_reserve_choosen">
                                <option selected disabled value="">seleccionar</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" style="margin-top: 15px">
                    <div class="centericon">
                        <center style="max-height: 36px">
                            <i class="fa fa-info-circle"></i>
                        </center>
                    </div>

                    <div class="border-info-reserva " style="margin-top: 13px; margin-bottom: 10px; padding: 10px; min-height:175px;">
                        {{-- CELDA INFO --}}
                        <div class="table-responsive m-t-sm">
                            <table class="table table-hover issue-tracker m-b-xxs">
                                <tbody>
                                    <tr>
                                        <td class="no-top-border" style="height: auto; padding: inherit;">
                                            <div style="
                                            display: flex;
                                            justify-content: flex-end;">
                                            <span class="label label-warning">Celda</span> 
                                            </div>
                                        </td>
                                        
                                    </tr>
                                <tr>
        
                                    <td class="issue-info col-md-6 no-top-border text-right">
                                        <a href="#">Numero de reserva</a> <br>
                                        <a href="#">Nombre celda</a><br>
                                        <a href="#">Nombre link</a><br>
                                        <a href="#">Bw reservado</a>
                                    </td>
                                    <td class="issue-info col-md-6 no-top-border">
                                        <span class="info_number_reserve"></span><br>
                                        <span class="info_name_node"></span><br>
                                        <span class="info_name_link"></span><br>
                                        <span class="info_bw_reserved"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-top-border" style="height: auto; padding: inherit;">
                                        <div style="
                                        display: flex;
                                        justify-content: flex-end;">
                                        <span class="label label-success">Data</span> 
                                        </div>
                                    </td>
                                    <td class="no-top-border" style="height: auto; padding: inherit;">
                                        <span></span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="issue-info col-md-6 no-top-border text-right">
                                        <a href="#">Oportunidad</a><br>
                                        <a href="#">Cliente</a><br>
                                    </td>
                                    <td class="issue-info col-md-6 no-top-border">
                                        <span class="oportunitty"></span><br>
                                        <span class="client"></span><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="no-top-border" style="height: auto; padding: inherit;">
                                        <div style="
                                        display: flex;
                                        justify-content: flex-end;">
                                        <span class="label label-succes">Comentario</span> 
                                        </div>
                                    </td>
                                    <td class="no-top-border" style="height: auto; padding: inherit;">
                                        <span></span>
                                    </td>
                                    
                                </tr>
                                <tr>
                                    <td class="issue-info col-md-6 no-top-border text-right">
                                        <a href="#">Texto</a>
                                    </td>
                                    <td class="issue-info col-md-6 no-top-border">
                                        <span class="info_comentary"></span>
                                    </td>
                                </tr>
                                
                                </tbody>
                            </table>
                        </div>
                        <div class="row m-t-none">
                            <div class="col-md-12">
                        <small>Información de <b>celda</b> al momento de reservar</small>

                                <div class="col-md-6 border-right border-bottom" style="padding-bottom:5px">
                                    <center>
                                        <p class="m-b-xs"><strong>Celda (Uplink)</strong></p>
                                            <h1 class="no-margins"><span id="node_bw_pop_info">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="node_bw_pop_info_size"></span>]</b></small></h1>
                                    </center>
                                </div>
                                <div class="col-md-6 border-bottom" style="padding-bottom: 5px;">
                                    <center>
                                        <p class="m-b-xs"><strong>Usado</strong></p>

                                            <h1 class="no-margins"><span id="node_bw_used_pop_info">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="node_bw_used_size_pop_info"></span>]</b></small></h1>
                                    </center>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="col-md-6 border-right">
                                    <center>
                                        <p class="m-b-xs"><strong>Reservado</strong></p>
                                                <h1 class="no-margins"><span id="node_bw_reserved_pop_info">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="node_bw_reserved_pop_info_size"></span>]</b></small></h1>
                                    </center>
                                </div>
                                <div class="col-md-6">
                                    <center>
                                        <p class="m-b-xs"><strong>Remanente</strong></p>
                                            <h1 class="no-margins"><span id="node_bw_remanent_pop_info">0</span><small style="font-size: 10px" class="text-navy"><b>[<span id="node_bw_remanent_pop_info_size"></span>]</b></small></h1>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span style="color: transparent">. </span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="selec_reserve();">Seleccionar</button>
            </div>
        </div>
    </div>
</div>