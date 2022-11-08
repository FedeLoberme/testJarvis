<div class="modal inmodal fade" id="pop_small_info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 400px">
        <div class="modal-content animated swing">
            <div class="modal-header">
                <button type="button" class="close" id="pop_small_info_close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="icon-ok-circle modal-icon"></i>
                <h4 class="modal-title">Reserva creada!</h4>
                    <div class=m-x-sm>
                        <div class="text-navy" style="font-size:30px;">
                            <span class="text-navy" style="font-size:30px;">#</span>
                            <span id=nro_reserva></span>
                            <button class="btn btn-white" data-clipboard-target="#nro_reserva"><i class="fa fa-copy"></i></button>
                        </div>
                    </div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover issue-tracker">
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
                                <a href="#">Estado celda</a><br>
                                <a href="#">Estado link</a><br>
                                <a href="#">Bw reservado [Kb]</a>
                            </td>
                            <td class="issue-info col-md-6 no-top-border">
                                <span class="number_reserve_span"></span><br>
                                <span class="info_status_node"></span><br>
                                <span class="info_status_link"></span><br>
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
                                <a href="#">Usuario</a> <br>
                                <a href="#">Fecha Inicio de Reserva</a><br>
                                <a href="#">Fecha Fin de Reserva</a><br>
                            </td>
                            <td class="issue-info col-md-6 no-top-border">
                                <span class="">{{ Auth::user()->name.' '.Auth::user()->last_name }}</span><br>
                                <span class="start_date"></span><br>
                                <span class="end_date"></span><br>
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
            </div>
            <div class="modal-footer">
                <button type="button" onclick="document.getElementById('pop_small_info_close').click();" class="btn btn-primary">Ok, gracias!</button>
            </div>
        </div>
    </div>
</div>