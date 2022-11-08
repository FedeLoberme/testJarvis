<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Constants extends Model
{
    //CREO EL MODELO DE CONSTANTS PARA ESTABLECER LAS CONSTANTES QUE SE NECESITEN


    // *** servicios ***

    //ASIGNACION_SERVICIO_VLAN

    const SERVICE_TYPE_ASSIGNED   = 'ASIGNADO';
    const SERVICE_TYPE_UNASSIGNED = 'DESASIGNADO';

    //LIST_USE_VLAN
    //Services types

    const VLAN_TYPE_GESTION_LS           = 1;
    const VLAN_TYPE_GESTION_RADIO        = 2;
    const VLAN_TYPE_INTERNET_WAN         = 3;
    const VLAN_TYPE_RPV_Y_TIP            = 4;
    const VLAN_TYPE_RPV_MH               = 5;
    const VLAN_TYPE_INTERNET_BV          = 6;
    const VLAN_TYPE_GESTION_ANILLO_IPRAN = 7;
    const VLAN_TYPE_GESTION_RADIO_IPRAN  = 8;
    const VLAN_TYPE_INTERNET_WAN_DS      = 9;
    const VLAN_TYPE_L2L_MP               = 10;
    const VLAN_TYPE_INTERNET_BV_DS       = 11;

    const VLAN_TYPES = [
      self::VLAN_TYPE_GESTION_LS           => 'Gestión LS',
      self::VLAN_TYPE_GESTION_RADIO        => 'Gestión Radio',
      self::VLAN_TYPE_INTERNET_WAN         => 'Internet WAN',
      self::VLAN_TYPE_RPV_Y_TIP            => 'RPV y TIP',
      self::VLAN_TYPE_RPV_MH               => 'RPV MH',
      self::VLAN_TYPE_INTERNET_BV          => 'Internet BV',
      self::VLAN_TYPE_GESTION_ANILLO_IPRAN => 'Gestión Anillo IPRAN',
      self::VLAN_TYPE_GESTION_RADIO_IPRAN  => 'Gestión Radio IPRAN',
      self::VLAN_TYPE_INTERNET_WAN_DS      => 'Internet WAN DS',
      self::VLAN_TYPE_L2L_MP               => 'L2L MP',
      self::VLAN_TYPE_INTERNET_BV_DS       => 'Internet BV DS'
    ];


    //tipos de vlan en LIST_USE_VLAN: list_use_vlan->ctag = si lleva o no lleva ctag

    const VLAN_USE_CTAG  = 'SI';
    const VLAN_NO_CTAG   = 'NO';
    const VLAN_CTAG_LIST = [
      self::VLAN_USE_CTAG  => 'La vlan no lleva ctag',
      self::VLAN_NO_CTAG   => 'La vlan lleva ctag'
    ];

    //USE_VLAN

    const USE_VLAN_STATUS_ASSIGNED   = 'ASIGNADO';
    const USE_VLAN_STATUS_UNASSIGNED = 'DESASIGNADO';



    /** EQUIPMENT MODEL (radios y demas) (tabla list_mark)*/

    const EQUIPMENT_MODEL_CISCO   = 1;
    const EQUIPMENT_MODEL_HUAWEI  = 2;
    const EQUIPMENT_MODEL_NOKIA   = 3;
    const EQUIPMENT_MODEL_GENERIC = 4;
    const EQUIPMENT_MODEL_AVIAT   = 61;

    const EQUIPMENT_MODELS_LIST = [
        self::EQUIPMENT_MODEL_CISCO   => 'Equipo modelo Cisco',
        self::EQUIPMENT_MODEL_HUAWEI  => 'Equipo modelo Huawei',
        self::EQUIPMENT_MODEL_NOKIA   => 'Equipo modelo Nokia',
        self::EQUIPMENT_MODEL_GENERIC => 'Equipo modelo Genérico',
        self::EQUIPMENT_MODEL_AVIAT   => 'Equipo modelo Aviat',
    ];

    /** EQUIPMENT MODEL (radios y demas) (tabla list_mark)*/

    const OCCUPIED_PORT      = 1;
    const NOT_OCCUPIED_PORT  = 2;

    const PORT_OCCUPATION = [
        self::OCCUPIED_PORT      => 'Puerto ocupado',
        self::NOT_OCCUPIED_PORT  => 'Puerto no ocupado',
    ];

    /** APPLICATIONS IDS */

    const APPLICATION_TYPE_USER                       = 1;
    const APPLICATION_TYPE_PERFIL                     = 2;
    const APPLICATION_TYPE_HISTORIAL                  = 3;
    const APPLICATION_TYPE_CLIENTES                   = 4;
    const APPLICATION_TYPE_MODELO                     = 5;
    const APPLICATION_TYPE_PUERTO                     = 6;
    const APPLICATION_TYPE_AGG                        = 7;
    const APPLICATION_TYPE_CPE                        = 8;
    const APPLICATION_TYPE_PE                         = 9;
    const APPLICATION_TYPE_NODO                       = 10;
    const APPLICATION_TYPE_ANILLO                     = 11;
    const APPLICATION_TYPE_UPLINK                     = 12;
    const APPLICATION_TYPE_LANSWITCH                  = 13;
    const APPLICATION_TYPE_DIRECCION                  = 14;
    const APPLICATION_TYPE_SERVICIO                   = 15;
    const APPLICATION_TYPE_ADMIN_IP                   = 16;
    const APPLICATION_TYPE_IMPORTAR                   = 17;
    const APPLICATION_TYPE_LISTA                      = 18;
    const APPLICATION_TYPE_DM                         = 19;
    const APPLICATION_TYPE_PEI                        = 20;
    const APPLICATION_TYPE_APN                        = 21;
    const APPLICATION_TYPE_CADENA                     = 22;
    const APPLICATION_TYPE_RADIO                      = 23;
    const APPLICATION_TYPE_LINK                       = 24;
    const APPLICATION_TYPE_RESERVAS                   = 25;
    const APPLICATION_TYPE_UPLINK_IPRAN               = 26;
    const APPLICATION_TYPE_SAR                        = 27;
    const APPLICATION_TYPE_VLAN_RANGOS                = 28;
    const APPLICATION_TYPE_FRONTERA                   = 29;
    const APPLICATION_TYPE_ASOCIACION_AGG             = 30;
    const APPLICATION_TYPE_LEDZITE                    = 31;
    const APPLICATION_TYPE_ASIGNACION_SERVICIO        = 32;
    const APPLICATION_TYPE_ASIGNACION_SERVICIO_MANUAL = 33;

    /**
     * en caso de necesitarse una lista o una explicacion mas detallada, se puede agrupar de la siguiente forma
     *
     * const SERVICE_TYPE_LIST = [
        self::SERVICE_TYPE_ASSIGNED => 'Asignado',
        self::SERVICE_TYPE_UNASSIGNED => 'Desasignado'
    ];**/
}
