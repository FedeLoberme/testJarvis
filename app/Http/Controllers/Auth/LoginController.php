<?php

namespace Jarvis\Http\Controllers\Auth;

use Jarvis\Http\Controllers\Controller;
use Jarvis\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Jarvis\User;
use Jarvis\User_history;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Controllers\UsersController;
use Jarvis\Http\Controllers\ConnectionLDAP;
use Jarvis\Http\Controllers\ControllerUser_history;
use Session;
use Carbon\Carbon;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function login(Request $request){
        $username = strtoupper($request->username);
        $pass = $request->password;
        $validation_users = ConnectionLDAP::Ldap($username, $pass); 
        if ($validation_users['exists'] == 10 || $username == 'ADMIN_JARVIS'){
            if ($username != 'ADMIN_JARVIS') {
                $users=DB::table('users')->select('id', 'status', 'fin_login')->where('USERNAME', '=', $username)->get();
                    $workgroup = $validation_users['workgroup'];
                    $img = $validation_users['img'];
                    $department = $validation_users['department'];
                    $name = utf8_encode($validation_users['name']);
                    $last_name = $validation_users['last_name'];
                    $username = $validation_users['user'];
                    $email = $validation_users['email'];
                if (count($users) > 0){
                    if ($users[0]->status <> 1) {
                        return redirect()->back()
                            ->withInput($request->only($this->username(), 'remember'))
                            ->withErrors([ $this->username() => Lang::get('auth.disable'),]);
                    }            
                    UsersController::update($users[0]->id, $name, $last_name, $img, $workgroup, $department, $pass);
                }else{
                    $admin = array('EXT83881', 'CLA20698', 'EXT82568', 'CTI22108', 'EXT83433', 'CTI22541','EXT83968');
                    if (in_array($username, $admin)) {
                            $profil = 2;
                    }else{
                        $client = array('CLA20390', 'CTI9507', 'CTI9572', 'CTI9985', 'CTI8276', 'CLA20959','CLA20547', 'CTI22613', 'CTI9497', 'CLA20765', 'EXA87371', 'CTI22448', 'CLA20596' ,'CTI9190', 'CTI9500', 'CLA20756', 'EXT82180', 'CTI22405', 'EXT82771', 'CTI22498','EXT83137','CTI22836','EXT83401','EXT82618','EXT83412');
                        if (in_array($username, $client)) {
                            $profil = 3;
                        }else{
                            $profil = 1;
                        }
                    }
                    UsersController::store($name, $last_name, $email, $username, $img, $workgroup, $department, $pass, $profil);
                }
            }else{
                UsersController::update(1, 'SUPER', 'JARVIS', 'https://logodownload.org/wp-content/uploads/2014/02/claro-logo1.png', 'ADMIN', 'ADMIN', 'Jarvis.1995');  
            }
               $this->validateLogin($request);

            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if ($this->attemptLogin($request)) {
                $authori = UsersController::authori();
                session(['authori' =>$authori]);
                ControllerUser_history::store('El usuario '.Auth::user()->name.' '.Auth::user()->last_name.' inicio sesión');
                return $this->sendLoginResponse($request);
            }

            // If the login attempt was unsuccessful we will increment the number of attempts
            // to login and redirect the user back to the login form. Of course, when this
            // user surpasses their maximum number of attempts they will get locked out.
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
            
        }else{
            return redirect()->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => Lang::get('auth.failed'),
                ]);
        }  
    }


    public function logout(Request $request){
        ControllerUser_history::store('El usuario '.Auth::user()->name.' '.Auth::user()->last_name.' cerro sesión');
        $users = User::find(Auth::user()->id);
                $users->fin_login = Carbon::now();
            $users->save();
        $sesion = $users->session_id;
        \Session::getHandler()->destroy($sesion);
        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();
        return redirect('/');
    }

    protected function sendLoginResponse(Request $request){
        $request->session()->regenerate();
        $previous_session = Auth::User()->session_id;
        if ($previous_session) {
            \Session::getHandler()->destroy($previous_session);
        }

        Auth::user()->session_id = \Session::getId();
        Auth::user()->save();
        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    } 
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username(){
        return 'username';
    }
}
