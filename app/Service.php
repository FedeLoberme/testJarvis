<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Service extends Model
{
    protected $table = 'service';
    protected $fillable = ['number', 'id_type', 'bw_service', 'commentary', 'order_down','order_high', 'id_client', 'id_address_a', 'id_address_b', 'status', 'list_down', 'id_service', 'relation'];

    public function asignacion()
    {
        return $this->hasOne(Asignacion_Servicio_Vlan::class, 'id_service');
    }

}
