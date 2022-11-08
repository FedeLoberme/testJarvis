<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Module;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use DB;
use Carbon\Carbon;
use Jarvis\User;
use Jarvis\Http\Requests\RequestModule;
use Jarvis\Http\Controllers\ControllerUser_history;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            if (!Auth::guest() == false){ 
               return redirect('login')->withErrors([Lang::get('validation.login'),]);
            }
            $authori_status = User::authorization_status(17);
            if ($authori_status['permi'] >= 3) {
                $info = Module::select('tipo_modulo')->groupBy('tipo_modulo')->get()->toArray();
                $tipos_modulo = [];
                foreach ($info as $value) {
                    if ($value['tipo_modulo'] != 'No Disponible' && $value['tipo_modulo'] != 'Sin Informacion' && $value['tipo_modulo'] != 'Desconocido'){
                        array_push($tipos_modulo, $value['tipo_modulo']);
                    }
                }
                return view('import/list_modules',compact('authori_status','tipos_modulo'));
            }else{
                return redirect('home')
                    ->withErrors([Lang::get('validation.authori_status'),]);
            }

    }

    public function index_list()
    {
        $data = [];
        $info = DB::table('module')
        ->select('nombre_modulo', 'tipo_modulo', 'distancia', 'fibra', 'corta_larga')->get();
        foreach ($info as $value) {
            $data[] = array(
                'nombre_modulo' => $value->nombre_modulo, 
                'tipo_modulo' => $value->tipo_modulo, 
                'distancia' => $value->distancia, 
                'fibra' => $value->fibra, 
                'corta_larga' => $value->corta_larga,
            );
        }
        return datatables()->of($data)->make(true);
    }

    public function insert_update_module(RequestModule $request)
    {
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(14);
		if ($authori_status['permi'] >= 3) {
	    	$id = 0;
	    	$name = $request->input('nombre_modulo');
			$type = $request->input('tipo_modulo');
            $distance = $request->input('distancia');
            $km = $request->input('km');
			$fibre = $request->input('fibra');
			$short_long = $request->input('corta_larga');
			$direccion = [];
			if (count($direccion) == 0) {
				if ($id != 0) {
	    			$modul =Module::find($id);
	    			$msj_historial = 'Modifico modulo';
		    	}else{
		    		$modul = new Module();
		    		$msj_historial = 'Registro modulo';
		    	}
	        	$modul->nombre_modulo = $name;
	        	$modul->tipo_modulo = $type;
	        	$modul->distancia = $distance.$km;
	        	$modul->fibra = $fibre;
	        	$modul->corta_larga = $short_long;
				$modul->save();
				ControllerUser_history::store($msj_historial);
				//$momduls = ControllerAddress::all_address();
				$resul = 'yes';
			}else{
				$resul = 'no';
				$direcc = '';
			}
        return array('resul' => $resul, /*'datos' => $direcc*/ );
		}else{
			return array('resul' => 'autori', );
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Jarvis\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Jarvis\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Jarvis\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Jarvis\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        //
    }
}
