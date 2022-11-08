#language: es
Característica: Totales de Puertos por agregador
    Como usuario de Jarvis se requiere contar en el Dashboard un botón a modo semáforo con el control de los agregadores.
    Escenario: Estado de control de agregadores Críticos en rojo
        Dado Al ingresar en la pantalla de Dasboard
        Cuando Exista mas de 10 agregadores en estado crítico
        Entonces Se visualiza el control con color Rojo
        
    Escenario: Estado de control de agregadores Críticos en amarillo
        Dado Al ingresar en la pantalla de Dasboard
        Cuando Exista entre 5 y 10 agregadores en estado crítico
        Entonces Se visualiza el control con color amarillo    
    
    Escenario: Estado de control de agregadores Críticos en verde
        Dado Al ingresar en la pantalla de Dasboard
        Cuando Exista entre 0 y 5 agregadores en estado crítico
        Entonces Se visualiza el control con color verde
    
    Escenario: Visualizar Listado de Ocupación de agregadores
        Dado Al ingresar en la pantalla de Dasboard
        Cuando El usuario cliquea en el control
        Entonces Se visualiza el listado de ocupacion del agregador
        Y Abierto Por Puerto Giga y Puerto Tengiga se visualizan total de puertos vacantes, Total de anillos vacantes, % Ocupación, Estado     
    
    Escenario: Visualizar estado de un Agregador
        Dado Un usuario ingreso en el listado de ocupacion de agregadores
        Cuando El usuario visualiza el agregador "<val_agregador>"
        Entonces El estado del agregador es "<val_estado>"
        Y el % de ocupación es "<Val_ocupacion>"
#    Ejemplos:
#    |<val_agregador> | <val_estado> | <Val_ocupacion>  |
#    |B1076-AGG-01    | OK           |                  |
#    |                | Analizar     | entre 80 a 89,99 |
#    |                | Critico      | > 90 %           |    