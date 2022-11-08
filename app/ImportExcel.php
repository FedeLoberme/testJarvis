<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class ImportExcel extends Model
{
    protected $table = 'import_excels';
    protected $fillable = ['idagg', 'date', 'ip', 'hostname', 'interface', 'anillo', 'adminstatus', 'operstatus', 'descripcion', 'nombremodulo', 'descripmodulo', 'tipomodulo','distancia', 'fibra', 'cortalarga'];
}
