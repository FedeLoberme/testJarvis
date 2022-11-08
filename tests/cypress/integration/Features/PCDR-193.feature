Feature: Listado de fronteras
    Como usuario de agregación Ip se requiere contar con una pantalla para realizar la administración de las fronteras.
    Scenario: Visualizar Fronteras
        Given Un usuario con el perfil de Agregación IP, ingresó en el menú Admin Vlan, Sub menú fronteras.
        When El usuario ingresa en la pantalla
        Then El sistema muestra la lista con los campos "Nro de Frontera, Equipo PE/PEI, Bundle PE/PEI, Equipo DM/ SAR, Bundle DM / SAR, BW"
