#language: es
Característica: Reservas, show user
    Como usuario de Jarvis se requiere que en la lista de reservas se debe listar el usuario que realizó la reserva.
    Escenario: Listar reservas
        Dado Un usuario ingresa en el Listado Reservas
        Cuando El usuario visualiza la lista de reservas
        Entonces Se ven las columnas "Nro Reserva, Bw Reserva, Estado, Usuario, Fecha de Inicio, Dias restantes, Oportunidad, Nodo, Nro Servicio, Comentario"