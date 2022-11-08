Feature: Consultas a tabla nodos del Ledzite
  Scenario: Consultas de Sitios Ledzite  Jarvis
    Given Un usuario de ingeniería ingresa en el menu de inventario submenu Sitios Jarvis,  Ledzite
    When Consulta ingresa en la lista
    Then El sistema muestra los campos de la tabla NODELEDZITE: "Cell id, Nodo , Tipo, Estado, Fecha Contrato, Dueño, Comentario, SIT_CODIGO, CLU_CODIGO, GEO_ID, ALM_CODIGO, SIT_NOMBRE, SIT_LATITUD, SIT_LONGITUD, SIT_CALLE, SIT_NUMERO, SIT_ADDRESS, SIT_HSNM, SIT_PREFIJO_TELCO, SIT_PREFIJO_CTI, SIT_AREA_EXPLOTACION, SIT_COMMON_BCCH, SIT_OBSERVACIONES, SIT_COUBICACION, TSI_CODIGO, SIT_GSM, SIT_UMTS, SIT_ID_FIJA,LCC_ID,PRO_ID,SIT_NS_ACTIVO,SIT_NS_INTEGRADO,SIT_NS_TIPO_CELDA,SIT_NS_CI,CCN_ID, SIT_NS_CLASIFICACION,SIT_NS_CREACION,SIT_NS_ACTUALIZACION,LOCL_CODIGO,SIT_ESTADO,SIT_FECHA_CARGA,SIT_OWNER,SIT_FECHA_VENCIMIENTO,SIT_TIPO_ESTRUCTURA,SIT_LTE,SIT_FACTOR_FO,OPR_ID,TE_ID,SIT_TE_ALTURA,SIT_TE_CAMUFLAJE,SIT_TE_COMPARTIBLE,SIT_FECHA_BAJA,TIPOS_SOLUCIONES,SIT_FECHA_ALTA,SIT_GRANJA,SIT_ESTADO_AUX,SIT_DISTRIBUCION_SM_3G ,SIT_VIP,LOC_AREA_CODIGO,SIT_DISTRIBUCION_SM_4G,SIT_DISTRIBUCION_SM_2G,ALTURA_ESTRUCTURA,DATOS_ENLACE_TX_ID,SIT_UBICACION_TEC_MOVIL,SIT_UBICACION_TEC_FIJA,SIT_UBICACION_TEC_INMUEBLE,SIT_COUBICACION_OTROS_CLARO ,SIT_PAGA_TASA_RECURRENTE,SIT_FECHA_ALTA_MUNICIPIO,SIT_ALQUILADO,ORD_JUDICIALIZADA_HAB,ORD_JUDICIALIZADA_TASAS,SIT_RAN_SHARING,SIT_RAN_SHARING_PROVEEDOR,SIT_ROAMING,SIT_ROAMING_PROVEEDOR,SIT_PROPIETARIO,SIT_CODIGO_ANTERIOR ,SIT_FRONTERIZO "
  #  -------------------------------------------

  Scenario: Consuta un Sitio que no existe en Jarvis
    Given Un usuario de ingeniería ingresa en el menu de inventario submenu Sitios Jarvis,  Ledzite
    When Consulta el sitio "MI301"
    Then El sistema mostrará los campos de Sitios de Ledzite y colocara libres los campos de Jarvis

  #  -------------------------------------------
  Scenario: Consuta un Sitio que existe en Jarvis
    Given Un usuario de ingeniería ingresa en el menu de inventario submenu Sitios Jarvis,  Ledzite
    When Consulta el sitio "C2264"
    Then El sistema mostrará los campos de Sitios en particular, de acuerdo a la informacion que se posea en la tabla NODELEDZITE