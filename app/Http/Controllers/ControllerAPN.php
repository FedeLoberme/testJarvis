<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Client;
use Jarvis\Ring;
use Jarvis\User;
use Jarvis\User_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Requests\RequestClient;
use Jarvis\Http\Controllers\ControllerIP;
use DB;
use Carbon\Carbon;
class ControllerAPN extends Controller
{
    // -----------------Funcion para listar cliente---------------------------
	public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		return view('admin_apn.list');
  	}
		
}