<div class="modal inmodal fade" id="detalle" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <img alt="image" class="img-circle modal-icon" style="width:72px; height:72px;" src="../public/img/ico_rou.jpg" />
                <h4 class="modal-title" id="e_equipo" >DETALLE DEL EQUIPO:</h4>
            </div>
            <form role="form"   method="POST" id="detalle_edit">
                <div class="col-sm-6 b-r">
                    <div class="form-group">
                        <label>Tipo de equipo</label>
                        <input type="text" disabled="true" id="detal_equipo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Marca</label>
                        <input disabled type="text" id="detal_marca" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Modelo</label> 
                        <input disabled type="text" id="detal_modelo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Código SAP</label> 
                        <input disabled type="text" id="detal_sap" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Estatus</label>
                        <input disabled type="text" id="detal_status" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Descripción</label>
                        <p id="detal_descri"></p>
                    </div>
                </div>
                           
                <div class="col-sm-6">
                    <div class="form-group" id="detal_max2">
                        <label>Bandwitdh max</label>
                        <input disabled type="text" id="detal_n_max" class="form-control">
                    </div>
                    <div class="form-group" id="detal_licen2">
                        <label>Bandwitdh básico licenciado</label>
                        <input disabled type="text" id="detal_n_licen" class="form-control">
                    </div>
                    <div class="form-group" id="detal_encrip2">
                        <label>Bandwitdh c/encripción</label>
                        <input disabled type="text" id="detal_n_encrip" class="form-control">
                    </div>
                    <div class="form-group" id="detal_alimenta2">
                        <label>Alimentación</label>
                        <input disabled type="text" id="detal_alimenta" class="form-control">
                    </div>
                    <div class="form-group" id="detal_dual2">
                        <label>Dual stack</label>
                        <input disabled type="text" id="detal_dual" class="form-control">
                    </div>
                    <div class="form-group" id="detal_full2">
                        <label>Full table</label>
                        <input disabled type="text" id="detal_full" class="form-control">
                    </div>
                    <div class="form-group" id="detal_multi2">
                        <label>Multivrf</label>
                        <input disabled type="text" id="detal_multi" class="form-control">
                    </div>
                    <div class="form-group" id="detal_banda2" >
                        <label>Banda</label>
                        <input disabled type="text" id="detal_banda" class="form-control">
                    </div>
                    <div class="form-group" id="detal_radio2">
                        <label>Tipo radio</label>
                        <input disabled type="text" id="detal_radio" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Modulos / slots (Cant.)</label> 
                        <input disabled type="text" id="detal_modulo" class="form-control">
                    </div>
                </div> 
             </form>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>