<?php

namespace Jarvis;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Jarvis\Imports\Asignacion_Servicio_Vlan_IntImport;
use Jarvis\Imports\Use_Vlan_Int_BviImport;
use Jarvis\Imports\Use_VlanImport;
use Jarvis\Imports\UseVlanIdImport;
use Jarvis\Imports\Use_Vlan_IntImport;
use Maatwebsite\Excel\Facades\Excel;

class Functions extends Model
{
    // creating this model to write scripts that we need to run in server

    public function store_vlan_excel_data_11_07_2022()
    {
        Excel::import(new UseVlanIdImport, 'ID_Vlan-ID_Frontera.xlsx');

        return true;
    }

    public function edit_vlan_11_07_2022()
    {
        $excelData = EditUseVlanAux::all();
        $actualUseVlanData = Use_Vlan::all();

        foreach ($excelData as $key => $excelVlan) {
            $actualUseVlanToBeChanged = $actualUseVlanData->where('id', $excelVlan->excel_id)->first();

            if(isset($actualUseVlanToBeChanged)){
                $actualUseVlanToBeChanged->update([
                    'id_frontera' => $excelVlan->excel_id
                ]);
            }
        }
    }

    /**
     *
     *
     * Import data from use_vlan excel made by Guille called use_vlan_rpv and storing it in new records of use_vlan table
     * Even saving it in a new table called use_vlan_import_ids to recover the ID info of those records in use_vlan table
     *
     * The new db table may contain
     * ID_IN_USE_VLAN_TABLE | VLAN | ID_LIST_USE_VLAN | ID_RING | ID_NODE | ID_EQUIPMENT | ID_FRONTERA | STATUS
     *
     * @return string
     */

    public function store_use_vlan_rpv_excel_data_18_10_2022()
    {
        try {
            $collection = Excel::toArray(new Use_VlanImport, 'USE_VLAN_RPV.xlsx');

            foreach ($collection[0] as $index=>$collect){
                $use_vlan                       = new Use_Vlan();
                $use_vlan->vlan                 = $collect['vlan'];
                $use_vlan->id_list_use_vlan     = $collect['id_list_use_vlan'];
                $use_vlan->id_ring              = $collect['id_ring'];
                $use_vlan->id_node              = null;
                $use_vlan->id_equipment         = null;
                $use_vlan->id_frontera          = $collect['id_frontera'];
                $use_vlan->status               = $collect['status'];
                $use_vlan->save();

                $use_vlan_import_ids                        = new UseVlanImportIds();
                $use_vlan_import_ids->id_in_use_vlan_table  = $use_vlan->id;
                $use_vlan_import_ids->vlan                  = $collect['vlan'];
                $use_vlan_import_ids->id_list_use_vlan      = $collect['id_list_use_vlan'];
                $use_vlan_import_ids->id_ring               = $collect['id_ring'];
                $use_vlan_import_ids->id_node               = null;
                $use_vlan_import_ids->id_equipment          = null;
                $use_vlan_import_ids->id_frontera           = $collect['id_frontera'];
                $use_vlan_import_ids->status                = $collect['status'];
                $use_vlan_import_ids->save();
            }

            return 'Records added successfully in use_vlan and use_vlan_import_ids';

        } catch (Exception $e){
            return $e->getMessage();
        }

    }

    /**
     *
     *
     * Fixing "id_ring" set as null in use_vlan_rpv massive import
     *  Searching for the ids existing in use_vlan_import_ids (table created from the import)
     * Deleting every record founded
     * After that, run a new import with the correct data
     *
     * ASK IF IDS MAY COINCIDE BOTH IN TESTING AND PRODUCTION
     * @return string
     */

    public function deleting_records_from_use_vlan_and_use_vlan_import_ids()
    {
        $use_vlan_import_ids = UseVlanImportIds::all();

        foreach ($use_vlan_import_ids as $id){

            $use_vlan = Use_Vlan::find($id->id_in_use_vlan_table);
            $use_vlan->delete();
            $id->delete();
        }

        return "records deleted successfully from use_vlan and use_vlan_import_ids";
    }


