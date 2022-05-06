<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Str;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Contracts\Support\MessageProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse as BaseRedirectResponse;
use Illuminate\Support\Facades\Input;

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
    //protected $redirectTo = '/home';

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
       /**
        * Get a validator for an incoming registration request.
        *
        * @param  array  $data
        * @return \Illuminate\Contracts\Validation\Validator
        */

   protected function redirectTo()
{
    return 'home_estudiante';
}

    public function username()
    {
        return 'id_user';
    }
    public function logout(Request $request)
  {
      $this->guard()->logout();

      $request->session()->invalidate();

      return $this->loggedOut($request) ?: redirect('perfiles');
  }


          protected function getLogin()
       {
           return view("estudiante.login_studiante");
       }


  public function postLogin(Request $request)
     {
      $this->validate($request, [
          'id_user' => 'required',
          'password' => 'required',
      ]);
      $credentials = $request->only('id_user', 'password');
      if ($this->auth->attempt($credentials, $request->has('remember')))
 {;
   if(Auth::user()->tipo_usuario == 'estudiante' &&  Auth::user()->bandera == '1'){
   //  return view('personal_administrativo\admin_sistema.home_admin');
       return redirect()->route('home_estudiante')->with('success', '¡Bienvenido(a)!, Tu sesion se ha iniciado correctamente, al terminar de usar los Servicios del Portal no olvides Cerrar tu Sesión');
   }
 }
   else {
     $this->guard()->logout();
    $request->session()->invalidate();
   //return $this->loggedOut($request) ?: redirect('estudiante')->with('error', 'Usuario Incorrecto, ¡Favor de Verificar Datos!');
  return $this->loggedOut($request) ?:  redirect()->back()->withInput(Input::all())->with('error','Usuario invalido: !Verifique sus datos!');
 }
 }



}
