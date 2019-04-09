<?php

//namespace App\Http\Controllers;
namespace App\Http\Controllers\Prueba;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PruebaController extends Controller
{


  /*public function __construct()
  {
      $this->middleware('prueba');
  }*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('prueba');
    }

    public function prueba()
    {
      return view('prueba');
    }


        public function estudiante()
        {
          return view('usuarios.estudiantes');
        }



}
