<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'codigo',
        'cliente_id',
        'usuario_id',
        'servicio_id',
        'horario_id',
        'fecha_solicitud',
        'metodo_pago',
        'estado',
    ];

    protected $casts = [
        'fecha_solicitud' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // public function servicio()
    // {
    //     return $this->belongsTo(Servicio::class);
    // }

    // public function horario()
    // {
    //     return $this->belongsTo(Horario::class);
    // }
}
