#language: es
Característica: Listar Servicios utilizados por un Uplink
    Como usuario de calidad de red se requiere contar con un acceso en el listado de Uplinks para listar
    todos los servicios relacionados con el Uplink consultado.
    Escenario: Listar servicios de un Uplink
        Dado usuario ingresa en la lista LINK UPLINK CELDA.
        Cuando El usuario se posiciona en el Uplink "AM008-1"
        Y Ingresa en la Opcion de Listar servicios
        Entonces Se ingresa en la pantalla listar Servicios
        Y es "visible" la lista de servicios con las columnas "Etiqueta, Vlan, Numero, BW, Cliente"
# Ejemplos:
#|<Var_Uplink> |   <var_resultado_visualizacion> |
#| AM008-1     |  be.visible |
# | AM010-1     |  not.exist |
    Escenario: El Uplink no posee servicios
        Dado usuario ingresa en la lista LINK UPLINK CELDA.
        Cuando El usuario se posiciona en el Uplink "AM010-1"
        Y Ingresa en la Opcion de Listar servicios
        Entonces Se ingresa en la pantalla listar Servicios
        Y es "no visible" la lista de servicios con las columnas "Etiqueta, Vlan, Numero, BW, Cliente"

        Escenario: Listar servicios de un Uplink
        Dado usuario ingresa en la lista LINK UPLINK CELDA.
        Cuando El usuario se posiciona en el Uplink "AP015-1"
        Y Ingresa en la Opcion de Listar servicios
        Entonces Se ingresa en la pantalla listar Servicios
        Y es "no visible" la lista de servicios con las columnas "Etiqueta, Vlan, Numero, BW, Cliente"