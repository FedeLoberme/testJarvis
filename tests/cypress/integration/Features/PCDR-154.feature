Feature: Alta de Fronteras
    Como usuario de agregación Ip se requiere contar con una pantalla para realizar la administración de las fronteras.
    Scenario: Creación de Frontera con numero sugerido
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras para crear una frontera.
        When El usuario clickea en nueva frontera
        And utilizar la próxima frontera libre sugerida por el sistema 556
        And elige el tipo de frontera "Metro"
        And elige el tipo de Servicio "RPV"
        Then El sistema habilita la carga de los campos "ZONA, Router PE, Puerto PE, router DM, Puerto DM"
    #-----------------------------------------------------------------------------
    Scenario: Creación de Frontera con numero sugerido
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras para crear una frontera.
        When El usuario clickea en nueva frontera
        And utilizar la próxima frontera libre sugerida por el sistema 556
        And elige el tipo de frontera "Metro"
        And elige el tipo de Servicio "Internet"
        Then El sistema habilita la carga de los campos "ZONA, Router PE, Puerto PE, router DM, Puerto DM"
    #------------------------------------------------------------------------------
    Scenario: Creación de Frontera con numero sugerido
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras para crear una frontera.
        When El usuario clickea en nueva frontera
        And utilizar la próxima frontera libre sugerida por el sistema 556
        And elige el tipo de frontera "AL"
        And elige el tipo de Servicio "RPV"
        Then El sistema habilita la carga de los campos "ZONA, Router PE Puerto PE, Router SAR, Puerto SAR"
    #------------------------------------------------------------------------------
    Scenario: Creación de Frontera con numero sugerido
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras para crear una frontera.
        When El usuario clickea en nueva frontera
        And utilizar la próxima frontera libre sugerida por el sistema 556
        And elige el tipo de frontera "AL"
        And elige el tipo de Servicio "Internet"
        Then El sistema habilita la carga de los campos "ZONA, Router PEI, Puerto PEI, router SAR, Puerto SAR"
    #------------------------------------------------------------------------------
    Scenario: Selección de router de acuerdo a la zona
        Given El usuario de agregación IP, ya seleccionó el tipo de Frontera y el tipo de servicio en la pantalla Alta de frontera.
        When elige una zona,
        Then El sistema carga las listas de los router con los equipos habilitados en la zona.
    #--------------------------------------------------------------------------------
    Scenario: Seleccionar un Router
        Given El usuario de agregación IP, ya seleccionó el router
        When elige un Router
        Then el sistema muestra los puertos del equipos
    Scenario: Crear Bundle y calcula el bw de la frontera
        Given El usuario de agregación IP, ya seleccionó los puertos del Router
        When Se para en el campo Nombre de la interfaz
        Then el sistema sugiere el nombre compuesto por Bundle-Ether mas el numero de frontera
        And Calcula el BW de la frontera, igual a la suma de los BW de los distintos puertos


    Scenario: Aceptar creación de Frontera
        Given El usuario de agregación IP, cargo todos los datos requeridos.
        When pulsa Aceptar
        Then El sistema realiza la validación de puertos
        And graba la frontera en la base


    Scenario: Validación de Puertos: diferencia en cantidad
        Given El usuario de agregación Ip, seleccionó distinta cantidad de puertos en el Router PE PEI que los seleccionados en el DM SAR
        When pulsa Aceptar
        Then el sistema emite una alerta que indicando que no coinciden la cantidad de puertos entre ambos extremos


    Scenario: Validación de Puertos: diferencia BW total de puertos
        Given El usuario de agregación Ip, seleccionó distinta capacidad de puertos en el Router PE PEI que en los elegidos en el DM SAR
        When pulsa Aceptar
        Then el sistema emite una alerta que indicando que no coinciden la capacidad de puertos entre ambos extremos


    #---------------------------------------------------------------


    Scenario: Creación de una frontera particular
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras
        And Se encuentra dentro de la pantalla de alta de frontera
        When modifica el numero de frontera 429
        Then El sistema Permite continuar con la carga.


    #-----------------------------------------------------------------------
    Scenario: Creación de una frontera particular
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras
        And Se encuentra dentro de la pantalla de alta de frontera
        When modifica el numero de frontera 430
        Then El sistema emite una alerta de Frontera existente y no permite continuar con la carga.


    #--------------------------------------------------------------------------


    Scenario: Salir del alta de frontera
        Given usuario con el perfil de Agregación IP dentro de la pantalla de alta de frontera
        When pulsa en el botón Cancelar
        Then El sistema descarta la información ingresada hasta el momento
        And sale de la pantalla Alta de frontera