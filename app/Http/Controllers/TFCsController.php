<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades;

class TFCsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // mejor en la ruta
    }
    
    /**
     *
     * @var type ruta para el archivo de trabajos
     */
   // protected $PATHTOARCHIVOS = 'C:\\Users\\PC PROFESOR\\Downloads\\tfcs\\';
    
    protected $PATHTOARCHIVOS = '/home/jl/Descargas/tfcs/';
    
    /**
     * Devuelve la ruta según el sistema utilizado en los diferentes sistema de
     * desarrollo
     * 
     * @return string path de archivo de TFCs
     */
     public function rutaDeTFCs()
    {
        
         if (php_uname('s')=='Linux'){ // por trabajar en dos sistemas diferentes. 
               
             $ruta='/home/jl/Descargas/tfcs/';
               
           } else {
                
               $ruta='C:\\Users\\PC PROFESOR\\Downloads\\tfcs\\';
           
               
           }
           return $ruta;
        
    }
    /**
     * Devuelve un listado con los trabajos de un usuario según el rol asignado
     * 0 -> alumno
     * 1 -> tutor
     * ...
     * 
     * @return type view 
     */
    public function consulta(Request $request)
    {
        $rol=auth()->user()->rol;
        
        switch ($rol) {
            
            case 0:  //alumno

                 $trabajos= \App\TFCs::where('dni_autor','=', auth()->user()->dni)
                ->paginate(7);
                
                return view('trabajos.consulta')->with('trabajos',$trabajos);
                break;
            
            case 1: //tutor
                
                $trabajos= $this->buscaTrabajosPorTitulo($request->titulo);
                
                return view('trabajos.consulta')->with('trabajos',$trabajos);
                break;
            
            case 2: //administrador
                
                $trabajos= $this->buscaTrabajosPorTitulo($request->titulo);
                return view('trabajos.consulta')->with('trabajos',$trabajos);
                break;

            default:
                
                break;
        }
            
        return view(login);    
            
    }
    
    /**
     * Formulario que recoge los datos del depósito de un TFC
     * 
     * 
     * @return view formulario de registro de TFC
     */
    public function depositar(){
        
        $tutores=\App\User::where('rol','=',1)->get();
        
        return view('trabajos.depositar')->with('tutores',$tutores );
    }
    /**
     * Muestra los datos introducidos en el formulario de depósito para su
     * confirmación.
     * 
     * @param Request $request Datos del formulario de depósito.
     * @return type view Datos de confirmación
     */
    public function confirmar(Request $request){
        //validar los datos primero antes de dar la posibilidad de confirmar
        $fichero=$request->fichero;
        
        $nombre=$fichero->getClientOriginalName();
        
        \Illuminate\Support\Facades\Storage::disk('public')->put($nombre , \File::get($fichero));
        
        return view('trabajos.confirmar')->with('trabajo',$request);
    }
    /**
     * Inserta un nuevo trabajo comprobando que no haya sido ya entregado.
     * 
     * @param Request $request
     * @return type view justificante de entrega.
     */
    public function store(Request $request){
        // comprobar que no existe otro trabajo realizado por la misma persona,
        // en el mismo curso, en el mismo ciclo sin nota o con nota igual o superior a 5.
        // no se contempla que pueda presentarse a subir nota. Podría haber un token para
        // trabajos no calificados? ¿mejora?
        
        
        if ($this->buscaRepes($request)){
            
            return 'Mensaje o pantalla de error diciendo que ya has entregado el'.
                    'trabajo, bonito.';
            
        }
        
         //obtenemos el campo file definido en el formulario
        
       $nombre = $request->input('archivo');
       
       //obtenemos el nombre del archivo, hay que llamar a la función rutaDeTFCs para arreglar el path controlar nombres repes
       
       $nombreTemporal = storage_path('app'.$this->barra().'public')
                        .$this->barra()         //sustituir slash por barra()
                        .$nombre; 
       
       $directorioArchivo=$this->PATHTOARCHIVOS.$request->ciclo
                            .$this->barra()         //sustituir slash por barra()
                            .$request->curso; 
       
       // Construir el directorio de destino según departamento y curso.
       if (file_exists($nombreTemporal)){
           
          // Comprueba que existe el directorio, si no existe lo crea
           if (!file_exists($directorioArchivo)){
               
               mkdir($directorioArchivo);
               
           }
           
           copy($nombreTemporal, $directorioArchivo.$this->barra().$nombre);
           unlink($nombreTemporal);
           //controlar errores de fichero********************
           // dar de alta el trabajo.

           $registro=array(
                           'titulo'=>$request->titulo,
                           'dni_autor'=>$request->dni_autor,
                           'curso'=>$request->curso,
                           'tutor'=>$request->tutor,
                           'ciclo'=>$request->ciclo,
                           'archivo'=>$request->archivo,
                            );
           
           $id=\App\TFCs::insertGetId($registro);
                          
           $trabajoNuevo= \App\TFCs::find($id);
           
           return view('trabajos.store')->with('trabajo',$trabajoNuevo);
           
     } else {
       
           
           abort(404); // cambiarlo por vista error.
       }
       
     
    }
    /**
     * Función que busca trabajos de un alumno entregados y aprobados en el
     *  mismo año, ciclo, tutor y aprobados.
     * 
     * Objetivo: comprobar que no existe otro trabajo realizado por la misma persona,
     * en el mismo curso, en el mismo ciclo sin nota o con nota igual o superior a 5.
     * no se contempla que pueda presentarse a subir nota. ¿Podría haber un token para
     * trabajos no calificados? ¿mejora?
     * 
     * @param Request $request
     * @return boolean:  true: ya entregado
     *                   false: no entregado
     */
    public function buscaRepes(Request $request){
        
        $existe=FALSE;
        
        $trabajosPresentados=\App\TFCs::where([
                    ['dni_autor','=',$request->dni_autor],
                    ['tutor','=',$request->tutor],
                    ['curso','=',$request->curso],
                    ['ciclo','=',$request->ciclo],
                    
                    
                ])->get();
        
        if ($trabajosPresentados->count()>0){
            
            foreach($trabajosPresentados as $trabajoPresentado){
                $existe=(($trabajoPresentado->nota<5) or ($trabajoPresentado->nota==NULL)) ? TRUE : FALSE;
            }
        }
        return $existe;
    }
    /**
     * Crea la ruta del fichero completa para utilizar con otras funciones
     * 
     * @param string $fichero el nombre del fichero.
     * @return string ruta al fichero.
     */
    
    public function rutaDeArchivo($ciclo,$curso,$fichero){
        
        return $this->PATHTOARCHIVOS.$ciclo.$this->barra().$curso. $this->barra().$fichero;
    }
    /**
     * Descarga el TFC al dispositivo del usuario.
     * 
     * @param string $fichero nombre del fichero 
     * @return Response descarga del fichero o mensaje de error.
     */
    public function descargar($ciclo,$curso,$fichero){
        
        $archivo=$this->rutaDeArchivo($ciclo,$curso,$fichero);

        if (file_exists($archivo)){
            return response()->download($archivo);
        } else {
            return 'Problemas. No encuentro el archivo.';
        }
        
        
    }
    /**
     * Devuelve un slash según el sistema utilizado.
     * 
     * @return string / o \
     */
    public function barra(){
        
        if (php_uname('s')=='Linux'){ // por trabajar en dos sistemas diferentes. 
               
             $slash='/';
               
           } else {
                
               $slash='\\';
           
               
           }
           return $slash;
        
    }
    /**
     * Selecciona los trabajos que un tutor puede evaluar (los suyos) no evaluados.
     * 
     * @return type view trabajos.evaluar con los  trabajos tutorizados
     */
    public function evaluar(){
         if (auth()->user()->rol==1){
            
            //$trabajos= \App\TFCs::get();
           // $trabajos= \App\TFCs::where([
           //     ['tutor','=',trim(auth()->user()->nombre)." "
           //      .trim(auth()->user()->apellido) ],
           //     ['nota','=','null'],
           //     ])->get();
             $trabajos=$this->trabajosDeUnTutor(trim(auth()->user()->nombre).' '.trim(auth()->user()->apellido));
             
            return view('trabajos.evaluar')->with('trabajos',$trabajos);
        }
        
        return route('logout');
    }
    /**
     * Permite grabar la nota y la fecha de defensa de un TFCs
     * 
     * @param Request $request
     * @return type view trabajos.evaluar
     */
    public function grabarNota(Request $request){
        
        $trabajo= \App\TFCs::findOrFail($request->id);
        
        $trabajo->nota=$request->nota;
        $trabajo->defensa=$request->defensa;
        
        $trabajo->save();
     
        
        return redirect()->route('evaluar');
        
        
    }
     /**
     * Actualiza las claves de los alumnos que pasan de SIGAD con valor NULL
     * funcion para el administrador del sitio. 
     * 
     */
    public function updateClaves(){
        
    
        
        
        
        $users= \App\User::all();
        
        foreach($users as $user){
            
            if ($user->clave==NULL) {
                
               // Autores::find($autor->ID_AUTOR)->update(['clave' => bcrypt( $autor->expediente) ]);
                
                // Otro metodo
                //$id = 1; //Obtienes, de alguna manera el identificador correspondiente o lo obtienes del $request ... si viene de un formulario
                $id=$user->ID_AUTOR;
                $reg = \App\User::find($id);
                //$reg->clave=bcrypt( $autor->expediente) ;
                $reg->clave= Hash::make($autor->expediente);
                $reg->save();
                
            }
            
        }
        return view('auth.login');
    }
    /**
     * Devuelve los trabajos de un tutor.
     * 
     * @param type $tutor String nombre del tutor
     * @return type filas encontradas (resource)
     */
    protected function trabajosDeUnTutor($tutor) {
        
        $trabajos= \App\TFCs::where('tutor','LIKE', '%'.$tutor.'%')
                            ->get();
        
        return $trabajos;
        
    }
    /**
     * devuelve una lista con los trabajos que se coinciden con el criterio de 
     * búsqueda por titulo.
     * 
     * @param type string $titulo -> título o parte de título
     * @return type filas encontradas (resource).
     */
    protected function buscaTrabajosPorTitulo($titulo){
        
        $titulo=trim($titulo);
        
       $trabajos= \App\TFCs::join('users', 'TRABAJOS_FIN_DE_CICLO.dni_autor', '=', 'users.dni')
                ->select('TRABAJOS_FIN_DE_CICLO.*','users.apellido as apellido','users.nombre as nombre')
                ->where ('titulo','LIKE', '%'.$titulo.'%')
	        ->orderBy('entrega','asc')
                ->paginate(7);
        
        /*$trabajos= \App\TFCs::join('users', 'TRABAJOS_FIN_DE_CICLO.dni_autor', '=', 'users.dni')
                            ->select('TRABAJOS_FIN_DE_CICLO.*','users.apellido as apellido')
                            ->paginate(7);*/
        return $trabajos;
        
    }
    
    protected function eliminarTFC($id){
        
        $trabajo= \App\TFCs::findOrFail($id);
        $fichero=$this->rutaDeArchivo($trabajo->ciclo,$trabajo->curso,$trabajo->archivo);
        //confirmar borrado.
        $trabajo->delete();
        unlink($fichero);
        
        return $fichero;
    }
}
