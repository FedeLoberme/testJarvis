Feature: Administración de router SAR
    Como usuario de agregación Ip, se requiere contar con una pantalla para realizar el mantenimientos de los router SAR.
    Scenario: Visualizar Equipos SAR
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When El usuario ingresa en la pantalla
        Then El sistema muestra la lista con los campos "Nodo CID, Acrónimo, Ip Gestión, Estado, Zona,  Comentario, Opciones"
    Scenario: Ingresa en la pantalla Crear Equipos SAR
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When El usuario hace click en el boton Nuevo SAR
        Then El sistema en la pantalla Registrar SAR
        And se visualizan los campos "Nodo, IR Alta, Acrónimo, Ip de gestión, Localización, Modelo, Comentario, Zona"
        And los botones Buscar nodo, Crear Nodo, Buscar Ip, Localización, buscar Modelo, Buscar Zona.
    Scenario: Crear Equipos SAR
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        And Clickeó en el botón Nuevo SAR
        When Ingresa el Nodo <Nodo>
        And Ingresa <IrAlta>
        And Ingresa <Acronimo>
        And Ingresa <IpGestion>
        And Ingresa <Modelo>
        And Ingresa <Placa>
        And Ingresa <Zona>
        And Pulsa Guardar
        Then el sistema verifica que los campos Nodo, IR Alta, Acrónimo, Ip Gestion, Modelo, Placa y Zona esten informado
        And Registrar SAR, en la tabla de Equipos
        And Registra la Ip en la tabla de IPs


    Scenario: Ingresar Editar Equipos SAR
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona Editar Equipo dentro de un equipo SAR
        Then El sistema muestra la con titulo Editar SAR
        And la información de los campos "Nodo, Ir Alta, Acrónimo, IP de Gestión, Localización, Modelo, Zona y Comentarios"
        And permite al usuario modificarlo.

    Scenario: Editar Equipos SAR y chequeo campos obligatorios
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        And Ingreso en la pantalla de Editar SAR
        When termina de realizar los cambios.
        And Pulsa Guardar
        Then el sistema verifica que los campos Nodo, IR Alta, Acronimo, Ip Gestión y Zona estén informado
        And Registrar SAR, en la tabla de Equipos
        And Registra la Ip en la tabla de IPs

    Scenario: Visualizar las placas asignadas
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona Detalle de placas Asignadas dentro de un equipo SAR
        Then El sistema muestra una pantalla donde se visualizan las placas asignadas al equipo
        And los campos "Posición, Modelo, Tipo, Cantidad de puertos"
        And Visualiza al menos una placa.

    Scenario: Dar de baja un equipo Sar
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona  Equipo dentro de un equipo SAR
        Then El sistema solicita al usuario ingrese el numero de Orden de baja
        And Al usuario Guardar, Actualiza el estado a Baja

    Scenario: Visualizar equipo
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona Imagen del Equipo dentro de un equipo SAR
        Then El sistema muestra la imagen del equipo registrada en el sistema.

    Scenario: Administrar Puertos
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona Detalle Puerto dentro de un equipo SAR
        Then El sistema muestra la pantalla de Puertos donde el usuario puede administrar los mismos.
    Scenario: Agregar o Quita placas
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona Agregar y/o Quitar placas dentro de un equipo SAR
        Then El sistema muestra la pantalla AGREGAR Y/O QUITAR PLACA, con las placas existentes en el equipo.
    Scenario: Cambiar Modelo
        Given Un usuario con el perfil de Agregación IP, ingresó Admin Ip, Sub menú Admin SAR.
        When Selecciona Cambiar Modelo dentro de un equipo SAR
        Then El sistema muestra la pantalla Cambiar Modelo del Equipo