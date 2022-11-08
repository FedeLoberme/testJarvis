<div class="modal inmodal fade" id="popcrear_profil" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog ">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_cliente" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-group modal-icon"></i>
            <h4 class="modal-title" id="title_profil"></h4>
        </div>
        <form role="form" method="POST" id="profil_new">
            <input  type="hidden" id="id_profil" name="id_profil" value="0">
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre del Perfil*</label> 
                    <input style="text-transform: uppercase;" class="form-control " type="text" id="name" placeholder="Nombre" maxlength="30" autocomplete="off" name="name" Onchange = "mostrar('name')" class="form-control" value="{{old('name')}}">
                </div>
                <label>Selecione su permiso</label>
                <table class="table table-striped table-bordered table-hover dataTables-example" id="claro_jarvis">
                    <thead>
                        <tr>
                            <th>Modulo</th>
                            <th colspan="4">Permiso</th>
                        </tr>
                        <tr>
                            <th>Nombre</th>
                            <th>Sin acceso</th>
                            <th>Lectura</th>
                            <th>Modificar</th>
                            <th>Crear</th>
                        </tr>
                    </thead>
                    <tbody id="profil_new_table">
                                        
                    </tbody>
                </table>                                 
            </div>
            <div class="modal-footer">
                <button type="button" onclick="cancelar_cerra();" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" onclick="profil_validacion();" type="button"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
