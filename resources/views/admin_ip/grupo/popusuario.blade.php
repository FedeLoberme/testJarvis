<div class="modal inmodal fade" id="popagregar_quitar_usuario" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="cerrar" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-user-circle modal-icon"></i>
                <h4 class="modal-title">AGREGAR O QUITAR USUARIO DEL GRUPO: <span id="name_group"></span> </h4> 
            </div>
                <form role="form" method="POST" id ="new_users">
                    {{ csrf_field() }}
                    <div style="overflow-y: auto; max-height: 600px;"> 
                        <div class="col-sm-6 ">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th colspan="2"><center> Asignado</center></th>
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody id="user_grupo_listo">
                                       
                                </tbody>
                            </table>
                 
                        </div>
<!-- ---------------------------divicion--------------------------------------- -->    
                        <div class="col-sm-6">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th colspan="2"><center> Sin Asignar</center></th>
                                    </tr>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Opcion</th>
                                    </tr>
                                </thead>
                                <tbody id="user_grupo_falta">
                                       
                                </tbody>
                            </table>
                        </div>  
                    </div>
                </form>
                <div class="modal-footer">
                </div>
        </div>
    </div>
</div>