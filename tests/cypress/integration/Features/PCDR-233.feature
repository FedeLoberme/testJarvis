
Feature: Habilitar / deshabilitar Frontera.
    Como usuario de agregación ip se requiere tener la posibilidad de deshabilitar o Habilitar una frontera para permitir realizar mantenimientos en la misma.
    Scenario: Deshabilitar una Frontera Activa.
        Given  Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú Fronteras.
        When Selecciona una frontera Activa
        And Pulsa en deshabilitar
        Then El sistema cambia el estado de la frontera a Deshabilitada.
    Scenario: Habilitar una Frontera, deshabilitada.
        Given  Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú Fronteras.
        When Selecciona una frontera deshabilitada
        And Pulsa en Activar
        Then El sistema cambia el estado de la frontera a ALTA
    Scenario: Consultar estado de Fronteras.
        Given  Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú Frontera.
        When el usuario ingresa en la lista
        Then  El sistema muestra la lista con los campos "Nro de Frontera,  Equipo PE/PEI, Interfaz PE/PEI, Equipo DM/SAR, Interfaz DM/SAR, BW, Zona, Estado"