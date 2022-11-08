<?php

namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Constants;
use Jarvis\Http\Requests\RequestProfile;
use Jarvis\Http\Requests\RequestProfileModifi;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\user;
use Jarvis\Profile;
use Jarvis\Application;
use Jarvis\Permissions;
use DB;
use Carbon\Carbon;
class ControllerProfile extends Controller
{
// -----------------Funcion para listar perfiles---------------------------
    public function index(){
      if (!Auth::guest() == false){ return redirect('login')
      ->withErrors([Lang::get('validation.login'),]);}
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_PERFIL);
      if ($authori_status['permi'] >= 3) {
        $application = Application::all();
        $profile = Profile::get()->where('deleted_at', '=', null);
        return view('profile.list',compact('profile', 'authori_status','application'));
      }else{
      return redirect('home')
              ->withErrors([Lang::get('validation.authori_status'),]);
      }
    }

// -----------------Funcion para eliminar perfiles---------------------------
  public function delate($id){
    if (!Auth::guest() == false){ return redirect('login')
      ->withErrors([Lang::get('validation.login'),]);}
    $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_PERFIL);
    if ($authori_status['permi'] >= 5) {
      $user = User::profile_name($id);
      if (count($user) == 0) {
        $profile = Profile::find($id);
          $profile->deleted_at = Carbon::now();
        $profile->save();
        ControllerUser_history::store('Elimino el perfil '.$profile->name);
        $notification = array(
                'message' => trans('validation.msj.deletereal'),
                'alert-type' => 'success'
            );
        return redirect('ver/perfil')->with($notification);
      }else{
        return redirect()->back()
                ->withErrors([Lang::get('validation.delate'),]);
      }
    }else{
        return redirect('home')->withErrors(
          [Lang::get('validation.authori_status'),]);
      }
  }
//--------------Funcion para buscarlos permiso del perfil--------------------
  public function select_profile(){
    $id=$_POST['cod'];
    $select_profile =DB::table('profile')
        ->Join('permissions', 'profile.id', '=', 'permissions.id_profile')
        ->Join('application', 'permissions.id_application', '=', 'application.id')
        ->where('profile.id', '=', $id)
        ->select('permissions.permission as permi', 'application.name as appli')
        ->get();
    $contar = count($select_profile);
    if ($contar <> 0) {
      foreach ($select_profile as $value) {
        $data[] = array(
          'contar' => $contar - 1,
          'permi' => trans('user.permi.'.$value->permi),
          'appli' => $value->appli,
        );
      }
    }else{
      $data[0] = array(
        'contar' => 0,
      );
    }
    return $data;
    }

// -----------------Funcion para registrar y/o modificar perfiles---------------------------
    public function insert_update_porfil(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_PERFIL);
      if ($autori_status['permi'] >= 5){
        $id=$_POST['id'];
        $name=$_POST['name_new'];
        $permi=$_POST['permi_value'];
        if ($id != 0) {
          $msj_perfil = "Modifico el perfil ";
          $profil = Profile::find($id);
        }else{
          if ($autori_status['permi'] >= 10){
            $msj_perfil = "Registro el perfil ";
            $profil = new Profile();
          }
        }
          $profil->name = strtoupper($name);
        $profil->save();
        ControllerUser_history::store($msj_perfil.$profil->name);
        foreach ($permi as $value) {
          $separar = explode('_', $value);
          $select =DB::table('permissions')
          ->where('permissions.id_profile', '=', $profil->id)
          ->where('permissions.id_application', '=', $separar[1])
          ->select('permissions.id')
          ->get();
          if (count($select) > 0) {
            $permission = Permissions::find($select[0]->id);
          }else{
            if ($autori_status['permi'] >= 10){
              $permission = new Permissions();
            }
          }
            $permission->id_profile = $profil->id;
            $permission->id_application =  $separar[1];
            $permission->permission = $separar[0];
          $permission->save();
        }
          return array('resul' => 'yes',);
      }else{
        return array('resul' => 'autori', );
      }
    }

    // -----------------Funcion para la vista de modificar perfiles----------------
    public function search_perfil(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_PERFIL);
      if ($autori_status['permi'] >= 5) {
        $id = $_POST['id'];
        $apli = Application::all();
        $profil_data = Profile::find($id);
        foreach ($apli as $key) {
          $profil =DB::table('profile')
                ->leftJoin('permissions', 'profile.id', '=', 'permissions.id_profile')
                ->where('profile.id', '=', $id)
                ->where('permissions.id_application', '=', $key->id)
                ->select('profile.name as profi', 'permissions.permission as permi', 'permissions.id', 'profile.id as pro_id')
                ->get();
                if (count($profil) > 0) {
                  $id_new = $profil[0]->id;
                  $profi = $profil[0]->profi;
                  $permis = $profil[0]->permi;
                  $pro_id = $profil[0]->pro_id;
                }else{
                  $id_new = 0;
                  $profi = 0;
                  $permis = 0;
                  $pro_id = 0;
                }
                $profiles[]  = array(
                  'id' => $id_new,
                  'profi' => $profi,
                  'appli' => $key->name,
                  'appli_id' => $key->id,
                  'permi' => $permis,
                  'pro_id' => $pro_id,
                );
              }
          $data = array('resul' => 'yes', 'datos' => $profiles, 'name' => $profil_data->name,);
        return $data;
      }else{
        return array('resul' => 'autori', );
      }
  }

  // -----------------Funcion para la vista de crear perfiles--------------------
    public function create(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_PERFIL);
      if ($authori_status['permi'] >= 10) {
        $application = Application::all();
        return array('resul' => 'yes', 'datos' => $application);
      }else{
        return array('resul' => 'autori', );
      }
    }
}
