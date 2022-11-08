
Feature: Como usuario de ingeniería al cliente se requiere que en las pantallas que se deba ingresar un BW el sistema lo coloque sin datos y solicite al usuario que los cargue, para  evitar errores en el mantenimiento de la información.
    Scenario: Crear una nueva reserva.
        Given Un usuario de ingeniería al cliente, ingresó en el menú Admin Celdas, Sub menú reservas, para crear una reserva.

        When El usuario cliquea en crear una reserva

        Then El sistema muestra en 0 el BW y la unidad en "seleccionar".

        And El sistema solicita que ingrese capacidad y Unidad para registrar la solicitud



    Scenario:  Crear un nuevo servicio
        Given Un usuario de ingeniería al cliente, ingresó en el menú inventario -> administrativo -> Servicios

        When El usuario cliquea en Nuevo Servicio

        Then El sistema muestra en 0 el Ancho de banda y la unidad en "seleccionar".

        And  El sistema solicita que ingrese capacidad y Unidad para registrar el servicio

    Scenario: Crear una nueva reserva sobre un servicio.
        Given Un usuario de ingeniería al cliente, ingresó en el menú Admin Celdas, Sub menú reservas, para crear una reserva sobre servicio.

        When El usuario cliquea en crear una reserva sobre servicio

        Then El sistema muestra en 0 el BW y la unidad en "seleccionar".

        And El sistema solicita que ingrese capacidad y Unidad para registrar la solicitud upgrade