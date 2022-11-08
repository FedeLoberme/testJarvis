<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Module extends Model
{
    protected $table = 'module';
    protected $fillable = ['nombre_modulo', 'tipo_modulo', 'distancia', 'fibra', 'corta_larga'];
}
