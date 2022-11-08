Feature: Asociar Agregadores
    Como usuario de agregación IP se requiere contar con una pantalla para permitir asociar un agregador con un equipo PE o PI.
    Scenario: Asociar agregador con roter PE/PI desde la lista de asociación de agregadores.
        Given El usuario de agregación IP, ingresó en el menú admin Vlan, sub menu lista asociacion agregadores.
        When Clickea en alta nueva asociacion
        And selecciona un agregador <Val_agregador> de la lista de agregadores
        And selecciona una zona de la lista como ZONA HOME <VAL_ZONA_HOME>
        And se selecciona un router PE <Val_PE> de los perteneciente a la zona <VAL_ZONA_HOME> para ser asignado como router PE home
        And se selecciona un router PI <Val_PEI> de los perteneciente a la zona <VAL_ZONA_HOME> para ser asignado como router PEI home
        And selecciona una de la lista una zona, como ZONA MULTIHOME HOME <VAL_ZONA_MH> distinta a la zona <VAL_ZONA_HOME>
        And se selecciona un router PE <Val_PE_MH> perteneciente a la zona <VAL_ZONA_MH> para ser asignado como router PE Multi home (MH)
        And se selecciona un router PI <Val_PEI_MH> perteneciente a la zona <VAL_ZONA_MH> para ser asignado como router PEI Multi home (MH)
        Then <Resultado_esperado>
Example: 
Descripción caso                                                                                        |Val_agregador  |VAL_ZONA_HOME  |Val_PE      |Val_PEI           |VAL_ZONA_MH|Val_PE_MH      |Val_PEI_MH     |Resultado_esperado
Router PE y PEI home olleros y MH de Garay, distinta frontera                                           |AGREGADOR1     |olleros        |TC2470-PE-04|TCF2470-PEI-04    |garay      |TCF296-PE-02   |TCF296-PEI-01  |se da de alta la asociación
Router PE de olleros, Equipo PEI de Garay en HOME y MH equipos de olleros distintos, distinta frontera  |AGREGADOR2     |olleros        |TC2470-PE-04|TCF296-PEI-01     |garay      |TCF296-PE-02   |TCF296-PEI-02  |No debería estar disponible el router TCF296-PEI-01 para ser utilizado como equipo pei en Home, ya que pertenece a una zona distinta a la zona <VAL_ZONA_HOME>. no se efectua el alta
Router PE y PEI home olleros y mismos router para MH, distinta frontera                                 |AGREGADOR3     |olleros        |TC2470-PE-04|TCF2470-PEI-04    |olleros    |TC2470-PE-04   |TCF2470-PEI-04 |No se pueden seleccionar Routers de la misma zona home en la zona Multi home, por lo cual no van a estar disponibles.
Router PE y PEI home olleros y routers MH de Garay, mismo nombre del agregador distinta frontera	    |AGREGADOR1     |olleros        |TC2470-PE-04|TCF2470-PEI-04    |olleros    |TCF296-PE-02   |TCF296-PEI-01  |El sistema indica que la Relación existe previamente.
Router PE y PEI home olleros y zona MH de Garay, sin agregar PE PI de zona multihome distinta frontera  |AGREGADOR5     |olleros    	|TC2470-PE-04|TCF2470-PEI-04	|garay      |               |               |El sistema indica que no se puede dar de alta ya que falta informar Routers
                                                                                                         AGREGADOR5      436      