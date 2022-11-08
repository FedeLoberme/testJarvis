<?php

namespace Jarvis\Imports;

use Jarvis\Use_Vlan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Use_VlanImport implements ToModel, WithChunkReading, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Use_Vlan([
            'id'                => $row['id'],
            'vlan'              => $row['vlan'],
            'id_list_use_vlan'  => $row['id_list_use_vlan'],
            'id_ring'           => $row['id_ring'],
            'id_frontera'       => $row['id_frontera'],
            'status'            => $row['status'],
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
