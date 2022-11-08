<div class="modal inmodal fade" id="popcrear_permiso_especial" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-sm">
    <div class="modal-content animated fadeIn">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" id="cerrar_permi_new" ><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <i class="fa fa-unlock-alt modal-icon"></i>
            <h4 class="modal-title" id="title_group_espe"></h4>
        </div>
        <form role="form" method="POST" id="group_new">
            <input  type="hidden" id="id_especial" name="id_especial" value="0">
            <div class="modal-body">
                <div class="form-group">
                    <label>Usuario*</label>
                    <select class="form-control" id="user" name="user">
                        <option selected disabled value="">seleccionar</option> 
                        @foreach($User as $User)
                            @if (old('user') == $User->id)
                                <option value="{{ $User->id }}" selected>{{ $User->name }} {{ $User->last_name }}</option>
                            @else
                                <option value="{{ $User->id }}">{{ $User->name }} {{ $User->last_name }}</option>
                            @endif
                        @endforeach           
                    </select>
                </div> 
                <div class="form-group">
                    <label>Rama*</label>
                    <select class="form-control rama" id="rama" name="rama">
                        <option selected disabled value="">seleccionar</option> 
                        @foreach($Branch as $Bran)
                            @if (old('rama') == $Bran->id)
                                <option value="{{ $Bran->id }}" selected>{{ $Bran->name }} {{ $Bran->last_name }}</option>
                            @else
                                <option value="{{ $Bran->id }}">{{ $Bran->name }} {{ $Bran->last_name }}</option>
                            @endif
                        @endforeach            
                    </select>
                </div>
                <div class="form-group">
                    <label>Permiso*</label>
                    <select class="form-control" id="permi_new" name="permi_new">
                        <option selected disabled value="">seleccionar</option> 
                        <option value="0">Sin acceso</option> 
                        <option value="3">Lectura</option> 
                        <option value="5">Modificar</option> 
                        <option value="10">Crear</option>            
                    </select>
                </div>                            
            </div>
            <div class="modal-footer">
                <button type="button" onclick="cancelar_cerra();" class="btn " data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i><strong>  Cancelar</strong></button>
                <button class="btn btn-primary" onclick="permis_ip_validacion();" type="button"><i class="fa fa-floppy-o"></i><strong>  Guardar</strong></button>
            </div>
        </form>
    </div>
</div>

</div>
