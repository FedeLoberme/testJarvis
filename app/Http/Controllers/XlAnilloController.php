<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\XlAnillo;
use Maatwebsite\Excel\Facades\Excel;
use Jarvis\Imports\XlAnillosImport;
use DB;
use Jarvis\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
class XlAnilloController extends Controller
{
    public function post($data = '')
    {
        return view('import/anillo_excel',compact('data')); 
    }
    public function import_anillos(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);
        DB::table('xl_anillos')->truncate();
        Excel::import(new XlAnillosImport, $request->file('file'));
        return back();
    }

    public function index_list(){
        if (!Auth::guest() == false){ 
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $posts = DB::table('xl_anillos')->select('*');
        return datatables()->of($posts)->make(true);
    }

    public function search_port(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
        $id = $_POST['id'];
        $data = [];
        $info_port = DB::table('xl_anillos')->where('id', '=', $id)
            ->select('ic_01','ic_02','ic_03','ic_04','ic_05','ic_06','ic_07','ic_08','ic_09','ic_10','ic_11','ic_12','ic_13','ic_14','ic_15','ic_16','ic_17','ic_18','ic_19','ic_20','ic_21','ic_22','ic_23','ic_24','ic_25','ic_26','ic_27','ic_28')->get();
        if (count($info_port) > 0) {
            $info_bw = DB::table('xl_anillos')->where('id', '=', $id)
                ->select('bw_01', 'bw_02', 'bw_03', 'bw_04', 'bw_05', 'bw_06', 'bw_07', 'bw_08', 'bw_09', 'bw_10', 'bw_11', 'bw_12', 'bw_13', 'bw_14', 'bw_15', 'bw_16', 'bw_17', 'bw_18', 'bw_19', 'bw_20', 'bw_21', 'bw_22', 'bw_23', 'bw_24', 'bw_25', 'bw_26', 'bw_27', 'bw_28')->get();
            for ($i=1; $i < 29; $i++) {
                if ($i < 10) {
                    $ic = 'ic_0'.$i;
                    $bw = 'bw_0'.$i;
                }else{
                    $ic = 'ic_'.$i;
                    $bw = 'bw_'.$i;
                }
                $data[] = array(
                    'num' => $i,
                    'port' => $info_port[0]->$ic,
                    'bw' => $info_bw[0]->$bw, 
                );
            }
            $resul = array('resul' => 'yes', 'datos' => $data,);
        }else{
            $resul = array('resul' => 'nop', 'datos' => $data,);
        }
        return $resul;
    }
}
