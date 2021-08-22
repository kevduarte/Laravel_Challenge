<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Contracts\Support\MessageProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse as BaseRedirectResponse;
//use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;


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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
  public function __construct(Guard $auth)
       {
           $this->auth = $auth;
           //$this->middleware('guest', ['except' => 'getLogout']);

       }

       public function username()
    {
        return 'username';
    }


       public function postLogin(Request $request)
      {
      $this->validate($request, [
          'username' => 'required',
          'password' => 'required',
      ]);
      $credentials = $request->only('username', 'password');
      if ($this->auth->attempt($credentials, $request->has('remember')))
 {;
            if(Auth::user()->rol == 'encargado'){


             Session::flash('message','Bienvenido administrador');
             return redirect()->route('admin');
         }


     }else {
       $this->guard()->logout();
       $request->session()->invalidate();
       Session::flash('message_error','Usuario o contraseña invalido, verifique sus datos'); 
       return $this->loggedOut($request) ?:  redirect()->back();
   }
}


     public function getLogout(Request $request)
{
  Auth::logout();
//  $this->guard()->logout();
 $request->session()->invalidate();
Session::flash('message','Cierre de sesión correcto'); 
  //return redirect()->route('welcome');
 return $this->loggedOut($request) ?:  redirect()->back();
}



}