    /**
     *
     *
     * Import data from excel made by Guille called use_vlan_int
     * Search records in use_vlan_table by id provided in excel data
     *  And update it's id_frontera and status values
     *
     * @return string
     */

    public function update_use_vlan_int_excel_data_18_10_2022()
    {
        try {
            $collection = Excel::toArray(new Use_Vlan_IntImport, 'USE_VLAN_INT.xlsx');

            foreach ($collection[0] as $index=>$collect){

                $use_vlan               = Use_Vlan::find($collect['id']);
                $use_vlan->id_frontera  = $collect['id_frontera'];
                $use_vlan->status       = $collect['status'];
                $use_vlan->save();
            }

            return 'Records updated successfully';

        } catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *
     *
     * Import data from excel made by Guille called asignacion_servicio_vlan int
     * Create new records in asignacion_servicio_vlan table
     *
     * @return string
     */

    public function store_asignacion_servicio_vlan_int_excel_data_18_10_2022()
    {
        try {
            $collection = Excel::toArray(new Asignacion_Servicio_Vlan_IntImport, 'ASIGNACION_SERVICIO_VLAN_INT.xlsx');

            foreach ($collection[0] as $index=>$collect){

                $asignacion = new Asignacion_Servicio_Vlan();
                $asignacion->id_service  = $collect['id_service'];
                $asignacion->id_use_vlan = $collect['id_use_vlan'];
                $asignacion->estado      = $collect['estado'];
                $asignacion->save();
            }

            return 'Records added successfully';

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *
     *
     * Import data from excel made by Guille called use_vlan_int bvi
     * Search records in use_vlan table by the id provided in excel
     * And update it's id_list_use_vlan, id_equipment and status values
     *
     * @return string
     */

    public function update_use_vlan_int_bvi_excel_data_18_10_2022()
    {
        try {
            $collection = Excel::toArray(new Use_Vlan_Int_BviImport, 'USE_VLAN_INT_BVI.xlsx');

            foreach ($collection[0] as $index=>$collect){

                $use_vlan                    = Use_Vlan::find($collect['id']);
                $use_vlan->id_list_use_vlan  = $collect['id_list_use_vlan'];
                $use_vlan->id_equipment      = $collect['id_equipment'];
                $use_vlan->status            = $collect['status'];
                $use_vlan->save();
            }

            return 'Records updated successfully';

        } catch (Exception $e){
            return $e->getMessage();
        }
    }

    /**
     *
     *
     * Import data from excel made by Guille called asignacion_servicio_vlan rpv received by me at 19/10/2022
     * Create new records in asignacion_servicio_vlan
     *
     * @return string
     */

    public function store_asignacion_servicio_vlan_rpv_excel_data_19_10_2022 ()
    {
        try {
            $collection = Excel::toArray(new Use_Vlan_Int_BviImport, 'ASIGNACION_SERVICIO_VLAN_RPV_19_10_2022.xlsx');
            $length = count($collection[0]);

            /**foreach($yesterday as $index => $yes){
                $id = $yes->id;
                $yes->delete();
                echo 'Deleted the record '.($index + 1).' with the id '.$id;
            }**/

            foreach ($collection[0] as $index => $collect){
                echo 'Creating record '.($index+1).' of '.$length."\r\n";
                $asignacion              = new Asignacion_Servicio_Vlan();
                $asignacion->id_service  = $collect['id_service'];
                $asignacion->id_use_vlan = $collect['id_use_vlan'];
                $asignacion->ctag        = $collect['ctag'];
                $asignacion->estado      = $collect['estado'];
                $asignacion->save();

               echo 'Saved record '.($index+1).' of '.$length."\r\n";
            }

            return 'Records added successfully';

        } catch (Exception $e){
            return $e->getMessage();
        }
    }
}
