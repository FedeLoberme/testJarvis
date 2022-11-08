<?php

namespace Jarvis\Imports;

use Jarvis\Use_Vlan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class Use_Vlan_Int_BviImport implements ToModel, WithChunkReading, WithHeadingRow, WithBatchInserts
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
            'id_list_use_vlan'  => $row['id_list_use_vlan'],
            'id_equipment'      => $row['id_equipment'],
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
