<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Asignacion_Servicio_Vlan extends Model
{
    protected $table = 'asignacion_servicio_vlan';
    protected $fillable = ['id_service', 'id_use_vlan', 'ctag', 'usuario', 'estado'];
}
