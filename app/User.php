<?php

namespace Jarvis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jarvis\Profile;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'last_name', 'email', 'password', 'status', 'url_img', 'workgroup', 'id_profile', 'created_at', 'updated_at', 'fin_login',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*+ public function profile(){
        return $this->belongsTo('Jarvis\Profile', 'id_profile', 'id');
    }**/

    public function user_history(){
        return $this->hasMany('Jarvis\User_history','id_user', 'id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'id_profile');
    }

    public static function authorization_status($id){
        if (!Auth::guest() == false){  return view('auth.login'); }
        if (Auth::user()->fin_login != null) {
            Auth::logout();
            return view('auth.login');
        }else{

            // query original
        /**$profile =DB::table('users')
            ->Join('profile', 'profile.id', '=', 'users.id_profile')
            ->Join('permissions', 'profile.id', '=', 'permissions.id_profile')
            ->Join('application', 'permissions.id_application', '=', 'application.id')
            ->where('users.id', '=',  Auth::user()->id)
            ->where('application.id', '=', $id)
            ->select('permissions.permission as permi', 'users.fin_login')
            ->get();**/

            //query actualizada con relaciones de eloquent
            $profile = Auth::user()->profile->permissions($id);

            if (isset($profile)) {
                $profi = array(
                    'permi' => $profile->permission,
                );
            }else{
                $profi = array(
                    'permi' => 0,
                );
            }
            return $profi;
        }
    }

    public static function profile_name($id){
        $profile =DB::table('users')
            ->Join('profile', 'profile.id', '=', 'users.id_profile')
            ->where('profile.id', '=', $id)
            ->select('profile.name')
            ->get();
            return $profile;
    }

    public static function profil_name_permi($id, $user){
        $profile =DB::table('users')
            ->Join('profile', 'profile.id', '=', 'users.id_profile')
            ->Join('permissions', 'profile.id', '=', 'permissions.id_profile')
            ->Join('application', 'permissions.id_application', '=', 'application.id')
            ->where('profile.id', '=', $id)
            ->where('users.id', '=', $user)
            ->select('application.name', 'permissions.permission as permi')
            ->get();
        return $profile;
    }
}
