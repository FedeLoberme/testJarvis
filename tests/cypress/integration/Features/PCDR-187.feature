Feature: Aplicar Reserva de Upgrade de servicio

    Un ingeniero de cliente ingresa en la reserva y tiene la posibilidad de cliquear en aplicar la reserva
    y se realizar el Upgrade en el servicio.

    Scenario: Aplicar reserva Vigente
        Given Un ingeniero de Cliente ingreso dentro del menu de Admin celda -> Reservas
        And Consulto en una reserva de Upgrade en estado Vigente
        When Cliquea en aplicar Reserva
        Then El sistema marca la reserva como Asignada
        And cambia el BW con el BW final a aplicar de la reserva.


    Scenario: Aplicar reserva no Vigente
        Given Un ingeniero de Cliente ingreso dentro del menu de Admin celda -> Reservas
        And Consulto en una reserva de Upgrade en estado  distinto a Vigente
        When Intenta Cliquear en aplicar Reserva
        Then Se muestra la reserva
        But el boton de aplicar reserva no esta disponible.