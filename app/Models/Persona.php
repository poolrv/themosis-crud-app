<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    
    protected $fillable = [
        'nombre',
        'apellido', 
        'rut',
        'fecha_nacimiento'
    ];

    protected $dates = [
        'fecha_nacimiento'
    ];

    // Validar formato RUT chileno
    public static function validarRut($rut)
    {
        $rut = preg_replace('/[^k0-9]/i', '', $rut);
        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;
        
        foreach(array_reverse(str_split($numero)) as $v) {
            if($i==8) $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        
        $dvr = 11 - ($suma % 11);
        
        if($dvr == 11) $dvr = 0;
        if($dvr == 10) $dvr = "K";
        
        return strtoupper($dv) == strtoupper($dvr);
    }

    // Formatear RUT para mostrar
    public function getRutFormateadoAttribute()
    {
        $rut = $this->rut;
        return substr($rut, 0, -1) . '-' . substr($rut, -1);
    }
}