<?php

namespace App\BackOffice\Models;

use Illuminate\Database\Eloquent\Model;

class ReportePagos extends Model
{
    protected $connection = "sqlsrv_backoffice";
    protected $table = 'backoffice.dbo.portalpagos_ReportePagos';
    protected $fillable = [
        'idPago', 
        'nMonto', 
        'NroReferencia',
        'sDescripcion',
        'EstadoCuenta',
        'status',
        'dFechaProceso',
        'Login',
        'Archivos',
        'codBancoOrigen',
        'codCuentaDestino',
        'NroReferencia2',
        'dFechaRegistro',
        'dFechaPago'
    ];

        /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cuenta()
    {
        return $this->belongsTo('App\BackOffice\Models\BancoReceptor', 'codCuentaDestino', 'cCodCuenta');
    }

    public $timestamps = false;
}
