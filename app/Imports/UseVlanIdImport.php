<?php

namespace Jarvis\Imports;

use Jarvis\EditUseVlanAux;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UseVlanIdImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EditUseVlanAux([
            'excel_id' => $row['id'],
            'excel_id_frontera' => $row['id_frontera']
        ]);
    }
}
