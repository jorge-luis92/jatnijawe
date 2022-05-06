<?php

namespace App\Http\Controllers\Auth;
use App\Persona;
use App\Estudiante;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'id_persona' => ['required', 'string', 'max:60', 'unique:personas'],
            'nombre' => ['required', 'string', 'max:25'],
            'apellido_paterno' => ['required', 'string', 'max:25'],
            'apellido_materno' => ['string', 'max:25'],
            'curp' => ['required', 'string', 'min:18','max:18'],
            'fecha_nacimiento' => ['required', 'date'],
            'lugar_nacimiento' => ['required', 'string', 'max:45'],
            'tipo_sangre' => ['required', 'string', 'max:8',],
            'edad' => ['required', 'numeric', 'max:100',],
            'genero' => ['required', 'string', 'max:8',],
            'matricula' => ['required', 'string', 'max:60', 'unique:estudiantes'],
            'modalidad' => ['required', 'string', 'max:20',],
            'fecha_ingreso' => ['required', 'date'],
            'semestre' => ['required', 'numeric', 'max:12',],
            'grupo' => ['required', 'max:1'],
            'estatus' => ['required', 'string', 'max:20',],
            'bachillerato_origen' => ['required', 'string', 'max:80',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'tipo_usuario' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

      Persona::create([
          'id_persona' => $data['id_persona'],
          'nombre' => $data['nombre'],
          'apellido_paterno' => $data['apellido_paterno'],
          'apellido_materno' => $data['apellido_materno'],
          'curp' => $data['curp'],
          'fecha_nacimiento' => $data['fecha_nacimiento'],
          'lugar_nacimiento' => $data['lugar_nacimiento'],
          'tipo_sangre' => $data['tipo_sangre'],
          'edad' => $data['edad'],
          'genero' => $data['genero'],
      ]);

      Estudiante::create([
          'matricula' => $data['matricula'],
          'modalidad' => $data['modalidad'],
          'fecha_ingreso' => $data['fecha_ingreso'],
          'semestre' => $data['semestre'],
          'grupo' => $data['grupo'],
          'estatus' => $data['estatus'],
          'bachillerato_origen' => $data['bachillerato_origen'],
          'id_persona' => $data['id_persona'],
      ]);

        User::create([
            'id_user' => $data['matricula'],
            'username' => $data['nombre'],
            'email' => $data['email'],
            'password' => Hash::make($data['matricula']),
            'tipo_usuario' => $data['tipo_usuario'],
            'id_persona' => $data['id_persona'],

        ]);
    }


    public function register(Request $request)
   {
       $this->validator($request->all())->validate();

       if(event(new Registered($user = $this->create($request->all())))){

       return redirect()->route('perfiles')->with('success','Usuario creado correctamente Puede ingresar al sistema');


}
else{
return redirect()->route('register')->with('error','Usuario invalido: !Verifique sus datos!');}
       //$this->guard()->login($user);

       //return $this->registered($request, $user)
        //              ?: redirect($this->redirectPath());
   }



   public function create_persona(Request $request)
 {
   $this->validate($request, [
     'id_persona' => ['required', 'string', 'max:60', 'unique:personas'],
     'nombre' => ['required', 'string', 'max:25'],
     'apellido_paterno' => ['required', 'string', 'max:25'],
     'apellido_materno' => ['string', 'max:25'],
     'curp' => ['required', 'string', 'min:18','max:18'],
     'fecha_nacimiento' => ['required', 'date'],
     'lugar_nacimiento' => ['required', 'string', 'max:45'],
     'tipo_sangre' => ['required', 'string', 'max:8',],
     'edad' => ['required', 'numeric', 'max:100',],
     'genero' => ['required', 'string', 'max:8',],
     'matricula' => ['required', 'string', 'max:60', 'unique:estudiantes'],
     'modalidad' => ['required', 'string', 'max:20',],
     'fecha_ingreso' => ['required', 'date'],
     'semestre' => ['required', 'numeric', 'max:12',],
     'grupo' => ['required', 'max:1'],
     'estatus' => ['required', 'string', 'max:20',],
     'bachillerato_origen' => ['required', 'string', 'max:80',],
     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
     'tipo_usuario' => ['required', 'string', 'max:255'],
   ]);

   $data = $request;

   $persona=new Persona;
   $persona->id_persona=$data['id_persona'];
   $persona->nombre=$data['nombre'];
   $persona->apellido_paterno=$data['apellido_paterno'];
   $persona->apellido_materno=$data['apellido_materno'];
   $persona->curp=$data['curp'];
   $persona->fecha_nacimiento=$data['fecha_nacimiento'];
   $persona->lugar_nacimiento=$data['lugar_nacimiento'];
   $persona->tipo_sangre=$data['tipo_sangre'];
   $persona->edad=$data['edad'];
   $persona->genero=$data['genero'];
   $persona->save();

if(save()){
     return redirect()->route('perfiles')->with('success','Usuario Creado Correctamente');
}
else{
  return redirect()->route('register')->with('error','error en la creacion');
}

 }
}
