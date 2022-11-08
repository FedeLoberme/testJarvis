#alta de anillo, 
#selecciona nodo
#selecciona agregador
#va a agregar Vlan
#selecciona un uso que su comportamiento soporte Frontera. 
#El sistema ofrece una frontera, de las creadas en la asociacion de Agregador, Router PE /PEI (AGG_ASSOCIATION).
#El sistema ofrece la primer Vlan libre para esa Agregador Frontera

Feature: Alta de Vlan servicio
    Como usuario ingeniería de cliente, se requiere que al modificar los servicios de un LS se deberá contar un Modal de Alta de VLAN (filtrando únicamente los productos con comportamiento Frontera) para poder asignar una VLAN a dicho servicio
    Scenario: Creación de Vlan Sugerida por el sistema
        Given Un usuario con el perfil de ingeniería de cliente, ingresó en la pantalla de crear anillo y selecciono el nodo y el agregador.
        When Ingresa en Agregar Vlan
        And seleccionó un uso de Vlan con comportamiento Frontera.
        Then El sistema ofrece las Fronteras creadas en la asociacion Agregador Router (AGG_ASSOCIATION), para dicho router.
        And Ofrece la primera Vlan libre para dicho servicio / frontera en dicho agregador.

    Scenario: Creación ingresa una Vlan existente en la frontera del agregador.
        Given Un usuario con el perfil de ingeniería de cliente, ingresó en la pantalla asignar VLAN.
        When El usuario modifica la VLAN ingresando una utilizada.
        Then El sistema no permite la registración e indica que la VLAN no esta disponible.
    
     Scenario: Creación ingresa una Vlan no existente en la frontera del agregador.
        Given Un usuario con el perfil de ingeniería de cliente, ingresó en la pantalla asignar VLAN.
        When El usuario modifica la VLAN ingresando una no utilizada.
        Then El sistema reserva la VLAN. (tabla use_VLAN)
   