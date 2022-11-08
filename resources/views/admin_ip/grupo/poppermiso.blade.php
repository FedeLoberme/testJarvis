<div class="modal inmodal fade" id="popagregar_quitar_permiso" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-ms">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrar_permisos_ip" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-unlock-alt modal-icon"></i>
                <h4 class="modal-title" id="c_equipo">AGREGAR O QUITAR PERMISO DEL GRUPO</h4> 
            </div>
                <form role="form" method="POST" id ="new_permis">
                    <input  type="hidden" id="id_group_new" name="id_group_new" value="0">
                    {{ csrf_field() }}
                    <div style="overflow-y: auto; max-height: 600px;"> 
                        <div class="col-lg-12">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Sin acceso</th>
                                        <th>Lectura</th>
                                        <th>Modificar</th>
                                        <th>Crear</th>
                                    </tr>
                                </thead>
                                <tbody id="permi_grupo">
                                       
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn " onclick="cancelar_cerra();" data-dismiss="modal">
                        <i class="fa fa-times-rectangle-o"></i>
                        <strong>  Cancelar</strong>
                    </button>
                    <button class="btn btn-primary" onclick="new_permi_group();" type="button">
                        <i class="fa fa-floppy-o"></i>
                        <strong>  Guardar</strong>
                    </button>
                </div>
        </div>
    </div>
</div>