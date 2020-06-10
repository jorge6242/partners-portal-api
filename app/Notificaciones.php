<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notificaciones extends Model
{
    protected $table = 'Notificaciones';

    protected $fillable = [      
        'sFuente', 
        'sCorreo', 
        'sTelefono', 
        'sAsunto',
        'sDestinatario',
        'sAccion',
        'nStatus',
        'nTipo',
        'dFecha',
        'dFechaProgramada',
        'dFechaProcesada',
        'sArchivo',
        'sContenido',
        'sCuenta',
        'nIntentos',
        'sRespuesta',
    ];

    public function setdFechaAttribute($value) {
        $this->attributes['dFecha'] = Carbon::now();
    }

    public function setdFechaProcesadaAttribute($value) {
        $this->attributes['dFechaProgramada'] = Carbon::now();
    }

    public $timestamps = false;
}
