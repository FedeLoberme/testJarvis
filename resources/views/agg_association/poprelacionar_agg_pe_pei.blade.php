<div class="modal inmodal animated fadeInLeft" id="poprelate_agg_pe_pei" tabindex="-1" role="dialog" style="overflow-y:scroll;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" id="close_relate_agg_pe_pei" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-slideshare modal-icon"></i>
                <h4 class="modal-title" id="">Relacionar AGG con PE/PEI</h4>
            </div>
            <div class="modal-body">
                <form id="relate_agg_pe_pei_form">
                    {{ csrf_field() }}
                    <div class="container-fluid">
                        <div class="row" id="agg_row_1" style="display:none;">
                            <div class="form-group col-md-12">
                                <label for="agg_sel">Agregador</label>
                                <div class="bw_all">
                                    <select class="form-control hide-arrow-select" id="agg_sel" name="agg_sel" disabled="true">
                                        <option selected disabled value="0">Ninguno</option>
                                    </select>
                                    <a class="ico_input btn btn-info" id="agg_btn" data-toggle="modal" data-target="#buscar_agg_all" onclick="list_agg_chain_all('agg_sel');"><i class="fa fa-search" title="Buscar Agregador" aria-hidden="true"> </i> Buscar</a>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="agg_row_2" style="display:none;">
                            <input type="hidden" id="agg_hidden" value="">
                            <div class="form-group col-md-12">
                                <label for="agg_sel">Agregador</label>
                                <input disabled type="text" class="form-control" id="agg_inpt" name="agg_inpt" placeholder="-">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="inpt_ip">IP</label>
                                <input disabled type="text" class="form-control" id="ip_inpt" name="ip_inpt" placeholder="-">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prefix_inpt">Prefijo Agregador</label>
                                <input disabled type="text" class="form-control" id="prefix_inpt" name="prefix_inpt" placeholder="-">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12"
                                style="border-width:1px; border-style:solid; border-color:#dc2; padding-top:1em; margin-top:1em;">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="zh_sel">ZONA HOME</label>
                                        <select class="form-control" id="zh_sel" name="zh_sel">
                                            <option>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="pe_mlps_sel_1">Router PE MLPS</label>
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="pe_mlps_sel_1" name="pe_mlps_sel_1" disabled="true">
                                                <option selected disabled value="0">Ninguno</option>
                                            </select>
                                            <a class="ico_input btn btn-info" id="pe_mlps_btn_1" data-toggle="modal" data-target="#pe_pei_list_modal"><i class="fa fa-search" title="Buscar Agregador" aria-hidden="true"> </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="pe_int_sel_1">Router PE INT</label>
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="pe_int_sel_1" name="pe_int_sel_1" disabled="true">
                                                <option selected disabled value="0">Ninguno</option>
                                            </select>
                                            <a class="ico_input btn btn-info" id="pe_int_btn_1" onclick="" data-toggle="modal" data-target="#pe_pei_list_modal"><i class="fa fa-search" title="Buscar Agregador" aria-hidden="true"> </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="zmh_sel">ZONA MULTI HOME</label>
                                        <select class="form-control"  id="zmh_sel" name="zmh_sel">
                                            <option>Seleccionar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="pe_mlps_sel_2">Router PE MLPS</label>
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="pe_mlps_sel_2" name="pe_mlps_sel_2" disabled="true">
                                                <option selected disabled value="0">Ninguno</option>
                                            </select>
                                            <a class="ico_input btn btn-info" id="pe_mlps_btn_2" onclick="" data-toggle="modal" data-target="#pe_pei_list_modal"><i class="fa fa-search" title="Buscar Agregador" aria-hidden="true"> </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="pe_int_sel_2">Router PE INT</label>
                                        <div class="bw_all">
                                            <select class="form-control hide-arrow-select" id="pe_int_sel_2" name="pe_int_sel_2" disabled="true">
                                                <option selected disabled value="0">Ninguno</option>
                                            </select>
                                            <a class="ico_input btn btn-info" id="pe_int_btn_2" onclick="" data-toggle="modal" data-target="#pe_pei_list_modal"><i class="fa fa-search" title="Buscar Agregador" aria-hidden="true"> </i> Buscar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12">
                    <button type="button" class="btn" data-dismiss="modal">
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button id="accept_relate_agg_pe_pei" class="btn btn-primary" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
            </div> 
        </div>
    </div>
</div>