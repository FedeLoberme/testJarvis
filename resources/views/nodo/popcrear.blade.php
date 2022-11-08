<div class="modal inmodal fade" id="popcrear_nodo" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" id="cerrar_nodo_all" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-share-alt modal-icon"></i>
                <h4 class="modal-title" id="title_nodo"></h4>
            </div>
            <form role="form" method="POST" id="nodo_new">
                <input  type="hidden" id="id_nodo" name="id_nodo">
                <input  type="hidden" id="pantalla" name="pantalla">
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>CELL ID*</label>
                                    <input type="text" placeholder="00000000000" autocomplete="off" name="cell_id" id="cell_id"  class="form-control" value="{{old('cell_id')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Nodo*</label>
                                    <input style="text-transform: uppercase;" class="form-control " type="text" id="nodo" placeholder="Nodo" autocomplete="off" name="nodo" value="{{old('nodo')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tipo*</label>
                                    <select class="form-control" id="type" name="type" onchange="lugar_nodo();">
                                        <option value="PROPIO"> Propio</option>
                                        <option value="ALQUILADO"> Alquilado</option>
                                        <option value="COUBICACION"> coubicación</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Dirección*</label>
                                    <div class="bw_all" id="bw_all">
                                        <select class="form-control hide-arrow-select" id="address" name="address" disabled="true">
                                            <option selected disabled value="">seleccionar</option>
                                        </select>
                                        <a class="ico_input btn btn-info "onclick="detal_addres(0);" data-toggle="modal" data-target="#buscar_direccion"><i class="fa fa-search" title="Buscar Dirección" > </i> Buscar</a>
                                        <a class="ico_input btn btn-info " data-toggle="modal" data-target="#popaddress_general" onclick="address_general();" title="Agregar Dirección"> <i class="fa fa-plus"> </i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="rent_data_row">
                            <div class="col-sm-8" id="propi2" style="display: none;">
                                <div class="form-group">
                                    <label>Propietario*</label>
                                    <input style="text-transform: capitalize;" type="text" placeholder="Propietario" autocomplete="off" id="propi" name="propi"class="form-control" value="{{old('propi')}}">
                                </div>
                            </div>
                            <div class="col-sm-4" id="fecha" style="display: none;">
                                <div class="form-group">
                                    <label>Fecha del contrato*</label>
                                    <input class="form-control " type="date" id="date" name="date" value="{{old('date')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label>Comentario</label>
                                    <input style="text-transform: capitalize;" type="text" placeholder="Comentario" autocomplete="off" name="commenta"class="form-control" maxlength="50" id="commenta" value="{{old('commenta')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Estado*</label>
                                    <select class="form-control" id="statu" name="statu">
                                        <option value="OPERATIVO"> OPERATIVO</option>
                                        <option value="NO OPERATIVO"> NO OPERATIVO</option>
                                        <option value="BAJA/MOVIMIENTO"> BAJA/MOVIMIENTO </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-12">
                        <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>

                        <button class="btn btn-primary" type="button" onclick="insert_update_nodo();"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
