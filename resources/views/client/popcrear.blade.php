<div class="modal inmodal fade" id="popcrear" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_cliente" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-building modal-icon"></i>
            <h4 class="modal-title">REGISTRAR CLIENTE</h4>
        </div>
        <form role="form" method="POST" id="clip_new">
            <div class="modal-body">
                <div class="form-group">
                    <label>CUIT*</label> 
                        <input type="text" placeholder="00000000000" autocomplete="off" maxlength="11" onkeypress="return esNumero(event);" name="cuit" id="cuit"  class="form-control" value="{{old('cuit')}}" Onchange = "cuit_msj('cuit')" >
                        <p class="mensajeInput" id="Cuit_exitoso"></p>
                </div>
                <div class="form-group">
                    <label>Razón Social*</label> 
                        <input style="text-transform: uppercase;" class="form-control " type="text" id="name" placeholder="Razón Social" autocomplete="off" name="name" Onchange = "mostrar('name')" class="form-control" value="{{old('name')}}">
                        <p class="mensajeInput" id="Razon_exitoso"></p>
                </div>
                <div class="form-group">
                    <label>Acrónimo*</label>
                        <div class="bw_all" id="bw_all" >  
                            <input onkeypress="return letra(event);" onkeypress="mayus(this);" style="text-transform: uppercase;" type="text" placeholder="----" maxlength="4"autocomplete="off" id="acronimo" name="acronimo"class="form-control" value="{{old('acronimo')}}" Onchange = "acronimo_msj('acronimo')">


                             <a class="ico_input btn btn-info " onclick="acronimo_client();"> <i class="fa fa-rotate-left" title="Generar Acrónimo"> </i> G. Acrónimo</a>
                        </div>
                        <p class="mensajeInput" id="Acronimo_exitoso"></p>
                </div>              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" onclick="validate_acronimo();" type="button"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
