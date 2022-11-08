<?php

namespace Jarvis\Imports;

use Jarvis\ImportExcel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;

class PostsImport implements ToModel, WithHeadingRow, WithCalculatedFormulas, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
    public function model(array $row)
    {
        return new ImportExcel([
            'idagg' => strtoupper($row['id']),
            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date']),
            'ip' => $row['ip'],
            'hostname' => $row['hostname'],
            'interface' => strtoupper($row['interface']),
            'anillo' => $row['anillo'],
            'adminstatus' => $row['adminstatus'],
            'operstatus' => $row['operstatus'],
            'descripcion' => $row['descripcion'],
            'nombremodulo' => $row['nombre_modulo'],
            'descripmodulo' => $row['descrip_modulo'],
            'tipomodulo' => $row['tipo_modulo'],
            'distancia' => $row['distancia'],
            'fibra' => $row['fibra'],
            'cortalarga' => $row['corta_larga'],
        ]);
    }
}
