Feature: Listado Asociaciones Agregadores
    Como usuario de agregación Ip se requiere contar con una pantalla para realizar la administración de loa agregadores.
    Scenario: Visualizar asociación de agregadores
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.
        When El usuario ingresa en la pantalla
        Then El sistema muestra la lista con los campos "Agregador,IP de Gestión, Zona Home, PE Home, PEI Home,  Zona Multihome, PE Multihome, PEI Multihome, Estado"

    Scenario: Alta de asociación
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú asociación agregadores.
        When cliqueo en el nueva asociación
        Then El sistema abre la pantalla de asociar agregador.