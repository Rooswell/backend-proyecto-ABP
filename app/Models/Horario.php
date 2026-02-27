<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horarios';

    protected $fillable = [
        'codigo',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'estado',
        'usuario_id',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class); // si tienes el modelo Usuario
    }
}
