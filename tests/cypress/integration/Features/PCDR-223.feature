Feature: Modificación pantalla de Admin PE
    Como usuario de Agregación Ip se requiere agregar el campo Zona en las pantalla de Admin PE, para facilitar la administración en Admin Vlan.
    Scenario: Visualizar Equipos PE
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PE.
        When El usuario ingresa en la pantalla
        Then El sistema muestra la lista con los campos "Nodo CID, Acrónimo, Ip Gestión, Estado, Zona,  Comentario, Opciones"
    Scenario: Ingresa en la pantalla Crear Equipos PE
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PE.
        When El usuario hace click en el boton Nuevo PE
        Then El sistema en la pantalla Registrar PE
        And se visualizan los campos "Nodo, IR Alta, Acrónimo, Ip de gestión, Localización, Modelo, Comentario, Zona"
        And los botones Buscar nodo, Crear Nodo, Buscar Ip, Localización, buscar Modelo, Buscar Zona.
    Scenario: Crear Equipos PE
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PE.
        And Clickeó en el botón Nuevo PE
        When Ingresa el Nodo <Nodo>
        And Ingresa <IrAlta>
        And Ingresa <Acronimo>
        And Ingresa <IpGestion>
        And Ingresa <Modelo>
        And Ingresa <Placa>
        And Ingresa <Zona>
        And Pulsa Guardar
        Then el sistema verifica que los campos Nodo, IR Alta, Acrónimo, Ip Gestión, Modelo, Placa y Zona estén informado
        And Registrar PE, en la tabla de Equipos
        And Registra la Ip en la tabla de IPs


    Scenario: Ingresa Editar Equipos PE
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PE.
        When Selecciona Editar Equipo dentro de un equipo PE
        Then El sistema muestra la con titulo Editar PE
        And la información de los campos "Nodo, Ir Alta, Acrónimo, IP de Gestión, Localización, Modelo, Zona y Comentarios"
        And permite al usuario modificarlo.

    Scenario: Editar Equipos PE y chequeo campos obligatorios
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PE.
        And Ingreso en la pantalla de Editar PE
        When termina de realizar los cambios.
        And Pulsa Guardar
        Then el sistema verifica que los campos Nodo, IR Alta, Acrónimo, Ip Gestión y Zona estén informado
        And Registrar PE, en la tabla de Equipos
        And Registra la Ip en la tabla de IPs

