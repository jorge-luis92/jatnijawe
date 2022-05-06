<?php
namespace App\Http\Controllers\Tallerista_Con;
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
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse as BaseRedirectResponse;

class LoginTallerista extends Controller
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

        protected function getLoginTallerista()
     {
          return view('tallerista.login_tallerista');
     }

     public function postLoginTallerista(Request $request)
        {
         $this->validate($request, [
             'username' => 'required',
             'password' => 'required',
         ]);

         $credentials = $request->only('username', 'password');
         if ($this->auth->attempt($credentials, $request->has('remember')))
   {;
    if(Auth::user()->tipo_usuario == 'tallerista' &&  Auth::user()->bandera == '1'){
    //  return view('tallerista.home_tallerista');
      return redirect()->route('home_tallerista')->with('success', '¡Bienvenido(a)!, recuerde Cerrar Sesión al terminar de usar los Servicios del Portal');
    }
  }
   return redirect()->back()->withInput(Input::all())->with('error','Usuario invalido: !Verifique sus datos!');
   //return redirect()->route('tallerista')->with('error','Usuario invalido: !Verifique sus datos!');
        /* return view("personal_administrativo.login_personal");*/
    //   }

}


  public function getLogout(Request $request)
{
    $this->guard()->logout();

    $request->session()->invalidate();

    return $this->loggedOut($request) ?: redirect('perfiles');
}

}
