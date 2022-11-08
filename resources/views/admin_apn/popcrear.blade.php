<div class="modal inmodal fade overflow-modal" id="admin_apn_crear" role="dialog" data-backdrop="static" aria-hidden="true" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"  id="cerra_admin_apn" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-map-marker modal-icon"></i>
                <h4 class="modal-title">CREAR APN</h4>
            </div>
            <div class="ibox-content">
                <form id="form" action="#" class="wizard-big">
                    <h1>Datos generales</h1>
                    <!-- modal 1 -->
                    <fieldset class="overflow-modal">
                        <h3>Alta de APN privado</h3>
                        <h4>Agrega un APN nuevo a la base de datos</h4>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Razon Social *</label>
                                <input id="social" name="social" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Pais del APN *</label>
                                <select class="form-control" id="pais" name="pais">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>ID de la VRF *</label>
                                <select class="form-control" id="vrf" name="vrf">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Usa IPSec *</label>
                                <select class="form-control" id="ipsec" name="ipsec">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                            </div>
                        </div>  
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Número de enlace *</label>
                                    <input id="numero" name="numero" type="text" class="form-control ">
                                </div>
                            </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Tipo *</label>
                                <select class="form-control" id="tipo" name="tipo">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Contexto PGW *</label>
                                <select class="form-control" id="pgw" name="pgw">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Relacionar el túnel IPSec *</label>
                                        <input id="tunel_ipsec" name="tunel_ipsec" type="text" class="form-control ">
                                    </div>
                                </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Nombre del APN *</label>
                                <input id="apn" name="apn" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Estado administrativo *</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option selected disabled value="">seleccionar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>RT MPLS *</label>
                                <input id="MPLS" name="MPLS" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>APN relacionado *</label>
                                <input id="relacionado" name="relacionado" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>WAN túnel GRE Torcuato *</label>
                                <input id="wan" name="wan" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>DNS interno 1 *</label>
                                <input id="DNS1" name="DNS1" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>Sitio principal IPSec *</label>
                                <input id="sitio" name="sitio" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>WAN túnel GRE Garay *</label>
                                <input id="garay" name="garay" type="text" class="form-control ">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label>DNS interno 2 *</label>
                                <input id="DNS2" name="DNS2" type="text" class="form-control ">
                            </div>
                        </div>
                    </fieldset>
                    <!-- modal 2 -->
                    <h1>Pools de los móviles</h1>
                    <fieldset>
                        <div class="bw_all" id="bw_all" >
                            <h3>Profile Information</h3>
                            <a class="ico_input btn btn-info" onclick="dupli_table();"> <i class="fa fa-plus"> </i></a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th class="col-lg-1">Asignación*</th>
                                        <th class="col-lg-3">Pool Torcuato*</th>
                                        <th class="col-lg-3">Pool Garay*</th>
                                        <th class="col-lg-2">Máscara asignada*</th>
                                        <th class="col-lg-2">Máscara reducida*</th>
                                        <th class="col-lg-1"> </th>
                                    </tr>
                                </thead>
                                <tbody id="max_input">
                                    <tr class="number_table" id="number_table0">
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" name="asigna[]">
                                                    <option selected disabled value="">*</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input name="torcuato[]" type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input name="Garay[]" type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" name="mascara">
                                                    <option selected disabled value="">*</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input name="reducida" type="text" class="form-control ">
                                            </div>
                                        </td>
                                        <td>
                                            <a class="ico_input btn btn-info"onclick="dele_table(0);"> <i class="fa fa-trash-o"> </i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>          
                    </fieldset>
                    <!-- modal 3 -->
                    <h1>Túneles IPSec</h1>
                    <fieldset>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vlan 1 Torcuato</label>
                                            <input id="vlan1" name="vlan1" type="text" class="form-control ">
                                         </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Red 1 Torcuato</label>
                                            <input id="red1" name="red1" type="text" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>OSPF Torcuato</label>
                                            <input id="OSPF" name="OSPF" type="text" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vlan 2 Torcuato</label>
                                            <input id="vlan2" name="vlan2" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Red 2 Torcuato</label>
                                            <input id="red2" name="red2" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vlan 1 Jonte</label>
                                            <input id="vlan01" name="vlan01" type="text" class="form-control ">
                                         </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Red 1 Jonte</label>
                                            <input id="red01" name="red01" type="text" class="form-control ">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>OSPF Jonte</label>
                                            <input id="OSPF01" name="OSPF01" type="text" class="form-control ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Vlan 2 Jonte</label>
                                            <input id="vlan02" name="vlan02" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label>Red 2 Jonte</label>
                                            <input id="red02" name="red02" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </fieldset>
                    <!-- modal 4 -->
                    <h1>Túneles IPSec</h1>
                    <fieldset>
                        <h2>Túneles IPSec</h2>
                        <div class="row">
                            
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Encripción</label>
                                        <input id="encripcion" name="encripcion" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Hash</label>
                                        <input id="hash" name="hash" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>Grupo</label>
                                        <input id="grupo" name="grupo" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label>Lifetime</label>
                                        <input id="lifetime" name="lifetime" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label>IKE</label>
                                        <input id="IKE" name="IKE" type="text" class="form-control ">
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>IP pública</label>
                                        <input id="ip_publica" name="ip_publica" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Pre-shared key</label>
                                        <input id="key" name="key" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>IP privada (detrás de un NAT)</label>
                                        <input id="ip_privada" name="ip_privada" type="text" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Red LAN</label>
                                        <input id="red_lan" name="red_lan" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Máscara</label>
                                        <input id="mascara" name="mascara" type="text" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Red de los pooles sumarizados</label>
                                        <input id="sumarizados" name="sumarizados" type="text" class="form-control ">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label>Máscara</label>
                                        <input id="mascara1" name="mascara1" type="text" class="form-control ">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <h1>Submit</h1>
                    <fieldset>
                        <h2>Terms and Conditions</h2>
                        <input id="acceptTerms" name="acceptTerms" type="checkbox" class="required"> <label for="acceptTerms">I agree with the Terms and Conditions.</label>
                    </fieldset>
                    </form>
                </div>
            <div class="modal-footer">
            </div> 
        </div>
    </div>
</div>
