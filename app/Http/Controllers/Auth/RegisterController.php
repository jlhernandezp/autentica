<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest');
        $this->middleware('auth');
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
            'nombre' => ['required', 'string', 'max:25'],
            'apellido' => ['required', 'string', 'max:35'],
            'dni' => ['required', 'string', 'max:9'],
            'expendiente' => ['required', 'string', 'max:9', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'rol' => ['required','integer'],
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    protected function showRegistrationForm() {
       
        
        return view('auth.register');
    }
    
    protected function register(\Illuminate\Http\Request $request) {
       // parent::register($request);
        
        if ($this->buscaRepes($request)){
            
            
            return view('auth.register');
            
        } 
        
        $registro=array(
            'nombre'=>$request->nombre,
            'apellido'=>$request->apellido,
            'dni'=>$request->dni,
            'expediente'=>$request->expediente,
            'email'=>$request->email,
            'password'=> bcrypt($request->password),
            'rol'=>$request->rol,
        );
        
        $nuevoUsuario= \App\User::create($registro);
        
        return view('home_2');
        
    }
    /**
     * Función que busca a un usuario registrado en el sistema.
     * 
     * Objetivo: comprobar que no existe otro usuario con el mimso email o dni
     * 
     * @param Request $request
     * @return boolean:  true: existe
     *                   false: no existe
     */
    public function buscaRepes(Request $request){
        
        $existe=FALSE;
        
        $usuarios=\App\User::where(
                          'email','=',$request->email)
                ->orWhere('dni','=',$request->dni)
                ->get();
        
        if ($usuarios->count()>0){
            
            $existe=TRUE;
        }
        return $existe;
    }
    /**
     * Muestra la lista de usuarios con las opciones de borrado y modificación.
     * 
     * @return type view users.consulta
     */
    protected function consulta(Request $request) {
        
        $apellido=trim($request->apellido);
        
        $usuarios= \App\User::where ('apellido','LIKE', '%'.$apellido.'%')
                ->orderBy('apellido','asc')
                ->paginate(7);
        
        return view('users.consulta')->with('usuarios',$usuarios);
                                     
        
    }
    
    
    protected function infoUsuario($clavePrimaria){
         return $clavePrimaria;
         $usuario= \App\User::findorFail($clavePrimaria);
        
         return view('users.infoUsuario')->with('usuario',$usuario);
    }
    
    protected function eliminarUsuario($clavePrimaria){
        
        //comprobar que no hay trabajos pendientes del usuario. ¿Qué pasa si un usuario no quiere que estén sus datos?
        
       // $usuario= \App\User::findorFail($clavePrimaria);
       // $usario->delete();
        return 'Usuario borrado';
    }
}
