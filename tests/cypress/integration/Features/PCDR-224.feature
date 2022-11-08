Feature: Modificación pantalla de Admin PEI
    Como usuario de Agregación Ip se requiere agregar el campo Zona en las pantalla de Admin PEI, para facilitar la administración en Admin Vlan.
    Scenario: Visualizar Equipos PEI
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PEI.
        When El usuario ingresa en la pantalla
        Then El sistema muestra la lista con los campos "Nodo CID, Acrónimo, Ip Gestión, Estado, Zona,  Comentario, Opciones"
    Scenario: Ingresa en la pantalla Crear Equipos PEI
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PEI.
        When El usuario hace click en el boton Nuevo PEI
        Then El sistema en la pantalla Registrar PEI
        And se visualizan los campos "Nodo, IR Alta, Acrónimo, Ip de gestión, Localización, Modelo, Comentario, Zona"
        And los botones Buscar nodo, Crear Nodo, Buscar Ip, Localización, buscar Modelo, Buscar Zona.
    Scenario: Crear Equipos PEI
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PEI.
        And Clickeó en el botón Nuevo PEI
        When Ingresa el Nodo <Nodo>
        And Ingresa <IrAlta>
        And Ingresa <Acronimo>
        And Ingresa <IpGestion>
        And Ingresa <Modelo>
        And Ingresa <Placa>
        And Ingresa <Zona>
        And Pulsa Guardar
        Then el sistema verifica que los campos Nodo, IR Alta, Acrónimo, Ip Gestión, Modelo, Placa y Zona estén informado
        And Registrar PEI, en la tabla de Equipos
        And Registra la Ip en la tabla de IPs


    Scenario: Ingresa Editar Equipos PEI
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PEI.
        When Selecciona Editar Equipo dentro de un equipo PEI
        Then El sistema muestra la con titulo Editar PEI
        And la información de los campos "Nodo, Ir Alta, Acrónimo, IP de Gestión, Localización, Modelo, Zona y Comentarios"
        And permite al usuario modificarlo.

    Scenario: Editar Equipos PEI y chequeo campos obligatorios
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin PEI.
        And Ingreso en la pantalla de Editar PEI
        When termina de realizar los cambios.
        And Pulsa Guardar
        Then el sistema verifica que los campos Nodo, IR Alta, Acrónimo, Ip Gestión y Zona estén informado
        And Registrar PEI, en la tabla de Equipos
        And Registra la Ip en la tabla de IPs

