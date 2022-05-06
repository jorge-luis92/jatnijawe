<?php
namespace App\Http\Controllers\Administrativo_Con;
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

class LoginAdministrativo extends Controller
{
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

/*      protected function redirectTo()
   {
      // return view ('personal_administrativo.home_admin');
   }
*/
 //login

        protected function getLogin()
     {
         return view("personal_administrativo.login_personal");
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
    if(Auth::user()->tipo_usuario == '5' &&  Auth::user()->bandera == '1'){
    // if(Auth::user()->tipo_usuario == 'estudiante' &&  Auth::user()->bandera == '1'){
        return redirect()->route('home_admin')->with('success', '¡Bienvenido(a) Administrador del Sistema!, recuerde Cerrar Sesión al terminar de usar los Servicios del Portal');
    }
    if (Auth::user()->tipo_usuario == '1' &&  Auth::user()->bandera == '1') {
      //  return view('personal_administrativo\formacion_integral.home_formacion');
          return redirect()->route('inicio_formacion')->with('success', '¡Bienvenido(a) Coordinador(a) de Formación Integral!, recuerde Cerrar Sesión al terminar de usar los Servicios del Portal');
    }
    if (Auth::user()->tipo_usuario == '2' &&  Auth::user()->bandera == '1') {
      //  planeacion;
          return redirect()->route('home_planeacion')->with('success', '¡Bienvenido(a) Coordinador(a) de Planeación!, recuerde Cerrar Sesión al terminar de usar los Servicios del Portal');
    }
    if (Auth::user()->tipo_usuario == '3' &&  Auth::user()->bandera == '1') {
      //  return view('personal_administrativo\formacion_integral.home_formacion');
          return redirect()->route('home_servicios')->with('success', '¡Bienvenido(a) Coordinador(a) de Servicio Social Y Titulación!, recuerde Cerrar Sesión al terminar de usar los Servicios del Portal');
    }
    elseif (Auth::user()->tipo_usuario == '4' &&  Auth::user()->bandera == '1') {
      return redirect()->route('home_academica')->with('success', '¡Bienvenido(a) Coordinador(a) Acádemico(a)!, recuerde Cerrar Sesión al terminar de usar los Servicios del Portal');
    }

   }
     return redirect()->back()->withInput(Input::all())->with('error','Usuario invalido: !Verifique sus datos!');
   //return redirect()->route('administrativo')->with('error','Usuario invalido: !Verifique sus datos!');
        /* return view("personal_administrativo.login_personal");*/
    //   }
  }


  public function getLogout(Request $request)
{
  Auth::logout();
//  $this->guard()->logout();
 $request->session()->invalidate();
return $this->loggedOut($request) ?:  redirect()->back()->with('success', 'Cierre de sesión correcto!');
}

}
