<div class="modal inmodal fade" id="popcrear_grupo" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_cliente" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-group modal-icon"></i>
            <h4 class="modal-title" id="title_group"></h4>
        </div>
        <form role="form" method="POST" id="group_new">
            <input  type="hidden" id="id_group" name="id_group" value="0">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre*</label> 
                    <input style="text-transform: uppercase;" class="form-control " type="text" id="name" placeholder="Nombre" maxlength="30" autocomplete="off" name="name" Onchange = "mostrar('name')" class="form-control" value="{{old('name')}}">
                </div>                             
            </div>
            <div class="modal-footer">
                <button type="button" onclick="cancelar_cerra();" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" onclick="grupo_ip_validacion();" type="button"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
