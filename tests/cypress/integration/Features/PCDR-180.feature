Feature: Asociar Agregadores
@focus     Como usuario de agregación IP se requiere contar con una pantalla para permitir asociar un agregador con un equipo PE o PEI.
    Scenario Outline: Asociar agregador con roter PE/PEI desde pantalla de agregadores.
        Given El usuario de agregación IP, ingresó en la lista equipos agregadores al Agg "<Val_agregador>", cliqueo sobre el icono de asociar equipos e ingreso en la pantalla con el agregador seleccionado.
        When Ingresa el numero de Prefijo de frontera "<Val_Nro_frontera>"
        And selecciona una zona de la lista como ZONA HOME "<VAL_ZONA_HOME>"
        And se selecciona un router PE "<Val_PE>" de los perteneciente a la zona "<VAL_ZONA_HOME>" para ser asignado como router PE home
        And se selecciona un router PEI "<Val_PEI>" de los perteneciente a la zona "<VAL_ZONA_HOME>" para ser asignado como router PEI home
        And selecciona una de la lista una zona, como ZONA MULTIHOME HOME "<VAL_ZONA_MH>" distinta a la zona "<VAL_ZONA_HOME>"
        And se selecciona un router PE "<Val_PE_MH>" perteneciente a la zona "<VAL_ZONA_MH>" para ser asignado como router PE Multi home
        And se selecciona un router PEI "<Val_PEI_MH>" perteneciente a la zona "<VAL_ZONA_MH>" para ser asignado como router PEI Multi home
        Then a "<Resultado_esperado>"
Examples:
| Val_agregador | Val_Nro_frontera | VAL_ZONA_HOME | Val_PE       | Val_PEI        | VAL_ZONA_MH | Val_PE_MH    | Val_PEI_MH     |
|BA038-AGG-01 |004|Garay| TCF296-PE-02|TCF296-PEI-01|Olleros|TC2470-PE-03|TCF2470-PEI-04|
|BA123-AGG-01|003|Garay|TCF296-PE-02|TCF296-PEI-01|Olleros|TC2470-PE-03|TCF2470-PEI-04|



#    Example:
#
#            | Descripción caso                                                                                       | Val_agregador | Val_Nro_frontera | VAL_ZONA_HOME | Val_PE       | Val_PEI        | VAL_ZONA_MH | Val_PE_MH    | Val_PEI_MH     |
#            | Router PE y PEI home olleros y MH de Garay, distinta frontera                                          | AGREGADOR1    | 430              | olleros       | TC2470-PE-04 | TCF2470-PEI-04 | garay       | TCF296-PE-02 | TCF296-PEI-01  |
#            | Router PE de olleros, Equipo PEI de Garay en HOME y MH equipos de olleros distintos, distinta frontera | AGREGADOR2    | 431              | olleros       | TC2470-PE-04 | TCF296-PEI-01  | garay       | TCF296-PE-02 | TCF296-PEI-02  |
#            | Router PE y PEI home olleros y mismos router para MH, distinta frontera                                | AGREGADOR3    | 432              | olleros       | TC2470-PE-04 | TCF2470-PEI-04 | olleros     | TC2470-PE-04 | TCF2470-PEI-04 |
#            | Router PE y PEI home olleros y MH de Garay, misma frontera ya cargada                                  | AGREGADOR4    | 430              | olleros       | TC2470-PE-04 | TCF2470-PEI-04 | olleros     | TCF296-PE-02 | TCF296-PEI-01  |
#            | Router PE y PEI home olleros y routers MH de Garay, mismo nombre del agregador distinta frontera       | AGREGADOR1    | 434              | olleros       | TC2470-PE-04 | TCF2470-PEI-04 | olleros     | TCF296-PE-02 | TCF296-PEI-01  |
#            | Router PE y PEI home olleros y zona MH de Garay, sin agregar PE PI de zona multihome distinta frontera | AGREGADOR5    | 435              | olleros       | TC2470-PE-04 | TCF2470-PEI-04 | garay       |              |                |
#AGREGADOR5      436