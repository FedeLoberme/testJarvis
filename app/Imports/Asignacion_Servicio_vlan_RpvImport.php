<?php

namespace Jarvis\Imports;

use Jarvis\Asignacion_Servicio_Vlan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Asignacion_Servicio_vlan_RpvImport implements ToModel, WithChunkReading, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Asignacion_Servicio_Vlan([
            'id_service'  => $row['id_service'],
            'id_use_vlan' => $row['id_use_vlan'],
            'ctag'        => $row['ctag'],
            'estado'      => $row['estado'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

}
