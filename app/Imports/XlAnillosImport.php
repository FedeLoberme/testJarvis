<?php

namespace Jarvis\Imports;

use Jarvis\XlAnillo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DB;


class XlAnillosImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    /*public function sheets(): array
    {
        return [
            0 => $this,
        ];
    }
    public function headingRow(): int
    {
        return 3;
    }*/


    public function model(array $row)
    {
        //Acronimo sw Vacante
        /*if($row['acronimo_sw'] === 'VACANTE'){
              return null;
        } else if ($row['acronimo_sw'] == null || $row['acronimo_sw'] == ''){
            $row['acronimo_sw'] = $row['acronimo_clienteacro_sw_viejo'];
        }

        //Acronimo sw viejo inexistente
        if($row['acronimo_clienteacro_sw_viejo'] == ''){
            return null;
        }
        */
        //Para arreglar el 'celdas compartidas en capacidad y bw anillo'
        // if($row['bw_anillombps'] == ''){
        //     $row['bw_anillombps'] == DB::table('xl_anillos')->latest('bw_anillo')->first();
        // }

        return new XlAnillo([
            'anillo' => $row['anillo'],
            'bw_anillo' => $row['bw_anillombps'],
            'acronimo_sw' => $row['acronimo_sw'],
            'bwcpe' => $row['bw_cpembps'],
            'capacidad' => $row['capacidadgbps'],
            'ic_alta' => $row['ic_alta'],
            'cliente' => $row['cliente'],
            'direccion' => $row['direccion'],
            'sw_viejo' => $row['acronimo_clienteacro_sw_viejo'],
            'ip_gestion' => $row['ip_gestion'],
            'vlan_gestion' => $row['vlan_gestion'],
            'by_pass' => $row['by_passoptico_dwdm'],
            'modelo' => $row['modelo_equipo'],
            'bw_migrado' => $row['bw_migradombps'],
            'ic_01' => $row['ic_01'],
            'bw_01' => $row['bw_01mbps'],
            'ic_02' => $row['ic_02'],
            'bw_02' => $row['bw_02mbps'],
            'ic_03' => $row['ic_03'],
            'bw_03' => $row['bw_03mbps'],
            'ic_04' => $row['ic_04'],
            'bw_04' => $row['bw_04mbps'],
            'ic_05' => $row['ic_05'],
            'bw_05' => $row['bw_05mbps'],
            'ic_06' => $row['ic_06'],
            'bw_06' => $row['bw_06mbps'],
            'ic_07' => $row['ic_07'],
            'bw_07' => $row['bw_07mbps'],
            'ic_08' => $row['ic_08'],
            'bw_08' => $row['bw_08mbps'],
            'ic_09' => $row['ic_09'],
            'bw_09' => $row['bw_09mbps'],
            'ic_10' => $row['ic_10'],
            'bw_10' => $row['bw_10mbps'],
            'ic_11' => $row['ic_11'],
            'bw_11' => $row['bw_11mbps'],
            'ic_12' => $row['ic_12'],
            'bw_12' => $row['bw_12mbps'],
            'ic_13' => $row['ic_13'],
            'bw_13' => $row['bw_13mbps'],
            'ic_14' => $row['ic_14'],
            'bw_14' => $row['bw_14mbps'],
            'ic_15' => $row['ic_15'],
            'bw_15' => $row['bw_15mbps'],
            'ic_16' => $row['ic_16'],
            'bw_16' => $row['bw_16mbps'],
            'ic_17' => $row['ic_17'],
            'bw_17' => $row['bw_17mbps'],
            'ic_18' => $row['ic_18'],
            'bw_18' => $row['bw_18mbps'],
            'ic_19' => $row['ic_19'],
            'bw_19' => $row['bw_19mbps'],
            'ic_20' => $row['ic_20'],
            'bw_20' => $row['bw_20mbps'],
            'ic_21' => $row['ic_21'],
            'bw_21' => $row['bw_21mbps'],
            'ic_22' => $row['ic_22'],
            'bw_22' => $row['bw_22mbps'],
            'ic_23' => $row['ic_23'],
            'bw_23' => $row['bw_23mbps'],
            'ic_24' => $row['ic_24'],
            'bw_24' => $row['bw_24mbps'],
            'ic_25' => $row['ic_25'],
            'bw_25' => $row['bw_25mbps'],
            'ic_26' => $row['ic_26'],
            'bw_26' => $row['bw_26mbps'],
            'ic_27' => $row['ic_27'],
            'bw_27' => $row['bw_27mbps'],
            'ic_28' => $row['ic_28'],
            'bw_28' => $row['bw_28mbps'],
        ]);
        

    }
    
    public function chunkSize(): int
    {
        return 10;
    }

}