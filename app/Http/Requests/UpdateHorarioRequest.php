<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHorarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dia_semana'  => ['sometimes','string','in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'],
            'hora_inicio' => ['sometimes','date_format:H:i'],
            'hora_fin'    => ['sometimes','date_format:H:i'],
            'estado'      => ['sometimes','string','in:Disponible,Ocupado'],

            'usuario_id'  => ['sometimes','nullable','string','exists:usuarios,cedula_usuario'],
            'fecha'       => ['sometimes','nullable','date'],
        ];
    }
}
