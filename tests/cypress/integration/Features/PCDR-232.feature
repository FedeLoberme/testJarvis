Feature: Modificar descripción en asociación Agregador
    Como usuario de agregación Ip se requiere modificar el nombre que actualmente figura como prefijo frontera por Prefijo agregador. 
    Scenario: Deshabilitar una Frontera, Activa.
        Given Un usuario con el perfil de Agregación IP, ingresó la pantalla Relacionar AGG con PE-PEI
        When Un agregador es elegido
        Then El sistema muestra los dato de IP de gestión del agregador y el campo Prefijo del agregador, ultimo octeto de la ip de gestión.