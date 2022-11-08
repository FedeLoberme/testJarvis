Feature: Reservas Upgrade de servicio
    #    Como usuario de consultoría se requiere contar con una pantalla para realizar una reservas para realizar el Upgrade de un servicio.
    Scenario: Crear reserva de Upgrade de un servicio activo.
        Given Un usuario de consultoría, ingresó en el menú Admin celda, Sub menú reservas.
        When El usuario clickea en crear reserva Upgrade
        And  selecciona el servicio activo: "5048415"
        Then El sistema carga el formulario de Upgrade los datos, celda, LINK, Cliente, tipo de servicio, estos datos no podrán ser modificables
        And habilita el campo Oportunidad para que el usuario lo ingrese
        And habilita el campo nuevo BW final del Servicio para que el usuario lo ingrese
        And actualiza el cuadro Información de celda al momento de reservar

    Scenario: Crear reserva de Upgrade de un servicio activo con bw mayor al actual.
        Given Un usuario de consultoría, ingresó en el menú Admin celda, Sub menú reservas.
        When El usuario clickea en crear reserva Upgrade
        And  selecciona el servicio activo: "5048415"
        And Completa el numero de oportunidad
        And Completa el BW final de servicio 10500 "Kbps"
        And Clickea Guardar
        Then El sistema verifica que el BW ingresado sea menor o igual al BW remanente
        And verifica que el bw ingresado sea mayor al del servicio
        And registra la reserva en la tabla RESERVE, donde BW_RESERVE será la diferencia entre el BW final ingresado por el usuario y el BW actual servicio.

    Scenario: Crear reserva de Upgrade de un servicio activo con bw menor al actual.
        Given Un usuario de consultoría, ingresó en el menú Admin celda, Sub menú reservas.
        When El usuario clickea en crear reserva Upgrade
        And  selecciona el servicio activo: "5048415"
        And Completa el numero de oportunidad
        And Completa el BW final de servicio 10000 "Kbps"
        And Clickea Guardar
        Then El sistema verifica que el BW ingresado sea menor o igual al BW remanente
        And verifica que el bw ingresado sea mayor al del servicio
        And El sistema emite un cartel indicando no es posible realizar una reserva para liberar ancho de banda.
        And No permite el guardado de la reserva.

