<?php

namespace Jarvis\Imports;

use Jarvis\ImportStExcel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockImport implements ToModel, WithHeadingRow

/* Asignación de nombre que vincula las columnas del Excel con el proyecto */

{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ImportStExcel([
            'tecn' => $row['tecn'],
            'marca' => $row['marca'],
            'codsap' => ($row['codsap_sinergia']),
            'codsap_anterior' => ($row['futuro_uso_1']),
            'descripcion' => $row['descripcion_completa'],
            'stock_benavidez' => $row['stock_de_inst_benavidez'],
            'stock_cordoba' => $row['stock_de_inst_cordoba'],
            'stock_mantenimiento' => $row['stock_mantenimiento'],
            'stock_proyectos' => $row['stock_proy_especiales'],
            'traslado_origen' => $row['en_traslado_desde_origen_std_esp'],
            'oc_generada' => $row['oc_generada_estandar_especial'],
            'stock_mimnimo' => $row['stock_minimo_reposicion'],
            'futuro_uso1' => $row['stock_devoluciones_benavidez'],
            'futuro_uso2' => $row['stock_devoluciones_cordoba'],
            'costo_uss' => $row['costo_us_nacionalizado'],
        ]);
    }
}
