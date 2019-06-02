<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TFCs extends Model
{
    /**
     *
     * Tabla para almacenar los datos de los trabajos.
     * 
     * 
     * @var type string
     */
    protected $table='TRABAJOS_FIN_DE_CICLO';
    
    /**
     * Definimos la clave primaria de la tabla anterior
     * 
     * 
     * @var type string
     */
    
    protected $primaryKey='ID_TRABAJO';
    
    /**
     * Campos de la tabla que podemos ver y utilizar en las consultas.
     * 
     * 
     * @var type array
     */
    
    protected $fillable=array('titulo','dni_autor','curso','tutor','ciclo','entrega','defensa','nota','archivo','GNU');
    
    /**
     * Campos de la tabla que NO podemos ver y utilizar en las consultas. Contraseña y token.
     * 
     * 
     * @var type array
     */
    //protected $hidden=array('archivo');
    
    /**
     * Eliminamos los campos updated_at y created_at
     * Alternativas individuales:
     * const UPDATED_AT = null;
     * const CREATED_AT = null;
     * @var type boolean
     */
    public $timestamps=false;
    
}
