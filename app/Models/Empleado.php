<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'cedula_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'cedula_usuario',
        'rol',
    ];

    protected $attributes = [
        'rol' => 'EMPLEADO',
    ];

    protected $hidden = [
        'rol'
    ];

    protected static function booted(): void
    {
        static::saving(function (Empleado $empleado) {
            $empleado->rol = 'EMPLEADO';
        });
    }
}
