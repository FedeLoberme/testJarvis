<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class ImportStExcel extends Model
{
    protected $table = 'import_st_excels';
    protected $fillable = ['tecn', 'marca', 'codsap', 'codsap_anterior', 'descripcion', 'stock_benavidez', 'stock_cordoba', 'stock_mantenimiento', 'stock_proyectos', 'traslado_origen', 'oc_generada', 'stock_mimnimo','futuro_uso1', 'futuro_uso2', 'costo_uss'];
}
