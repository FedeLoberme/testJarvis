Feature: Habilitar / deshabilitar agregador
    Como usuario de agregación ip se requiere tener la posibilidad de deshabilitar o Habilitar un agregador para permitir realizar mantenimientos en la misma.
    Scenario: Deshabilitar un agregador Activo.
        Given  Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.
        When Selecciona un agregador Activa (ALTA)
        And Pulsa en deshabilitar
        Then El sistema cambia el estado del agregador queda en Deshabilitado.
    Scenario: Habilitar un agregador, deshabilitado.
        Given  Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.
        When Selecciona un agregador deshabilitado
        And Pulsa en Activar
        Then El sistema cambia el estado del agregador a ALTA
    Scenario: Consultar estado de agregadores.
        Given  Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.
        When el usuario ingresa en la lista
        Then  El sistema muestra la lista con los campos "Agregador, Zona Home, equipo PE, Equipo PEI,  Zona Multihome, equipo PE MH, Equipo PEI MH, Estado"